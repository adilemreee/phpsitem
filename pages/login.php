<?php

session_start();

if (!empty($_SESSION['GET_USER_SSID'])) {
    header('location: ../home');
    exit;
}

include '../server/database.php';

$systemStmt = $db->query("SELECT multiSystem FROM `systems` LIMIT 1");
$systemData = $systemStmt->fetch(PDO::FETCH_ASSOC);
$multiSystem = $systemData['multiSystem'] ?? 'no';
$allowAdminLogin = isset($_GET['admin']) && $_GET['admin'] === '1';

if ($multiSystem === "yes" && !$allowAdminLogin) {
    header('location: ../bakim');
    exit;
}

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <?php include 'inc/header_main.php'; ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/snowfall/dist/css/snowfall.css">
</head>

<style>
    body {
        background-color: black;
    }
</style>


<body id="kt_body" class="auth-bg">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
            <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                <div class="d-flex flex-stack py-2">
                    <div class="me-2"></div>
                </div>
                <div class="py-20">
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" action="#">
                        <div class="card-body">
                            <div class="text-center mb-10">
                                <img src="../assets/img/enyenii.png" width="300" alt="Logo" />
<!--                                <h1 class="text-white mb-3 fs-3x" data-kt-translate="sign-in-title">-->
<!--                                    Giriş Yap-->
<!--                                </h1>-->
                                <div class="text-gray-700 fw-semibold fs-6" data-kt-translate="general-desc">
                                    <span id="kt_typedjs_example_1" class="fs-2 fw-bold"></span>
                                </div>
                            </div>

                            <!-- Email input -->
                            <div class="fv-row mb-8">
                                <input type="email" placeholder="Email Adresi" name="email" autocomplete="off" data-kt-translate="sign-in-input-email" class="form-control form-control-solid" />
                            </div>

                            <!-- Password input -->
                            <div class="position-relative mb-5" data-kt-password-meter="true">
                                <input type="password" id="password" placeholder="Şifre" name="password" autocomplete="off" data-kt-translate="sign-in-input-password" class="form-control form-control-solid" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                    <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </span>
                            </div>

                            <!-- Şifremi Unuttum Linki -->
                            <div class="d-flex justify-content-end mb-5">
                                <a href="../forget-password" class="link-primary fw-bold fs-6">
                                    Şifremi Unuttum?
                                </a>
                            </div>

                            <!-- Additional options -->
                            <div class="d-flex justify-content-center align-items-center">
                                    <span class="text-gray-400 fw-bold fs-5 me-2" data-kt-translate="sign-in-head-desc">
                                        Henüz üye değil misiniz?
                                    </span>
                                <a href="../register" class="btn btn-link fw-bold fs-5 text-primary" data-kt-translate="sign-in-head-link">
                                    Kaydolun
                                </a>
                            </div>

                            <!-- Submit button -->
                            <div class="d-flex flex-stack">
                                <button id="kt_sign_up_submit" onclick="textChanger();" class="btn btn-success me-2 flex-shrink-0 form-control">
                                    <span class="indicator-label" data-kt-translate="sign-in-submit">
                                        <i class="fa fa-sign-in"></i>&nbsp; <span id="loginText">Giriş Yap</span>
                                    </span>
                                </button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>

                <!-- Language switcher -->

            </div>
        </div>
    </div>
</div>

<script>
    function textChanger() {
        var loginText = document.getElementById('loginText');
        setTimeout(() => loginText.innerText = "Bekleyin", 100);
        setTimeout(() => loginText.innerText = "Giriş Yap", 500);
    }
</script>
<script src=".././assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
<script>
    KTUtil.onDOMContentLoaded(function() {
        var typed = new Typed("#kt_typedjs_example_1", {
            strings: ["dünyanın", "hatta evrenin evrenin", "en iyi paneline", "giriş yapabilmen için ufak bir adım"],
            typeSpeed: 25
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src=".././assets/plugins/global/plugins.bundle.js"></script>
<script src=".././assets/js/scripts.bundle.js"></script>
<script src=".././assets/js/custom/authentication/sign-in/i18n.js"></script>
<script src=".././assets/js/custom/authentication/sign-in/general.js"></script>
<script src=".././assets/js/custom/login.js"></script>
</body>



</html>
