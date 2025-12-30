<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/functions.php';

$page_title = "IP Sorgu";

?>
<!DOCTYPE html>

<html lang="tr">

<head>
	<?php include 'inc/header_main.php'; ?>
	<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
												<h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/ip.png" alt=""> &nbsp; IP Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="ipsorgu" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<input class="form-control form-control-solid"
																autocomplete="off" type="text" name="ip"
																placeholder="Sorgulanacak IP Adresi" required>
															<br>
														</div>
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
																	<th scope="col">IP Adresi</th>
																	<th scope="col">Ülke</th>
																	<th scope="col">Ülke Kodu</th>
																	<th scope="col">Bölge</th>
																	<th scope="col">Bölge Kodu</th>
																	<th scope="col">Şehir</th>
																	<th scope="col">Posta Kodu</th>
																	<th scope="col">Zaman Dilimi</th>
																	<th scope="col">Enlem</th>
																	<th scope="col">Boylam</th>
																	<th scope="col">Organizasyon</th>
																	<th scope="col">ISP</th>
																	<th scope="col">As Numarası/Adı</th>
																</tr>
															</thead>
															<tbody id="00001010">
																<?php

																if (isset($_POST['Sorgula'])) {
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

																	$ip = htmlspecialchars(strip_tags($_POST['ip']));


																	totalLog("ipsrg");
																	countAdd();


																	$title = $page_title;

																	$getInfoSSID = $_SESSION['GET_USER_SSID'];

																	$getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

																	while ($getInfoData = $getInfoQuery->fetch()) {
																		$username = base64_decode($getInfoData['username']);
																	}

																	$time = date('d.m.Y H:i');

																	$content = "**" . $username . "**" . " tarafından IP sorgulama işlemi başlatıldı. \n \n IP **$ip**";


																	$ip_bilgi = file_get_contents('http://ip-api.com/json/'. htmlspecialchars(strip_tags($_POST['ip'])));
																	$json_coz = json_decode($ip_bilgi, true);
																	$cikanip = $json_coz['query'];
																	$myip = "23.88.110.0";

																	if ($cikanip == $myip) {
																		echo "<script>toastr.error('Maalesef, aradığınız IP adresi bulunamadı.');</script>";
																	} else { 
																		echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı.');</script>";?>
																		<tr>
																			<td>
																				<?php echo $json_coz['query']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['country']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['countryCode']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['regionName']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['region']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['city']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['zip']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['timezone']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['lat']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['lon']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['org']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['isp']; ?>
																			</td>
																			<td>
																				<?php echo $json_coz['as']; ?>
																			</td>
																		</tr>
																		<?php
																	}
																}
																?>
															</tbody>
														</table>
														<div style="padding: 4px;"></div>
														<div
															class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
															<i
																class="ki-duotone ki-information-2 fs-2hx text-primary me-4 mb-5 mb-sm-0">
																<span class="path1"></span><span
																	class="path2"></span><span class="path3"></span></i>
															<div class="d-flex flex-column pe-0 pe-sm-10">
																<h5 class="mb-1">Bilgilendirme</h5>
																<div style="padding: 1px;"></div>
																<span class="text-gray-800">IP adresi sorgulandığında,
																	otomatik olarak ilgili coğrafi konum verileri alınır
																	ve bu bilgi harita üzerinde görsel olarak sunulur,
																	böylece IP'nin fiziksel konumu hızlıca
																	görülebilir.</span>
															</div>
															<button type="button"
																class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
																data-bs-dismiss="alert">
																<i class="ki-duotone ki-cross fs-1 text-primary">
																	<span class="path1"></span><span
																		class="path2"></span></i>
															</button>
														</div>
														<table>
															<div id="harita"
																style="width: 100%;height: 400px;margin-top: 15px;border-radius: 6px;">
															</div>

															<script>
																// Harita oluşturun ve belirli bir enlem ve boylamda başlatın
																var harita = L.map('harita').setView([<?php echo $json_coz['lat'] ?>, <?php echo $json_coz['lon'] ?>], 13);

																// Harita katmanı ekleyin (örneğin, OpenStreetMap)
																L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
																	maxZoom: 19,
																	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
																}).addTo(harita);
															</script>
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