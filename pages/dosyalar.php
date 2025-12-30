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
								<div class="card-body mt-5 pt-0">
									<h4 class="card-title mb-4"><img style="width: 30px;height: auto;" src="https://cdn-icons-png.flaticon.com/128/5994/5994725.png" alt=""> Dosyalar</h4>
									<div class="text-gray-600 fw-semibold mb-5">
												Bu platform üzerinden ücretsiz olarak paylaştığımız dosyalara erişim sağlayabilir, Paylaştığımız dosyalarda kesinlikle TROJAN içeren birşey bulundurmuyoruz. Virustotal butonundan kontrol sağlayabilirsiniz.
												</div>
									<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
										<thead>
											<tr class="fw-bold fs-6 text-gray-800 px-7">
												<th>Durum</th>
												<th>Dosya Türü</th>
												<th>Dosya Adı</th>
												<th>Paylaşan Admin</th>
												<th>Paylaşılma Tarihi</th>
												<th>Görüntülenme</th>
												<th>İşlem</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$get = htmlspecialchars(strip_tags($_GET['search']));

											if (empty($get)) {
												$query = $db->query("SELECT * FROM `dosyalar` ORDER BY id DESC");
											} else {
												$query = $db->query("SELECT * FROM `dosyalar` WHERE `title` LIKE '%$get%' ORDER BY id DESC");
											}

											$m = 1;

											while ($data = $query->fetch()) {

												$type = $data['type'];


												if ($type == "rat") {
													$result = "https://i.hizliresim.com/ptg0162.png";
												} else if ($type == "database") {
													$result = "https://i.hizliresim.com/m2yjaa4.png";
												} else if ($type == "script") {
													$result = "https://i.hizliresim.com/708ozqs.png";
												}
												else {
													$result = "https://i.hizliresim.com/gpkjct7.png";
												}

	


											$checkUser = $db->query("SELECT * FROM `accounts` WHERE hash = '$user_hash'");

											while ($checkData = $checkUser->fetch()) {
												$image = $checkData['profile_image'];
												$get_username = $checkData['username'];
											}


											?>
												<tr>
													<td><?php
														$ucret = $data['ucret'];

                                        				if ($ucret == "ucretsiz") {
                                            				echo '<span class="badge badge-success">Ücretsiz</span>';
                                        				} else {
                                          					 echo '<span class="badge badge-danger">Ücretli</span>';
                                        				}

				                                    ?></td>
													<td><img src="<?= $result; ?>" width="25px"></td>
													<td><?= $data['title']; ?></td>
													<td><p style="color: #FF7F00;"><?= $data['admin']; ?></p></td>
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
													<td><?= $data['view']; ?> Görüntülenme</td>
													<td><a href="/dosya?hex=<?= $data['hash']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Görüntüle</a></td>
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