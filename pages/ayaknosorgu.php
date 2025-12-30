<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Ayak Numarası Sorgu";


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
												<div class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
													<i class="ki-duotone ki-information-2 fs-2hx text-primary me-4 mb-5 mb-sm-0">
														<span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
													<div class="d-flex flex-column pe-0 pe-sm-10">
														<h5 class="mb-1">Bilgilendirme</h5>
														<div style="padding: 1px;"></div>
														<span class="text-gray-800">Bu sistem tamamen eğlence amaçlı kodlanmıştır. Çıkan sonuçlar gerçek değildir.</span>
													</div>
													<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
														<i class="ki-duotone ki-cross fs-1 text-primary">
															<span class="path1"></span><span class="path2"></span></i>
													</button>
												</div>
												<br>
												<h4 class="card-title mb-4">Ayak Numarası Sorgu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="ayaknosorgu" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<input class="form-control form-control-solid" autocomplete="off" type="tel" id="kt_inputmask_2" name="tcno" minlength="11" maxlength="11" placeholder="TC Kimlik Numarası" required>
															<br>
														</div>
														<button name="Sorgula" type="submit" class="btn waves-effect waves-light btn-rounded btn-light-primary" style="font-weight: 400;;width: 180px; height: 45px; outline: none;"> Sorgula </button>

													</form>

													<div class="table-responsive">

														<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
															<thead>
																<tr>
																	<th>TC</th>
																	<th>Ayak Numarası</th>
																</tr>
															</thead>
															<tbody id="00001010">
																<?php

																if (isset($_POST['Sorgula'])) {
																	

																	echo "<script>toastr.info('Kişi bilgileri getirildi.');</script>";
																	echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı.');</script>";

																	$tc = htmlspecialchars(strip_tags($_POST['tcno']));

																	$salt = rand(30, 70);

																	if ($salt <= 40) {
																		$message = "gayet ideal bir ayak numarasi.";
																	} else if ($salt >= 41 && $salt <= 55) {
																		$message = "ortalamadan yuksek bir ayak numarasi.";
																	} else if ($salt >= 55 && $salt <= 70) {
																		$message = "shrekmisin orospu evladi.";
																	} else {
																		$message = "normal bir ayak numarasi";
																	}


																?>
																	<tr>
																		<td> <?php echo $tc; ?> </td>
																		<td> <?= $salt; ?> numara <?php echo $message; ?></td>
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

	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
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