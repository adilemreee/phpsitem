<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Düzenle";

?>
<!DOCTYPE html>

<html lang="tr">

<head>
    <?php include 'inc/header_main.php'; ?>
</head>

<body id="kt_body" class="aside-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">

            <?php

            include 'inc/header_sidebar.php';

            if (isset($_POST['destroyAccount'])) {

                $hash = $_SESSION['GET_USER_SSID'];

                $delete = $db->prepare("DELETE FROM `accounts` WHERE hash = :hash");
                $delete->bindParam(':hash', $hash);
                $delete->execute();

                echo "<script>window.location = 'logout';</script>";
            }

            if (isset($_POST['changePassword'])) {

                $post_currentpassword = htmlspecialchars(strip_tags($_POST['currentpassword']));

                $post_newpassword = htmlspecialchars(strip_tags($_POST['newpassword']));

                $post_confirmpassword = htmlspecialchars(strip_tags($_POST['confirmpassword']));

                $salt = '/x!a@r-$r%an¨.&e&+f*f(f(a)';

                $hashedPassword = hash_hmac('md5', $post_newpassword, $salt);

                if (empty($post_confirmpassword) || empty($post_currentpassword) || empty($post_newpassword)) {
                    echo '<script type="text/javascript">toastr.error("Boş alan olamaz.");</script>';
                } else if ($post_newpassword != $post_confirmpassword) {
                    echo '<script type="text/javascript">toastr.error("Şifreler eşleşmiyor.");</script>';
                } else {
                    try {
                        $stmt = $db->prepare("UPDATE accounts SET password = :password WHERE hash = :hash");
                        $stmt->bindParam(':password', $hashedPassword);
                        $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                        $stmt->execute();

                        // Şifre değiştirme başarılı, toastr ile uyarı mesajı gönder
                        echo '<script type="text/javascript">toastr.success("Şifre başarıyla değiştirildi.");</script>';
                    } catch (PDOException $e) {
                        // Hata durumunda, toastr ile hata mesajı gönder
                        echo '<script type="text/javascript">toastr.error("Şifre değiştirilirken bir hata oluştu.");</script>';
                    }
                }
            }

            if (isset($_POST['changeEmail'])) {

                $post_emailaddress = htmlspecialchars(strip_tags($_POST['emailaddress']));

                $post_confirmemailpassword = htmlspecialchars(strip_tags($_POST['confirmemailpassword']));

                $b64_email = base64_encode($post_emailaddress);

                $checkEmail = $db->query("SELECT * FROM `accounts` WHERE email = '$b64_email'");
                $emailCount = $checkEmail->rowCount();

                if (empty($post_emailaddress) || empty($post_confirmemailpassword)) {
                    echo '<script type="text/javascript">toastr.error("Boş alan olamaz.");</script>';
                } else if ($emailCount == 1) {
                    echo '<script type="text/javascript">toastr.error("Bu email adresi başka bir kullanıcı tarafından kullanılıyor.");</script>';
                } else {
                    try {
                        $stmt = $db->prepare("UPDATE accounts SET email = :email WHERE hash = :hash");
                        $stmt->bindParam(':email', $b64_email);
                        $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                        $stmt->execute();

                        // Şifre değiştirme başarılı, toastr ile uyarı mesajı gönder
                        echo '<script type="text/javascript">toastr.success("Email başarıyla değiştirildi.");setTimeout(() => window.location = "settings", 2000);</script>';
                    } catch (PDOException $e) {
                        // Hata durumunda, toastr ile hata mesajı gönder
                        echo '<script type="text/javascript">toastr.error("Email değiştirilirken bir hata oluştu.");</script>';
                    }
                }
            }

            if (isset($_POST['editAccount'])) {
                $post_username = htmlspecialchars(strip_tags($_POST['username']));
                $post_secret_question = htmlspecialchars(strip_tags($_POST['secret_question']));
                $post_secret_answer = htmlspecialchars(strip_tags($_POST['secret_answer']));
                $post_hide_username = htmlspecialchars(strip_tags($_POST['hide_username']));

                // Gerekli kontroller
                if (empty($post_username) || empty($post_secret_question) || empty($post_secret_answer)) {
                    echo "<script>toastr.error('Lütfen tüm alanları doldurun.');</script>";
                } else {
                    // Resim yükleme işlemi sadece resim geldiyse yapılır
                    if (!empty($_FILES['image']['name'])) {
                        $maxSize = 3 * 1024 * 1024; // 3 MB
                        $allowedExtensions = array('png', 'jpg', 'jpeg', 'gif');

                        $uploadDir = '../assets/img/account/';
                        $fileName = $_FILES['image']['name'];
                        $encryptedFileName = md5($fileName) . '_' . time(); // Şifrelenmiş dosya adı
                        $uploadFile = $uploadDir . $encryptedFileName;
                        $serverName = $_SERVER['SERVER_NAME'];
                        $updatedDir = 'assets/img/account/' . $encryptedFileName;

                        $currentTime = time();
                        $lastUploadTime = $_SESSION['last_upload_time'];
                        $timeDifference = $currentTime - $lastUploadTime;

                        $productImgName = $_FILES['image']['name'];
                        $productImgType = strtolower(pathinfo($productImgName, PATHINFO_EXTENSION));
                        $productImgSize = $_FILES['image']['size'];
                        $productImgTmp = $_FILES['image']['tmp_name'];

                        if (!in_array($productImgType, $allowedExtensions)) {
                            echo '<script type="text/javascript">toastr.error("Avatar resmi yalnızca PNG, JPG, JPEG ve GIF uzantılarına sahip olmalıdır.");</script>';
                        } elseif ($productImgSize > $maxSize) {
                            echo '<script type="text/javascript">toastr.error("Avatar resmi en fazla 3 MB olmalıdır");</script>';
                        } elseif ($timeDifference < 1) {
                            echo '<script type="text/javascript">toastr.error("Resmi sadece 15 dakikada bir yükleyebilirsiniz.");</script>';
                        } else {
                            // Güncelleme işlemi
                            $stmt = $db->prepare("UPDATE accounts SET secret_question = :secret_question, secret_answer = :secret_answer, hide_username = :hide_username, username = :username, profile_image = :profile_image WHERE hash = :hash");
                            $stmt->bindValue(':secret_question', $post_secret_question);
                            $stmt->bindValue(':secret_answer', $post_secret_answer);
                            $stmt->bindValue(':hide_username', $post_hide_username);
                            $stmt->bindValue(':username', base64_encode($post_username));
                            $stmt->bindValue(':hash', $_SESSION['GET_USER_SSID']);

                            if (!empty($_FILES['image']['name'])) {
                                move_uploaded_file($productImgTmp, $uploadFile);
                                $_SESSION['last_upload_time'] = time();
                                $stmt->bindValue(':profile_image', "https://" . $serverName . "/" . $updatedDir);
                            } else {
                                $stmt->bindValue(':profile_image', $profile_image);
                            }

                            $stmt->execute();

                            echo '<script type="text/javascript">toastr.success("Hesap başarıyla güncellendi.");setTimeout(() => window.location = "settings", 1200);</script>';
                        }
                    } else {
                        // Güncelleme işlemi
                        $stmt = $db->prepare("UPDATE accounts SET secret_question = :secret_question, secret_answer = :secret_answer, hide_username = :hide_username, username = :username WHERE hash = :hash");
                        $stmt->bindValue(':secret_question', $post_secret_question);
                        $stmt->bindValue(':secret_answer', $post_secret_answer);
                        $stmt->bindValue(':hide_username', $post_hide_username);
                        $stmt->bindValue(':username', base64_encode($post_username));
                        $stmt->bindValue(':hash', $_SESSION['GET_USER_SSID']);
                        $stmt->execute();

                        echo '<script type="text/javascript">toastr.success("Hesap başarıyla güncellendi.");setTimeout(() => window.location = "settings", 1200);</script>';
                    }
                }
            }

            ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'inc/header_navbar.php'; ?>
                <div class="content d-flex flex-column flex-column-fluid " id="kt_content">
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class=" container-xxl ">
                            <div class="card mb-5 mb-xl-10">
                                <div class="card-body pt-9 pb-0">
                                    <div class="d-flex flex-wrap flex-sm-nowrap">
                                        <div class="me-7 mb-4">
                                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
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
                                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="overview">
                                            Bilgilerimi Görüntüle </a>
                                    </li>
                                    <li class="nav-item mt-2">
                                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="settings">
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
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Bilgilerimi Düzenle</h3>
                                </div>
                            </div>

                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <form method="POST" action="" id="kt_account_profile_details_form" enctype="multipart/form-data" autocomplete="off" class="form">
                                    <div class="card-body border-top p-9">
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                            <?php

                                            if (empty($profile_image)) {
                                                $img = "assets/media/svg/avatars/blank.jpg";
                                            } else {
                                                $img = $profile_image;
                                            }

                                            ?>
                                            <div class="col-lg-8">
                                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('../assets/media/svg/avatars/blank.jpg')">
                                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?= $img; ?>)"></div>
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Avatarı Değiştir">
                                                        <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                                                        <input type="file" name="image" accept=".png, .jpg, .jpeg, .gif" />
                                                        <input type="hidden" name="avatar_remove" />
                                                    </label>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Avatarı İptal Et">
                                                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i> </span>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Avatarı Kaldır">
                                                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i> </span>
                                                </div>
                                                <div class="form-text">İzin verilen dosya türleri: png, jpg, jpeg, gif.</div>
                                            </div>

                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label  fw-semibold fs-6">Kullanıcı Adı</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="username" class="form-control form-control-lg form-control-solid" placeholder="Şirket adı" value="<?= $username; ?>" />
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                <span class="">Gizli Soru</span>
                                            </label>
                                            <div class="col-lg-8 fv-row">
                                                <select name="secret_question" data-control="select2" class="form-select form-select-solid form-select-lg fw-semibold">
                                                 <?php
												$selectedQuestion = $secret_question;
												$questions = array(
													"En sevdiğin hacker filmi hangisidir?",
													"En çok beğendiğin programlama dili hangisidir?",
													"En çok beğendiğin siber güvenlik aracı nedir?",
													"Annenizin kızlık soyadı nedir?",
													"Gittiğiniz ilk okulun ismi nedir?",
													"İlk evcil hayvanınızın ismi nedir?"

												);

												foreach ($questions as $question) {
													if ($selectedQuestion == $question) {
														echo '<option value="' . htmlspecialchars($question) . '" selected>' . htmlspecialchars($question) . '</option>';
													} else {
														echo '<option value="' . htmlspecialchars($question) . '">' . htmlspecialchars($question) . '</option>';
													}
												}
												?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6 ">Gizli Soru Cevabı</label>
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" name="secret_answer" class="form-control form-control-lg form-control-solid" value="<?= $secret_answer; ?>">
                                            </div>
                                        </div>
                                        <div class="row mb-6">
                                            <label class="col-lg-4 col-form-label fw-semibold fs-6 ">Takma Adımı Gizle</label>
                                            <div class="col-lg-8 fv-row">
                                                <select name="hide_username" data-control="select2" class="form-select form-select-solid form-select-lg fw-semibold">
                                                    <?php
                                                    $options = array(
                                                        array("value" => "true", "text" => "Anonim kalmak için takma adımı gizli tutuyorum."),
                                                        array("value" => "false", "text" => "Takma adımı gizlemeye ihtiyaç duymuyorum.")
                                                    );

                                                    foreach ($options as $option) {
                                                        $selected = ($hide_username === $option["value"]) ? "selected" : "";
                                                        echo '<option value="' . $option["value"] . '" ' . $selected . '>' . $option["text"] . '</option>';
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex py-6 px-9">
                                        <button type="submit" name="editAccount" class="btn btn-primary me-2" id="kt_account_profile_details_submit">Güncelle</button>
                                        <button type="reset" class="btn btn-light btn-active-light-primary">İptal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Giriş Bilgileri</h3>
                                </div>
                            </div>

                            <div id="kt_account_settings_signin_method" class="collapse show">
                                <div class="card-body border-top p-9">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div id="kt_signin_email">
                                            <div class="fs-6 fw-bold mb-1">E-posta Adresi</div>
                                            <div class="fw-semibold text-gray-600"><?= $email; ?></div>
                                        </div>
                                        <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                            <form action="" method="POST" id="kt_signin_change_email" class="form" novalidate="novalidate">
                                                <div class="row mb-6">
                                                    <div class="col-lg-6 mb-4 mb-lg-0">
                                                        <div class="fv-row mb-0">
                                                            <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Yeni E-posta Adresini Girin</label>
                                                            <input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="E-posta Adresi" name="emailaddress" value="<?= $email; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="fv-row mb-0">
                                                            <label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Şifreyi Onaylayın</label>
                                                            <input type="password" class="form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <button id="kt_signin_submit" type="submit" name="changeEmail" class="btn btn-primary me-2 px-6">E-postayı Güncelle</button>
                                                    <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">İptal</button>
                                                </div>
                                            </form>

                                        </div>
                                        <div id="kt_signin_email_button" class="ms-auto">
                                            <button class="btn btn-light btn-active-light-primary">Değiştir</button>
                                        </div>
                                    </div>

                                    <div class="separator separator-dashed my-6"></div>

                                    <div class="d-flex flex-wrap align-items-center mb-10">
                                        <div id="kt_signin_password">
                                            <div class="fs-6 fw-bold mb-1">Şifre</div>
                                            <div class="fw-semibold text-gray-600">************</div>
                                        </div>
                                        <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                            <form method="POST" action="" id="kt_signin_change_password" class="form" novalidate="novalidate">
                                                <div class="row mb-1">
                                                    <div class="col-lg-4">
                                                        <div class="fv-row mb-0">
                                                            <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Mevcut Şifre</label>
                                                            <input type="password" class="form-control form-control-lg form-control-solid " name="currentpassword" id="currentpassword" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="fv-row mb-0">
                                                            <label for="newpassword" class="form-label fs-6 fw-bold mb-3">Yeni Şifre</label>
                                                            <input type="password" class="form-control form-control-lg form-control-solid " name="newpassword" id="newpassword" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="fv-row mb-0">
                                                            <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Yeni Şifreyi Onaylayın</label>
                                                            <input type="password" class="form-control form-control-lg form-control-solid " name="confirmpassword" id="confirmpassword" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-text mb-5">Şifre en az 8 karakter içermeli ve semboller içermelidir</div>

                                                <div class="d-flex">
                                                    <button id="kt_password_submit" type="submit" name="changePassword" class="btn btn-primary me-2 px-6">Şifreyi Güncelle</button>
                                                    <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">İptal</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div id="kt_signin_password_button" class="ms-auto">
                                            <button class="btn btn-light btn-active-light-primary">Değiştir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" aria-expanded="true">
                                <div class="card-title m-0">
                                    <h3 class="fw-bold m-0">Hesabını Sil</h3>
                                </div>
                            </div>
                            <div id="kt_account_settings_deactivate" class="collapse show">
                                <form action="" method="POST" class="form">
                                    <div class="card-body border-top p-9">
                                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                                            <i class="ki-duotone ki-information fs-2tx text-warning me-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            <div class="d-flex flex-stack flex-grow-1 ">
                                                <div class=" fw-semibold">
                                                    <h4 class="text-gray-900 fw-bold">Hesabınızı silmeye karar veriyorsunuz.</h4>

                                                    <div class="fs-6 text-gray-700 ">Hesabınızı sildiğinizde, tüm verileriniz ve içeriğiniz kalıcı olarak kaybolacaktır. Bu işlem geri alınamaz. <br /></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check form-check-solid fv-row">
                                            <input class="form-check-input" type="checkbox" value="" required>
                                            <label class="form-check-label fw-semibold ps-2 fs-6">Hesabımın silinmesini onaylıyor ve bilgilerimin geri getirilmeyeceğini kabul ediyorum.</label>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex  py-6 px-9">
                                        <button id="kt_account_deactivate_account_submit" name="destroyAccount" type="submit" class="btn btn-danger fw-semibold">Hesabı Sil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'inc/footer_main.php'; ?>
        </div>
    </div>

    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
    </div>

    <script src="../assets/plugins/global/plugins.bundle.js"></script>
    <script src="../assets/js/scripts.bundle.js"></script>
    <script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../assets/js/custom/account/settings/signin-methods.js"></script>
    <script src="../assets/js/custom/pages/user-profile/general.js"></script>
    <script src="../assets/js/widgets.bundle.js"></script>
    <script src="../assets/js/custom/widgets.js"></script>
    <script src="../assets/js/custom/apps/chat/chat.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
    <script src="../assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
    <script src="../assets/js/custom/utilities/modals/two-factor-authentication.js"></script>
    <script src="../assets/js/custom/utilities/modals/users-search.js"></script>

</body>

</html>