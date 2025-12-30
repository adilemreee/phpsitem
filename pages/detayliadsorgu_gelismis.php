<?php

include '../server/database.php';
include '../server/rolecontrol.php';
include '../server/vipcontrol.php';
include '../server/premiumcontrol.php';
include '../server/functions.php';

$page_title = "Detaylı Ad Soyad (Gelişmiş)";

if (!function_exists('das_normalize_name')) {
    function das_normalize_name($value)
    {
        $clean = preg_replace('/\s+/u', ' ', trim((string)$value));
        if ($clean === '') {
            return '';
        }

        return $clean;
    }
}

if (!function_exists('das_prepare_alternatives')) {
    function das_prepare_alternatives($value)
    {
        if (!is_string($value) || trim($value) === '') {
            return [];
        }

        $parts = preg_split('/[\r\n,;]+/', $value);
        $clean = [];
        foreach ($parts as $part) {
            $normalized = das_normalize_name($part);
            if ($normalized !== '') {
                $clean[] = $normalized;
            }
        }

        return $clean;
    }
}

if (!function_exists('das_build_name_condition')) {
    function das_build_name_condition($column, $value, $matchType, $ignoreSpaces, $allowPrefixExpansion, &$params, $key)
    {
        $normalized = das_normalize_name($value);
        if ($normalized === '') {
            return null;
        }

        $matchType = in_array($matchType, ['exact', 'starts', 'contains'], true) ? $matchType : 'exact';
        $columnExpr = $ignoreSpaces ? "REPLACE($column, ' ', '')" : $column;
        $valueExpr = $ignoreSpaces ? str_replace(' ', '', $normalized) : $normalized;

        if ($matchType === 'contains') {
            $paramKey = $key . '_contains';
            $params[$paramKey] = '%' . $valueExpr . '%';
            return "$columnExpr LIKE :$paramKey";
        }

        if ($matchType === 'starts') {
            $paramKey = $key . '_starts';
            $params[$paramKey] = $valueExpr . '%';
            return "$columnExpr LIKE :$paramKey";
        }

        $paramKey = $key . '_exact';
        $params[$paramKey] = $valueExpr;
        $condition = "$columnExpr = :$paramKey";

        if ($allowPrefixExpansion) {
            $prefixKey = $key . '_prefix';
            $params[$prefixKey] = $valueExpr . '%';
            $condition = "($condition OR $columnExpr LIKE :$prefixKey)";
        }

        return $condition;
    }
}

if (!function_exists('das_old')) {
    function das_old($key)
    {
        return isset($_POST[$key]) ? htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8') : '';
    }
}

if (!function_exists('das_checked')) {
    function das_checked($key)
    {
        return isset($_POST[$key]) ? 'checked' : '';
    }
}

if (!function_exists('das_selected')) {
    function das_selected($key, $value, $default = '')
    {
        $current = $_POST[$key] ?? $default;
        return $current === $value ? 'selected' : '';
    }
}

if (!function_exists('das_escape')) {
    function das_escape($value)
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('das_format_summary_value')) {
    function das_format_summary_value($value, $matchType = 'exact')
    {
        $clean = trim((string)$value);
        if ($clean === '') {
            return '';
        }

        switch ($matchType) {
            case 'starts':
                return $clean . '*';
            case 'contains':
                return '*' . $clean . '*';
            case 'exact':
            default:
                return $clean;
        }
    }
}

