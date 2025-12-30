<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Bakiye Transferi";

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

			if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["transferBalance"])) {

				$hash = $_SESSION['GET_USER_SSID'];

				$post_username = htmlspecialchars(strip_tags($_POST["username"]));

				$post_count = htmlspecialchars(strip_tags($_POST["count"]));

				$count = substr($post_count, 1, -3);

				$base64_username = base64_encode($post_username);

				$checkAccount = $db->query("SELECT * FROM `accounts` WHERE username = '$base64_username'");
				$accountCount = $checkAccount->rowCount();

				while ($checkData = $checkAccount->fetch()) {
					$currBalance = $checkData['balance'];
				}

				if ($currBalance == null) {
					$money = 0; // $money değişkeni burada 0 olarak atanmalıdır.
				} else {
					$money = $currBalance; // $money değişkeni $currBalance değeri ile güncellenmelidir.
				}

				if (empty($post_username) || $count <= 0) {
					echo "<script>setTimeout(() => toastr.error('Lütfen geçerli bir kullanıcı adı ve geçerli bir miktar girin.'), 500)</script>";
				} else if ($post_username == $username) {
					echo "<script>setTimeout(() => toastr.error('Kendinize bakiye gönderemezsiniz!'), 500)</script>";
				} else if ($accountCount != 1) {
					echo "<script>setTimeout(() => toastr.error('Kullanıcı bulunamadı. Lütfen geçerli bir kullanıcı adı girin.'), 500)</script>";
				} else if ($balance < $count) {
					echo "<script>setTimeout(() => toastr.error('Hata: Yetersiz bakiye!'), 500)</script>";
				} else if ($balance > $count && $accountCount == 1) {

					$newBalanceSender = $balance - $count;

					$stmt1 = $db->prepare("UPDATE `accounts` SET balance = :balance WHERE hash = :hash");
					$stmt1->bindParam(':balance', $newBalanceSender);
					$stmt1->bindParam(':hash', $hash);
					$stmt1->execute();

					$sql2 = "INSERT INTO `balance_transfers` (balance, hash, username, history) VALUES (:balance, :hash, :username, :history)";
					$stmt2 = $db->prepare($sql2);
					$stmt2->bindParam(':balance', $count);
					$stmt2->bindParam(':hash', $hash);
					$stmt2->bindParam(':username', $post_username);
					$stmt2->bindParam(':history', date('Y.m.d H:i'));
					$stmt2->execute();


					$newBalance = $money + $count;

					$stmt2 = $db->prepare("UPDATE `accounts` SET balance = :balance WHERE username = :username");
					$stmt2->bindParam(':balance', $newBalance);
					$stmt2->bindParam(':username', $base64_username);
					$stmt2->execute();

					$recordsql = "INSERT INTO records (message, icon, user_hash, hour) VALUES (:message, :icon, :user_hash, :hour)";
					$record = $db->prepare($recordsql);

					$record->bindValue(':message', $username . " " . $post_username . " kullanıcısına $count USDT gönderdi.");
					$record->bindValue(':icon', "fa fa-sack-dollar");
					$record->bindValue(':user_hash', $_SESSION['GET_USER_SSID']);
					$record->bindValue(':hour', date('H:i'));
					$record->execute();

					echo "<script>setTimeout(() => toastr.success('Transfer başarılı! $post_username kullanıcısına $count TL bakiye gönderildi.'), 500)</script><script>setTimeout (() => window.location.reload(), 1500);</script>";
				} else {
					echo "<script>setTimeout(() => toastr.error('Bilinmeyen bir hata oluştu!'), 500)</script>";
				}
			}

			?>

			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class=" container-xxl ">
							<div class="card mb-5 mb-xl-10">
								<div class="card-body pt-9 pb-0">
									<div class="d-flex flex-wrap flex-sm-nowrap">
										<div class="me-7 mb-4">
											<div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
												<?php

												if (empty($profile_image)) {

												?>
													<img src="assets/media/svg/avatars/blank.svg">
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
										<a class="nav-link text-active-primary ms-0 me-10 py-5" href="overview">
											Bilgilerimi Görüntüle </a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 " href="settings">
											Bilgilerimi Düzenle </a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 " href="security">
											Güvenlik Kayıtları </a>
									</li>
									<li class="nav-item mt-2">
										<a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="balance">
											Bakiye Transferi </a>
									</li>

								</ul>
							</div>
						</div>
						<div class="card mb-5 mb-xl-10">
							<div class="card-header cursor-pointer">
								<div class="card-title m-0">
									<h3 class="fw-bold m-0">Bakiye Transferi</h3>
								</div>
							</div>
							<form action="balance" method="POST">
								<div class="card-body p-9">
									<div class="row mb-7">
										<div class="col-lg-12">
											<input type="text" autocomplete="off" name="username" class="form-control-solid form-control" placeholder="Alıcı hesabın kullanıcı adı nedir?">
										</div>
									</div>
									<div class="row mb-7">
										<div class="col-lg-12">
											<div class="position-relative" data-kt-dialer="true" data-kt-dialer-min="5" data-kt-dialer-max="50000" data-kt-dialer-step="10" data-kt-dialer-prefix="$" data-kt-dialer-decimals="2">
												<button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0" data-kt-dialer-control="decrease">
													<i class="ki-duotone ki-minus-square fs-2"><span class="path1"></span><span class="path2"></span></i>
												</button>
												<input type="text" name="count" class="form-control form-control-solid border-0 ps-12" data-kt-dialer-control="input" autocomplete="off" value="$5" />
												<button type="button" class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0" data-kt-dialer-control="increase">
													<i class="ki-duotone ki-plus-square fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
												</button>
											</div>
										</div>
									</div>
									<div class="row mb-7">
										<div class="col-lg-12">
											<button type="submit" class="btn btn-success btn-shadow" name="transferBalance"><i class="fa fa-check"></i> Onayla</button>
										</div>
									</div>
									<div class="alert alert-dismissible bg-light-info border border-info  d-flex flex-column flex-sm-row w-100 p-5 mb-0">
										<i class="ki-duotone ki-dollar fs-2hx text-info me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Bakiye Yükle</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Bakiye yüklemek istiyorsanız <a href="add-balance">buraya</a> tıklayın.</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-info"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>
								</div>
							</form>
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
	<script src="../assets/js/custom/account/referrals/referral-program.js"></script>
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