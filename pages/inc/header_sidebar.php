<?php

$session_id = $_SESSION['GET_USER_SSID'];

$query = $db->query("SELECT * FROM `accounts` WHERE hash = '$session_id'");

while ($data = $query->fetch()) {
    $username = base64_decode($data['username']);
    $email = base64_decode($data['email']);
    $access_level = $data['access_level'];
    $secret_question = $data['secret_question'];
    $secret_answer = $data['secret_answer'];
    $hide_username = $data['hide_username'];
    $last_login_time = $data['last_login_time'];
    $exp = $data['exp'];
    $profile_image = $data['profile_image'];
    $success_login_count = $data['success_login_count'];
    $failed_login_count = $data['failed_login_count'];
    $suspect_login_count = $data['suspect_login_count'];
    $balance = $data['balance'];
    $premium = $data['premium'];
    $register_date = $data['register_date'];
    $tcvip = $data['tcvip'];
    $total_query = $data['total_query'];
    $expiration_date = $data['expiration_date'];
    $pin_claim = $data['pin_claim'];
    $ts_last_spin = $data['ts_last_spin'];
}

$hookquery = $db->query("SELECT * FROM `webhooks`");

while ($hookdata = $hookquery->fetch()) {
    $web1 = $hookdata['confirmationHook'];
    $web2 = $hookdata['cookieChangeHook'];
    $web5 = $hookdata['multiHook'];
    $web6 = $hookdata['reportHook'];
    $web7 = $hookdata['adminHook'];
    $web8 = $hookdata['queryHook'];
    $web9 = $hookdata['vipqueryHook'];
}

if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ip = $_SERVER['HTTP_CLIENT_IP'];
else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if (isset($_SERVER['HTTP_X_FORWARDED']))
    $ip = $_SERVER['HTTP_X_FORWARDED'];
else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_FORWARDED_FOR'];
else if (isset($_SERVER['HTTP_FORWARDED']))
    $ip = $_SERVER['HTTP_FORWARDED'];
else if (isset($_SERVER['REMOTE_ADDR']))
    $ip = $_SERVER['REMOTE_ADDR'];
else
    $ip = 'Bilinmiyor';


if ($hide_username == "true") {
    $username_privacy = "Gizlendi";
} else {
    $username_privacy = "Gizlenmedi";
}

function rankName($access_level)
{
    if ($access_level >= 6) {
        $rank = "Admin";
    } else if ($access_level >= 5) {
        $rank = "Alt Bayi";
    } else if ($premium >= time() or $access_level == 4) {
        $rank = "Premium Üye";
    } else if ($access_level <= 3) {
        $rank = "Ücretsiz Üyelik";
    }
    return $rank;
}

$rank = rankName($access_level);