$username = 'Bilinmiyor';
if (isset($_SESSION['GET_USER_SSID'])) {
    $getInfoSSID = $_SESSION['GET_USER_SSID'];
    $getInfoQuery = $db->prepare("SELECT username FROM `accounts` WHERE hash = :hash LIMIT 1");
    $getInfoQuery->execute(['hash' => $getInfoSSID]);
    if ($getInfoData = $getInfoQuery->fetch(PDO::FETCH_ASSOC)) {
        $username = base64_decode($getInfoData['username']);
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <?php include 'inc/header_main.php'; ?>
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <style>
        .form-select,
        .form-control,
        textarea {
            margin: 6px 0;
        }

        .query-hint {
            font-size: 12px;
            color: #7e8299;
        }

        .option-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #eef6ff;
            color: #1a56b3;
        }

        .table-notice {
            font-size: 14px;
        }
    </style>
</head>

<body id="kt_body" class="aside-enabled">
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <?php include 'inc/header_sidebar.php'; ?>
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <?php include 'inc/header_navbar.php'; ?>
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <div id="kt_content_container" class="container-xxl">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title mb-4">
                                                <img style="width: 28px;height: auto;" src="/assets/img/icons/adsoyad.png" alt="">
                                                &nbsp; Detaylı Ad Soyad Sorgu (Gelişmiş)
                                            </h4>
                                            <div class="text-gray-600 fw-semibold mb-5">
                                                İsim varyasyonları, boşluk hassasiyetleri ve çoklu kriterlerle kişinin kayıtlarını filtreleyebilirsiniz. Tam ad yazıp ikinci isimleri de yakalayabilir, memleket / nüfus filtreleri ve doğum yılı aralığı ile sonuç setini daraltabilirsiniz.
                                            </div>
                                            <div class="block-content tab-content">
                                                <form action="detayliadsorgu_gelismis" method="POST">
                                                    <div class="row g-4">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Ad</label>
                                                            <input autocomplete="off" name="txtad" class="form-control form-control-solid" type="text" placeholder="Ad" value="<?= das_old('txtad'); ?>">
                                                            <span class="query-hint">Varsayılan olarak yazdığınız ad ile başlayan tüm ikinci isimli kayıtlar listelenir.</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">İkinci / Alternatif Ad</label>
                                                            <input autocomplete="off" name="txtikinciad" class="form-control form-control-solid" type="text" placeholder="Örn: Emre" value="<?= das_old('txtikinciad'); ?>">
                                                            <span class="query-hint">Ad alanı içinde herhangi bir yerde geçmesini istediğiniz kelimeleri yazabilirsiniz.</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Soyad</label>
                                                            <input autocomplete="off" name="txtsoyad" class="form-control form-control-solid" type="text" placeholder="Soyad" value="<?= das_old('txtsoyad'); ?>">
                                                            <span class="query-hint">Soyad eşleşme tipini aşağıdan değiştirebilirsiniz.</span>
                                                        </div>
                                                    </div>

                                                    <div class="row g-4 mt-1">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Tam Ad</label>
                                                            <input autocomplete="off" name="txttamad" class="form-control form-control-solid" type="text" placeholder="Adil Karayürek veya Adil   Emre Karayürek" value="<?= das_old('txttamad'); ?>">
                                                            <span class="query-hint">Boşluk sayısı önemli değildir. İlk kelime ad, son kelime soyad olarak yorumlanır.</span>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Ad Alternatifleri</label>
                                                            <textarea name="txtadset" rows="3" class="form-control form-control-solid" placeholder="Her satıra veya virgülle ayırarak yazabilirsiniz."><?= das_old('txtadset'); ?></textarea>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Soyad Alternatifleri</label>
                                                            <textarea name="txtsoyadset" rows="3" class="form-control form-control-solid" placeholder="Her satıra veya virgülle ayırarak yazabilirsiniz."><?= das_old('txtsoyadset'); ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row g-4 mt-1">
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Ad Eşleşme Tipi</label>
                                                            <select name="ad_match_type" class="form-select form-select-solid">
                                                                <option value="exact" <?= das_selected('ad_match_type', 'exact', 'starts'); ?>>Tam Eşleşme</option>
                                                                <option value="starts" <?= das_selected('ad_match_type', 'starts', 'starts'); ?>>İle Başlayan</option>
                                                                <option value="contains" <?= das_selected('ad_match_type', 'contains', 'starts'); ?>>İçeren</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Soyad Eşleşme Tipi</label>
                                                            <select name="soyad_match_type" class="form-select form-select-solid">
                                                                <option value="exact" <?= das_selected('soyad_match_type', 'exact', 'exact'); ?>>Tam Eşleşme</option>
                                                                <option value="starts" <?= das_selected('soyad_match_type', 'starts', 'exact'); ?>>İle Başlayan</option>
                                                                <option value="contains" <?= das_selected('soyad_match_type', 'contains', 'exact'); ?>>İçeren</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label fw-semibold">Koşullar Arası Bağlaç</label>
                                                            <select name="logic_operator" class="form-select form-select-solid">
                                                                <option value="AND" <?= das_selected('logic_operator', 'AND', 'AND'); ?>>VE (tüm kriterler sağlansın)</option>
                                                                <option value="OR" <?= das_selected('logic_operator', 'OR', 'AND'); ?>>VEYA (herhangi biri yeterli)</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row g-4 mt-1">
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Memleket İl</label>
                                                            <input name="memleket_il" class="form-control form-control-solid" type="text" placeholder="Örn: İSTANBUL" value="<?= das_old('memleket_il'); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Memleket İlçe</label>
                                                            <input name="memleket_ilce" class="form-control form-control-solid" type="text" placeholder="Örn: KADIKÖY" value="<?= das_old('memleket_ilce'); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Adres İl</label>
                                                            <input name="adres_il" class="form-control form-control-solid" type="text" placeholder="Örn: SİVAS" value="<?= das_old('adres_il'); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Adres İlçe</label>
                                                            <input name="adres_ilce" class="form-control form-control-solid" type="text" placeholder="Örn: MERKEZ" value="<?= das_old('adres_ilce'); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="row g-4 mt-1">
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Doğum Yılı Başlangıcı</label>
                                                            <input name="dogum_bas" class="form-control form-control-solid" type="number" min="1900" max="2024" placeholder="Örn: 1985" value="<?= das_old('dogum_bas'); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Doğum Yılı Bitişi</label>
                                                            <input name="dogum_bit" class="form-control form-control-solid" type="number" min="1900" max="2024" placeholder="Örn: 2000" value="<?= das_old('dogum_bit'); ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Cinsiyet</label>
                                                            <select name="cinsiyet" class="form-select form-select-solid">
                                                                <option value="" <?= das_selected('cinsiyet', '', ''); ?>>Farketmez</option>
                                                                <option value="E" <?= das_selected('cinsiyet', 'E', ''); ?>>Erkek</option>
                                                                <option value="K" <?= das_selected('cinsiyet', 'K', ''); ?>>Kadın</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label fw-semibold">Sonuç Limiti</label>
                                                            <input name="result_limit" class="form-control form-control-solid" type="number" min="10" max="1000" value="<?= das_old('result_limit') ?: 250; ?>">
                                                            <span class="query-hint">Varsayılan 250 kayıt &mdash; arttırmak için limiti güncelleyebilirsiniz.</span>
                                                        </div>
                                                    </div>

                                                    <div class="row g-4 mt-3">
                                                        <div class="col-md-4">
                                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" name="ignore_spaces" value="1" <?= das_checked('ignore_spaces'); ?>>
                                                                <span class="form-check-label">Boşlukları yok say (Adil   Karayürek = Adil Karayürek)</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" name="allow_middle" value="1" <?= das_checked('allow_middle'); ?>>
                                                                <span class="form-check-label">Ad eşleşmelerinde ikinci isimleri otomatik yakala</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox" name="search_fullname" value="1" <?= das_checked('search_fullname'); ?>>
                                                                <span class="form-check-label">Tam ad alanını tek parça olarak da ara</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center justify-content-center flex-wrap mt-4">
                                                        <button id="sorgula" name="Sorgula" type="submit" class="btn btn-success btn-rounded me-3" style="width: 200px;">Sorgula</button>
                                                        <button onclick="clearTable()" id="durdurButon" type="button" class="btn btn-danger btn-rounded me-3" style="width: 160px;">Sıfırla</button>
                                                        <button onclick="copyTable()" id="copy_btn" type="button" class="btn btn-primary btn-rounded me-3" style="width: 160px;">Kopyala</button>
                                                        <button onclick="printTable()" id="yazdirTable" type="button" class="btn btn-info btn-rounded" style="width: 160px;">Yazdır</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="table-responsive mt-10">
                                                <?php if (!empty($resultsMeta)) : ?>
                                                    <div class="alert alert-light border rounded d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
                                                        <div class="fw-semibold text-gray-800">Toplam <span class="text-primary"><?= (int) $resultsMeta['count']; ?></span> kayıt listelendi.</div>
                                                        <div class="text-muted small mt-3 mt-md-0">Kriterler: <?= das_escape($resultsMeta['summary']); ?></div>
                                                    </div>
                                                <?php endif; ?>
                                                <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7">
                                                    <thead>
                                                    <tr class="fw-bold fs-6 text-gray-800">
                                                        <th>ID</th>
                                                        <th>TC</th>
                                                        <th>Ad</th>
                                                        <th>Soyad</th>
                                                        <th>GSM</th>
                                                        <th>Baba Adı</th>
                                                        <th>Baba TC</th>
                                                        <th>Anne Adı</th>
                                                        <th>Anne TC</th>
                                                        <th>Doğum Tarihi</th>
                                                        <th>Ölüm Tarihi</th>
                                                        <th>Doğum Yeri</th>
                                                        <th>Memleket İl</th>
                                                        <th>Memleket İlçe</th>
                                                        <th>Memleket Köy</th>
                                                        <th>Adres İl</th>
                                                        <th>Adres İlçe</th>
                                                        <th>Aile Sıra No</th>
                                                        <th>Birey Sıra No</th>
                                                        <th>Medeni Hal</th>
                                                        <th>Cinsiyet</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $tableNotice = null;
                                                    $rows = [];
                                                    $resultsMeta = null;
                                                    $queryExecuted = false;
                                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                        $adInput = trim($_POST['txtad'] ?? '');
                                                        $ikinciAdInput = $_POST['txtikinciad'] ?? '';
                                                        $soyadInput = trim($_POST['txtsoyad'] ?? '');
                                                        $tamAdInput = $_POST['txttamad'] ?? '';
                                                        if ($adInput !== '' && $soyadInput === '') {
                                                            $nameParts = preg_split('/\s+/u', $adInput, -1, PREG_SPLIT_NO_EMPTY);
                                                            if (count($nameParts) >= 2) {
                                                                $soyadInput = array_pop($nameParts);
                                                                $adInput = implode(' ', $nameParts);
                                                            }
                                                        }
                                                        $adSetInput = $_POST['txtadset'] ?? '';
                                                        $soyadSetInput = $_POST['txtsoyadset'] ?? '';
                                                        $adMatchType = $_POST['ad_match_type'] ?? 'starts';
                                                        $soyadMatchType = $_POST['soyad_match_type'] ?? 'exact';
                                                        $logicOperator = strtoupper($_POST['logic_operator'] ?? 'AND');
                                                        $logicOperator = in_array($logicOperator, ['AND', 'OR'], true) ? $logicOperator : 'AND';
                                                        $ignoreSpaces = isset($_POST['ignore_spaces']);
                                                        $allowMiddle = isset($_POST['allow_middle']);
                                                        $searchFullname = isset($_POST['search_fullname']);
                                                        $memleketIl = $_POST['memleket_il'] ?? '';
                                                        $memleketIlce = $_POST['memleket_ilce'] ?? '';
                                                        $adresIl = $_POST['adres_il'] ?? '';
                                                        $adresIlce = $_POST['adres_ilce'] ?? '';
                                                        $cinsiyet = strtoupper(trim($_POST['cinsiyet'] ?? ''));
                                                        $dogumBas = preg_replace('/\D/', '', $_POST['dogum_bas'] ?? '');
                                                        $dogumBit = preg_replace('/\D/', '', $_POST['dogum_bit'] ?? '');
                                                        $resultLimit = (int)($_POST['result_limit'] ?? 250);
                                                        if ($resultLimit < 10) {
                                                            $resultLimit = 10;
                                                        }
                                                        if ($resultLimit > 1000) {
                                                            $resultLimit = 1000;
                                                        }

                                                        $rateLimited = false;
                                                        if (session_status() === PHP_SESSION_NONE) {
                                                            session_start();
                                                        }
                                                        $currentTime = time();
                                                        $lastQueryTime = $_SESSION['last_query_time'] ?? 0;
                                                        $timeDifference = $currentTime - $lastQueryTime;

                                                        if ($access_level != 6 && $timeDifference < 10) {
                                                            echo "<script>toastr.error('10 saniyede 1 kere sorgu atabilirsiniz.');</script>";
                                                            $tableNotice = [
                                                                'variant' => 'warning',
                                                                'message' => '10 saniyede 1 kere sorgu atabilirsiniz.'
                                                            ];
                                                            $rateLimited = true;
                                                        } else {
                                                            $_SESSION['last_query_time'] = $currentTime;
                                                            if (function_exists('totalLog')) {
                                                                totalLog('adsyd');
                                                            }
                                                            if (function_exists('countAdd')) {
                                                                countAdd();
                                                            }
                                                        }

                                                        if (!$rateLimited) {
                                                            $advancedTriggerValues = [
                                                                $ikinciAdInput,
                                                                $tamAdInput,
                                                                $adSetInput,
                                                                $soyadSetInput,
                                                                $memleketIl,
                                                                $memleketIlce,
                                                                $adresIl,
                                                                $adresIlce,
                                                                $cinsiyet,
                                                                $dogumBas,
                                                                $dogumBit
                                                            ];
                                                            $hasAdvancedInput = false;
                                                            foreach ($advancedTriggerValues as $triggerValue) {
                                                                if (is_string($triggerValue) && trim($triggerValue) !== '') {
                                                                    $hasAdvancedInput = true;
                                                                    break;
                                                                }
                                                            }
                                                            if (!$hasAdvancedInput) {
                                                                $hasAdvancedInput = isset($_POST['ignore_spaces']) || isset($_POST['allow_middle']) || isset($_POST['search_fullname']);
                                                            }
                                                            if (!$hasAdvancedInput) {
                                                                $hasAdvancedInput = ($adMatchType !== 'starts') || ($soyadMatchType !== 'exact') || ($logicOperator !== 'AND');
                                                            }

                                                            $shouldUseBasicQuery = !$hasAdvancedInput && $adInput !== '' && $soyadInput !== '';

                                                            $summaryParts = [];
                                                            if ($adInput !== '') {
                                                                $adSummaryValue = das_format_summary_value($adInput, $shouldUseBasicQuery ? 'starts' : $adMatchType);
                                                                if ($adSummaryValue !== '') {
                                                                    $summaryParts[] = 'Ad=' . $adSummaryValue;
                                                                }
                                                            }
                                                            if ($soyadInput !== '') {
                                                                $soyadSummaryValue = das_format_summary_value($soyadInput, 'exact');
                                                                if ($soyadSummaryValue !== '') {
                                                                    $summaryParts[] = 'Soyad=' . $soyadSummaryValue;
                                                                }
                                                            }
                                                            if ($ikinciAdInput !== '') {
                                                                $secondSummaryValue = das_format_summary_value($ikinciAdInput, 'contains');
                                                                if ($secondSummaryValue !== '') {
                                                                    $summaryParts[] = 'İkinciAd=' . $secondSummaryValue;
                                                                }
                                                            }
                                                            if ($tamAdInput !== '') {
                                                                $summaryParts[] = 'TamAd=' . $tamAdInput;
                                                            }
                                                            if ($adSetInput !== '') {
                                                                $altPreview = das_prepare_alternatives($adSetInput);
                                                                if (!empty($altPreview)) {
                                                                    $summaryParts[] = 'Ad Alternatifleri=' . implode(' | ', array_slice($altPreview, 0, 3)) . (count($altPreview) > 3 ? '...' : '');
                                                                }
                                                            }
                                                            if ($soyadSetInput !== '') {
                                                                $soyAltPreview = das_prepare_alternatives($soyadSetInput);
                                                                if (!empty($soyAltPreview)) {
                                                                    $summaryParts[] = 'Soyad Alternatifleri=' . implode(' | ', array_slice($soyAltPreview, 0, 3)) . (count($soyAltPreview) > 3 ? '...' : '');
                                                                }
                                                            }
                                                            if ($memleketIl !== '') {
                                                                $summaryParts[] = 'Memleket İl=' . $memleketIl;
                                                            }
                                                            if ($memleketIlce !== '') {
                                                                $summaryParts[] = 'Memleket İlçe=' . $memleketIlce;
                                                            }
                                                            if ($adresIl !== '') {
                                                                $summaryParts[] = 'Adres İl=' . $adresIl;
                                                            }
                                                            if ($adresIlce !== '') {
                                                                $summaryParts[] = 'Adres İlçe=' . $adresIlce;
                                                            }
                                                            if ($cinsiyet === 'E' || $cinsiyet === 'K') {
                                                                $summaryParts[] = 'Cinsiyet=' . ($cinsiyet === 'E' ? 'Erkek' : 'Kadın');
                                                            }
                                                            if ($dogumBas !== '' || $dogumBit !== '') {
                                                                if ($dogumBas !== '' && $dogumBit !== '') {
                                                                    $dogumLabel = $dogumBas . '-' . $dogumBit;
                                                                } elseif ($dogumBas !== '') {
                                                                    $dogumLabel = $dogumBas . '+';
                                                                } else {
                                                                    $dogumLabel = '<=' . $dogumBit;
                                                                }
                                                                $summaryParts[] = 'Doğum Yılı=' . $dogumLabel;
                                                            }

                                                            if ($shouldUseBasicQuery) {
                                                                try {
                                                                    $basicDb = new PDO("mysql:host=localhost:8889;dbname=sorguuu;charset=utf8", "root", "root");
                                                                    $basicDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                                    $sql = "SELECT ID, TC, AD, SOYAD, GSM, BABAADI, BABATC, ANNEADI, ANNETC, DOGUMTARIHI, OLUMTARIHI, DOGUMYERI, MEMLEKETIL, MEMLEKETILCE, MEMLEKETKOY, ADRESIL, ADRESILCE, AILESIRANO, BIREYSIRANO, MEDENIHAL, CINSIYET FROM 109m WHERE AD LIKE :ad_prefix AND SOYAD = :soyad LIMIT :limit_value";
                                                                    $stmt = $basicDb->prepare($sql);
                                                                    $stmt->bindValue(':ad_prefix', $adInput . '%');
                                                                    $stmt->bindValue(':soyad', $soyadInput);
                                                                    $stmt->bindValue(':limit_value', $resultLimit, PDO::PARAM_INT);
                                                                    $stmt->execute();
                                                                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                    $queryExecuted = true;
                                                                    if (empty($rows)) {
                                                                        $tableNotice = [
                                                                            'variant' => 'warning',
                                                                            'message' => 'Maalesef, sorguladığınız kişinin bilgileri bulunamadı.'
                                                                        ];
                                                                        echo "<script>toastr.error('Maalesef, sorguladığınız kişinin bilgileri bulunamadı.');</script>";
                                                                    } else {
                                                                        echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";
                                                                        echo "<script>toastr.info('Kişi bilgileri getirildi.');</script>";
                                                                    }
                                                                } catch (PDOException $e) {
                                                                    $tableNotice = [
                                                                        'variant' => 'danger',
                                                                        'message' => 'Veritabanı hatası: ' . $e->getMessage()
                                                                    ];
                                                                    echo "<script>toastr.error('Veritabanı hatası oluştu.');</script>";
                                                                }
                                                            } else {
                                                                $conditions = [];
                                                                $params = [];
                                                                $hasCriteria = false;

                                                                $condition = das_build_name_condition('AD', $adInput, $adMatchType, $ignoreSpaces, $allowMiddle, $params, 'ad_main');
                                                                if ($condition) {
                                                                    $conditions[] = $condition;
                                                                    $hasCriteria = true;
                                                                }

                                                                $condition = das_build_name_condition('SOYAD', $soyadInput, $soyadMatchType, $ignoreSpaces, false, $params, 'soyad_main');
                                                                if ($condition) {
                                                                    $conditions[] = $condition;
                                                                    $hasCriteria = true;
                                                                }

                                                                $ikinciAdNormalized = das_normalize_name($ikinciAdInput);
                                                                if ($ikinciAdNormalized !== '') {
                                                                    $params['second_name'] = '%' . str_replace(' ', '%', $ikinciAdNormalized) . '%';
                                                                    $conditions[] = "AD LIKE :second_name";
                                                                    $hasCriteria = true;
                                                                }

                                                                $adAlternatives = array_slice(das_prepare_alternatives($adSetInput), 0, 10);
                                                                if (!empty($adAlternatives)) {
                                                                    $altConditions = [];
                                                                    foreach ($adAlternatives as $index => $alt) {
                                                                        $altCondition = das_build_name_condition('AD', $alt, $adMatchType, $ignoreSpaces, $allowMiddle, $params, 'ad_alt_' . $index);
                                                                        if ($altCondition) {
                                                                            $altConditions[] = $altCondition;
                                                                        }
                                                                    }
                                                                    if ($altConditions) {
                                                                        $conditions[] = '(' . implode(' OR ', $altConditions) . ')';
                                                                        $hasCriteria = true;
                                                                    }
                                                                }

                                                                $soyadAlternatives = array_slice(das_prepare_alternatives($soyadSetInput), 0, 10);
                                                                if (!empty($soyadAlternatives)) {
                                                                    $altConditions = [];
                                                                    foreach ($soyadAlternatives as $index => $alt) {
                                                                        $altCondition = das_build_name_condition('SOYAD', $alt, $soyadMatchType, $ignoreSpaces, false, $params, 'soyad_alt_' . $index);
                                                                        if ($altCondition) {
                                                                            $altConditions[] = $altCondition;
                                                                        }
                                                                    }
                                                                    if ($altConditions) {
                                                                        $conditions[] = '(' . implode(' OR ', $altConditions) . ')';
                                                                        $hasCriteria = true;
                                                                    }
                                                                }

                                                                $tamAdNormalized = das_normalize_name($tamAdInput);
                                                                if ($tamAdNormalized !== '') {
                                                                    $parts = explode(' ', $tamAdNormalized);
                                                                    if (count($parts) >= 2) {
                                                                        $fullLast = array_pop($parts);
                                                                        $fullFirst = array_shift($parts);
                                                                        $fullConditions = [];
                                                                        $fullFirstCondition = das_build_name_condition('AD', $fullFirst, 'starts', $ignoreSpaces, true, $params, 'full_first');
                                                                        if ($fullFirstCondition) {
                                                                            $fullConditions[] = $fullFirstCondition;
                                                                        }
                                                                        $fullLastCondition = das_build_name_condition('SOYAD', $fullLast, 'exact', $ignoreSpaces, false, $params, 'full_last');
                                                                        if ($fullLastCondition) {
                                                                            $fullConditions[] = $fullLastCondition;
                                                                        }

                                                                        if ($allowMiddle && !empty($parts)) {
                                                                            foreach ($parts as $midIndex => $mid) {
                                                                                $midNormalized = das_normalize_name($mid);
                                                                                if ($midNormalized === '') {
                                                                                    continue;
                                                                                }
                                                                                $midKey = 'full_mid_' . $midIndex;
                                                                                $params[$midKey] = '%' . $midNormalized . '%';
                                                                                $fullConditions[] = "AD LIKE :$midKey";
                                                                            }
                                                                        }

                                                                        if ($fullConditions) {
                                                                            $conditions[] = '(' . implode(' AND ', $fullConditions) . ')';
                                                                            $hasCriteria = true;
                                                                        }
                                                                    } else {
                                                                        $singleFullConditions = [];
                                                                        $singleFullConditions[] = das_build_name_condition('AD', $tamAdNormalized, $adMatchType, $ignoreSpaces, $allowMiddle, $params, 'full_single_ad');
                                                                        $singleFullConditions[] = das_build_name_condition('SOYAD', $tamAdNormalized, $soyadMatchType, $ignoreSpaces, false, $params, 'full_single_soyad');
                                                                        $singleFullConditions = array_filter($singleFullConditions);
                                                                        if ($singleFullConditions) {
                                                                            $conditions[] = '(' . implode(' OR ', $singleFullConditions) . ')';
                                                                            $hasCriteria = true;
                                                                        }
                                                                    }

                                                                    if ($searchFullname) {
                                                                        $concatExpr = $ignoreSpaces ? "REPLACE(CONCAT(AD, ' ', SOYAD), ' ', '')" : "CONCAT(AD, ' ', SOYAD)";
                                                                        $concatKey = 'full_concat';
                                                                        $params[$concatKey] = $ignoreSpaces ? str_replace(' ', '', $tamAdNormalized) : $tamAdNormalized;
                                                                        $conditions[] = "$concatExpr LIKE :$concatKey";
                                                                        $hasCriteria = true;
                                                                    }
                                                                }

                                                                $memleketIlNormalized = das_normalize_name($memleketIl);
                                                                if ($memleketIlNormalized !== '') {
                                                                    $params['memleket_il'] = $memleketIlNormalized;
                                                                    $conditions[] = "MEMLEKETIL = :memleket_il";
                                                                    $hasCriteria = true;
                                                                }

                                                                $memleketIlceNormalized = das_normalize_name($memleketIlce);
                                                                if ($memleketIlceNormalized !== '') {
                                                                    $params['memleket_ilce'] = $memleketIlceNormalized;
                                                                    $conditions[] = "MEMLEKETILCE = :memleket_ilce";
                                                                    $hasCriteria = true;
                                                                }

                                                                $adresIlNormalized = das_normalize_name($adresIl);
                                                                if ($adresIlNormalized !== '') {
                                                                    $params['adres_il'] = $adresIlNormalized;
                                                                    $conditions[] = "ADRESIL = :adres_il";
                                                                    $hasCriteria = true;
                                                                }

                                                                $adresIlceNormalized = das_normalize_name($adresIlce);
                                                                if ($adresIlceNormalized !== '') {
                                                                    $params['adres_ilce'] = $adresIlceNormalized;
                                                                    $conditions[] = "ADRESILCE = :adres_ilce";
                                                                    $hasCriteria = true;
                                                                }

                                                                if ($cinsiyet === 'E' || $cinsiyet === 'K') {
                                                                    $params['cinsiyet'] = $cinsiyet;
                                                                    $conditions[] = "CINSIYET = :cinsiyet";
                                                                    $hasCriteria = true;
                                                                }

                                                                if ($dogumBas !== '') {
                                                                    $params['dogum_bas'] = $dogumBas;
                                                                    $conditions[] = "SUBSTR(DOGUMTARIHI, 1, 4) >= :dogum_bas";
                                                                    $hasCriteria = true;
                                                                }

                                                                if ($dogumBit !== '') {
                                                                    $params['dogum_bit'] = $dogumBit;
                                                                    $conditions[] = "SUBSTR(DOGUMTARIHI, 1, 4) <= :dogum_bit";
                                                                    $hasCriteria = true;
                                                                }

                                                                if (!$hasCriteria) {
                                                                    $tableNotice = [
                                                                        'variant' => 'warning',
                                                                        'message' => 'En az bir sorgu kriteri belirtmelisiniz.'
                                                                    ];
                                                                    echo "<script>toastr.error('En az bir sorgu kriteri belirtmelisiniz.');</script>";
                                                                } else {
                                                                    try {
                                                                        $sorguDb = new PDO("mysql:host=localhost:8889;dbname=sorguuu;charset=utf8", "root", "root");
                                                                        $sorguDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                                                        $whereClause = implode(" $logicOperator ", $conditions);
                                                                        $sql = "SELECT ID, TC, AD, SOYAD, GSM, BABAADI, BABATC, ANNEADI, ANNETC, DOGUMTARIHI, OLUMTARIHI, DOGUMYERI, MEMLEKETIL, MEMLEKETILCE, MEMLEKETKOY, ADRESIL, ADRESILCE, AILESIRANO, BIREYSIRANO, MEDENIHAL, CINSIYET FROM 109m WHERE $whereClause ORDER BY SOYAD, AD LIMIT :limit_value";

                                                                        $stmt = $sorguDb->prepare($sql);
                                                                        foreach ($params as $key => $value) {
                                                                            $stmt->bindValue(':' . $key, $value);
                                                                        }
                                                                        $stmt->bindValue(':limit_value', $resultLimit, PDO::PARAM_INT);
                                                                        $stmt->execute();

                                                                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                                        $queryExecuted = true;
                                                                        if (empty($rows)) {
                                                                            $tableNotice = [
                                                                                'variant' => 'warning',
                                                                                'message' => 'Sorgunuza uygun kayıt bulunamadı.'
                                                                            ];
                                                                            echo "<script>toastr.error('Eşleşen kayıt bulunamadı.');</script>";
                                                                        } else {
                                                                            $totalRows = count($rows);
                                                                            echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı.');</script>";
                                                                            echo "<script>toastr.info('Toplam $totalRows kayıt listelendi.');</script>";
                                                                        }
                                                                    } catch (PDOException $e) {
                                                                        $tableNotice = [
                                                                            'variant' => 'danger',
                                                                            'message' => 'Veritabanı hatası: ' . $e->getMessage()
                                                                        ];
                                                                        echo "<script>toastr.error('Veritabanı hatası oluştu.');</script>";
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        if ($queryExecuted) {
                                                                $summaryText = $summaryParts ? implode(', ', $summaryParts) : 'Varsayılan kriter';
                                                                $resultsMeta = [
                                                                    'count' => count($rows),
                                                                    'summary' => $summaryText
                                                                ];
                                                            }
                                                        }
                                                    
                                                    if (!empty($rows)) {
                                                        foreach ($rows as $data) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo das_escape($data['ID'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['TC'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['AD'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['SOYAD'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['GSM'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['BABAADI'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['BABATC'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['ANNEADI'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['ANNETC'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['DOGUMTARIHI'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['OLUMTARIHI'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['DOGUMYERI'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['MEMLEKETIL'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['MEMLEKETILCE'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['MEMLEKETKOY'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['ADRESIL'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['ADRESILCE'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['AILESIRANO'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['BIREYSIRANO'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['MEDENIHAL'] ?? null); ?></td>
                                                                <td><?php echo das_escape($data['CINSIYET'] ?? null); ?></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                                <?php if (!empty($tableNotice)) : ?>
                                                    <div class="alert alert-<?= das_escape($tableNotice['variant']); ?> mt-5 table-notice" role="alert">
                                                        <?= das_escape($tableNotice['message']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'inc/footer_main.php'; ?>
        </div>
    </div>
</div>

<style>
    #kt_datatable_dom_positioning_filter {
        text-align: left;
        margin-right: 15px;
    }

    .dt-buttons button:nth-child(3) {
        background-color: #dc3545 !important;
        color: #fff;
        border-color: #dc3545;
    }
</style>

<script>
    $(document).ready(function () {
        var table = $('#kt_datatable_dom_positioning').DataTable({
            "language": {
                "lengthMenu": "Sayfada _MENU_ kayıt göster",
                "emptyTable": "Tabloda herhangi bir veri bulunmamaktadır",
                "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                "infoEmpty": "Gösterilecek kayıt bulunamadı",
                "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                "zeroRecords": "Eşleşen kayıt bulunamadı",
                "search": "Ara:",
                "processing": "İşleniyor...",
                "loadingRecords": "Kayıtlar yükleniyor...",
                "paginate": {
                    "first": "İlk",
                    "last": "Son",
                    "next": "Sonraki",
                    "previous": "Önceki"
                },
                "buttons": {
                    "copy": "Kopyala",
                    "excel": "Excel",
                    "pdf": "PDF"
                }
            },
            "dom": "<'row'" +
                "<'col-sm-12 d-flex align-items-center justify-content-start'l>" +
                "<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
                ">" +
                "<'table-responsive'tr>" +
                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-start justify-content-md-end'p>" +
                ">",
            "sDom": '<"refresh"i<"clear">>rt<"top"lf<"clear">>rt<"bottom"p<"clear">>',
            "paging": false,
            "ordering": false,
            "info": false
        });

        new $.fn.dataTable.Buttons(table, {
            buttons: [
                'excel',
                {
                    extend: 'pdfHtml5',
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 5;
                        doc.styles.tableHeader.fontSize = 5;
                        doc.styles.tableBodyOdd.fontSize = 5;
                        doc.styles.tableBodyEven.fontSize = 5;
                    }
                },
                {
                    text: 'Sorun Bildir',
                    action: function () {
                        Swal.fire({
                            title: 'Sorun Bildir',
                            html: '<textarea max="200" min="10" id="sorun" class="form-control" placeholder="Sorununuzu yazın">',
                            focusConfirm: false,
                            preConfirm: () => {
                                const sorun = Swal.getPopup().querySelector('#sorun').value;
                                postToDiscordWebhook(sorun);
                            }
                        });
                    }
                }
            ]
        }).container().appendTo($('#kt_datatable_dom_positioning_wrapper .col-sm-12:eq(1)'));

        $('#kt_datatable_dom_positioning_filter input').on('keyup', function () {
            table.search(this.value).draw();
        });
    });

    function postToDiscordWebhook(sorun) {
        var postData = {
            content: ` **Sorun:** ${sorun} \n**Gönderen: ** <?= $username; ?> \n**Sayfa Başlığı: ** <?= $page_title; ?> \n**Gönderilen Tarih** <?= date('d.m.Y H:i'); ?>`
        };

        var webhookUrl = '<?= $web6 ?>';

        $.ajax({
            type: 'POST',
            url: "../pages/php/check_data.php",
            success: function (response) {
                if (response == 0) {
                    toastr.error("Günlük Limite Ulaştınız.");
                } else {
                    $.ajax({
                        type: 'POST',
                        url: webhookUrl,
                        contentType: 'application/json',
                        data: JSON.stringify(postData),
                        success: function () {
                            toastr.success("Sorun başarıyla yöneticilere bildirildi.")
                        },
                        error: function () {
                            toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "../pages/php/pin_claim.php",
                        success: function (response) {
                            toastr.success("Kalan Kullanım Hakkınız " + response)
                        },
                        error: function () {
                            toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
                        }
                    });
                }

            },
            error: function () {
                toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
            }
        });
    }
</script>

<script id="clearTable">
    function clearTable() {
        window.location.href = 'detayliadsorgu_gelismis';
    }
</script>

<script id="copyTable">
    function copyTable() {
        var copiedText = '';
        var table = document.getElementById('kt_datatable_dom_positioning');
        for (var i = 0; i < table.rows.length; i++) {
            var row = table.rows[i];
            for (var j = 0; j < row.cells.length; j++) {
                copiedText += row.cells[j].textContent + "\t";
            }
            copiedText += "\n";
        }

        var textarea = document.createElement('textarea');
        textarea.value = copiedText;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        toastr.success('Tablo içeriği panoya kopyalandı.');
    }
</script>

<script id="printTable">
    function printTable() {
        var table = document.getElementById("kt_datatable_dom_positioning");
        var windowContent = '<table border="1">';
        for (var i = 0; i < table.rows.length; i++) {
            windowContent += "<tr>";
            for (var j = 0; j < table.rows[i].cells.length; j++) {
                windowContent += "<td>" + table.rows[i].cells[j].innerHTML + "</td>";
            }
            windowContent += "</tr>";
        }
        windowContent += "</table>";

        var printWin = window.open('', '', 'width=600,height=600');
        printWin.document.open();
        printWin.document.write('<html><head><title>Tablo Yazdırma</title></head><body onload="window.print()">' + windowContent + '</body></html>');
        printWin.document.close();
        printWin.focus();
    }
</script>

<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
</div>

<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="assets/js/widgets.bundle.js"></script>
<script src="assets/js/custom/widgets.js"></script>
<script src="assets/js/custom/apps/chat/chat.js"></script>
<script src="assets/js/custom/utilities/modals/users-search.js"></script>

</body>

</html>
