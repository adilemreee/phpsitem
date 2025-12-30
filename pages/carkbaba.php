<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Hediye Çarkı";

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <?php include 'inc/header_main.php'; ?>
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <style>
        .container {
            width: 500px;
            height: 500px;
            background-color: #ccc;
            border-radius: 50%;
            border: 15px solid #2C2C41;
            position: relative;
            overflow: hidden;
            transition: transform 2s ease-out;
            /* Geçiş süresini 2 saniyeye ayarla (daha hızlı) */
        }

        .container div {
            height: 50%;
            width: 270px;
            position: absolute;
            clip-path: polygon(100% 0, 50% 100%, 0 0);
            transform: translateX(-50%);
            transform-origin: bottom;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            font-family: sans-serif;
            color: #fff;
            left: 100px
        }

        .container .one {
            background-color: #3f51b5;
            left: 50%
        }

        .container .two {
            background-color: #ff9800;
            transform: rotate(60deg)
        }

        .container .three {
            background-color: #e91e63;
            transform: rotate(120deg)
        }

        .container .four {
            background-color: #4caf50;
            transform: rotate(180deg)
        }

        .container .five {
            background-color: #009688;
            transform: rotate(240deg)
        }

        .container .six {
            background-color: #795548;
            transform: rotate(300deg)
        }

        #spin {
            position: absolute;
            top: 58%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            background-color: #1E1E2D;
            text-transform: uppercase;
            border: 8px solid #171825;
            font-weight: bold;
            font-size: 20px;
            color: #FFF;
            width: 100px;
            height: 100px;
            font-family: sans-serif;
            border-radius: 50%;
            cursor: pointer;
            outline: none;
            letter-spacing: 1px;
        }

        .prize-indicator {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            color: #000;
            border: 2px solid #000;
        }

        #spin:disabled {
            cursor: not-allowed
        }

        .prize-indicator {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            color: #000;
            border: 2px solid #000;
        }
@media only screen and (min-width: 150px) and (max-width: 600px)
{
        .container {
            width: 300px;
            height: 300px;
            background-color: #ccc;
            border-radius: 50%;
            border: 15px solid #2C2C41;
            position: relative;
            overflow: hidden;
            transition: transform 2s ease-out;
            /* Geçiş süresini 2 saniyeye ayarla (daha hızlı) */
        }
            #spin {
            position: absolute;
            top: 59%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            background-color: #1E1E2D;
            text-transform: uppercase;
            border: 8px solid #171825;
            font-weight: bold;
            font-size: 13px;
            color: #FFF;
            width: 70px;
            height: 70px;
            font-family: sans-serif;
            border-radius: 50%;
            cursor: pointer;
            outline: none;
            letter-spacing: 1px;
        }
         #spin:disabled {
            top: 64%;
            left: 50%;
            cursor: not-allowed
        }
        .container .one {
            background-color: #3f51b5;

            width: 53%;
            height: 53%


        }

        .container .two {
            background-color: #ff9800;
            width: 53%;
            height: 53%;
            position: absolute;
            left: 65px;
            transform: rotate(60deg);


        }

        .container .three {
            background-color: #e91e63;
            width: 60%;
            height: 53%;
            position: absolute;
            left: 65px;
            transform: rotate(120deg)
        }

        .container .four {
            background-color: #4caf50;
            width: 53%;
            height: 53%;
            position: absolute;
            left: 65px;
            transform: rotate(180deg)
        }

        .container .five {
            background-color: #009688;
            width: 53%;
            height: 53%;
            position: absolute;
            left: 65px;
            transform: rotate(240deg)
        }

        .container .six {
            width: 53%;
            height: 53%;
            position: absolute;
            left: 65px;
            background-color: #795548;
            transform: rotate(300deg)
        }



    </style>
</head>

