<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

$page_title = "Whitelist Yönetimi";

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

			if ($_POST) {

				$db = new PDO("mysql:host=localhost;dbname=101m;charset=utf8", "root", "");

				$tc = htmlspecialchars(strip_tags($_POST['tc']));

				$query = $db->query("SELECT * FROM 101m WHERE TC = '$tc'");
				$count = $query->rowCount();

				if ($count == 0) {
					echo "<script>toastr.error('Bu kişi zaten silinmiş!');setTimeout(() => window.location.reload(),800);</script>";
				} else {
					$sql = "DELETE FROM 101m WHERE TC = :tc";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':tc', $tc);
					$stmt->execute();
					echo "<script>toastr.success('Başarıyla silindi!');setTimeout(() => window.location.reload(),800);</script>";
				}
			}

			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="row">
								<div class="col-xl-12 col-md-12">
									<div class="col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row w-100 p-5 mb-7">
													<i class="ki-duotone ki-tablet-delete fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
													<div class="d-flex flex-column pe-0 pe-sm-10">
														<h5 class="mb-1">Whitelist Yönetimi</h5>
														<div style="padding: 1px;"></div>
														<span class="text-gray-800">Bu sistem aracılığıyla istediğiniz kişinin bilgilerini 101m veritabanından silebilirsiniz.</span>
													</div>
													<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
														<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i>
													</button>
												</div>
												<p>Veritabanından silmek istediğiniz kişinin TC Kimlik Numarasını aşağıya yazınız.</p>
												<p class="text-warning fw-bold"><i class="fa fa-info-circle text-warning"></i>&nbsp; Silinen veriler kesinlikle herhangi bir yere kaydedilmeyecektir.</p>
												<div class="block-content tab-content">
													<div class="tab-pane active" role="tabpanel">
														<form method="post">
															<input class="form-control form-control-solid" type="text" name="tc" required autocomplete="off" placeholder="TC Kimlik Numarası" maxlength="11" minlength="11"><br>
															<button type="submit" class="btn waves-effect waves-light btn-rounded btn-light-primary" style="width: 180px; height: 45px; outline: none;"> Gönder </button>
														</form>
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