if ($exp >= 0 && $exp < 500) {
    $rankName = "Cyber Shadow";
    $level = "1. Seviye";
    $img = 1;
} elseif ($exp >= 500 && $exp < 1000) {
    $rankName = "Code Whisperer";
    $level = "2. Seviye";
    $img = 1;
} elseif ($exp >= 1000 && $exp < 1500) {
    $rankName = "Data Phantom";
    $level = "3. Seviye";
    $img = 1;
} elseif ($exp >= 1500 && $exp < 2000) {
    $rankName = "Encryption Wizard";
    $level = "4. Seviye";
    $img = 1;
} elseif ($exp >= 2000 && $exp < 2500) {
    $rankName = "Firewall Breaker";
    $level = "5. Seviye";
    $img = 1;
} elseif ($exp >= 2500 && $exp < 3000) {
    $rankName = "Malware Slayer";
    $level = "6. Seviye";
    $img = 2;
} elseif ($exp >= 3000 && $exp < 3500) {
    $rankName = "Database Ninja";
    $level = "7. Seviye";
    $img = 2;
} elseif ($exp >= 3500 && $exp < 4000) {
    $rankName = "Stealth Hacker";
    $level = "8. Seviye";
    $img = 2;
} elseif ($exp >= 4000 && $exp < 4500) {
    $rankName = "Zero-Day Master";
    $level = "9. Seviye";
    $img = 2;
} elseif ($exp >= 4500 && $exp < 5000) {
    $rankName = "Binary Ghost";
    $level = "10. Seviye";
    $img = 2;
} elseif ($exp >= 5000 && $exp < 5500) {
    $rankName = "Digital Saboteur";
    $level = "11. Seviye";
    $img = 3;
} elseif ($exp >= 5500 && $exp < 6000) {
    $rankName = "Trojan Hunter";
    $level = "12. Seviye";
    $img = 3;
} elseif ($exp >= 6000 && $exp < 6500) {
    $rankName = "Root Access Master";
    $level = "13. Seviye";
    $img = 3;
} elseif ($exp >= 6500 && $exp < 7000) {
    $rankName = "Exploit Enforcer";
    $level = "14. Seviye";
    $img = 3;
} elseif ($exp >= 7000 && $exp < 7500) {
    $rankName = "Cipher Sentinel";
    $level = "15. Seviye";
    $img = 3;
} elseif ($exp >= 7500 && $exp < 8000) {
    $rankName = "Bug Bounty Hunter";
    $level = "16. Seviye";
    $img = 4;
} elseif ($exp >= 8000 && $exp < 8500) {
    $rankName = "Cyber Mercenary";
    $level = "17. Seviye";
    $img = 4;
} elseif ($exp >= 8500 && $exp < 9000) {
    $rankName = "Deep Web Explorer";
    $level = "18. Seviye";
    $img = 5;
} elseif ($exp >= 9000 && $exp < 9500) {
    $rankName = "Script Kiddie Whisperer";
    $level = "19. Seviye";
    $img = 5;
} elseif ($exp >= 10000) {
    $rankName = "Virtual Vigilante";
    $level = "20. Seviye";
    $img = 6;
} else {
    $rankName = "Bilinmeyen";
    $level = "";
    $img = 1;
}

?>

<div class="page-loader">
    <span class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </span>
</div>

<script>
    const loadingEl = document.createElement("div");

    document.body.append(loadingEl);
    loadingEl.classList.add("page-loader");
    loadingEl.innerHTML = `
        <span class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Yükleniyor...</span>
        </span>
    `;

    KTApp.showPageLoading();

    setTimeout(function () {
        KTApp.hidePageLoading();
        loadingEl.remove();
    }, 3000);
</script>

