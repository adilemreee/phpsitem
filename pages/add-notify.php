<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

$page_title = "Bildirim Ekle";

$get = urldecode(base64_decode($_GET['hex']));

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

			if (isset($_POST['add'])) {
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

				$post_title = htmlspecialchars(strip_tags($_POST['title']));
				$post_content = htmlspecialchars(strip_tags($_POST['content']));
				$post_type = htmlspecialchars(strip_tags($_POST['type']));
				$post_history = date('d.m.Y H:i');
				$post_hash = strtoupper(bin2hex(random_bytes(32)));
				$post_view = 0;

				if ($post_title == "" || $post_content == "" || $post_type == "") {

					echo "<script>toastr.error('Boş alan olamaz');</script>";
				} else {

					$recordsql = "INSERT INTO records (message, icon, user_hash, hour) VALUES (:message, :icon, :user_hash, :hour)";
					$record = $db->prepare($recordsql);

					$record->bindValue(':message', $username . " " . $post_title . " başlıklı duyuru paylaştı.");
					$record->bindValue(':icon', "fa fa-bullhorn");
					$record->bindValue(':user_hash', $_SESSION['GET_USER_SSID']);
					$record->bindValue(':hour', date('H:i'));
					$record->execute();

					$sql = "INSERT INTO `news` (title, content, type, view, history, hash, user_hash) VALUES (:title, :content, :type, :view, :history, :hash, :user_hash)";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':title', $post_title);
					$stmt->bindParam(':content', $post_content);
					$stmt->bindParam(':type', $post_type);
					$stmt->bindParam(':view', $post_view);
					$stmt->bindParam(':history', $post_history);
					$stmt->bindParam(':hash', $post_hash);
					$stmt->bindParam(':user_hash', $_SESSION['GET_USER_SSID']);
					$stmt->execute();

					echo "<script>toastr.success('Bildirim başarıyla eklendi.');</script>";

                    $telegramMessage = "🕵️‍♂️ <b>Yeni Bildirim</b> 🕵️‍♂️
                                                                                            👤 <b>Ekleyen Kullanıcı:</b> <code>$username</code>
                                                                                            📄 <b>Mesaj Başlığı:</b> <code>$post_title</code>
                                                                                            📄 <b>Eklenen Mesaj:</b> <code>" . utf8_encode($post_content) . "</code>
                                                                                            📄 <b>Türü:</b> <code>$post_type</code>
                                                                                            🕒 <b>Tarih:</b> " . date('d.m.Y H:i') . "";


                    sendTelegramMessage($telegramMessage, $telegramBotToken, $telegramChatID);


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
										<i class="ki-duotone ki-notification-on fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Bildirim Ekle</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Bildirimleri bu sayfadan ekleyebilirsiniz.</span>
										</div>
										<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
											<i class="ki-duotone ki-cross fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i> </button>
									</div>
								</div>
								<div class="card-body mt-5 pt-0">
									<?php
									$query = $db->query("SELECT * FROM `news` WHERE hash = '$get'");
									$data = $query->fetch(PDO::FETCH_ASSOC);

									$count = $query->rowCount();

									if ($data) {
										$id = $data['id'];
										$title = $data['title'];
										$content = $data['content'];
										$view = $data['view'];
										$history = $data['history'];
										$type = $data['type'];
									}
									?>

									<form action="" method="POST" autocomplete="off">
										<div class="form-group mt-5">
											<label class="required">Başlık</label>
											<div style="padding: 3px;"></div>
											<input type="text" name="title" placeholder="Başlık" class="form-control form-control-solid" value="<?= $title; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">İçerik</label>
											<div style="padding: 3px;"></div>
											<textarea id="textarea" type="text" name="content" class="form-control form-control-solid"><?= $content; ?></textarea>
										</div>

										<div class="form-group mt-5">
											<label class="required">Tür</label>
											<div style="padding: 3px;"></div>
											<select name="type" class="form-control form-control-solid">
												<option value="event">Etkinlik</option>
												<option value="update">Bakım Notu</option>
												<option value="news">Duyuru</option>
											</select>
										</div>
										<br>

										<button type="submit" name="add" class="btn btn-light-primary">Bildirim Ekle</button>
										<button type="reset" class="btn btn-light btn-active-light-primary">İptal</button>
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

    <script src="https://cdn.tiny.cloud/1/m96ih40krl6u7sjfth16rd68ud9kskkqwqkkr9b3dg36wrim/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>	<script>
		tinymce.init({
			selector: '#textarea',

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