<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$accountQuery = $db->query("SELECT * FROM `accounts`");
$accountCount = $accountQuery->rowCount();

$unconfirmedQuery = $db->query("SELECT * FROM `accounts` WHERE access_level = '4'");
$unconfirmedCount = $unconfirmedQuery->rowCount();

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
$onlineUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
$onlineCount = count($onlineUsers);



$page_title = "Kullanıcı Paneli";


?>
<!DOCTYPE html>

<html lang="tr">

<head>
	<?php include 'inc/header_main.php'; ?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<style id="Alert">

		.picture1 img {
			width: 49%;
		}

		.images {
			display: flex;
		}

		.picture1 img:hover{
			filter: grayscale(.4);
		}

		span.login-text {
    		font-size: 22px;
    		display:table;
    		margin-left: auto;
    		margin-right: auto;
		}
	</style>
	<style type="text/css">
		
.kayanyazi {
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
}
 
.kayanyazi span {
    display: inline-block;
    padding-left: 100%;
    text-indent: 0;
    animation: marquee 15s linear infinite;
}

.kayanyazi span2 {
    display: inline-block;
    padding-left: 100%;
    text-indent: 0;
    animation: marquee 100s linear infinite;
}
 
@keyframes marquee {
    0%   { transform: translate(0, 0); }
    100% { transform: translate(-100%, 0); }
}

.neon {
            color: #fff;
            text-align: center;
            position: relative;
            font-family: sans-serif;
            font-size: 15px;
            top: 200;
            text-shadow:
            0 0 5px #fff, 
            0 0 10px #fff,
            0 0 15px #0073e6;
        }

	</style>
<style>

.glow {
  font-size: 15px;
  color: #fff;
  text-align: center;
}

@-webkit-keyframes glow {
  from {
    text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073, 0 0 70px #e60073;
  }
  
  to {
    text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6, 0 0 80px #ff4da6;
  }
}


</style>
</head>