<body id="kt_body" class="aside-enabled">
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <?php include 'inc/header_sidebar.php'; ?>
            <?php
            $now = time();
            $next_spin_time = strtotime('+1 day', $ts_last_spin);
            $time_left = $next_spin_time - $now;

            if ($_SERVER["REQUEST_METHOD"] == "POST" && $time_left <= 0) {
                $donen_odul = htmlspecialchars(strip_tags($_POST['donen_odul']));

                $stmt = $db->prepare("UPDATE accounts SET ts_last_spin = :ts_last_spin WHERE hash = :hash");
                $ts_last_spin = time();
                $stmt->bindParam(':ts_last_spin', $ts_last_spin);
                $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                $stmt->execute();

                try {
                    switch ($donen_odul) {
                        case "5 USDT":
                            $new_balance = $balance + 5;
                            $stmt = $db->prepare("UPDATE accounts SET balance = :new_balance WHERE hash = :hash");
                            $stmt->bindParam(':new_balance', $new_balance);
                            $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                            $stmt->execute();
                            $message = "5₺ site bakiyesi kazandınız!";
                            break;
                        case "10 USDT":
                            $new_balance = $balance + 10;
                            $stmt = $db->prepare("UPDATE accounts SET balance = :new_balance WHERE hash = :hash");
                            $stmt->bindParam(':new_balance', $new_balance);
                            $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                            $stmt->execute();
                            $message = "10₺ site bakiyesi kazandınız!";
                            break;
                        case "Boş":
                            $message = "Üzgünüz, pas geçti.";
                            break;
                        case "15 USDT":
                            $new_balance = $balance + 15;
                            $stmt = $db->prepare("UPDATE accounts SET balance = :new_balance WHERE hash = :hash");
                            $stmt->bindParam(':new_balance', $new_balance);
                            $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                            $stmt->execute();
                            $message = "15₺ site bakiyesi kazandınız!";
                            break;
                        case "1 USDT":
                            $new_balance = $balance + 1;
                            $stmt = $db->prepare("UPDATE accounts SET balance = :new_balance WHERE hash = :hash");
                            $stmt->bindParam(':new_balance', $new_balance);
                            $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                            $stmt->execute();
                            $message = "1₺ site bakiyesi kazandınız!";
                            break;
                        case "20 USDT":
                            $new_balance = $balance + 20;
                            $stmt = $db->prepare("UPDATE accounts SET balance = :new_balance WHERE hash = :hash");
                            $stmt->bindParam(':new_balance', $new_balance);
                            $stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                            $stmt->execute();
                            $message = "20₺ site bakiyesi kazandınız!";
                            break;
                        default:
                            $message = "Bir hata oluştu!";
                            break;
                    }
                    echo '<script>
					Swal.fire({
						icon: "success",
						title: "Kazandınız!",
						text: "' . $message . '",
						showCloseButton: true
					}).then((result) => {
						if (result.isConfirmed) {
							location.reload();
						}
					});
				</script>';
                } catch (PDOException $e) {
                    echo "Hata Oluştu!";
                }

                $db = null;
            }
            ?>
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <?php include 'inc/header_navbar.php'; ?>
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <div id="kt_content_container" class="container-xxl">
                            <div class="card">
                                <div class="card-body mt-5 pt-0">
                                    <?php
                                    if ($time_left > 0) {
                                        $hours_left = floor($time_left / 3600);
                                        $minutes_left = floor(($time_left % 3600) / 60);
                                        echo "<span class='alert bg-light-info form-control text-center'>Bir sonraki çark çevirme hakkı için $hours_left saat $minutes_left dakika kaldı.</span>";
                                    }
                                    ?>
                                    <br>
                                    <h1 class="card-title mb-4 text-center mt-1"> Hediye Çarkı</h1>
                                    <br>
                                    <center>
                                        <form id="spinForm" method="post"
                                            action="hediyecarki">
                                            <button id="spin" type="button" <?php if ($time_left > 0)
                                                echo "disabled"; ?>>Çevir</button>
                                            <div class="container">
                                                <div class="one">5 TL</div>
                                                <div class="two">10 TL</div>
                                                <div class="three">Boş</div>
                                                <div class="four">15 TL</div>
                                                <div class="five">1 TL</div>
                                                <div class="six">20 TL</div>
                                                <div class="prize-indicator"
                                                    style="transform: rotate(120deg); left: 85%;">Gelen Ödül</div>
                                            </div>
                                            <input type="hidden" name="donen_odul" id="donen_odul">
                                        </form>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include 'inc/footer_main.php'; ?>
            </div>
        </div>
    </div>
    <script>
        let container = document.querySelector(".container");
        let btn = document.getElementById("spin");
        btn.onclick = function () {
            let number = Math.ceil(Math.random() * 1000);
            container.style.transition = "transform 2s ease-out"; 
            container.style.transform = "rotate(" + (number + 3600) + "deg)"; 
            setTimeout(() => {
                let rotation = (number + 3600) % 360;
                let selectedSegment = getSelectedSegment(rotation);
                switch (selectedSegment) {
                    case 1:
                        document.getElementById("donen_odul").value = "5 USDT";
                        break;
                    case 2:
                        document.getElementById("donen_odul").value = "10 USDT";
                        break;
                    case 3:
                        document.getElementById("donen_odul").value = "Boş";
                        break;
                    case 4:
                        document.getElementById("donen_odul").value = "15 USDT";
                        break;
                    case 5:
                        document.getElementById("donen_odul").value = "1 USDT";
                        break;
                    case 6:
                        document.getElementById("donen_odul").value = "20 USDT";
                        break;
                }
                document.getElementById("spinForm").submit();
            }, 2000);
        };

        function getSelectedSegment(rotation) {
            if (rotation >= 0 && rotation < 60) { return 1; }
            else if (rotation >= 60 && rotation < 120) { return 2; }
            else if (rotation >= 120 && rotation < 180) { return 3; }
            else if (rotation >= 180 && rotation < 240) { return 4; }
            else if (rotation >= 240 && rotation < 300) { return 5; }
            else { return 6; }
        }
    </script>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true"><i class="ki-duotone ki-arrow-up"><span
                class="path1"></span><span class="path2"></span></i></div>
    <script src="../assets/plugins/global/plugins.bundle.js"></script>
    <script src="../assets/js/scripts.bundle.js"></script>
    <script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../assets/js/custom/apps/customers/list/export.js"></script>
    <script src="../assets/js/custom/apps/customers/list/list.js"></script>
    <script src="../assets/js/custom/apps/customers/add.js"></script>
    <script src="../assets/js/widgets.bundle.js"></script>
    <script src="../assets/js/custom/widgets.js"></script>
    <script src="../assets/js/custom/apps/chat/chat.js"></script>
    <script src="../assets/js/custom/utilities/modals/users-search.js"></script>
</body>

</html>