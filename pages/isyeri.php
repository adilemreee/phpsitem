<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/functions.php';

include '../server/vipcontrol.php';


$page_title = "İşyeri Sorgu";

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
														<span class="text-gray-800">Kişinin TC Kimlik numarasından, güncel çalıştığı ve çalıştığı yerin çalışanlarını listeler.</span>
													</div>
													<br>
													<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
														<i class="ki-duotone ki-cross fs-1 text-primary">
															<span class="path1"></span><span class="path2"></span></i>
													</button>
												</div>
												<br>
												<h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/job.png" alt=""> &nbsp; İşyeri Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="isyerisorgu" method="POST">
														<div class="tab-pane active" id="tcno" role="tabpanel">
															<input autocomplete="off" name="tcno"
																class="form-control form-control-solid" type="text"
																minlength="11" maxlength="11"
																placeholder="TC Kimlik Numarası" required>
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
																	<th scope="col">Kimlik Numarası</th>
																	<th scope="col">Çalışan Ad Soyad</th>
																	<th scope="col">Çalışan ID</th>
																	<th scope="col">Çalışma Durumu</th>
																	<th scope="col">İşçi ID</th>
																	<th scope="col">İşe Giriş Tarihi</th>
																	<th scope="col">İşyeri ID</th>
																	<th scope="col">İşyeri Nace Kodu</th>
																	<th scope="col">İşyeri Sektörü</th>
																	<th scope="col">İşyeri SGK Sicil Numarası</th>
																	<th scope="col">İşyeri Tehlike Sınıfı</th>
																	<th scope="col">İşyeri Ünvanı</th>
																</tr>
															</thead>
															<tbody id="00001010">
																<?php

																if (isset($_POST['Sorgula'])) {

																	totalLog("isyerisrg");
																	countAdd();
																	
																	$currentTime = time();
																	$lastQueryTime = $_SESSION['last_query_time'];
																	$timeDifference = $currentTime - $lastQueryTime;

																	if ($access_level != 6) {

																		if ($timeDifference < 10) {
																			echo '<script type="text/javascript">toastr.error("10 saniyede bir kere sorgu atabilirsiniz.");</script>';
																			exit;
																		} else {
																			$_SESSION['last_query_time'] = time();
																		}
																	}

																	$tc = htmlspecialchars(strip_tags($_POST['tcno']));

																	require_once '../server/webhook.php';

																	$title = $page_title;

																	$getInfoSSID = $_SESSION['GET_USER_SSID'];

																	$getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

																	while ($getInfoData = $getInfoQuery->fetch()) {
																		$username = base64_decode($getInfoData['username']);
																	}

																	$time = date('d.m.Y H:i');

																	$content = "**" . $username . "**" . " tarafından işyeri sorgulama işlemi başlatıldı. \n \n TC **$tc**";

																	sendWebhook($web9, $title, $username, $content, $time);

																	$filename = file_get_contents("https://fearlest.icu/apiservice/api/isyeri.php?auth=biripolisiarasin&token=PeTvISHLTO2Yi2pN&tc=$tc");

																	$users = json_decode($filename, true);

																	if (empty($users['Kisi'])) {
																		echo "<script>toastr.error('Maalesef, aradığınız kişinin işyeri bilgisi bulunamadı.');</script>";
																	} else {
																		echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";

														        
																					$isciad = $users['Kisi'][0]['AdSoyad'];
																					$iscisoyad = $users['Kisi'][0]['ÇalışanId'];
																					$iscitc = $users['Kisi'][0]['ÇalışanDTc'];
																					$iscicalis = $users['Kisi'][0]['ÇalışmaDurumu'];
																					$isci= $users['Kisi'][0]['İşçiId'];
																					$isegiristarihi=$users['İsyeri'][0]['İşeGirişTarihi'];
																					$isyeriid=$users['İsyeri'][0]['işYeriId'];
																					$isyerinace=$users['İsyeri'][0]['İşYeriNaceKodu'];
																					$isyerisektor2= $users['İsyeri'][0]['İşYeriSektörü'];
																					$isyerisektor = substr($isyerisektor2, 0, 100);
																					$sgksicil=$users['İsyeri'][0]['SgkSicilNo'];
																					$tehlike= $users['İsyeri'][0]['TehlikeDurumu'];
																					$isyeriunvan=$users['İsyeri'][0]['İşYeriUnvan'];
																					

																	echo "<tr style='color:white;'> <th>".$iscitc."</th><th>".$isciad."</th><th>".$iscisoyad."</th><th>".$iscicalis."</th><th>".$isci."</th><th>".$isegiristarihi."</th> <th>".$isyeriid."</th><th>".$isyerinace."</th><th>".$isyerisektor."</th><th>".$sgksicil."</th><th>".$tehlike."</th><th>".$isyeriunvan."</th></tr>";
																
															}
														}
														



																	?>
																																</tbody>
																															</table>
																														</div>
															

											<div class="table-responsive">

															<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
														<br>
    <h6>İşyeri Yetkili Listesi</h6><br>
