<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Bakiye Yükle";

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
	<style>
		figure {
			border: 1px solid #262635;
			border-radius: 12px;
		}

		.img2-fluid {
			border-radius: 12px;
			width: 100%;
			height: 30em;
			padding: 30px;
		}

		#card:hover {
			cursor: pointer;
			opacity: 0.8;
			transition: 2s;
			transform: rotate(360deg);
		}

		.button {
			border: 1px solid #262635;
			border-radius: 4px;
			padding: 15px;
		}

		:root {
			--card-height: 2.125in;
			--card-width: 3.375in;
			--card-radius: 0.125in;
			--card-thickness: 0in;
		}

		.card {
			margin-top: 2vh;
			margin-left: 1vh;
			border: 1px solid transparent;
			padding: 1rem;
			height: 100%;
			width: auto;
			width: var(--card-width);
			height: var(--card-height);
			border-radius: var(--card-radius);
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
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
								<div class="alert alert-primary d-flex align-items-center p-5">
    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
    <div class="d-flex flex-column">
        <h4 class="mb-1 text-gray-900">Nasıl bakiye yatırabilirim?</h4>
        <span>Aşağıda bulunan ödeme yöntemlerinden birini seçip yöntemlerin altında bulunan bilgilere para transferini yaparak seçtiğiniz ödeme yönteminin altında bulunan yatırdım butonuna tıklayarak bakiyenizi yükleyebilirsiniz.</span>
    </div>
</div>
								<div class="col-xl-12 col-md-12">
									<div class="col-lg-12">
										<div class="card-body">
											<div class="block-content tab-content">
												<br>
												<div class="row gallery">
													<div class="col-lg-4 col-md-6 col-xs-8 thumb">
														<figure>
															<img id="card" class="img2-fluid" src="https://www.ininal.com/assets/images/card1.png">
															<center><div class="text-gray-900 fw-semibold mb-7">
												İninal
												</div></center>
												<center><div class="text-danger fw-semibold mb-5">
												Şuan için İninal ödeme yöntemi bulunmuyor.
												</div></center>
														</figure>

														<div class="button">
															<button id="ininal" name="ininal" type="submit" class="btn btn-primary form-control">Yatırdım!</button>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-xs-8 thumb">
														<figure><img id="card" class="img2-fluid" src="https://cdn.papara.com/web/cards/Black.png">
																														<center><div class="text-gray-900 fw-semibold mb-7">
												Papara
												</div></center>
												<center><div class="text-danger fw-semibold mb-5">
												Şuan için Papara ödeme yöntemi bulunmuyor.
												</div></center></figure></figure>

														<div class="button">
															<button id="papara" name="papara" type="submit" class="btn btn-primary form-control">Yatırdım!</button>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-xs-8 thumb">
														<figure><img id="card" class="img2-fluid" src="https://download.logo.wine/logo/Binance/Binance-Logo.wine.png">												<center><div class="text-gray-900 fw-semibold mb-5">
												AĞ
												</div></center>
												<center><div class="text-danger fw-semibold mb-5">
												TRON(TRC20)
												</div></center>
												<center><div class="text-gray-900 fw-semibold mb-5">
												Adres
												</div></center>
												<center><div class="text-danger fw-semibold mb-5">
												TTPeFM4XTgFAzpv5qQjzMbtJYuqgTVjLqb
												</div></center></figure>
														<div class="button">
															<form method="post" id="binance" name="binance">
																<div class="form-group mt-5">
																<label class="required">Yatırdığınız TRX Miktarı</label>
																<div style="padding: 3px;"></div>
																<input type="text" autocomplete="off" minlength="1" maxlength="5" name="trx" placeholder="TRX" class="form-control form-control-solid">
																</div>
																<br>
															<button id="binance" name="binance" type="submit" class="btn btn-primary form-control">Yatırdım!</button> </form>
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
				<?php 
				$post_user_hash = $_SESSION['GET_USER_SSID'];
				$checkComment = $db->query("SELECT * FROM `odemeler` WHERE user_hash = '$post_user_hash' ");
				$commentCount = $checkComment->rowCount();

				if (isset($_POST['binance'])) {
					$trx = htmlspecialchars(strip_tags($_POST['trx']));

					if (empty($trx)) {
						echo "<script>toastr.error('Lütfen yatırdığınız TRX miktarını giriniz.');</script>";
        				exit();
    				}
    				if ($commentCount >= 1) {
					echo "<script>setTimeout(() => toastr.error('Aktif ödeme talebiniz bulunuyor, lütfen diğer talebinizin sonuçlanmasını bekleyin.'), 500)</script>";
					exit();
					}

				$encrypted_username = base64_encode($username);

				$checkUsername = $db->query("SELECT * FROM `odemeler` WHERE username = '$encrypted_username'");
				$usernameCount = $checkUsername->rowCount();

				$post_trx = htmlspecialchars(strip_tags($_POST['trx']));
				$post_tl = htmlspecialchars(strip_tags($_POST['TL']));

				if ($usernameCount == $encrypted_username) {
					echo "<script>toastr.error('Bu kullanıcı adına sahip üye bulunamadı.');</script>";
				} else {
					$yontem = "Binance";
					$DateTimeNow = date('Y-m-d H:i:s');
					$sql = "INSERT INTO odemeler (username, miktar, yontem, tarih, user_hash) VALUES (:username, :miktar, :yontem, :tarih, :user_hash)";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':username', $username);
					$stmt->bindParam(':miktar', $post_trx);
					$stmt->bindParam(':yontem', $yontem);
					$stmt->bindParam(':tarih', $DateTimeNow);
					$stmt->bindParam(':user_hash', $_SESSION['GET_USER_SSID']);
					$stmt->execute();


					echo "<script>toastr.success('Başarıyla crypto ödeme talebiniz yollandı.');</script>";
				}
			}
				if (isset($_POST['papara'])) {
					$turklira = htmlspecialchars(strip_tags($_POST['TL']));
					if (strlen($message) >= 5) {
						echo "<script>toastr.error('Yatırdığınız TL miktarı 5 karakteri geçemez!');</script>";
        				exit();
    				}

					if (empty($turklira)) {
						echo "<script>toastr.error('Lütfen yatırdığınız TL miktarını giriniz.');</script>";
        				exit();
    				}
    				if ($commentCount >= 1) {
					echo "<script>setTimeout(() => toastr.error('Aktif ödeme talebiniz bulunuyor, lütfen diğer talebinizin sonuçlanmasını bekleyin.'), 500)</script>";
					exit();
					}

				$encrypted_username = base64_encode($username);

				$checkUsername = $db->query("SELECT * FROM `accounts` WHERE username = '$encrypted_username'");
				$usernameCount = $checkUsername->rowCount();

				if ($usernameCount != 1) {
					echo "<script>toastr.error('Bu kullanıcı adına sahip üye bulunamadı.');</script>";
				} else {
					$yontem = "Papara";
					$DateTimeNow = date('Y-m-d H:i:s');
					$sql = "INSERT INTO odemeler (username, miktar, yontem, tarih, user_hash) VALUES (:username, :miktar, :yontem, :tarih, :user_hash)";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':username', $username);
					$stmt->bindParam(':miktar', $turklira);
					$stmt->bindParam(':yontem', $yontem);
					$stmt->bindParam(':tarih', $DateTimeNow);
					$stmt->bindParam(':user_hash', $_SESSION['GET_USER_SSID']);
					$stmt->execute();



					echo "<script>toastr.success('Başarıyla papara ödeme talebiniz yollandı.');</script>";
				}
			}

			 ?>
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