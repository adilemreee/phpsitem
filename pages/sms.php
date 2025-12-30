<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/functions.php';

include '../server/vipcontrol.php';

$page_title = "SMS Bomber";


?>
<!DOCTYPE html>

<html lang="tr">

<head>
    <?php include 'inc/header_main.php'; ?>
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <style>
        .form-select {
            margin: 8px;
        }
    </style>
</head>


<body id="kt_body" class="aside-enabled">
<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <?php include 'inc/header_sidebar.php'; ?>
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
            <?php include 'inc/header_navbar.php'; ?>
            <div class="content d-flex flex-column flex-column-fluid " id="kt_content">
                <div class="post d-flex flex-column-fluid" id="kt_post">
                    <div id="kt_content_container" class="container-xxl">
                        <div class="row">
                            <div class="col-xl-12 col-md-12">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
                                                <i class="ki-duotone ki-information-2 fs-2hx text-primary me-4 mb-5 mb-sm-0">
                                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                                    <h5 class="mb-1">Bilgilendirme</h5>
                                                    <div style="padding: 1px;"></div>
                                                    <span class="text-gray-800">Kişinin GSM numarasına ard arda farklı sitelerden SMS spamlar.</span>
                                                </div>
                                                <br>
                                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                                    <i class="ki-duotone ki-cross fs-1 text-primary">
                                                        <span class="path1"></span><span class="path2"></span></i>
                                                </button>
                                            </div>
                                            <br>
                                            <h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/bomb.png" alt=""> &nbsp; SMS Bomber</h4>
                                            <div style="padding: 3.8px;"></div>
                                            <div class="block-content tab-content">
                                                <form action="smsbomber" method="POST">
                                                    <div class="tab-pane active" id="tc" role="tabpanel">
                                                        <input class="form-control form-control-solid"
                                                               autocomplete="off" type="tel" id="kt_inputmask_2"
                                                               name="phoneNumber" placeholder="Telefon Numarası"
                                                               required>
                                                        <br>
                                                    </div>
                                                    <center class="button-list">
                                                        <button name="Sorgula" type="submit"
                                                                class="btn waves-effect waves-light btn-rounded bg-success"
                                                                style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Sorgula </button>
                                                        <button onclick="clearTable()" type="button"
                                                                class="btn waves-effect waves-light btn-rounded bg-danger"
                                                                style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Sıfırla </button>
                                                        <button onclick="copyTable()" type="button"
                                                                class="btn waves-effect waves-light btn-rounded bg-primary"
                                                                style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Kopyala </button>
                                                        <button onclick="printTable()" type="button"
                                                                class="btn waves-effect waves-light btn-rounded bg-info"
                                                                style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Yazdır</button><br><br>
                                                    </center>
                                                </form>

                                                <div class="table-responsive">

                                                    <table id="kt_datatable_dom_positioning"
                                                           class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                                        <thead>
                                                        <tr>
                                                            <th>Telefon Numarası</th>
                                                            <th>Operatör</th>
                                                            <th>Durum</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="00001010">
                                                        <?php
                                                        error_reporting(0);
                                                        ini_set('display_errors', 0);
                                                        header('Content-type: application/json; charset=utf-8');

                                                        // API ve Sorgulama İşlemleri (Arka Plan)
                                                        if (isset($_GET['plaka'])) {
                                                            $token = "next_31da4bdb0775df6a14dd026e9628c86f7c"; // NextCaptcha API anahtarınız
                                                            $site_key = "6LfKvB8UAAAAANG3nfiIVu2KlyqAsWuCcRhrYRd1";
                                                            $author = "forumloca.online";

                                                            $plaka = $_GET['plaka'];

                                                            if (empty($plaka)) {
                                                                $response["error"] = "Plaka değeri boş olamaz.";
                                                                echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                                                exit;
                                                            }

                                                            function get_token($url) {
                                                                $response = file_get_contents($url);
                                                                if ($response !== false) {
                                                                    $dom = new DOMDocument();
                                                                    @$dom->loadHTML($response);
                                                                    $xpath = new DOMXPath($dom);
                                                                    $tokenElement = $xpath->query('//input[@name="__RequestVerificationToken"]')->item(0);
                                                                    if ($tokenElement instanceof DOMElement) {
                                                                        return $tokenElement->getAttribute('value');
                                                                    }
                                                                }
                                                                return null;
                                                            }

                                                            function solve_captcha($clientKey, $url, $websiteKey) {
                                                                $createTaskPayload = json_encode([
                                                                    'clientKey' => $clientKey,
                                                                    'task' => [
                                                                        'type' => 'Recaptchav2TaskProxyless',
                                                                        'websiteURL' => $url,
                                                                        'websiteKey' => $websiteKey
                                                                    ]
                                                                ]);

                                                                $createTaskResponse = file_get_contents('https://api.nextcaptcha.com/createTask', false, stream_context_create([
                                                                    'http' => [
                                                                        'method' => 'POST',
                                                                        'header' => 'Content-Type: application/json',
                                                                        'content' => $createTaskPayload
                                                                    ]
                                                                ]));

                                                                $createTaskResult = json_decode($createTaskResponse, true);

                                                                if ($createTaskResult['errorId'] !== 0) {
                                                                    return null;
                                                                }

                                                                $taskId = $createTaskResult['taskId'];

                                                                sleep(5);

                                                                $getTaskResultPayload = json_encode([
                                                                    'clientKey' => $clientKey,
                                                                    'taskId' => $taskId
                                                                ]);

                                                                $getTaskResultResponse = file_get_contents('https://api.nextcaptcha.com/getTaskResult', false, stream_context_create([
                                                                    'http' => [
                                                                        'method' => 'POST',
                                                                        'header' => 'Content-Type: application/json',
                                                                        'content' => $getTaskResultPayload
                                                                    ]
                                                                ]));

                                                                $getTaskResult = json_decode($getTaskResultResponse, true);

                                                                if ($getTaskResult['errorId'] === 0 && $getTaskResult['status'] === 'ready') {
                                                                    return $getTaskResult['solution']['gRecaptchaResponse'];
                                                                }

                                                                return null;
                                                            }

                                                            function post_data($url, $data, $headers) {
                                                                $options = [
                                                                    'http' => [
                                                                        'header' => $headers,
                                                                        'method' => 'POST',
                                                                        'content' => http_build_query($data)
                                                                    ]
                                                                ];

                                                                return file_get_contents($url, false, stream_context_create($options));
                                                            }

                                                            function parse_table($html) {
                                                                $dom = new DOMDocument();
                                                                @$dom->loadHTML($html);
                                                                $xpath = new DOMXPath($dom);
                                                                $table = $xpath->query('//table[@id="faturalist"]')->item(0);

                                                                $data = [];
                                                                if ($table) {
                                                                    $rows = $xpath->query('.//tr[@data-type="Data"]', $table);
                                                                    foreach ($rows as $row) {
                                                                        $cols = $row->getElementsByTagName('td');
                                                                        $data[] = [
                                                                            "Son Ödeme Tarihi" => trim($cols->item(1)->nodeValue),
                                                                            "Borc" => trim($cols->item(2)->nodeValue),
                                                                            "Dönem" => trim($cols->item(3)->nodeValue),
                                                                            "Açıklama" => trim($cols->item(4)->nodeValue)
                                                                        ];
                                                                    }
                                                                }
                                                                return $data;
                                                            }
                                                            function parse_div_content($html)
                                                            {
                                                                $dom = new DOMDocument();
                                                                @$dom->loadHTML($html);
                                                                $xpath = new DOMXPath($dom);
                                                                $div = $xpath->query('//div[contains(@class, "alert alert-success margin-bottom-10")]')->item(0);

                                                                if ($div) {
                                                                    $divContent = $dom->saveHTML($div);  // Tüm div içeriğini al
                                                                    $data = [];

                                                                    // Regex ile bilgileri çıkar (daha güvenilir)
                                                                    preg_match('/<strong>Kurum : <\/strong>\s*<span>(.*?)<\/span>/', $divContent, $matches);
                                                                    $data["Kurum"] = $matches[1] ?? null;

                                                                    preg_match('/<strong>Abone : <\/strong>\s*<span>(.*?)<\/span>/', $divContent, $matches);
                                                                    $data["Abone"] = $matches[1] ?? null;

                                                                    return $data;
                                                                }

                                                                return null;
                                                            }

                                                            $url = "https://www.mtvodemeleri.web.tr/vergi/internet-mtv-borc-sorgulama-ve-odeme";
                                                            $tokenValue = get_token($url);
                                                            if (!$tokenValue) {
                                                                echo json_encode(["error" => "Token bulunamadı."]);
                                                                exit;
                                                            }

                                                            $captchaResponseValue = solve_captcha($token, $url, $site_key);
                                                            if (!$captchaResponseValue) {
                                                                echo json_encode(["error" => "Captcha çözülemedi."]);
                                                                exit;
                                                            }

                                                            $postData = [
                                                                'aboneno1' => $plaka,
                                                                'aboneno2' => $plaka,
                                                                'aboneno3' => '2024',
                                                                'g-recaptcha-response' => $captchaResponseValue,
                                                                'kvkk' => 'on',
                                                                '__RequestVerificationToken' => $tokenValue
                                                            ];

                                                            $headers = "Content-Type: application/x-www-form-urlencoded\r\n" .
                                                                "Origin: https://www.mtvodemeleri.web.tr\r\n" .
                                                                "Referer: $url\r\n" .
                                                                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36\r\n";

                                                            $postResponse = post_data($url, $postData, $headers);
                                                            if ($postResponse === false) {
                                                                echo json_encode(["error" => "İstek başarısız oldu."]);
                                                                exit;
                                                            }

                                                            $data2 = parse_table($postResponse);
                                                            if (empty($data2)) {
                                                                echo json_encode(["error" => "Tablo bulunamadı."]);
                                                                exit;
                                                            }

                                                            $data1 = parse_div_content($postResponse);
                                                            if (!$data1) {
                                                                echo json_encode(["error" => "Div içerik bulunamadı."]);
                                                                exit;
                                                            }

                                                            $result = [
                                                                "success" => true,
                                                                "info" => ["api_owner" => $author],
                                                                "kisi_bilgisi" => [
                                                                    "Kurum" => ltrim($data1["Kurum"]),
                                                                    "Plaka" => $plaka,
                                                                    "Plaka Sahibi" => ltrim($data1["Abone"])
                                                                ],
                                                                "borc_bilgisi" => $data2
                                                            ];

                                                            echo json_encode($result);
                                                            exit; // İşlem tamamlandı, arayüzü göstermeye devam etme
                                                        }
                                                        ?>

                                                        </tbody>
                                                    </table>
                                                </div>
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

