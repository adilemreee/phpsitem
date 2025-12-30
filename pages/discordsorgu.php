<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Discord Sorgu";

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
												<h4 class="card-title mb-4"><img style="width: 28px;height: auto;" src="/assets/img/icons/discord.png" alt=""> &nbsp; Discord Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="discordsorgu" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<input autocomplete="off" name="tcno" class="form-control form-control-solid" type="text" minlength="15" maxlength="20" placeholder="Discord ID" required>
														</div>
														<br>
														<center class="nw">
															<button onclick="checkNumber()" id="sorgula" name="Sorgula" type="submit" class="btn waves-effect waves-light btn-rounded btn-success" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Sorgula </button>
															<button onclick="clearTable()" id="durdurButon" type="button" class="btn waves-effect waves-light btn-rounded btn-danger" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Sıfırla </button>
															<button onclick="copyTable()" id="copy_btn" type="button" class="btn waves-effect waves-light btn-rounded btn-primary" style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Kopyala </button>
															<button onclick="printTable()" id="yazdirTable" type="button" class="btn waves-effect waves-light btn-rounded btn-info" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Yazdır</button><br><br>
														</center>
													</form>

													<?php

													if (isset($_POST['Sorgula'])) {


														$tc = htmlspecialchars(strip_tags($_POST['tcno']));

														$filename = file_get_contents("http://localhost/pages/api/dcapi.php?auth=baba31&id=$tc"); // API linki buraya girilir ve ardından istekler gönderilir.
														$json_decode = json_decode($filename, true);

														$ad = $json_decode['data']['id'];
														$type = $json_decode['data']['type'];
														$bot = $json_decode['data']['is_bot'];
														$globalname = $json_decode['data']['username'];
														$image = $json_decode['data']['avatar']['url'];
														$premiummu = $json_decode['data']['flags'];										
														$timee = $json_decode['data']['created_at'];
													}

													?>
													<center>
														<div class="col-xl-2 col-md-6">
															<div class="col-12">
																<div class="card">
																	<div class="card-body">
																		<h4 &nbsp;="" class="card-title mb-4">Avatar</h4>
																		<?php
																		if ($image == "") {
																		?>
																			<div class="symbol symbol-150px">
																				<img src="../assets/media/images.jpeg">
																			</div>
																		<?php
																		} else {
																		?>
																			<img src="<?= $image; ?>" style="border-radius: 12px;" width="160" height="200">
																			<div style="padding: 5px;"></div>
																			<button class="btn btn-outline-primary"><a style="color: #fff" rel="nofollow" href="<?= $image; ?>" download="">Görseli İndir</a></button>
																		<?php
																		}
																		?>
																	</div>
																</div>
															</div>
														</div>
													</center>

													<div class="table-responsive">

														<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
															<thead>
																<tr>
																	<th>Discord ID</th>
																	<th>Hesap Tipi</th>
																	<th>Bot</th>
																	<th>Username</th>
																	<th>Badgeler</th>
																	<th>Hesap Oluşturulma Tarihi</th>
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
																	date_default_timezone_set('Europe/Istanbul');
																?>
																	<tr>
																		<th><?php echo $ad; ?></th>
																		<th><?php echo $type; ?></th>
																		<th><?php echo "Hayır"; ?></th>
																		<th><?php echo $globalname; ?></th>
																		<th><?php echo $premiummu; ?></th>
																		<th><?php echo date('d/m/Y H:i a', $timee); ?></th>
																	</tr>
																<?php
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