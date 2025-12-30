<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Bildirimler";

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
			<?php

			include 'inc/header_sidebar.php';

			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="card">
								<div class="card-header border-0 pt-5">
									<div class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
										<i class="ki-duotone ki-notification fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Bildirimler</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Paylaştığımız duyuruları bu platform üzerinden görüntüleyebilirsiniz.</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>
								</div>
								<div class="card-body mt-5 pt-0">
									<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
										<thead>
											<tr class="fw-bold fs-6 text-gray-800 px-7">
												<th>Sıra</th>
												<th>Başlık</th>
												<th>Tür</th>
												<th>Görüntülenme</th>
												<th>Paylaşılma Tarihi</th>
												<th>İşlem</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$get = htmlspecialchars(strip_tags($_GET['search']));

											if (empty($get)) {
												$query = $db->query("SELECT * FROM `news` ORDER BY id DESC");
											} else {
												$query = $db->query("SELECT * FROM `news` WHERE `title` LIKE '%$get%' ORDER BY id DESC");
											}

											$m = 1;

											while ($data = $query->fetch()) {

												$type = $data['type'];

												if ($type == "event") {
													$result = "Etkinlik";
												} else if ($type == "news") {
													$result = "Duyuru";
												} else {
													$result = "Bakım Notu";
												}

											?>
												<tr>
													<td><?= $m++; ?></td>
													<td><?= $data['title']; ?></td>
													<td><?= $result; ?></td>
													<td><?= $data['view']; ?> Görüntülenme</td>
													<td>
														<?php
														$verilenTarih = $data['history'];
														$hedefTarih = DateTime::createFromFormat('d.m.Y H:i', $verilenTarih);
														$bugun = new DateTime();

														$interval = $hedefTarih->diff($bugun);

														if ($interval->y > 0) {
															echo $interval->y . " yıl önce";
														} elseif ($interval->m > 0) {
															echo $interval->m . " ay önce";
														} elseif ($interval->d > 0) {
															echo $interval->d . " gün önce";
														} elseif ($interval->h > 0) {
															echo $interval->h . " saat önce";
														} elseif ($interval->i > 0) {
															echo $interval->i . " dakika önce";
														} else {
															echo "Az önce";
														}
														?>
													</td>
													<td><a href="view?hex=<?= $data['hash']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Görüntüle</a></td>
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

	<script src="../assets/plugins/global/plugins.bundle.js"></script>
	<script src="../assets/js/scripts.bundle.js"></script>
	<script src="../assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="../assets/js/custom/apps/customers/list/export.js"></script>
	<script src="../assets/js/custom/apps/customers/list/list.js"></script>
	<script src="../assets/js/custom/apps/customers/add.js"></script>
	<script src="../assets/js/widgets.bundle.js"></script>
	<script src="../assets/js/custom/widgets.js"></script>
	<script src="../assets/js/custom/apps/chat/chat.js"></script>
	<script src="../assets/js/custom/utilities/modals/users-search.js"></script>

</body>

</html>