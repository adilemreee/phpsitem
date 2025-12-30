<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Sıralama";

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
										<i class="ki-duotone ki-cup fs-2hx text-warning me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Sıralama</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Bu sayfada, en iyi 50 kullanıcı sıralanmaktadır.</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>
								</div>
								<div class="card-body mt-5 pt-0">
									<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
										<thead>
											<tr class="fw-bold fs-6 text-gray-800 px-7">
												<th>Sıralama</th>
												<th>Takma Ad</th>
												<th>Rütbe</th>
												<th>XP</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$query = $db->query("SELECT * FROM `accounts` WHERE exp > 19000 ORDER BY exp DESC LIMIT 50");

											$m = 1;

											while ($data = $query->fetch()) {

												$exp = $data['exp'];

												if ($exp >= 0 && $exp < 500) {
													$rankName = "Cyber Shadow";
													$level = "1. Seviye";
													$img = 1;
												} elseif ($exp >= 500 && $exp < 1000) {
													$rankName = "Code Whisperer";
													$level = "2. Seviye";
													$img = 1;
												} elseif ($exp >= 1000 && $exp < 1500) {
													$rankName = "Data Phantom";
													$level = "3. Seviye";
													$img = 1;
												} elseif ($exp >= 1500 && $exp < 2000) {
													$rankName = "Encryption Wizard";
													$level = "4. Seviye";
													$img = 1;
												} elseif ($exp >= 2000 && $exp < 2500) {
													$rankName = "Firewall Breaker";
													$level = "5. Seviye";
													$img = 1;
												} elseif ($exp >= 2500 && $exp < 3000) {
													$rankName = "Malware Slayer";
													$level = "6. Seviye";
													$img = 2;
												} elseif ($exp >= 3000 && $exp < 3500) {
													$rankName = "Database Ninja";
													$level = "7. Seviye";
													$img = 2;
												} elseif ($exp >= 3500 && $exp < 4000) {
													$rankName = "Stealth Hacker";
													$level = "8. Seviye";
													$img = 2;
												} elseif ($exp >= 4000 && $exp < 4500) {
													$rankName = "Zero-Day Master";
													$level = "9. Seviye";
													$img = 2;
												} elseif ($exp >= 4500 && $exp < 5000) {
													$rankName = "Binary Ghost";
													$level = "10. Seviye";
													$img = 2;
												} elseif ($exp >= 5000 && $exp < 5500) {
													$rankName = "Digital Saboteur";
													$level = "11. Seviye";
													$img = 3;
												} elseif ($exp >= 5500 && $exp < 6000) {
													$rankName = "Trojan Hunter";
													$level = "12. Seviye";
													$img = 3;
												} elseif ($exp >= 6000 && $exp < 6500) {
													$rankName = "Root Access Master";
													$level = "13. Seviye";
													$img = 3;
												} elseif ($exp >= 6500 && $exp < 7000) {
													$rankName = "Exploit Enforcer";
													$level = "14. Seviye";
													$img = 3;
												} elseif ($exp >= 7000 && $exp < 7500) {
													$rankName = "Cipher Sentinel";
													$level = "15. Seviye";
													$img = 3;
												} elseif ($exp >= 7500 && $exp < 8000) {
													$rankName = "Bug Bounty Hunter";
													$level = "16. Seviye";
													$img = 4;
												} elseif ($exp >= 8000 && $exp < 8500) {
													$rankName = "Cyber Mercenary";
													$level = "17. Seviye";
													$img = 4;
												} elseif ($exp >= 8500 && $exp < 9000) {
													$rankName = "Deep Web Explorer";
													$level = "18. Seviye";
													$img = 5;
												} elseif ($exp >= 9000 && $exp < 9500) {
													$rankName = "Script Kiddie Whisperer";
													$level = "19. Seviye";
													$img = 5;
												} elseif ($exp >= 10000) {
													$rankName = "Virtual Vigilante";
													$level = "20. Seviye";
													$img = 6;
												} else {
													$rankName = "Bilinmeyen";
													$level = "";
													$img = 1;
												}

											?>
												<tr>
													<td><?= $m++; ?></td>
													<td>
														<?php

														if (empty($data['profile_image'])) {

														?>
															<img src="assets/media/svg/avatars/blank.jpg" style="border-radius: 50%;width: 32px;box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);">
														<?php

														} else {

														?>
															<img src="<?= $data['profile_image']; ?>" style="border-radius: 50%;width: 32px;box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);">
														<?php
														}
														?>
														&nbsp;<?= base64_decode($data['username']); ?>
													</td>
													<td><img src="../assets/img/<?= $img; ?>.png" style="border-radius: 50%;width: 32px;box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);"> &nbsp;<span><?= $rankName; ?></span></td>
													<td><?= $data['exp']; ?></td>
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