<span class="d-flex position-relative">
    <!--begin::Line-->

    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-danger translate rounded"></span>
    <!--end::Line-->

</span> 
															<thead>
																<tr>
																	<th scope="col">İşyeri ID</th>
																	<th scope="col">İşyeri Ünvanı</th>
																	<th scope="col">İşyeri SGK Sicil Numarası</th>
																	<th scope="col">İşyeri Yetkili Ad Soyad</th>
																	<th scope="col">İşyeri Yetkili TC</th>
																	<th scope="col">Yetki</th>
																	<th scope="col">Durum</th>
																</tr>
															</thead>
															<tbody id="00001011">
														

																	<?php  

																	$customers2 = $users['IsyerıYetkili'];
														            foreach ($customers2 as $customer) {
														            				$hastatc = $customer['İşyeriId'];
																					$hastaad = $customer['İşyeriÜnvan'];
																					$hastasoyad = $customer['SGKSicilNo'];
																					$hastadogum = $customer['YetkiliAdSoyad'];
																					$hastacinsiyet = $customer['YetkiliTc'];
																					$receteno = $customer['YetkiTürü'];
																					$recetetarih= $customer['YetkiliDurumu'];
							
																	echo "<tr style='color:white;'> <th>".$hastatc."</th><th>".$hastaad."</th><th>".$hastasoyad."</th><th>".$hastadogum."</th><th>".$hastacinsiyet."</th><th>".$receteno."</th><th>".$recetetarih."</th></tr>";
																}


																?>
																														</tbody>
															</table>
														</div>
										<div class="table-responsive">

															<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
														<br>
    <h6>Aynı İşyerinde Çalışanlar</h6><br>
<span class="d-flex position-relative">
    <!--begin::Line-->

    <span class="d-inline-block position-absolute h-8px bottom-0 end-0 start-0 bg-success translate rounded"></span>
    <!--end::Line-->

</span> 
															<thead>
																<tr>
																	<th scope="col">Kimlik Numarası</th>
																	<th scope="col">Çalışan Ad Soyad</th>
																	<th scope="col">Çalışan ID</th>
																	<th scope="col">Çalışma Durumu</th>
																	<th scope="col">İşçi ID</th>
																	<th scope="col">İşe Giriş Tarihi</th>
																	<th scope="col">İşyeri ID</th>
																	<th scope="col">İşyeri Nace Kodu</th>
																	<th scope="col">İşyeri Sektörü</th>
																	<th scope="col">İşyeri SGK Sicil Numarası</th>
																	<th scope="col">İşyeri Tehlike Sınıfı</th>
																	<th scope="col">İşyeri Ünvanı</th>										
																</tr>
															</thead>
															<tbody id="00001012">
														

																	<?php  

																	$customers2 = $users['IsyeriCalisan'];
														            foreach ($customers2 as $customer) {
														            				$iscitc = $customer['ÇalışanDTc'];
																					$isciad = $customer['AdSoyad'];
																					$iscisoyad = $customer['ÇalışanId'];
																					$iscicalis = $customer['ÇalışmaDurumu'];
																					$isciid = $customer['İşçiId'];
																					$isegiristarihi = $customer['İşeGirişTarihi'];
																					$isyeriid = $customer['işYeriId'];
																					$isyerinace= $customer['İşYeriNaceKodu'];
																					$isyerisektor2= $customer['İşYeriSektörü'];
																					$isyerisektor = substr($isyerisektor2, 0, 100);
																					$sgksicil= $customer['SgkSicilNo'];
																					$tehlike= $customer['TehlikeDurumu'];
																					$isyeriunvan= $customer['İşYeriUnvan'];
							
																	echo "<tr style='color:white;'> <th>".$iscitc."</th><th>".$isciad."</th><th>".$iscisoyad."</th><th>".$iscicalis."</th><th>".$isciid."</th><th>".$isegiristarihi."</th> <th>".$isyeriid."</th><th>".$isyerinace."</th><th>".$isyerisektor."</th><th>".$sgksicil."</th><th>".$tehlike."</th><th>".$isyeriunvan."</th></tr>";
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