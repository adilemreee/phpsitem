<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

$page_title = "Kullanıcı Görüntüle";

$get = urldecode(base64_decode($_GET['token']));

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

			if (isset($_POST['user_delete'])) {

				$hash = htmlspecialchars(strip_tags($_POST['hash']));

				$sql = $db->query("DELETE FROM accounts WHERE hash = '$hash'");

				echo "<script>toastr.success('Kullanıcı başarıyla silindi.');</script>";
			}

			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="card">
								<div class="card-header border-0 pt-5">
									<div class="alert alert-dismissible bg-light-primary border border-primary  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
										<i class="ki-duotone ki-eye fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Kullanıcı Görüntüle</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Bu sayfa üzerinden kullanıcıların bilgilerini inceleyebilirsiniz.</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>
								</div>
								<div class="card-body mt-5 pt-0">
									<?php

									$query = $db->query("SELECT * FROM `accounts` WHERE hash = '$get'");

									$count = $query->rowCount();

									if ($count != 1) {
										echo "<script>window.location = 'users';</script>";
										exit;
									}

									while ($data = $query->fetch()) {
										$id = $data['id'];
										$username = base64_decode($data['username']);
										$email = base64_decode($data['email']);
										$register_date = $data['register_date'];
										$balance = $data['balance'];
										$exp = $data['exp'];
										$secret_question = $data['secret_question'];
										$secret_answer = $data['secret_answer'];
										$last_login_time = $data['last_login_time'];
										$access_level = $data['access_level'];
										$hide_username = $data['hide_username'];
										$premium = $data['premium'];
										$success_login_count = $data['success_login_count'];
										$failed_login_count = $data['failed_login_count'];
										$suspect_login_count = $data['suspect_login_count'];
										$profile_image = $data['profile_image'];
										$expiration_date = $data['expiration_date'];
									}

									$DateTimeNow = date('Y-m-d H:i:s');

									if ($DateTimeNow == $last_login_time) {
										$class = "bg-success";
										$color = "success";
										$status = "Çevrimiçi";
									} else {
										$class = "bg-danger";
										$color = "danger";
										$status = "Çevrimdışı";
									}

									?>


									<table id="zero-conf" class="table table-striped table-row-bordered gy-5 gs-7 border rounded" style="width:100%">
										<tbody>
											<tr>
												<th>Kullanıcı ID</th>
												<td><?= $id; ?></td>
											</tr>
											<tr>
												<th>Kullanıcı Adı</th>
												<td><?= $username; ?></td>
											</tr>
											<tr>
												<th>Email Adresi</th>
												<td><?= $email; ?></td>
											</tr>
											<tr>
												<th>Kalan Zaman</th>
												<td>
													<?php

													if ($expiration_date == "0") {
														echo "Sınırsız";
													} else {
														// Bugünkü tarihi alın
														$current_date = date("Y-m-d");

														// Hesap bitiş tarihini ve bugünkü tarihi datetime nesnelerine dönüştürün
														$expiration_datetime = new DateTime($expiration_date);
														$current_datetime = new DateTime($current_date);

														// Farkı hesaplayın
														$date_diff = $current_datetime->diff($expiration_datetime);

														// Kalan gün sayısını alın
														$remaining_days = $date_diff->days;

														// Kalan gün sayısını ekrana yazdırın
														echo "Hesabınızın süresi dolmasına " . $remaining_days . " gün kaldı.";
													}

													?>
												</td>
											</tr>
											<tr>
												<th>Profil Resmi</th>
												<td>
													<div class="me-7 mb-4">
														<div class="symbol symbol-100px symbol-lg-140px symbol-fixed position-relative">
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
															<div class="position-absolute translate-middle bottom-0 start-100 mb-6 <?= $class; ?> rounded-circle border border-4 border-body h-20px w-20px"></div>
														</div>
													</div>
												</td>
											</tr>
											<tr>
												<th>Durum</th>
												<td><span class="badge badge-light-<?= $color; ?>"><?= $status; ?></span></td>
											</tr>
											<tr>
												<th>Gizli Soru</th>
												<td><?= $secret_question; ?></td>
											</tr>
											<tr>
												<th>Gizli Soru Cevabı</th>
												<td><?= $secret_answer; ?></td>
											</tr>
											<tr>
												<th>Yetki Durumu</th>
												<td>
													<?php

													if ($access_level == 6) {
														echo "Admin";
													} else {
														echo "Normal Kullanıcı";
													}

													?>
												</td>
											</tr>
											<tr>
												<th>Premium Durumu</th>
												<td>
													<?php

													if ($premium == 1) {
														echo "Premium üyeliği bulundu.";
													} else {
														echo "Premium üyeliği bulunamadı.";
													}

													?>
												</td>
											</tr>
											<tr>
												<th>Takma Ad Gizle</th>
												<td>
													<?php

													if ($hide_username == "true") {
														echo "Gizlendi";
													} else {
														echo "Gizlenmedi";
													}

													?>
												</td>
											</tr>
											<tr>
												<th>Son Giriş Tarihi</th>
												<td><?= $last_login_time; ?></td>
											</tr>
											<tr>
												<th>Bakiye</th>
												<td><?= $balance; ?> $</td>
											</tr>
											<tr>
												<th>Kayıt Olma Tarihi</th>
												<td><?= $register_date; ?></td>
											</tr>
											<tr>
												<th>Deneyim Puanı</th>
												<td><?= $exp; ?></td>
											</tr>
											<tr>
												<th>Hesap Durumu</th>
												<td>Onaylandı</td>
											</tr>
											<tr>
												<th>Başarılı Giriş</th>
												<td><?= $success_login_count; ?> Giriş</td>
											</tr>
											<tr>
												<th>Başarısız Giriş</th>
												<td><?= $failed_login_count; ?> Giriş</td>
											</tr>
											<tr>
												<th>Onaysız Giriş Denemesi</th>
												<td><?= $suspect_login_count; ?> Giriş</td>
											</tr>

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