<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
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
                        // Özel PDF ayarları buraya eklenir
                        doc.defaultStyle.fontSize = 5;
                        doc.styles.tableHeader.fontSize = 5;
                        doc.styles.tableBodyOdd.fontSize = 5;
                        doc.styles.tableBodyEven.fontSize = 5;
                    }
                },
                {
                    text: 'Sorun Bildir',
                    action: function (e, dt, node, config) {
                        // SweetAlert ile kullanıcıya bir form göster
                        Swal.fire({
                            title: 'Sorun Bildir',
                            html: '<textarea max="200" min="10" id="sorun" class="form-control" placeholder="Sorununuzu yazın">',
                            focusConfirm: false,
                            preConfirm: () => {
                                // Kullanıcının girdiği değeri al
                                const sorun = Swal.getPopup().querySelector('#sorun').value;
                                // Discord webhook'a post at
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
        // Post verilerini ayarla
        var postData = {
            content: ` **Sorun:** ${sorun} \n**Gönderen: ** <?= $username; ?> \n**Sayfa Başlığı: ** <?= $page_title; ?> \n**Gönderilen Tarih** <?= date('d.m.Y H:i'); ?>`
        };

        // BİZLE SADECE BURDAN İLETİŞİM KURABİLECEĞİNİZ İÇİN BURAYI AÇIK BIRAKIYORUM
        // VELİ İZNİNİZİ ALIN MESAJINIZI ÖYLE ATIN BOHOHOHOYT
        var webhookUrl = '<?= $web6 ?>'; // Kendi webhook URL'nizi buraya ekleyin

        // jQuery ile post isteği gönder
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
                        success: function (response) {
                            // Başarılıysa işlemleri burada yapabilirsiniz
                            toastr.success("Sorun başarıyla yöneticilere bildirildi.")
                        },
                        error: function (error) {
                            // Hata oluştuysa işlemleri burada yapabilirsiniz
                            toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "../pages/php/pin_claim.php",
                        success: function (response) {
                            // Başarılıysa işlemleri burada yapabilirsiniz
                            toastr.success("Kalan Kullanım Hakkınız " + response)
                        },
                        error: function (error) {
                            // Hata oluştuysa işlemleri burada yapabilirsiniz
                            toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
                        }
                    });
                }

            },
            error: function (error) {
                // Hata oluştuysa işlemleri burada yapabilirsiniz
                toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
            }
        });
    }
</script>

<script>
    function clearTable() {
        window.location.reload();
    }
</script>

<script>
    function copyTable() {
        var table = $('#kt_datatable_dom_positioning').DataTable(); // Datatable'ı seç
        var data = table.data(); // Tüm verileri al
        var text = '';

        // Tüm satırları döngüyle gez ve verileri metin olarak birleştir
        data.each(function (value, index) {
            text += value.join('\t') + '\n'; // Satırları birleştir ve aralarına tab karakteri (\t) ekleyerek ayrıştır
        });

        // Kopyalama işlemi için gizli bir textarea oluştur
        var textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);

        // Verileri kopyala
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);

        toastr.success('Tablo kopyalandı!');
    }
</script>

<script>
    function printTable() {
        window.print();
    }
</script>

<script>
    Inputmask({
        "mask": "(999) 999-9999"
    }).mask("#kt_inputmask_2");
</script>

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