<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

include '../server/webhook.php';

$page_title = "Kullanıcı Düzenle";

$get = urldecode(base64_decode($_GET['token']));

?>
<!DOCTYPE html>

<html lang="tr">


<head>
	<?php include 'inc/header_main.php'; ?>
	<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
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

			if (isset($_POST['update'])) {

				// Formdan gelen verileri alın
				$username = base64_encode(htmlspecialchars(strip_tags($_POST['username'])));
				$email = base64_encode(htmlspecialchars(strip_tags($_POST['email'])));
				$access_level = htmlspecialchars(strip_tags($_POST['access_level']));
				$secret_question = htmlspecialchars(strip_tags($_POST['secret_question']));
				$secret_answer = htmlspecialchars(strip_tags($_POST['secret_answer']));
				$hide_username = htmlspecialchars(strip_tags($_POST['hide_username']));
				$balance = intval($_POST['balance']); // Bakiye için tam sayı olarak alındı
				$exp = intval($_POST['exp']); // Deneyim puanı için tam sayı olarak alındı
				$success_login_count = intval($_POST['success_login_count']);
				$failed_login_count = intval($_POST['failed_login_count']);
				$suspect_login_count = intval($_POST['suspect_login_count']);
				$expiration_date = htmlspecialchars(strip_tags($_POST['expiration_date']));

				// Gerekli kontrol işlemleri
				if (empty($username) || empty($email) || empty($access_level) || empty($secret_question) || empty($secret_answer) || empty($hide_username)) {
					echo "<script>toastr.error('Boş alan olamaz.');setTimeout(() => window.location.reload(), 800;</script>";
				} else {
					// Veritabanında güncelleme işlemi
					$updateQuery = $db->prepare("UPDATE accounts SET 
						username = :username,
						email = :email,
						access_level = :access_level,
						secret_question = :secret_question,
						secret_answer = :secret_answer,
						hide_username = :hide_username,
						balance = :balance,
						exp = :exp,
						success_login_count = :success_login_count,
						failed_login_count = :failed_login_count,
						suspect_login_count = :suspect_login_count,
						expiration_date = :expiration_date
						WHERE hash = :user_hash");

					$updateQuery->bindParam(':username', $username);
					$updateQuery->bindParam(':email', $email);
					$updateQuery->bindParam(':access_level', $access_level);
					$updateQuery->bindParam(':secret_question', $secret_question);
					$updateQuery->bindParam(':secret_answer', $secret_answer);
					$updateQuery->bindParam(':hide_username', $hide_username);
					$updateQuery->bindParam(':balance', $balance);
					$updateQuery->bindParam(':exp', $exp);
					$updateQuery->bindParam(':success_login_count', $success_login_count);
					$updateQuery->bindParam(':failed_login_count', $failed_login_count);
					$updateQuery->bindParam(':suspect_login_count', $suspect_login_count);
					$updateQuery->bindParam(':expiration_date', $expiration_date);
					$updateQuery->bindParam(':user_hash', $get);

					$session = $_SESSION['GET_USER_SSID'];

					$query = $db->query("SELECT * FROM `accounts` WHERE hash = '$session'");

					while ($data = $query->fetch()) {
						$n = base64_decode($data['username']);
						$em = base64_decode($data['email']);
						$h = $data['hash'];
					}

					$q = $db->query("SELECT * FROM `accounts` WHERE hash = '$get'");

					while ($d = $q->fetch()) {
						$newB = $d['balance'];
					}

					$newblnc = $newB == 0 ? $balance : $balance - $newB;


                    // Telegram mesajı oluştur
                    $message = "📢 <b>Kullanıcı Bilgileri Güncellendi</b>\n\n";
                    $message .= "👤 <b>Yetkili Bilgileri:</b>\n";
                    $message .= "👤 <b>Güncellenen Kullanıcı:</b>\n";
                    $message .= "🔹 <b>Kullanıcı Adı:</b> " . base64_decode($username) . "\n";
                    $message .= "📧 <b>E-posta:</b> " . base64_decode($email) . "\n";
                    $message .= "⏳ <b>Üyelik Bitiş:</b> $expiration_date\n";
                    $message .= "🔑 <b>Yetki Seviyesi:</b> $access_level\n";
                    $message .= "❓ <b>Gizli Soru:</b> $secret_question\n";
                    $message .= "🔑 <b>Gizli Cevap:</b> $secret_answer\n";
                    $message .= "🙈 <b>Kullanıcı İsmi Gizli mi?:</b> $hide_username\n";
                    $message .= "💰 <b>Yeni Bakiye:</b> $balance\n";
                    $message .= "🏆 <b>Yeni Deneyim Puanı:</b> $exp\n";
                    $message .= "❌ <b>Başarısız Giriş:</b> $failed_login_count\n";
                    $message .= "✅ <b>Başarılı Giriş:</b> $success_login_count\n";
                    $message .= "⚠️ <b>Şüpheli Giriş:</b> $suspect_login_count\n";
                    $message .= "🔄 <b>Eklenen/Azaltılan Bakiye:</b> $newblnc\n";



                    // Telegram mesajını gönder
                    sendTelegramMessage($message, $telegramBotToken, $telegramChatID);
					if ($updateQuery->execute()) {
						echo "<script>toastr.success('Başarıyla güncellendi.');</script>";
					} else {
						echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
					}
				}
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
										<i class="ki-duotone ki-user fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Kullanıcı Düzenle</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Kullanıcıları bu sayfadan düzenleyebilirsiniz.</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>
								</div>
								<div class="card-body mt-5 pt-0">
									<?php
									$query = $db->query("SELECT * FROM `accounts` WHERE hash = '$get'");
									$data = $query->fetch(PDO::FETCH_ASSOC);

									$count = $query->rowCount();

									if ($data) {
										$username = base64_decode($data['username']);
										$email = base64_decode($data['email']);
										$success_login_count = $data['success_login_count'];
										$failed_login_count = $data['failed_login_count'];
										$suspect_login_count = $data['suspect_login_count'];
										$balance = $data['balance'];
										$exp = $data['exp'];
										$secret_question = $data['secret_question'];
										$secret_answer = $data['secret_answer'];
										$access_level = $data['access_level'];
										$hide_username = $data['hide_username'];
										$expiration_date = $data['expiration_date'];
									}
									?>

									<form action="" method="POST" autocomplete="off">
										<div class="form-group mt-5">
											<label class="required">Kullanıcı Adı</label>
											<div style="padding: 3px;"></div>
											<input type="text" name="username" class="form-control form-control-solid" value="<?= $username; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Email Adresi</label>
											<div style="padding: 3px;"></div>
											<input type="email" name="email" class="form-control form-control-solid" value="<?= $email; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Hesap Süresi</label>
											<div style="padding: 3px;"></div>
											<input type="date" name="expiration_date" class="form-control form-control-solid" value="<?= $expiration_date; ?>">
										</div>


										<div class="form-group mt-5">
											<label class="required">Yetki</label>
											<div style="padding: 3px;"></div>
											<select name="access_level" class="form-control form-control-solid">
												<?php
												if ($access_level == 6) {
													echo '<option value="6" selected>Admin</option>';
													echo '<option value="5">Premium Üye</option>';
													echo '<option value="4">VIP Üye</option>';
													echo '<option value="1">Normal Üye</option>';
												} else {
													echo '<option value="6">Admin</option>';
													echo '<option value="5">Premium Üye</option>';
													echo '<option value="4">VIP Üye</option>';
													echo '<option value="1" selected>Normal Üye</option>';
												}
												?>
											</select>

										</div>

										<div class="form-group mt-5">
											<label class="required">Gizli Soru</label>
											<div style="padding: 3px;"></div>
											<select name="secret_question" class="form-control form-control-solid">
												<?php
												$selectedQuestion = $secret_question;
												$questions = array(
													"En sevdiğin hacker filmi hangisidir?",
													"En çok beğendiğin programlama dili hangisidir?",
													"En çok beğendiğin siber güvenlik aracı nedir?",
													"Annenizin kızlık soyadı nedir?",
													"Gittiğiniz ilk okulun ismi nedir?",
													"İlk evcil hayvanınızın ismi nedir?"

												);

												foreach ($questions as $question) {
													if ($selectedQuestion == $question) {
														echo '<option value="' . htmlspecialchars($question) . '" selected>' . htmlspecialchars($question) . '</option>';
													} else {
														echo '<option value="' . htmlspecialchars($question) . '">' . htmlspecialchars($question) . '</option>';
													}
												}
												?>
											</select>

										</div>

										<div class="form-group mt-5">
											<label class="required">Gizli Soru Cevabı</label>
											<div style="padding: 3px;"></div>
											<input type="text" name="secret_answer" class="form-control form-control-solid" value="<?= $secret_answer; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">İsim Gizle</label>
											<div style="padding: 3px;"></div>
											<select name="hide_username" class="form-control form-control-solid">
												<?php
												if ($hide_username == "true") {
													echo '<option value="true" selected>Anonim kalmak için takma adımı gizli tutuyorum.</option>';
													echo '<option value="false">Takma adımı gizlemeye ihtiyaç duymuyorum.</option>';
												} else {
													echo '<option value="true">Anonim kalmak için takma adımı gizli tutuyorum.</option>';
													echo '<option value="false" selected>Takma adımı gizlemeye ihtiyaç duymuyorum.</option>';
												}
												?>
											</select>
										</div>

										<div class="form-group mt-5">
											<label class="required">Bakiye</label>
											<div style="padding: 3px;"></div>
											<input type="number" name="balance" class="form-control form-control-solid" value="<?= $balance; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Deneyim Puanı</label>
											<div style="padding: 3px;"></div>
											<input type="number" name="exp" class="form-control form-control-solid" value="<?= $exp; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Başarılı Giriş</label>
											<div style="padding: 3px;"></div>
											<input type="number" name="success_login_count" class="form-control form-control-solid" value="<?= $success_login_count; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Başarısız Giriş</label>
											<div style="padding: 3px;"></div>
											<input type="number" name="failed_login_count" class="form-control form-control-solid" value="<?= $failed_login_count; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Onaysız Giriş Denemesi</label>
											<div style="padding: 3px;"></div>
											<input type="number" name="suspect_login_count" class="form-control form-control-solid" value="<?= $suspect_login_count; ?>">
										</div>

										<br>

										<button type="submit" name="update" class="btn btn-light-primary">Güncelle</button>
										<button type="reset" data-kt-ecommerce-settings-type="cancel" class="btn btn-light ">
											Sıfırla
										</button>
									</form>
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