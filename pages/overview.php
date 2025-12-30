<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Bilgilerimi Görüntüle";

?>
<!DOCTYPE html>

<html lang="tr">

<head>
    <?php

    include 'inc/header_main.php';

    ?>
</head>


<body id="kt_body" class="aside-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php

            include 'inc/header_sidebar.php';

            ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'inc/header_navbar.php'; ?>
                <div class="content d-flex flex-column flex-column-fluid " id="kt_content">
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl ">
                            <div class="card mb-5 mb-xl-10">
                                <div class="card-body pt-9 pb-0">
                                    <div class="d-flex flex-wrap flex-sm-nowrap">
                                        <div class="me-7 mb-4">
                                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                                <?php

                                                if (empty($profile_image)) {

                                                ?>
                                                    <img src="../assets/media/svg/avatars/blank.jpg">
                                                <?php

                                                } else {

                                                ?>
                                                    <img src="<?= $profile_image; ?>">
                                                <?php
                                                }
                                                ?>
                                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $username; ?></a>
                                                        <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i></a>
                                                    </div>

                                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> <?= $rank; ?>
                                                        </a>
                                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                            <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span class="path2"></span></i> <?= $site_name; ?>
                                                        </a>
                                                        <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                                            <i class="ki-duotone ki-sms fs-4"><span class="path1"></span><span class="path2"></span></i> &nbsp;<?= $email; ?>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="d-flex my-4">
                                                    <a href="notification" class="btn btn-sm btn-light me-2">
                                                        <span class="indicator-label">
                                                            Bildirimleri Aç</span>
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-primary me-3" onclick="window.location.reload();">Yenile</a>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap flex-stack">
                                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="border border-gray-300 border-solid rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-duotone ki-medal-star fs-3 text-success me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                                <div class="fs-2 fw-bold"><?= $rankName; ?></div>
                                                            </div>
                                                            <div class="fw-semibold fs-6 text-gray-400">Rütbe Adı</div>

                                                        </div>
                                                        <div class="border border-gray-300 border-solid rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-duotone ki-abstract-23 fs-3 text-danger me-2"><span class="path1"></span><span class="path2"></span></i>
                                                                <div class="fs-2 fw-bold"><?= $exp; ?> XP</div>
                                                            </div>
                                                            <div class="fw-semibold fs-6 text-gray-400">Deneyim Puanı</div>
                                                        </div>

                                                        <div class="border border-gray-300 border-solid rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-duotone ki-crown fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                                                                <div class="fs-2 fw-bold"><?= $level; ?></div>
                                                            </div>
                                                            <div class="fw-semibold fs-6 text-gray-400">Seviye</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                                    <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                        <span class="fw-semibold fs-6 text-gray-400">Seviye İlerlemesi</span>
                                                        <?php

                                                        if ($exp >= 10000) {

                                                        ?>
                                                            <span class="fw-bold fs-6">100%</span>
                                                    </div>
                                                    <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                        <div class="bg-success rounded h-5px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                <?php

                                                        } else {

                                                            $maxExp = 10000; // Maksimum deneyim puanı (örneğin 10000)
                                                            $percent = ($exp / $maxExp) * 100;


                                                ?>
                                                    <span class="fw-bold fs-6"><?= $percent; ?>%</span>
                                                </div>
                                                <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                    <div class="bg-success rounded h-5px" role="progressbar" style="width: <?= $percent; ?>%;" aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            <?php
                                                        }
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="overview">
                                            Bilgilerimi Görüntüle </a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="settings">
                                            Bilgilerimi Düzenle </a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="security">
                                            Güvenlik Kayıtları </a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="balance">
                                            Bakiye Transferi </a>
                                    </li>

                                </ul>
                            </div>
                        </div>

                        <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                            <div class="card-header cursor-pointer">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Bilgilerimi Görüntüle</h3>
                                </div>
                                <a href="settings" class="btn btn-sm btn-primary align-self-center">Bilgilerimi Düzenle</a>
                            </div>
                            <div class="card-body p-9">
                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Kullanıcı Adı</label>
                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800"><?= $username; ?></span>
                                    </div>
                                </div>

                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Email Adresi</label>
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6"><?= $email; ?></span>
                                    </div>
                                </div>

                                <div class="row mb-7">
                                    <label class="col-lg-4 fw-semibold text-muted">Kalan Zaman</label>
                                    <div class="col-lg-8 fv-row">
                                        <span class="fw-semibold text-gray-800 fs-6">
                                            <?php

                                            if ($expiration_date == "0") {
                                                echo "SINIRSIZ";
                                            } else {
                                                // Bugünkü tarihi alın
                                                $current_date = date("Y-m-d");

                                                // Hesap bitiş tarihini ve bugünkü tarihi datetime nesnelerine dönüştürün
                                                $expiration_datetime = new DateTime($expiration_date);
                                                $current_datetime = new DateTime($current_date);

                                                // Farkı hesaplayın
                                                $date_diff = $current_datetime->diff($expiration_datetime);

                                                // Kalan gün sayısını alın
                                                $remaining_days = $date_diff->days;

                                                // Kalan gün sayısını ekrana yazdırın
                                                echo "Hesabınızın süresi dolmasına " . $remaining_days . " gün kaldı.";
                                            }

                                            ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="row mb-7">

                                    <label class="col-lg-4 fw-semibold text-muted">
                                        Takma Adımı Gizle
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Kullanıcı adınızı gizleyerek hem ana sayfada hem de sohbet kısmında anonim kalabilirsiniz.">
                                            <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> </span>
                                    </label>

                                    <div class="col-lg-8 d-flex align-items-center">
                                        <?php

                                        if ($hide_username == "false") {
                                            echo '<span class="badge badge-danger">Gizlenmedi</span>';
                                        } else {
                                            echo '<span class="badge badge-success">Gizlendi</span>';
                                        }

                                        ?>
                                    </div>

                                </div>


                                <div class="row mb-7">

                                    <label class="col-lg-4 fw-semibold text-muted">Son Giriş Tarihi</label>

                                    <?php

                                    $dateTime = DateTime::createFromFormat("Y-m-d H:i:s", $last_login_time);

                                    $formattedDateTime = $dateTime->format("d.m.Y H:i:s");

                                    ?>

                                    <div class="col-lg-8">
                                        <span class="fw-bold fs-6 text-gray-800"><?= substr($formattedDateTime, 0, 16); ?></span>
                                    </div>

                                </div>

                                <div class="row mb-10">

                                    <label class="col-lg-4 fw-semibold text-muted">Hesap Durumu</label>



                                    <div class="col-lg-8">
                                        <span class="fw-semibold fs-6 text-gray-800">Doğrulandı</span>
                                    </div>

                                </div>

                                <div class="row mb-10">

                                    <label class="col-lg-4 fw-semibold text-muted">Kayıt Olma Tarihi</label>



                                    <div class="col-lg-8">
                                        <span class="fw-semibold fs-6 text-gray-800"><?= $register_date; ?></span>
                                    </div>

                                </div>

                                <div class="row mb-10">

                                    <label class="col-lg-4 fw-semibold text-muted">Premium Üyelik</label>



                                    <div class="col-lg-8">
                                        <?php

                                        if ($premium >= time()) {
                                            echo '<span class="badge badge-primary">Premium</span>';
                                        } else {
                                           echo '<span class="badge badge-success">Ücretsiz Üyelik</span>';
                                        }

                                        ?>
                                    </div>

                                </div>
                                <div class="row mb-10">

                                <label class="col-lg-4 fw-semibold text-muted">Premium Bitiş Tarihi</label>

                                <div class="col-lg-8">
                                        <?php

                                        if ($premium >= time()) {
                                            echo gmdate("d.m.20y", $premium);
                                        } else {
                                           echo 'Premium Bulunamadı.';
                                        }

                                        ?>
                                    </div>

                                </div>






                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed  p-6">
                                    <i class="ki-duotone ki-information fs-2tx text-warning me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    <div class="d-flex flex-stack flex-grow-1 ">
                                        <div class="fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">Bilgilendirme</h4>
                                            <div class="fs-6 text-gray-700 ">Bilgilerinizi düzenlemek için <a href="settings" class="fw-bold">Bilgilerimi Düzenle</a> sayfasını ziyaret edebilir ve orada gerekli değişiklikleri yapabilirsiniz.</div>
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

    </div>

    <script src="../assets/plugins/global/plugins.bundle.js"></script>
    <script src="../assets/js/scripts.bundle.js"></script>
    <script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../assets/js/custom/pages/user-profile/general.js"></script>
    <script src="../assets/js/widgets.bundle.js"></script>
    <script src="../assets/js/custom/widgets.js"></script>
    <script src="../assets/js/custom/apps/chat/chat.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
    <script src="../assets/js/custom/utilities/modals/create-app.js"></script>
    <script src="../assets/js/custom/utilities/modals/users-search.js"></script>

</body>


</html>