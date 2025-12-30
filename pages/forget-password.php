<?php

session_start();

if (!empty($_SESSION['GET_USER_SSID'])) {
    header('location: ../home');
    exit;
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <?php include 'inc/header_main.php'; ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous">
</head>

<body id="kt_body" class="auth-bg">
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    <div class="d-flex flex-stack py-2">
                        <div class="me-2">
                            <a href="../login" class="btn btn-icon bg-light rounded-circle">
                                <i class="ki-duotone ki-black-left fs-2 text-gray-800"></i> </a>
                        </div>

                        <div class="m-0">
                            <span class="text-gray-400 fw-bold fs-5 me-2" data-kt-translate="new-password-head-desc">
                                Giriş yapmak istiyor musunuz?
                            </span>

                            <a href="../login" class="link-primary fw-bold fs-5" data-kt-translate="new-password-head-link">
                                Giriş Yap
                            </a>
                        </div>
                    </div>
                    <div class="py-20">
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" action="#">
                            <div class="text-start mb-10">
                                <h1 class="text-dark mb-3 fs-3x" data-kt-translate="new-password-title">
                                    Şifremi Unuttum
                                </h1>
                                <div class="text-gray-400 fw-semibold fs-6" data-kt-translate="new-password-desc">
                                    Parolayı buradan sıfırlayabilirsiniz.
                                </div>
                            </div>
                            <div class="mb-10 fv-row">
                                <div class="mb-1">
                                    <div class="fv-row mb-10">
                                        <input class="form-control form-control form-control-solid" type="email" placeholder="Email Adresi" name="email" autocomplete="off" data-kt-translate="new-password-confirm-password" />
                                    </div>

                                    <div class="fv-row mb-10">
                                        <input class="form-control form-control form-control-solid" type="text" placeholder="Kullanıcı Adınız" name="secret_answer" autocomplete="off" data-kt-translate="new-password-confirm-password" />
                                    </div>

                                    <div class="position-relative mb-3" data-kt-password-meter="true">
                                        <input class="form-control form-control form-control-solid" id="password" type="password" placeholder="Yeni Parola" name="new_password" autocomplete="off" data-kt-translate="new-password-input-password" />

                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n5">
                                            <i class="ki-duotone ki-eye-slash fs-2"></i> <i class="ki-duotone ki-eye fs-2"></i>
                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </span>
                                    </div>

                                </div>

                            </div>

                            <div class="d-flex flex-stack">
                                <button id="kt_sign_up_submit" class="btn btn-light-success form-control" data-kt-translate="new-password-submit">
                                    <span class="indicator-label">
                                        <i class="fa fa-lock-open"></i>&nbsp; Onayla</span>
                                </button>
                            </div>
                            <br>
                                <div class="d-flex flex-stack">
                                        <button type="button" onclick="window.location = '<?= $telegram; ?>'"  class="btn btn-primary form-control"><i class="fab fs-2 fa-telegram"></i> Telegram</button>
                                        &nbsp;&nbsp;
                                        <button type="button" onclick="window.location = '<?= $discord; ?>'" class="btn btn-primary form-control" style="background-color: #5865F2;"><i class="fab fs-2 fa-discord"></i> Discord</button>
                                </div>
                        </form>
                    </div>

                    <div class="m-0">
                        <button class="btn btn-flex btn-link rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                            <img data-kt-element="current-lang-flag" class="w-25px h-25px rounded-circle me-3" src=".././assets/media/flags/turkey.svg" alt="" />
                            <span data-kt-element="current-lang-name" class="me-2">Türkçe</span>
                            <i class="ki-duotone ki-down fs-2 text-muted rotate-180 m-0"></i> </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4" data-kt-menu="true" id="kt_auth_lang_menu">
                            <div class="menu-item px-3">
                                <a href="#" onclick="deleteAllCookies()" class="menu-link d-flex px-5" data-kt-lang="Turkish">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src=".././assets/media/flags/turkey.svg" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Türkçe</span>
                                </a>
                            </div>
                            <script>
                                function deleteAllCookies() {
                                    var cookies = document.cookie.split(";");

                                    for (var i = 0; i < cookies.length; i++) {
                                        var cookie = cookies[i];
                                        var eqPos = cookie.indexOf("=");
                                        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                                        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                                    }

                                    // Sayfayı yenile
                                    location.reload();
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src=".././assets/plugins/global/plugins.bundle.js"></script>
    <script src=".././assets/js/scripts.bundle.js"></script>
    <script src=".././assets/js/custom/authentication/sign-in/i18n.js"></script>
    <script src=".././assets/js/custom/authentication/sign-in/general.js"></script>
    <script src=".././assets/js/custom/password.js"></script>