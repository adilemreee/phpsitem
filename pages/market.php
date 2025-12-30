<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Market";

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

			if (isset($_POST['haftalik'])){
				$output = 4;

				$output_balance = $balance - 150;

				if ($balance < 150) {

					echo "<script>toastr.error('Bakiyeniz yeterli değil!');</script>";
				} else {
					$user_package = $data['premium'];
					if ($user_package == 0){
					$user_package = time();
						}
					$package_name = "7 GUNLUK";
					$package = strtotime('+7 day', $user_package); 
					$sql = "UPDATE `accounts` SET access_level = :tcvip, premium = :premium, balance = :balance WHERE hash = :hash";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':tcvip', $output);
					$stmt->bindParam(':premium', $package);
					$stmt->bindParam(':balance', $output_balance);
					$stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
					$stmt->execute();

					echo "<script>toastr.success('Tebrikler! Haftalık Premium hesabınıza eklendi.');</script>";
				}


			}


			if (isset($_POST['aylik'])){
				$output = 4;

				$output_balance = $balance - 300;

				if ($balance < 300) {

					echo "<script>toastr.error('Bakiyeniz yeterli değil!');</script>";
				} else {
					$user_package = $data['premium'];
					if ($user_package == 0){
					$user_package = time();
						}
					$user_package = $data['premium'];
					$package_name = "1 Aylık";
					$package = strtotime('+1 month', $user_package); 
					$sql = "UPDATE `accounts` SET access_level = :tcvip, premium = :premium, balance = :balance WHERE hash = :hash";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':tcvip', $output);
					$stmt->bindParam(':premium', $package);
					$stmt->bindParam(':balance', $output_balance);
					$stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
					$stmt->execute();

					echo "<script>toastr.success('Tebrikler! Aylık Premium hesabınıza eklendi.');</script>";
				}


			}

			if (isset($_POST['3aylik'])){
				$output = 4;

				$output_balance = $balance - 600;

				if ($balance < 600) {

					echo "<script>toastr.error('Bakiyeniz yeterli değil!');</script>";
				} else {
					$user_package = $data['premium'];
					if ($user_package == 0){
					$user_package = time();
						}
					
					$package_name = "3 AYLIK";
					$package = strtotime('+3 month', $user_package); 
					$sql = "UPDATE `accounts` SET access_level = :tcvip, premium = :premium, balance = :balance WHERE hash = :hash";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':tcvip', $output);
					$stmt->bindParam(':premium', $package);
					$stmt->bindParam(':balance', $output_balance);
					$stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
					$stmt->execute();

					echo "<script>toastr.success('Tebrikler! 3 Aylık Premium hesabınıza eklendi.');</script>";
				}


			}

			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="content flex-row-fluid" id="kt_content">
								<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
									<div class="col-md-4">
										<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
											<right><img src="../assets/img/logoadilemre.png" width="30"></right><br>
											<div class="mb-7 text-center">
												<h1 class="text-white mb-5 fw-bolder">Haftalık Premium</h1>
												<div class="text-gray-600 fw-semibold mb-5">
												Bir hafta eziğin premium üyesi ol, haftanın tadını çıkar!
												</div>
												<div class="text-center">
													<span class="mb-2 text-primary">TL</span>

													<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
														150 </span>
												</div>
											</div>
											<div class="w-100 mb-10">
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Tüm TR Vesika Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Güncel TC>GSM Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													İşyeri Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Üniversite Mezun Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Eğitim Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													EGM İhbar</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Plaka Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													İlaç Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Okul No Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													7/24 Canlı Destek Hizmeti</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												
											</div>
											<form action="" method="POST">
												<button name="haftalik" type="submit" class="btn btn-sm btn-primary">Satın Al</button>
											</form>
										</div>
									</div>
									<div class="col-md-4">
										<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
											<right><img src="../assets/img/logoadilemre.png" width="30"></right><br>
											<div class="mb-7 text-center">
												<h1 class="text-white mb-5 fw-bolder">Aylık Premium</h1>
												<div class="text-gray-600 fw-semibold mb-5">
												Bir ay eziğin premium üyesi ol, haftanın tadını çıkar!
												</div>
												<div class="text-center">
													<span class="mb-2 text-primary">TL</span>

													<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
														300 </span>
												</div>
											</div>
											<div class="w-100 mb-10">
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Tüm TR Vesika Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Güncel TC>GSM Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													İşyeri Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Üniversite Mezun Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Eğitim Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													EGM İhbar</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Plaka Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													İlaç Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Okul No Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													7/24 Canlı Destek Hizmeti</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
											</div>
											<form action="" method="POST">
												<button name="aylik" type="submit" class="btn btn-sm btn-primary">Satın Al</button>
											</form>
										</div>
									</div>
									<div class="col-md-4">
										<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
											<right><img src="../assets/img/logoadilemre.png" width="30"></right><br>
											<div class="mb-7 text-center">
												<h1 class="text-white mb-5 fw-bolder">3 Aylık Premium</h1>
												<div class="text-gray-600 fw-semibold mb-5">
												Üç ay eziğin premium üyesi ol, haftanın tadını çıkar!
												</div>
												<div class="text-center">
													<span class="mb-2 text-primary">TL</span>

													<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
														600 </span>
												</div>
											</div>
											<div class="w-100 mb-10">
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Tüm TR Vesika Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Güncel TC>GSM Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													İşyeri Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Üniversite Mezun Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Eğitim Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													EGM İhbar</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Plaka Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													İlaç Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Okul No Sorgu</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													7/24 Canlı Destek Hizmeti</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
											</div>
											<form action="" method="POST">
												<button name="3aylik" type="submit" class="btn btn-sm btn-primary">Satın Al</button>
											</form>
										</div>
									</div>
									<div class="col-md-4">
										<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
											<right><img src="../assets/img/hat.png" width="30"></right><br>
											<div class="mb-7 text-center">
												<h1 class="text-white mb-5 fw-bolder">Açık Hat Satışı</h1>
												<div class="text-gray-600 fw-semibold mb-5">
												Açık Hat Satışı (Paketli - Paketsiz / Paket Yükleme)
												</div>
												<div class="text-center">
													<span class="mb-2 text-primary">TL</span>

													<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
														1800</span>
												</div>
											</div>
											<div class="w-100 mb-10">
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													1 Ay Kapanmama Garantisi</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Tamamen kullanılmamış size özel açtırılmış hatlar</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													7/24 Canlı Destek Hizmeti</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
											</div>
												<a href="https://t.me/biripolisiarasin"  target="_blank" rel="nofollow"><button class="btn btn-sm btn-primary">Satın Al</button></a>
										</div>
									</div>
									<div class="col-md-4">
										<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
											<right><img src="../assets/img/facebook.png" width="30"></right><br>
											<div class="mb-7 text-center">
												<h1 class="text-white mb-5 fw-bolder">Facebook & Sahibinden Hesap</h1>
												<div class="text-gray-600 fw-semibold mb-5">
												Facebook & Sahibinden vs. Platformların hesap satışları, phishing için bire bir hesaplar.
												</div>
												<div class="text-center">
													<span class="mb-2 text-primary">TL</span>

													<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
														250 </span>
												</div>
											</div>
											<div class="w-100 mb-10">
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Marketplace Açık Hesaplar</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													7/24 Canlı Destek Hizmeti</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
											</div>
											<a href="https://t.me/biripolisiarasin"  target="_blank" rel="nofollow"><button class="btn btn-sm btn-primary">Satın Al</button></a>
										</div>
									</div>
									<div class="col-md-4">
										<div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
											<right><img src="../assets/img/sms.png" width="30"></right><br>
											<div class="mb-7 text-center">
												<h1 class="text-white mb-5 fw-bolder">+90 SMS ONAY</h1>
												<div class="text-gray-600 fw-semibold mb-5">
												+90 Türkiye Lokasyon uygulamlar, ödeme uygulamalarına uygun fiyattan sms onay
												</div>
												<div class="text-center">
													<span class="mb-2 text-primary">TL</span>

													<span class="fs-3x fw-bold text-primary" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">
														70/700</span>
												</div>
											</div>
											<div class="w-100 mb-10">
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													Ödeme Uygulamarı </span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
												<div class="d-flex align-items-center mb-5">
													<span class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
													7/24 Canlı Destek Hizmeti</span>
													<i class="ki-duotone ki-check-circle fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
												</div>
											</div>
											<a href="https://t.me/biripolisiarasin"  target="_blank" rel="nofollow"><button class="btn btn-sm btn-primary">Satın Al</button></a>
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