<body id="kt_body" class="aside-enabled">
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<?php include 'inc/header_sidebar.php'; ?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">

						<div id="kt_content_container" class=" container-xxl ">
							<div class="row mb-2">
								<div class="col-xl-12">
									<div class="col-xl-12">
									<div class="alert alert-dismissible bg-light-success  d-flex flex-column flex-sm-row w-100 p-5">
										<marquee direction="right">📢 ADİL EMRE KARAYÜREK SUNAR <a href="https://t.me/Adil_Emre" target="_blank" rel="nofollow"><span style="text-shadow: #ff0000 0px 0px 10px;"><font color="red"><b>@adilemre</b></font></a></marquee>
									</div>
								</div>
								</div>
							</div>
							<div class="row g-5 g-xl-8">
									<div class="picture1">

									</div>
								<div class="col-xl-3">
									<div class="card bg-light-success card-xl-stretch mb-xl-8">
										<div class="card-body my-3">
											<a href="#" class="card-title fw-bold text-success fs-5 mb-3 d-block">
												Kayıtlı Kullanıcılar </a>

											<div class="py-1">
												<span class="text-gray-900 fs-3 fw-bold me-2" style="background-image: url(https://media.giphy.com/media/eYRGWfchREFUUlXT7P/giphy.gif); font-size:17px;"><?= $accountCount; ?> Kişi</span>
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
												<span class="text-gray-900 fs-3 fw-bold me-2" style="background-image: url(https://media.giphy.com/media/eYRGWfchREFUUlXT7P/giphy.gif); font-size:17px;"><?= $onlineCount; ?> Kişi</span>
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
												Premium Kullanıcılar </a>

											<div class="py-1">
												<span class="text-gray-900 fs-3 fw-bold me-2" style="background-image: url(https://media.giphy.com/media/eYRGWfchREFUUlXT7P/giphy.gif); font-size:17px;"><?= $unconfirmedCount; ?> Kişi</span>
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
												Toplam Sorgu </a>

											<div class="py-1">
												<span class="text-gray-900 fs-3 fw-bold me-2" style="background-image: url(https://media.giphy.com/media/eYRGWfchREFUUlXT7P/giphy.gif); font-size:17px;">
												 <?= $total_query; ?> Sorgu</span>
											</div>

											<div class="progress h-7px bg-danger bg-opacity-50 mt-7">
												<div class="progress-bar bg-danger" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row g-5 g-xl-8 mb-8">
								
	
								</div>								<div class="col-xl-5">
	

							</div>






							<div class="row g-xl-8">
								<div class="col-xl-12">
									
									<div class="card card-xl-stretch mb-xl-8">
										<div class="card-header align-items-center border-1 mt-2">
											<h3 class="card-title align-items-start flex-column">
												<span class="fw-bold text-gray-800"><img style="width: 28px;height: auto; border-radius: 15px; " src="/assets/img/icons/ispiyoncu.png" alt=""> &nbsp;<?= $site_name; ?> Sitesinin Giriş Kayıtları</span>
											</h3>
										</div>
										<div class="card-body pt-3">
											<div class="align-items-sm-center mb-3">
												<table id="01000001" class="table table-striped table-row-bordered gy-3 mt-3 gs-7 border rounded" style="width:100%;">
													<tbody id="00001010">
														<?php

														$recordQuery = $db->query("SELECT * FROM `records` ORDER BY id DESC LIMIT 5");

														while ($recordData = $recordQuery->fetch()) {

															$recordHash = $recordData['user_hash'];

															$recordUserQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$recordHash'");

															while ($recordUserData = $recordUserQuery->fetch()) {
																$recordProfileImage = $recordUserData['profile_image'];
															}

															if (!empty($recordProfileImage)) {
																$outputImage = $recordProfileImage;
															} else {
																$outputImage = "assets/media/svg/avatars/blank.jpg";
															}


															if ($access_level == 6) {
																$color = "red";
																$glow = '"<span style="text-shadow: #ff0000 0px 0px 10px;">';
															} elseif ($access_level == 5) {
																$color = "yellow";
																$glow = '"<span style="text-shadow: #00CCFF 0px 0px 12px;">';
															}
															elseif ($premium >= time()) {
																$color = "#28B3F2";
																$glow = '<span style="text-shadow: #00CCFF 0px 0px 12px;">';
															}
															else {
																$color = "";
																$glow = '';
															}

															if ($onlinedata['hide_username'] == "true") {
																$display_username = $get_secret_username;
															} else {
																$display_username = $get_username;
															}

														?>
															<tr>
																<td>
																	<div style="display: flex;">
																		<img style="border-radius: 50%;box-shadow: 0 1px 3px 0 rgb(54 74 99 / 5%);object-fit: cover;" src="<?= $outputImage; ?>" width="32" height="32">
																		<div style="padding: 8px;">
																			&nbsp;<i class="fa-solid fa <?= $recordData['icon']; ?>"></i>&nbsp;
																			<span><?= $recordData['message'] ?></span> <time><?= $recordData['hour']; ?></time>
																		</div>
																	</div>
																</td>
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

							<div class="online-list">
								<div style="padding: 8px;">
								<div class="user-list">
									Çevrimiçi Kullanıcılar :
									<?php
									$counter = 0;
									$total_count = $onlineCount;

									if ($total_count === 0) {
										echo '<span class="text-muted">Şu anda çevrimiçi kullanıcı bulunmuyor.</span>';
									} else {
										foreach ($onlineUsers as $onlinedata) {
											$counter++;
										$get_username = base64_decode($onlinedata['username']);
										$get_secret_username = "İsim Gizlendi";

										if ($onlinedata['access_level'] == 6) {
											$color = "red";
											$glow = '<span style="text-shadow: #ff0000 0px 0px 10px;">';
										} elseif ($onlinedata['access_level'] == 5) {
											$color = "yellow";
											$glow = '<span style="text-shadow: #00CCFF 0px 0px 12px;">';
										}
										elseif ($onlinedata['premium'] >= time()) {
											$color = "#28B3F2";
											$glow = '<span style="text-shadow: #00CCFF 0px 0px 12px;">';
										}
										else {
											$color = "#8B8A8A";
											$glow = '';
										}

										if ($onlinedata['hide_username'] == "true") {
											$display_username = $get_secret_username;
										} else {
											$display_username = $get_username;
										}

										// Son kişi ise virgül yerine bir şey ekleme
										if ($counter === $total_count) {
											echo '<a href="#" style="color: ' . $color . ';">' . $display_username . '</a>';
										} else {
											echo '<a href="#" style="color: ' . $color . ';">'. $glow . '' . $display_username . '</a>, ';
										}
									}
									}
									?>

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

	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/utilities/modals/users-search.js"></script>

</body>


</html>