<div id="kt_aside" class="aside" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-toolbar flex-column-auto" id="kt_aside_toolbar">
        <div class="aside-user d-flex align-items-sm-center justify-content-center py-5">
            <div class="symbol symbol-50px">
                <?php

                if (empty($profile_image)) {

                    ?>
                    <img src="assets/media/svg/avatars/blank.jpg">
                    <?php

                } else {

                    ?>
                    <img src="<?= $profile_image; ?>">
                    <?php
                }

                ?>
                <?php
                if ($access_level >= 6) {
                    $textcolor = "danger";
                } else if ($access_level == 5) {
                    $textcolor = "warning";
                }
                else if ($premium >= time() or $access_level == 4) {
                    $textcolor = "info";
                }  else {
                    $textcolor = "gray-600";
                }
                ?>
            </div>
            <div class="aside-user-info flex-row-fluid flex-wrap ms-5">
                <div class="d-flex">
                    <div class="flex-grow-1 me-2">
                        <a href="#" class="text-white text-hover-primary fs-6 fw-bold">
                            <?= $username; ?> <img src="../../assets/img/verified.png" width="16px">
                        </a>
                        <span class="text-<?php echo $textcolor; ?> fw-semibold d-block fs-8 mb-1">
                            <?= $rank; ?>
                        </span>
                        <div class="d-flex align-items-center text-success fs-9">
                            <span class="bullet bullet-dot bg-success me-1"></span>
                            <span class="text-success fw-semibold d-block fs-8 mb-1">Çevrimiçi</span>
                        </div>
                    </div>

                    <div class="me-n2">
                        <a href="#" class="btn btn-icon btn-sm btn-active-color-primary mt-n2"
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start"
                            data-kt-menu-overflow="true">
                            <i class="ki-duotone ki-setting-2 text-muted fs-1"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </a>

                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <?php

                                        if (empty($profile_image)) {

                                            ?>
                                            <img src="assets/media/svg/avatars/blank.jpg">
                                            <?php

                                        } else {

                                            ?>
                                            <img src="<?= $profile_image; ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">
                                            <?= $username; ?> <span
                                                class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">
                                                <?= $rank; ?>
                                            </span>
                                        </div>

                                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                            <?= $email; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="separator my-2"></div>

                            <div class="menu-item px-5">
                                <a href="overview" class="menu-link px-5">
                                    Hesap Ayarları
                                </a>
                            </div>

                            <div class="separator my-2"></div>

                            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                data-kt-menu-placement="right-start" data-kt-menu-offset="-15px, 0">
                                <a href="#" class="menu-link px-5">
                                    <span class="menu-title position-relative">
                                        Dil Seçenekleri

                                        <span
                                            class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                            Türkçe <img class="w-15px h-15px rounded-1 ms-2"
                                                src="assets/media/flags/turkey.svg" alt="" />
                                        </span>
                                    </span>
                                </a>

                            </div>



                            <div class="menu-item px-5">
                                <a onclick="logout();" class="menu-link px-5">
                                    Çıkış Yap
                                </a>
                            </div>

                            <script>
                                // Çıkış yapma işlemi
                                function logout() {
                                    swal.fire({
                                        title: "Çıkış Yapmak İstiyor Musunuz?",
                                        text: "Emin misiniz? Oturumunuz sonlandırılacak.",
                                        icon: "warning",
                                        dangerMode: true,
                                        confirmButtonText: 'Evet',
                                        cancelButtonText: 'Hayır',
                                        showCancelButton: true,
                                        showCloseButton: true
                                    }).then((willLogout) => {
                                        if (willLogout.isConfirmed) {
                                            window.location.href = "logout";
                                        } else {
                                            toastr.info("Çıkış yapma işlemi iptal edildi.");
                                        }
                                    });
                                }
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="aside-search">
           
        </div>
    </div>

    <div class="aside-menu flex-column-fluid">
        <div class="hover-scroll-overlay-y mx-3 my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="{default: '#kt_aside_toolbar, #kt_aside_footer', lg: '#kt_header, #kt_aside_toolbar, #kt_aside_footer'}"
            data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="5px">
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">

                <div class="menu-item menu-accordion" onclick="window.location = 'home'">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-home-1 text-success fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                        <span class="menu-title">Ana Sayfa</span>
                </div>


                <div class="menu-item menu-accordion" onclick="window.location = 'ranking'">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-ranking text-danger fs-2">
                                <i class="path1"></i>
                                <i class="path2"></i>
                                <i class="path3"></i>
                                <i class="path4"></i>
                            </i>
                        </span>
                        <span class="menu-title">Kullanıcı Sıralaması </span>
                </div>


                <?php

                if ($access_level == 6) {

                ?>

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-crown fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Admin Paneli</span><span class="menu-arrow"></span></span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item"><a class="menu-link" href="odemeler"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ödemeler</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="general-settings"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ayarlar</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="verify-account"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Kullanıcı Onay</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="users"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Kullanıcı Listesi</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="management-notify"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bildirim Yönetimi</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="comments-notify"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bildirim Yorumları</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="ban"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ban Yönetimi</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="premium"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Premium Üyelik Yönetimi</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="whitelist"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Whitelist Yönetimi</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="sessions"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Kullanıcı Giriş Kayıtları</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="add-money"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bakiye Ekle</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="money-transfers"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bakiye Transferleri</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="add-file"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Dosya Paylaşma</span></a></div>
                            <div class="menu-item"><a class="menu-link" href="comments-file"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Dosya Yorumları</span></a></div>
                        </div>
                    </div>

                <?php
                }
                ?>
                <div class="menu-item pt-0">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold fs-7">Market</span>
                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-shop fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Mağaza İşlemleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="market"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Market</span><span class="badge badge-light-success"></span></a></div>
                        <div class="menu-item"><a class="menu-link" href="add-balance"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bakiye Yükle</span><span class="badge badge-light-success"></span></a></div>
                    </div>
                </div>

                <div class="menu-item pt-0">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold fs-7">Sorgu Çözümleri</span>
                    </div>
                </div>


                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-star text-danger fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Premium Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="tcsorguv2"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">TC Sorgu PRO</span><span class="badge badge-light-danger">Premium</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="multecisorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Mülteci Sorgu</span><span class="badge badge-light-danger">Premium</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="vergisorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Tapu Sorgu</span><span class="badge badge-light-danger">Premium</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="yabancisorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Yabancı Sorgu</span><span class="badge badge-light-danger">Premium</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="ttnetsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Öğretmen Sorgu</span><span class="badge badge-light-danger">Pasif</span></a></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-crown fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">AD-SOYAD Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="adsorgupro"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ad İl İlçe Sorgu</span><span class="badge badge-light-danger">Premium</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="detayliadsorgu_gelismis"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Detaylı Ad Soyad (Gelişmiş)</span><span class="badge badge-light-danger">Premium</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="adsoyadsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ad Soyad Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="detayliadsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Detaylı Ad Soyad Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-crown fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Adres Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="adressorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Adres Sorgu</span><span class="badge badge-light-info">FREE</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="plakasorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Güncel Adres Sorgu</span><span class="badge badge-light-success">Yuri</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="hanesorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Hane Sorgu</span><span class="badge badge-light-success">AKTİF</span></a></div>
                    </div>
                </div>




                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-profile-user fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Aile Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="ailesorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Aile Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="soyagacisorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Soyağacı Sorgu</span><span class="badge badge-light-success">101M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="soyagacisorgu4"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Soyağacı Sorgu(109M)</span><span class="badge badge-light-info">YENİ</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="evliliksorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Evlilik Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="akrabasorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Akraba Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="anneailesorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Anne Tarafı Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="babaailesorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Baba Tarafı Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="annesorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Anne Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="babasorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Baba Sorgu</span><span class="badge badge-light-success">109M</span></a></div>
                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-phone fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">GSM Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="gsmtc"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">GSM -> TC</span><span class="badge badge-light-success">145M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="tcgsm"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">TC -> GSM</span><span class="badge badge-light-success">145M</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="gsmisim"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">GSM -> İsim</span><span class="badge badge-light-success">145M</span></a></div>

                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-wrench fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Diğer Çözümler</span><span class="badge badge-light-success">Aktif</span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="ttnettsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">TTNET Sorgu</span></a></div>
                    </div>
                </div>
                <div class="menu-item pt-0">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold fs-7">Yardımcı Araçlar</span>
                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-wrench fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Araçlar</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
<!--                        <div class="menu-item"><a class="menu-link" href="smsbomber"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">SMS Bomber</span><span class="badge badge-light-danger">Premium</span></a></div>-->
                        <div class="menu-item"><a class="menu-link" href="discordsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Discord Sorgu</span><span class="badge badge-light-success">2025</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="ipsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">IP Sorgu</span><span class="badge badge-light-success">2025</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="iban"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">IBAN Sorgu</span><span class="badge badge-light-success">2025</span></a></div>
                        
                    </div>
                </div>
                                <div class="menu-item menu-accordion" onclick="window.location = 'dosyalar'">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-flash-circle fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                        <span class="menu-title">Dosya Paylaşımı</span> <span class="badge badge-light-success">Yeni</span>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-picture fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Kimlik Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="kimlikolusturucu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Kimlik Oluşturucu</span></a></div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-like fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Eğlence Çözümleri</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="burcsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Burç Sorgu</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="cennetsorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Cennet Sorgu</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="ayaknosorgu"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ayak Numarası Sorgu</span></a></div>
                    </div>
                </div>
                <div class="menu-item pt-0">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold fs-7">Carder Özel</span>
                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span class="menu-icon"><i class="ki-duotone ki-credit-cart fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span><span class="menu-title">Carder Özel</span><span class="menu-arrow"></span></span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item"><a class="menu-link" href="cc"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">CC Checker</span><span class="badge badge-light-success">2024</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="binchecker"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">BIN Checker</span><span class="badge badge-light-success">2024</span></a></div>
                        <div class="menu-item"><a class="menu-link" href="dnschecker"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">DNS Checker</span><span class="badge badge-light-success">2024</span></a></div>
                    </div>
                </div>
               
                <div class="menu-item pt-0">
                    <div class="menu-content">
                        <span class="menu-heading fw-bold fs-7">Sosyal Alanlar</span>
                    </div>
                </div>

                <div class="menu-item menu-accordion" onclick="window.location = 'logout'">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-duotone ki-toggle-off fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </span>
                        <span class="menu-title">Çıkış Yap</span>
                </div>
            </div>
        </div>
    </div>
</div>
