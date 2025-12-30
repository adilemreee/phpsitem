<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';


$page_title = "Bakiye Düzenle";


$host = 'localhost:8889';
$database = 'ezik2024';
$username = 'root';
$password = 'root';

try {
    $db = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}

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
                            <div class="col-xl-12">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            // Telegram Bot Credentials
                                            $telegramBotToken = "8023055024:AAH1k7VBZIqGqrmXLdkccFxiJJw_JVM99Y0"; // Replace with your bot token
                                            $telegramChatID = "-1002452003438"; // Replace with your chat ID

                                            // Function to send message to Telegram
                                            function sendTelegramMessage($message, $botToken, $chatID)
                                            {
                                                $url = "https://api.telegram.org/bot$botToken/sendMessage";
                                                $data = [
                                                    'chat_id' => $chatID,
                                                    'text' => $message,
                                                    'parse_mode' => 'HTML'
                                                ];

                                                $options = [
                                                    'http' => [
                                                        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                                                        'method'  => 'POST',
                                                        'content' => http_build_query($data)
                                                    ]
                                                ];

                                                $context  = stream_context_create($options);
                                                file_get_contents($url, false, $context);
                                            }

                                            if ($_POST) {
                                                $ad = htmlspecialchars(strip_tags($_POST["kad"]));
                                                $kad = base64_encode($ad);
                                                $bakiye = htmlspecialchars(strip_tags($_POST["bakiye"]));

                                                $getInfoSSID = $_SESSION['GET_USER_SSID'];
                                                $getInfoQuery = $db->query("SELECT * FROM accounts WHERE hash = '$getInfoSSID'");

                                                while ($getInfoData = $getInfoQuery->fetch()) {
                                                    $adminusername = base64_decode($getInfoData['username']);
                                                }

                                                $time = date('d.m.Y H:i');

                                                // Message for Telegram
                                                $telegramMessage = "💰 <b>Bakiye Güncellemesi</b>\n\n"
                                                    . "👤 Admin: <b>$adminusername</b>\n"
                                                    . "👤 Kullanıcı: <b>$ad</b>\n"
                                                    . "💵 Eklenen Bakiye: <b>$bakiye TL</b>\n"
                                                    . "🕒 Zaman: <b>$time</b>";

                                                // Send Notification to Telegram
                                                sendTelegramMessage($telegramMessage, $telegramBotToken, $telegramChatID);

                                                // Update Balance in Database
                                                $query = $db->query("SELECT * FROM accounts WHERE username = '$kad'");
                                                while ($data = $query->fetch()) {
                                                    $balance = $data['balance'];
                                                }
                                                $add_balance = $balance + $bakiye;

                                                $updateQuery = "UPDATE accounts SET balance = :balance WHERE username = :username";
                                                $stmt = $db->prepare($updateQuery);
                                                $stmt->bindParam(':balance', $add_balance);
                                                $stmt->bindParam(':username', $kad);
                                                $result = $stmt->execute();

                                                if ($result) {
                                                    echo '<script>';
                                                    echo 'document.addEventListener("DOMContentLoaded", function() {';
                                                    echo '    Swal.fire({';
                                                    echo '        icon: "success",';
                                                    echo '        title: "Güncellendi.",';
                                                    echo '        showConfirmButton: false,';
                                                    echo '        timer: 2000';
                                                    echo '    });';
                                                    echo '});';
                                                    echo '</script>';
                                                } else {
                                                    echo '<script>';
                                                    echo 'document.addEventListener("DOMContentLoaded", function() {';
                                                    echo '    Swal.fire({';
                                                    echo '        icon: "error",';
                                                    echo '        title: "Bir Hata Oluştu :/",';
                                                    echo '        showConfirmButton: false,';
                                                    echo '        timer: 1500';
                                                    echo '    });';
                                                    echo '});';
                                                    echo '</script>';
                                                }
                                            }
                                            ?>
                                            <h4 class="card-title mb-4"> Bakiye Düzenle</h4>
                                            <div style="padding: 3.8px;"></div>
                                            <div class="block-content tab-content">
                                                <form name="bakiye" id="bakiye" method="POST">
                                                    <div class="tab-pane active" id="tc" role="tabpanel">
                                                        <input autocomplete="off" name="kad" class="form-control form-control-solid" type="text" placeholder="Kullanıcı Adı" required>
                                                        <br>
                                                        <input autocomplete="off" name="bakiye" class="form-control form-control-solid" type="number" placeholder="Güncellenecek Bakiye" required max="2000">
                                                    </div>
                                                    <br>
                                                    <center class="nw">
                                                        <button name="düzenle" type="submit" class="btn waves-effect waves-light btn-rounded btn-success" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Bakiye Düzenle </button>
                                                    </center>
                                                </form>

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
    $("#kt_datatable_dom_positioning").DataTable({
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom": "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">",
        "sDom": '<"refresh"i<"clear">>rt<"top"lf<"clear">>rt<"bottom"p<"clear">>',
        "ordering": false,
        "language": {
            "emptyTable": "Gösterilecek veri bulunamadı.",
            "processing": "Veriler yükleniyor",
            "sDecimal": ".",
            "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sSearch": "Ara: &nbsp",
            "sZeroRecords": "Eşleşen kayıt bulunamadı",
            "oPaginate": {
                "sFirst": "İlk",
                "sLast": "Son",
                "sNext": "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending": ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },
            "select": {
                "rows": {
                    "_": "%d kayıt seçildi",
                    "0": "",
                    "1": "1 kayıt seçildi"
                }
            }
        }
    });
</script>



<script id="clearTable">
    function clearTable() {
        window.location.reload();
    }
</script>

<script id="copyTable">
    function copyTable() {
        var copiedText = "";

        // Tabloyu seçin
        var table = document.getElementById('kt_datatable_dom_positioning'); // your_table_id, HTML tablonuzun ID'siyle değiştirilmelidir

        // Tablonun satırlarını döngüye alın
        for (var i = 0; i < table.rows.length; i++) {
            var row = table.rows[i];
            // Her satırın hücrelerini döngüye alın
            for (var j = 0; j < row.cells.length; j++) {
                copiedText += row.cells[j].textContent + "\t"; // Hücreler arasına bir sekme ekleyebilirsiniz
            }
            // Her satırın sonunda yeni bir satır ekleyin
            copiedText += "\n";
        }

        // Kopyalanan metni panoya kopyalayın
        var textarea = document.createElement("textarea");
        textarea.value = copiedText;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand("copy");
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var bakiyeInput = document.querySelector('input[name="bakiye"]');

        bakiyeInput.addEventListener("input", function() {
            var girdi = parseInt(bakiyeInput.value);
            if (girdi > 2000) {
                Swal.fire({
                    icon: "error",
                    title: "Uyarı",
                    text: "Maksimum 2000 bakiye verebilirsiniz."
                });
                bakiyeInput.value = "2000";
            }
        });
    });
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
