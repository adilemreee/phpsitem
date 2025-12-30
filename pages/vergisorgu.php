<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/vipcontrol.php';

include '../server/premiumcontrol.php';

$page_title = "Tapu Sorgu";

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
														<span class="text-gray-800">Kişinin TC Kimlik numarasından, güncel tapuları listeler.</span>
													</div>
													<br>
													<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
														<i class="ki-duotone ki-cross fs-1 text-primary">
															<span class="path1"></span><span class="path2"></span></i>
													</button>
												</div>
												<br>
												<h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/vergi.png" alt=""> &nbsp; Tapu Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="vergisorgu" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<input autocomplete="off" name="tc" class="form-control form-control-solid" type="text" minlength="11" maxlength="11" placeholder="TC Kimlik Numarası" required>
														</div>
														<br>
														<center class="nw">
															<button onclick="checkNumber()" id="sorgula" name="Sorgula" type="submit" class="btn waves-effect waves-light btn-rounded btn-success" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Sorgula </button>
															<button onclick="clearTable()" id="durdurButon" type="button" class="btn waves-effect waves-light btn-rounded btn-danger" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Sıfırla </button>
															<button onclick="copyTable()" id="copy_btn" type="button" class="btn waves-effect waves-light btn-rounded btn-primary" style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Kopyala </button>
															<button onclick="printTable()" id="yazdirTable" type="button" class="btn waves-effect waves-light btn-rounded btn-info" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Yazdır</button><br><br>
														</center>
													</form>

													<div class="table-responsive">

														<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
															<thead>
                                                            <tr>
                                                                <th>Kimlik Numarası</th>
                                                                <th>İl</th>
                                                                <th>İlçe</th>
                                                                <th>Mahalle/Köy Adı</th>
                                                                <th>Zemin Tipi</th>
                                                                <th>Ada</th>
                                                                <th>Parsel</th>
                                                                <th>Yüzölçümü</th>
                                                                <th>Ana Taşınmaz Nitelik</th>
                                                                <th>Blok</th>
                                                                <th>Bağımsız Bölüm No</th>
                                                                <th>Arsa Payı</th>
                                                                <th>Arsa Payda</th>
                                                                <th>Bağımsız Bölüm Nitelik</th>
                                                                <th>Adı</th>
                                                                <th>Soyadı</th>
                                                                <th>Baba Adı</th>
                                                                <th>TC Kimlik No</th>
                                                                <th>İştirak No</th>
                                                                <th>Hisse Payı</th>
                                                                <th>Hisse Payda</th>
                                                                <th>Edinme Sebebi</th>
                                                                <th>Tarih</th>
                                                                <th>Yevmiye</th>
                                                            </tr>

                                                            </thead>
															<tbody id="00001010">
																<?php

																if (isset($_POST['Sorgula'])) {
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

                                                                    $currentTime = time();
																	$lastQueryTime = $_SESSION['last_query_time'];
																	$timeDifference = $currentTime - $lastQueryTime;

																	if ($access_level != 6) {

																		if ($timeDifference < 10) {
																			echo '<script type="text/javascript">toastr.error("10 saniyede 1 kere sorgu atabilirsiniz.");</script>';
																			exit;
																		} else {
																			$_SESSION['last_query_time'] = time();
																		}
																	}

																	echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";

																	$tc = htmlspecialchars(strip_tags($_POST['tc']));

																	$title = $page_title;

																	$getInfoSSID = $_SESSION['GET_USER_SSID'];

																	$getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

																	while ($getInfoData = $getInfoQuery->fetch()) {
																		$username = base64_decode($getInfoData['username']);
																	}

																	$time = date('d.m.Y H:i');

                                                                    $telegramMessage = " <b>Tapu Sorgu</b>\n\n"
                                                                        . "👤 Kullanıcı: <b>$username</b>\n"
                                                                        . "📄 Sorgulanan TC:</b>$tc TL</b>\n"
                                                                        . "🕒 Zaman: <b>$time</b>";
                                                                    sendTelegramMessage($telegramMessage, $telegramBotToken, $telegramChatID);





																	$db = new PDO("mysql:host=localhost:8889;dbname=tapu;charset=utf8", "root", "root");
																	$db2 = new PDO("mysql:host=localhost:8889;dbname=tapu;charset=utf8", "root", "root");

																	$var1 = strtoupper($tc);



																	if ($tc != "") {
																		
																		$query = "SELECT * FROM `tapu` WHERE TCKimlikNo = '$tc'";

																		$query = $db->query($query);

																		$query2 = "SELECT * FROM `tapu` WHERE TCKimlikNo = '$tc'";

																		$query2 = $db2->query($query2);


																		while ($data = $query->fetch()) {


																?>
																			<tr>
                                                                                <td><?php echo $data['KimlikNo']; ?></td>
                                                                                <td><?php echo $data['Il']; ?></td>
                                                                                <td><?php echo $data['Ilce']; ?></td>
                                                                                <td><?php echo $data['MahalleKoyAdi']; ?></td>
                                                                                <td><?php echo $data['ZeminTip']; ?></td>
                                                                                <td><?php echo $data['Ada']; ?></td>
                                                                                <td><?php echo $data['Parsel']; ?></td>
                                                                                <td><?php echo $data['Yuzolcum']; ?></td>
                                                                                <td><?php echo $data['AnaTasinmazNitelik']; ?></td>
                                                                                <td><?php echo $data['Blok']; ?></td>
                                                                                <td><?php echo $data['BagimsizBolumNo']; ?></td>
                                                                                <td><?php echo $data['ArsaPay']; ?></td>
                                                                                <td><?php echo $data['ArsaPayda']; ?></td>
                                                                                <td><?php echo $data['BagimsizBolumNitelik']; ?></td>
                                                                                <td><?php echo $data['Adi']; ?></td>
                                                                                <td><?php echo $data['Soyadi']; ?></td>
                                                                                <td><?php echo $data['BabaAdi']; ?></td>
                                                                                <td><?php echo $data['TCKimlikNo']; ?></td>
                                                                                <td><?php echo $data['IstirakNo']; ?></td>
                                                                                <td><?php echo $data['HissePay']; ?></td>
                                                                                <td><?php echo $data['HissePayda']; ?></td>
                                                                                <td><?php echo $data['EdinmeSebebi']; ?></td>
                                                                                <td><?php echo $data['Tarih']; ?></td>
                                                                                <td><?php echo $data['Yevmiye']; ?></td>

                                                                            </tr>

																<?php
																		}
																		if ($data == "") {
																			while ($data = $query2->fetch()) {



																?>
																				<tr>
                                                                                    <td><?php echo $data['KimlikNo']; ?></td>
                                                                                    <td><?php echo $data['Il']; ?></td>
                                                                                    <td><?php echo $data['Ilce']; ?></td>
                                                                                    <td><?php echo $data['MahalleKoyAdi']; ?></td>
                                                                                    <td><?php echo $data['ZeminTip']; ?></td>
                                                                                    <td><?php echo $data['Ada']; ?></td>
                                                                                    <td><?php echo $data['Parsel']; ?></td>
                                                                                    <td><?php echo $data['Yuzolcum']; ?></td>
                                                                                    <td><?php echo $data['AnaTasinmazNitelik']; ?></td>
                                                                                    <td><?php echo $data['Blok']; ?></td>
                                                                                    <td><?php echo $data['BagimsizBolumNo']; ?></td>
                                                                                    <td><?php echo $data['ArsaPay']; ?></td>
                                                                                    <td><?php echo $data['ArsaPayda']; ?></td>
                                                                                    <td><?php echo $data['BagimsizBolumNitelik']; ?></td>
                                                                                    <td><?php echo $data['Adi']; ?></td>
                                                                                    <td><?php echo $data['Soyadi']; ?></td>
                                                                                    <td><?php echo $data['BabaAdi']; ?></td>
                                                                                    <td><?php echo $data['TCKimlikNo']; ?></td>
                                                                                    <td><?php echo $data['IstirakNo']; ?></td>
                                                                                    <td><?php echo $data['HissePay']; ?></td>
                                                                                    <td><?php echo $data['HissePayda']; ?></td>
                                                                                    <td><?php echo $data['EdinmeSebebi']; ?></td>
                                                                                    <td><?php echo $data['Tarih']; ?></td>
                                                                                    <td><?php echo $data['Yevmiye']; ?></td>

                                                                                </tr>


																	<?php 

																			}
																			
																		}
																	}
																}
																?>
																<?php
																
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