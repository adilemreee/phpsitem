<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

$page_title = "Odemeler";

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
										<i class="ki-duotone ki-dollar fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Yatırımlar</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Yatırımları bu sayfadan görüntüleyebilirsiniz.</span>
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
												<th>Gönderen</th>
												<th>Miktar</th>
												<th>Yöntem</th>
												<th>Tarih</th>
												<th>İşlem</th>
											</tr>
										</thead>
										<tbody>
											<?php

											if (isset($_POST['add_balance'])) {

												$hash3 = htmlspecialchars(strip_tags($_POST['hash']));
												$query = $db->query("SELECT * FROM `odemeler` ORDER BY id DESC LIMIT 100");
												$query2 = $db->query("SELECT * FROM `odemeler` WHERE user_hash = '$hash3'");
												while ($data3 = $query2->fetch()) {
   													 $miktar = $data3['miktar'];
												}
												$query3 = $db->query("SELECT * FROM `accounts` WHERE hash = '$hash3'");
												while ($data4 = $query3->fetch()) {
   													 $balance2 = $data4['balance'];
												}
											
												$totalpara = $miktar + $balance2;

												$sql = "UPDATE accounts SET balance = :miktar WHERE hash = :hash";
												$stmt = $db->prepare($sql);
												$stmt->bindParam(':miktar', $totalpara);
												$stmt->bindParam(':hash', $hash3);
												$stmt->execute();


												echo "<script>toastr.success('Kullanıcı başarıyla onaylanmış ve $miktar TL bakiyesi eklenmiştir.');</script>";

												$sql = $db->query("DELETE FROM odemeler WHERE user_hash = '$hash3'");

											}
	
											

											if (isset($_POST['delete_balance'])) {

												$hash = htmlspecialchars(strip_tags($_POST['hash']));

												$sql = $db->query("DELETE FROM odemeler WHERE user_hash = '$hash'");

												echo "<script>toastr.success('Başarıyla yatırım iptal edildi.');</script>";
												}

											$query = $db->query("SELECT * FROM `odemeler` ORDER BY id DESC LIMIT 100");

											$m = 1;

											while ($data = $query->fetch()) {

												$user_hash = $data['user_hash'];

												$query2 = $db->query("SELECT * FROM `accounts` WHERE hash = '$user_hash'");

												while ($data2 = $query2->fetch()) {

											?>
													<tr>
														<td><?= $m++; ?></td>
														<td><?= $data['username']; ?></td>
														<td><?= $data['miktar']; ?></td>
														<td><?= $data['yontem']; ?></td>
														<td><?= $data['tarih']; ?></td>
														<td>
														<div class="d-flex">
															<form action="" method="POST">
																<input type="hidden" name="hash" value="<?= $data['user_hash']; ?>">
																<button type="submit" name="add_balance" class="btn btn-sm btn-success"> Onayla</button>
															</form>
															<div style="padding: 5px;"></div>
															<form action="" method="POST">
																<input type="hidden" name="hash" value="<?= $data['user_hash']; ?>">
																<button type="submit" name="delete_balance" class="btn btn-sm btn-danger"> Reddet</button>
															</form>
														</div>
													</td>
													</tr>
											<?php

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