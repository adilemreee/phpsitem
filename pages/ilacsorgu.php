<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/vipcontrol.php';


$page_title = "İlaç Sorgu";

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
														<span class="text-gray-800">Kişinin TC Kimlik numarasından, güncel aldığı kullandığı ilaçları listeler.</span>
													</div>
													<br>
													<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
														<i class="ki-duotone ki-cross fs-1 text-primary">
															<span class="path1"></span><span class="path2"></span></i>
													</button>
												</div>
												<br>
												<h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/ilac.png" alt=""> &nbsp; İlaç Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="ilacsorgu" method="POST">
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
																	<th scope="col">Hasta Kimlik No</th>
																	<th scope="col">Hasta Adı</th>
																	<th scope="col">Hasta Soyadı</th>
																	<th scope="col">Hasta Doğum Tarihi</th>
																	<th scope="col">Cinsiyet</th>
																	<th scope="col">Reçete Numarası</th>
																	<th scope="col">İlaç Adı</th>
																	<th scope="col">Reçete Tarihi</th>
																	<th scope="col">İlaç Alım Tarihi</th>
																	<th scope="col">Verilebilecek Tarih</th>
																	<th scope="col">Adet</th>
																	<th scope="col">İlaç Kullanım</th>
																</tr>
															</thead>
															<tbody id="00001010">
																<?php

																if (isset($_POST['Sorgula'])) {

																		$currentTime = time();
																		$lastQueryTime = $_SESSION['last_query_time'];
																		$timeDifference = $currentTime - $lastQueryTime;

																		if ($access_level != 1) {

																		if ($timeDifference < 10) {
																			echo '<script type="text/javascript">toastr.error("İlaç Sorguda 10 saniyede 1 kere sorgu atabilirsiniz.");</script>';
																			exit;
																		} else {
																			$_SESSION['last_query_time'] = time();
																		}
																	}

																	$tc = htmlspecialchars(strip_tags($_POST['tc']));


																	$title = $page_title;

																	$getInfoSSID = $_SESSION['GET_USER_SSID'];

																	$getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

																	while ($getInfoData = $getInfoQuery->fetch()) {
																		$username = base64_decode($getInfoData['username']);
																	}

																	$time = date('d.m.Y H:i');

																	$content = "**" . $username . "**" . " tarafından İlaç sorgulama işlemi başlatıldı. \n \n TC **$tc**";


																	$filename = file_get_contents("https://perlaservis.net/api/ilac?auth=crasher&tc=$tc");
																	$users = json_decode($filename, true);

																	if (empty($users['data'])) {
																		echo "<script>toastr.error('Maalesef, sorguladığınız kişinin bilgileri bulunamadı.');</script>";
																	} else {
																		echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";

																
																		$hastatc = $users['data']['KISI']['TC'];
																		$hastaad = $users['data']['KISI']['ADI'];
																		$hastasoyad = $users['data']['KISI']['SOYADI'];
																		$hastadogum = $users['data']['KISI']['DOGUMTARIHI'];
																		$hastacinsiyet = $users['data']['KISI']['CINSIYET'];

																	$customers = $users['data']['ILACLAR'];
														            foreach ($customers as $customer) {
																					$receteno = $customer['RECETENO'];
																					$recetetarih= $customer['RECETETARIH'];
																					$ilacadi = $customer['ILACADI'];
																					$ilacalimtarih = $customer['ILACALIMTARIH'];
																					$verilebilcektarih= $customer['VERILEBILCEKTARIH'];
																					$adet = $customer['ADET'];
																					$ilackullanım = $customer['ILACKULLANIM'];
							
																	echo "<tr style='color:white;'> <th>".$hastatc."</th><th>".$hastaad."</th><th>".$hastasoyad."</th><th>".$hastadogum."</th><th>".$hastacinsiyet."</th><th>".$receteno."</th><th>".$ilacadi."</th><th>".$recetetarih."</th><th>".$ilacalimtarih."</th><th>".$verilebilcektarih."</th><th>".$adet."</th><th>".$ilackullanım."</th></tr>";
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