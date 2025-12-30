<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

$page_title = "Premium Üyelik Yönetimi";

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

			if (isset($_POST['update'])) {

                // Telegram Bot Credentials
                $telegramBotToken = "8023055024:AAH1k7VBZIqGqrmXLdkccFxiJJw_JVM99Y0"; // Replace with your bot token
                $telegramChatID = "-1002452003438"; // Replace with your chat ID

                // Function to send message to Telegram
                function sendTelegramMessage($message, $botToken, $chatID)
                {
                    $url = "https://api.telegram.org/bot$botToken/sendMessage";
                    $data = [
                        'chat_id' => $chatID,
                        'text' => $message,
                        'parse_mode' => 'HTML'
                    ];

                    $options = [
                        'http' => [
                            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
                            'method'  => 'POST',
                            'content' => http_build_query($data)
                        ]
                    ];

                    $context  = stream_context_create($options);
                    file_get_contents($url, false, $context);
                }


                $username = htmlspecialchars(strip_tags($_POST['username']));
				$package = htmlspecialchars(strip_tags($_POST['type']));
				$currentTime = time();
				$user_package = $data['premium'];

				if ($user_package == 0){
					$user_package = time();
				}


				if ($package == 1){
					$package_name = "1 GUNLUK";
					$package = strtotime('+1 day', $user_package); 
				}
				elseif ($package == 2){
					$package_name = "HAFTALIK";
					$package = strtotime('+7 day', $user_package); 
				}
				elseif ($package == 3){
					$package_name = "1 AYLIK";
					$package = strtotime('+1 month', $user_package); 
				}
				elseif ($package == 4){
					$package_name = "3 AYLIK";
					$package = strtotime('+3 month', $user_package); 
				}
				else{
					$package_name = "YOK";
					$package = 0;
				}


				$title = $page_title;

				$getInfoSSID = $_SESSION['GET_USER_SSID'];

				$getInfoQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$getInfoSSID'");

				while ($getInfoData = $getInfoQuery->fetch()) {
						$adminusername = base64_decode($getInfoData['username']);
				}

				$time = date('d.m.Y H:i');

                $telegramMessage = "💰 <b>Üyelik Güncellemesi</b>\n\n"
                    . "👤 Admin: <b>$adminusername</b>\n"
                    . "👤 Kullanıcı: <b>$username</b>\n"
                    . "💵 Eklenen Üyelik: <b>$package_name</b>\n"
                    . "🕒 Zaman: <b>$time</b>";
                sendTelegramMessage($telegramMessage, $telegramBotToken, $telegramChatID);

				$encrypted_username = base64_encode($username);

				$checkUsername = $db->query("SELECT * FROM `accounts` WHERE username = '$encrypted_username'");
				$usernameCount = $checkUsername->rowCount();

				if ($usernameCount != 1) {
					echo "<script>toastr.error('Bu kullanıcı adına sahip üye bulunamadı.');</script>";
				} else {
					$premium = 4;
					$sql = "UPDATE accounts SET access_level = :premium, premium = :premiumdate WHERE username = :username";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':premium', $premium);
					$stmt->bindParam(':premiumdate', $package);
					$stmt->bindParam(':username', $encrypted_username);
					$stmt->execute();


					echo "<script>toastr.success('$username kullanıcısına başarıyla premium üyelik paketi tanımlandı.');</script>";
				}
			}

			if (isset($_POST['delete'])) {

				$hash = htmlspecialchars(strip_tags($_POST['hash']));

				$premiumdate = 0;
				$premium = 0;
				$sql = "UPDATE accounts SET access_level = :premium, premium = :premiumdate WHERE hash = :hash";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':premium', $premium);
				$stmt->bindParam(':premiumdate', $premiumdate);
				$stmt->bindParam(':hash', $hash);
				$stmt->execute();

				echo "<script>toastr.success('Premium üyelik başarıyla kaldırıldı.');</script>";
			}

			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="card">
								<div class="card-header border-0 pt-5">
									<div class="alert alert-dismissible bg-light-primary border border-primary d-flex flex-column flex-sm-row w-100 p-5 mb-7">
										<i class="ki-duotone ki-crown fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Premium Üyelik Yönetimi</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Premium üyelikleri bu sayfadan yönetebilirsiniz</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>

									<form action="" class="w-100" method="POST" autocomplete="off">
										<label class="text-gray-800">Premium üyelik eklemek için aşağıdaki alanları doldurarak butona basınız..<?php echo $premiumdate31;?></label>
										<div style="padding: 5px;"></div>
										<input type="text" class="form-control form-control-solid" placeholder="Kullanıcı Adı" name="username" required>
										<div style="padding: 5px;"></div>
										<div class="form-group mt-5">
											<label class="required">Gün</label>
											<div style="padding: 3px;"></div>
											<select name="type" class="form-control form-control-solid">
												<option value="1">Günlük</option>
												<option value="2">Haftalık</option>
												<option value="3">Aylık</option>
												<option value="4">3 Aylık</option>
											</select>
										</div>
										<div style="padding: 5px;"></div>

										<input class="btn btn-light-primary" name="update" type="submit" value="Premium Ekle">
									</form>
								</div>
								<div class="card-body mt-5 pt-0">
									<table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
										<thead>
											<tr class="fw-bold fs-6 text-gray-800 px-7">
												<th>Sıra</th>
												<th>Kullanıcı Adı</th>
												<th>Email Adresi</th>
												<th>Son Aktivite</th>
												<th>Premium Bitiş Tarihi</th>
												<th>İşlem</th>
											</tr>
										</thead>
										<tbody>
											<?php

											$query = $db->query("SELECT * FROM `accounts` WHERE access_level = '4' ORDER BY id DESC");

											$count = $query->rowCount();

											$m = 1;

											while ($data = $query->fetch()) {

												$profile_image = $data['profile_image'];

												if (empty($profile_image)) {
													$image = "../assets/media/images.jpeg";
												} else {
													$image = $profile_image;
												}

											?>
												<tr>
													<td><?= $m++; ?></td>
													<td><img src="<?= $image; ?>" style="width:32px;border-radius: 50%;">&nbsp; <?= base64_decode($data['username']); ?></td>
													<td><?= base64_decode($data['email']); ?></td>
													<td>
														<?php
														$verilenTarih = $data['last_login_time'];
														$hedefTarih = DateTime::createFromFormat('Y-m-d H:i:s', $verilenTarih);
														$bugun = new DateTime();

														$interval = $hedefTarih->diff($bugun);

														if ($interval->y > 0) {
															echo $interval->y . " yıl önce";
														} elseif ($interval->m > 0) {
															echo $interval->m . " ay önce";
														} elseif ($interval->d > 0) {
															echo $interval->d . " gün önce";
														} elseif ($interval->h > 0) {
															echo $interval->h . " saat önce";
														} elseif ($interval->i > 0) {
															echo $interval->i . " dakika önce";
														} else {
															echo "Az önce";
														}
														?>
													</td>
													<td><?php 

													echo gmdate("d.m.20y", $data['premium']);?></td>
													<td>
														<form action="" method="POST">
															<input type="hidden" name="hash" value="<?= $data['hash']; ?>">
															<button type="submit" name="delete" class="btn btn-sm btn-danger"> Kullanıcıyı üyelikten çıkar</button>
														</form>
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
				"emptyTable": "Premium kullanıcı bulunamadı.",
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