<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Kurallar";

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

		.card-body img:hover {
			opacity: 0.8;
			filter: grayscale(1.1);
			cursor: pointer;
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
							<div class="row">
								<div class="col-md-12">
									<div class="card">
										<div class="card-body">
										<div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row w-100 mt-1 p-5 mb-0">
												<i class="ki-duotone ki-information-2 fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
												<div class="d-flex flex-column pe-0 pe-sm-10">
													<h5 class="mb-1">Bilgilendirme</h5>
													<div style="padding: 1px;"></div>
													<span class="text-gray-800">Tüm kayıt olan kullanıcılar, kuralları kabul etmiş sayılır.</span>
												</div>
												<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
													<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
											</div>
											<br>
											<img src="../assets/img/welcome2.png" style="width: 100%;height: 430px;object-fit: cover;border-radius: 8px;" alt="">
											<br>
											<br>
											<div id="rules">
												<span><img src="../assets/img/verified.png" style="width: 32px;"> &nbsp;&nbsp;Hesaplarınız size özeldir, Hesabınızı başka bir kullanıcıyla birlikte kullanmanız yasaktır.</span>
												<div style="padding: 7px;"></div>
												<span><img src="../assets/img/verified.png" style="width: 32px;"> &nbsp;&nbsp;Premium sorguları admin onayı olmadan ücretsiz olarak free üyelerimize, platformlara, forumlara sunmak yasaktır.</span>
												<div style="padding: 7px;"></div>
												<span><img src="../assets/img/verified.png" style="width: 32px;"> &nbsp;&nbsp;Bakiye yükleme kısmını suistimal etmek yasaktır.</span>
												<div style="padding: 7px;"></div>
												<span><img src="../assets/img/verified.png" style="width: 32px;"> &nbsp;&nbsp;Resmi kanallarımız https://discord.gg/ezik ve https://t.me/ezikworld'dür. Başka sosyal medya ağımız bulunmamaktadır.</span>
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