<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Güvenlik Kayıtları";

?>
<!DOCTYPE html>

<html lang="tr">

<head>
	<?php include 'inc/header_main.php'; ?>
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
					<!--begin::Post-->
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<!--begin::Container-->
						<div id="kt_content_container" class=" container-xxl ">

							<!--begin::Navbar-->
							<div class="card mb-5 mb-xl-10">
								<div class="card-body pt-9 pb-0">
									<div class="d-flex flex-wrap flex-sm-nowrap">
										<div class="me-7 mb-4">
											<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
												<?php

												if (empty($profile_image)) {

												?>
													<img src="assets/media/svg/avatars/blank.jpg">
												<?php

												} else {

												?>
													<img src="<?= $profile_image; ?>">
												<?php
												}
												?>
												<div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
											</div>
										</div>

										<div class="flex-grow-1">
											<div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
												<div class="d-flex flex-column">
													<div class="d-flex align-items-center mb-2">
														<a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?= $username; ?></a>
														<a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i></a>
													</div>

													<div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
														<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
															<i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> <?= $rank; ?>
														</a>
														<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
															<i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span class="path2"></span></i> <?= $site_name; ?>
														</a>
														<a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
															<i class="ki-duotone ki-sms fs-4"><span class="path1"></span><span class="path2"></span></i> &nbsp;<?= $email; ?>
														</a>
													</div>
												</div>

												<div class="d-flex my-4">
													<a href="notification" class="btn btn-sm btn-light me-2">
														<span class="indicator-label">
															Bildirimleri Aç</span>
													</a>
													<a href="#" class="btn btn-sm btn-primary me-3" onclick="window.location.reload();">Yenile</a>
												</div>
											</div>

											<div class="d-flex flex-wrap flex-stack">
												<div class="d-flex flex-column flex-grow-1 pe-8">
													<div class="d-flex flex-wrap">
														<div class="border border-gray-300 border-solid rounded min-w-125px py-3 px-4 me-6 mb-3">
															<div class="d-flex align-items-center">
																<i class="ki-duotone ki-medal-star fs-3 text-success me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
																<div class="fs-2 fw-bold"><?= $rankName; ?></div>
															</div>
															<div class="fw-semibold fs-6 text-gray-400">Rütbe Adı</div>

														</div>
														<div class="border border-gray-300 border-solid rounded min-w-125px py-3 px-4 me-6 mb-3">
															<div class="d-flex align-items-center">
																<i class="ki-duotone ki-abstract-23 fs-3 text-danger me-2"><span class="path1"></span><span class="path2"></span></i>
																<div class="fs-2 fw-bold"><?= $exp; ?> XP</div>
															</div>
															<div class="fw-semibold fs-6 text-gray-400">Deneyim Puanı</div>
														</div>

														<div class="border border-gray-300 border-solid rounded min-w-125px py-3 px-4 me-6 mb-3">
															<div class="d-flex align-items-center">
																<i class="ki-duotone ki-crown fs-3 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
																<div class="fs-2 fw-bold"><?= $level; ?></div>
															</div>
															<div class="fw-semibold fs-6 text-gray-400">Seviye</div>
														</div>
													</div>
												</div>

												<div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
													<div class="d-flex justify-content-between w-100 mt-auto mb-2">
														<span class="fw-semibold fs-6 text-gray-400">Seviye İlerlemesi</span>
														<?php

														if ($exp >= 10000) {

														?>
															<span class="fw-bold fs-6">100%</span>
													</div>
													<div class="h-5px mx-3 w-100 bg-light mb-3">
														<div class="bg-success rounded h-5px" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
													</div>
												<?php

														} else {

															$maxExp = 10000; // Maksimum deneyim puanı (örneğin 10000)
															$percent = ($exp / $maxExp) * 100;


												?>
													<span class="fw-bold fs-6"><?= $percent; ?>%</span>
												</div>
												<div class="h-5px mx-3 w-100 bg-light mb-3">
													<div class="bg-success rounded h-5px" role="progressbar" style="width: <?= $percent; ?>%;" aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											<?php
														}
											?>
											</div>
										</div>
									</div>
								</div>

								<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 " href="overview">
											Bilgilerimi Görüntüle </a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 " href="settings">
											Bilgilerimi Düzenle </a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="security">
											Güvenlik Kayıtları </a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 " href="balance">
											Bakiye Transferi </a>
									</li>

								</ul>
							</div>
						</div>
						<div class="row g-xxl-9">
							<div class="col-xxl-12">
								<div class="card card-xxl-stretch mb-5 mb-xl-10">
									<div class="card-header card-header-stretch">
										<div class="card-title">
											<h3 class="m-0 text-gray-900">Güvenlik Kayıtları</h3>
										</div>
									</div>
									<div class="card-body pt-7 pb-0 px-0">
										<div class="tab-content">
											<div class="tab-pane fade active show" id="kt_security_summary_tab_pane_hours" role="tabpanel">
												<div class="row p-0 mb-5 px-9">
													<div class="col">
														<div class="border border-solid border-gray-300 text-center min-w-125px rounded pt-4 pb-2 my-3" style="background-color: #1c3238;border-color: #50cd89 !important;">
															<span class="fs-4 fw-semibold text-success d-block"> Başarılı Giriş</span>
															<span class="fs-2hx fw-bold text-gray-900" data-kt-countup="true" data-kt-countup-value="<?= $success_login_count; ?>"><?= $success_login_count; ?></span>
														</div>
													</div>
													<div class="col">
														<div class="border border-solid border-gray-300 text-center min-w-125px rounded pt-4 pb-2 my-3" style="background-color: #392f28;border-color: #ffc700 !important;">
															<span class="fs-4 fw-semibold text-warning d-block">Onaysız Giriş Denemesi</span>
															<span class="fs-2hx fw-bold text-gray-900" data-kt-countup="true" data-kt-countup-value="<?= $suspect_login_count; ?>"><?= $suspect_login_count; ?></span>
														</div>
													</div>
													<div class="col">
														<div class="border border-solid border-gray-300 text-center min-w-125px rounded pt-4 pb-2 my-3" style="background-color: #3a2434;border-color: #f1416c !important;">
															<span class="fs-4 fw-semibold text-danger d-block">Başarısız Giriş</span>
															<span class="fs-2hx fw-bold text-gray-900" data-kt-countup="true" data-kt-countup-value="<?= $failed_login_count; ?>"><?= $failed_login_count; ?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card mb-5 mb-xl-10">
							<div class="card-header">
								<div class="card-title">
									<h3>Giriş Kayıtları</h3>
								</div>
							</div>
							<div class="card-body p-0">
								<div class="table-responsive">
									<table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
										<thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
											<tr>
												<th class="min-w-100px">Durum Kodu</th>
												<th class="min-w-150px">Tarayıcı</th>
												<th class="min-w-150px">İşletim Sistemi</th>
												<th class="min-w-150px">IP Class</th>
												<th class="min-w-150px">Giriş Tarihi</th>
											</tr>
										</thead>
										<tbody class="fw-6 fw-semibold text-gray-600">
											<?php

											$hash = $_SESSION['GET_USER_SSID'];

											$loginSessQry = $db->query("SELECT * FROM login_sessions WHERE hash = '$hash' ORDER BY id DESC LIMIT 5");

											while ($loginSessData = $loginSessQry->fetch()) {

											?>
												<tr>

													<td>
														<span class="badge badge-light-success fs-7 fw-bold"><i class="fa fa-check text-success"></i>&nbsp; OK 200</span>
													</td>

													<td><?= $loginSessData['device']; ?></td>

													<td><?= $loginSessData['operating_system']; ?></td>

													<td><?= $loginSessData['ip_class']; ?></td>

													<td><?= $loginSessData['login_time']; ?></td>
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
	<script src="../assets/js/custom/pages/user-profile/general.js"></script>
	<script src="../assets/js/custom/account/settings/signin-methods.js"></script>
	<script src="../assets/js/custom/account/security/security-summary.js"></script>
	<script src="../assets/js/custom/account/security/license-usage.js"></script>
	<script src="../assets/js/custom/account/settings/deactivate-account.js"></script>
	<script src="../assets/js/widgets.bundle.js"></script>
	<script src="../assets/js/custom/widgets.js"></script>
	<script src="../assets/js/custom/apps/chat/chat.js"></script>
	<script src="../assets/js/custom/utilities/modals/offer-a-deal/type.js"></script>
	<script src="../assets/js/custom/utilities/modals/offer-a-deal/details.js"></script>
	<script src="../assets/js/custom/utilities/modals/offer-a-deal/finance.js"></script>
	<script src="../assets/js/custom/utilities/modals/offer-a-deal/complete.js"></script>
	<script src="../assets/js/custom/utilities/modals/offer-a-deal/main.js"></script>
	<script src="../assets/js/custom/utilities/modals/users-search.js"></script>
</body>

</html>