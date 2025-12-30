<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "İstatistikler";

$accountQuery = $db->query("SELECT * FROM `accounts`");
$accountCount = $accountQuery->rowCount();

$unconfirmedQuery = $db->query("SELECT * FROM `accounts` WHERE confirmed = 'false'");
$unconfirmedCount = $unconfirmedQuery->rowCount();

$bannedQuery = $db->query("SELECT * FROM `accounts` WHERE access_level = '-1'");
$bannedCount = $bannedQuery->rowCount();

$newsQuery = $db->query("SELECT * FROM `news`");
$newsCount = $newsQuery->rowCount();

$premiumQuery = $db->query("SELECT * FROM `accounts` WHERE access_level = '4'");
$premiumCount = $premiumQuery->rowCount();

$confirmedQuery = $db->query("SELECT * FROM `accounts` WHERE confirmed = 'true'");
$confirmedCount = $confirmedQuery->rowCount();

$accessQuery = $db->query("SELECT * FROM `accounts` WHERE access_level = '6'");
$accessCount = $accessQuery->rowCount();

$loginSessionQuery = $db->query("SELECT * FROM `login_sessions`");
$loginCount = $loginSessionQuery->rowCount();

$getLastUserQuery = $db->query("SELECT * FROM `accounts` ORDER BY id DESC LIMIT 1");

while ($getLastData = $getLastUserQuery->fetch()) {
	$lastUser = $getLastData['username'];
}

$currentTime = time();
$fiveMinutesAgo = date("Y-m-d H:i:s", $currentTime - (5 * 60)); // MySQL DATETIME formatına uygun string

$query = "SELECT * FROM `accounts` WHERE STR_TO_DATE(last_login_time, '%Y-%m-%d %H:%i:%s') >= ?"; // Yer tutucu kullanın
$stmt = $db->prepare($query);
$stmt->execute([$fiveMinutesAgo]); // Parametre olarak bağlayın
$onlineCount = $stmt->rowCount();

echo "Çevrimiçi Kullanıcı Sayısı: " . $onlineCount;

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
					<div class="d-flex flex-column flex-column-fluid">
						<div id="kt_app_content" class="app-content  flex-column-fluid ">
							<div id="kt_app_content_container" class="app-container  container-xxl ">
								<div class="row g-5 g-xl-8">
									<div class="col-xl-4">
										<div class="card card-xl-stretch mb-xl-8">
											<div class="card-body d-flex align-items-center pt-3 pb-0">
												<div class="d-flex flex-column flex-grow-1 py-2 py-lg-13 me-2">
													<a href="#" class="fw-bold text-white fs-4 mb-2 text-hover-primary">En Son Kayıt Olan Kullanıcı</a>

													<span class="fw-semibold text-muted fs-5"><?= base64_decode($lastUser); ?></span>
												</div>
												<img src="../assets/img/logoadilemre.png" width="%25" alt="" class="align-self-end h-100px">
											</div>
										</div>
									</div>

									<div class="col-xl-4">
										<a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
											<div class="card-body">
												<i class="ki-duotone ki-notification text-primary fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
												<div class="text-gray-900 fw-bold fs-2 mb-2 mt-5">
													<?= $newsCount; ?>
												</div>
												<div class="fw-semibold fw-bold text-gray-400">
													Toplam Bildirim </div>
											</div>
										</a>
									</div>


									<div class="col-xl-4">
										<a href="#" class="card bg-info hoverable card-xl-stretch mb-5 mb-xl-8">
											<div class="card-body">
												<i class="ki-duotone ki-lock text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>

												<div class="text-white fw-bold fs-2 mb-2 mt-5">
													Toplam Giriş
												</div>

												<div class="fw-semibold text-white">
													<?= $loginCount; ?> </div>
											</div>
										</a>
									</div>
								</div>

								<div class="row g-5 g-xl-8">
									<div class="col-xl-4">
										<a href="#" class="card bg-danger hoverable card-xl-stretch mb-xl-8">
											<div class="card-body">
												<i class="ki-duotone ki-crown-2 text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>

												<div class="text-white fw-bold fs-2 mb-2 mt-5">
													Yetkili Kullanıcılar
												</div>
												<div class="fw-semibold text-white">
													<?= $accessCount; ?> </div>
											</div>
										</a>
									</div>

									<div class="col-xl-4">
										<a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
											<div class="card-body">
												<i class="ki-duotone ki-user-tick text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></i>
												<div class="text-white fw-bold fs-2 mb-2 mt-5">
													Onaylanmış Hesaplar
												</div>
												<div class="fw-semibold text-white">
													<?= $confirmedCount; ?> </div>
											</div>
										</a>
									</div>

									<div class="col-xl-4">
										<a href="#" class="card bg-success hoverable card-xl-stretch mb-5 mb-xl-8">
											<div class="card-body">
												<i class="ki-duotone ki-crown text-white fs-2x ms-n1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>

												<div class="text-white fw-bold fs-2 mb-2 mt-5">
													Premium Kullanıcılar
												</div>

												<div class="fw-semibold text-white">
													<?= $premiumCount; ?> </div>
											</div>
										</a>
									</div>
								</div>

								<div class="row g-5 g-xl-8">
									<div class="col-xl-3">
										<div class="card bg-light-success card-xl-stretch mb-xl-8">
											<div class="card-body my-3">
												<a href="#" class="card-title fw-bold text-success fs-5 mb-3 d-block">
													Kayıtlı Kullanıcılar </a>

												<div class="py-1">
													<span class="text-white fs-3 fw-bold me-2"><?= $accountCount; ?> Kişi</span>
												</div>

												<div class="progress h-7px bg-success bg-opacity-50 mt-7">
													<div class="progress-bar bg-success" role="progressbar" style="width: 87%" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-xl-3">
										<div class="card bg-light-primary card-xl-stretch mb-xl-8">
											<div class="card-body my-3">
												<a href="#" class="card-title fw-bold text-primary fs-5 mb-3 d-block">
													Çevrimiçi Kullanıcılar </a>

												<div class="py-1">
													<span class="text-white fs-3 fw-bold me-2"><?= $onlineCount; ?> Kişi</span>
												</div>

												<div class="progress h-7px bg-primary bg-opacity-50 mt-7">
													<div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-xl-3">
										<div class="card bg-light-warning card-xl-stretch mb-5 mb-xl-8">
											<div class="card-body my-3">
												<a href="#" class="card-title fw-bold text-warning fs-5 mb-3 d-block">
													Onay Bekleyen Kullanıcılar </a>

												<div class="py-1">
													<span class="text-white fs-3 fw-bold me-2"><?= $unconfirmedCount; ?> Kişi</span>
												</div>

												<div class="progress h-7px bg-warning bg-opacity-50 mt-7">
													<div class="progress-bar bg-warning" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-xl-3">
										<div class="card bg-light-danger card-xl-stretch mb-5 mb-xl-8">
											<div class="card-body my-3">
												<a href="#" class="card-title fw-bold text-danger fs-5 mb-3 d-block">
													Banlı Kullanıcılar </a>

												<div class="py-1">
													<span class="text-white fs-3 fw-bold me-2"><?= $bannedCount; ?> Kişi</span>
												</div>

												<div class="progress h-7px bg-danger bg-opacity-50 mt-7">
													<div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
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
		</div>

		<?php include 'inc/footer_main.php'; ?>

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