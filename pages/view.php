<?php

include '../server/database.php';
include '../server/rolecontrol.php';

$get = htmlspecialchars(strip_tags($_GET['hex']));

$checkThisNotify = $db->query("SELECT * FROM `news` WHERE hash = '$get'");
$notifyCount = $checkThisNotify->rowCount();

if (empty($notifyCount) || $notifyCount != 1) {
	header('Location: home');
	exit;
}

while ($notifyData = $checkThisNotify->fetch()) {
	$title = $notifyData['title'];
	$content = $notifyData['content'];
	$history = $notifyData['history'];
	$user_hash = $notifyData['user_hash'];
	$view = $notifyData['view'];
	$type = $notifyData['type'];
}

$updater = $db->exec("UPDATE news SET view = $view + 1 WHERE hash = '$get'");

if ($type == "event") {
	$result = "Etkinlik";
} else if ($type == "news") {
	$result = "Duyuru";
} else {
	$result = "Bakım Notu";
}

$checkUser = $db->query("SELECT * FROM `accounts` WHERE hash = '$user_hash'");

while ($checkData = $checkUser->fetch()) {
	$image = $checkData['profile_image'];
	$get_username = $checkData['username'];
}

if (empty($image)) {
	$get_image = "assets/media/svg/avatars/blank.jpg";
} else {
	$get_image = $image;
}

$page_title = $title;

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

			if (isset($_POST['commentSend'])) {

				$comment = htmlspecialchars(strip_tags($_POST['comment']));

				$post_user_hash = $_SESSION['GET_USER_SSID'];
				$post_date_text = date('Y-m-d H:i:s');
				$post_preview = $comment;
				$post_hash = htmlspecialchars(strip_tags($_GET['hex']));

				$badwords = array("sg", "oç", "oçe", "anan", "sokuk", "kaltak", "ananı", "ananı sikim", "anneni sikim", "anneni sikeyim", "ananı sikeyim", "annen", "ağzına", "ağzına sıçim", "ağzına sıçayım", "ağzına s", "am", "ambiti", "amını", "amını s", "amcık", "amcik", "amcığını", "amciğini", "amcığını", "amcığını s", "amck", "amckskm", "amcuk", "amına", "amına k", "amınakoyim", "amına s", "amunu", "amını", "amın oğlu", "amın o", "amınoğlu", "amk", "aq", "amnskm", "anaskm", "ananskm", "amkafa", "amk çocuğu", "amk oç", "piç", "amk ç", "amlar", "amcıklar", "amq", "amındaki", "amnskm", "ananı", "anan", "ananın am", "ananızın", "aneni", "aneni s", "annen", "anen", "ananın dölü", "sperm", "döl", "anasının am", "anası orospu", "orospu", "orosp,", "kahpe", "kahbe", "kahße", "ayklarmalrmsikerim", "ananı avradını", "avrat", "avradını", "avradını s", "babanı", "babanı s", "babanın amk", "annenin amk", "ananın amk", "bacı", "bacını s", "babası pezevenk", "pezevenk", "pezeveng", "kaşar", "a.q", "a.q.", "bitch", "çük", "yarrak", "am", "cibiliyetini", "bokbok", "bombok", "dallama", "göt", "götünü s", "ebenin", "ebeni", "ecdadını", "gavat", "gavad", "ebeni", "ebe", "fahişe", "sürtük", "fuck", "gotten", "götten", "göt", "gtveren", "gttn", "gtnde", "gtn", "hassiktir", "hasiktir", "hsktr", "haysiyetsiz", "ibne", "ibine", "ipne", "kaltık", "kancık", "kevaşe", "kevase", "kodumun", "orosbu", "fucker", "penis", "pic", "porno", "sex", "sikiş", "s1kerim", "s1k", "puşt", "sakso", "sik", "skcm", "siktir", "sktr", "skecem", "skeym", "slaleni", "sokam", "sokuş", "sokarım", "sokarm", "sokaym", "şerefsiz", "şrfsz", "sürtük", "taşak", "taşşak", "tasak", "tipini s", "yarram", "yararmorospunun", "yarramın başı", "yarramınbaşı", "yarraminbasi", "yrrk", "zikeyim", "zikik", "zkym");

				$checkComment = $db->query("SELECT * FROM `news_comments` WHERE user_hash = '$post_user_hash' AND hash = '$get'");
				$commentCount = $checkComment->rowCount();

				foreach ($badwords as $badword) {
					if (stripos($comment, $badword) !== false) {
						echo "<script>setTimeout(() => toastr.error('Küfür kullanımına izin verilmiyor!'), 500)</script>";
						$insert = false;
					}
				}

				if (empty($comment)) {
					echo "<script>setTimeout(() => toastr.error('Yorumunuz boş olamaz.'), 500)</script>";
					$insert = false;
				} else if (strlen($comment) < 5 || strlen($comment) > 75) {
					echo "<script>setTimeout(() => toastr.error('Yorumunuz 5 karakterden kısa veya 75 karakterden uzun olamaz.'), 500)</script>";
					$insert = false;
				} else if ($commentCount >= 1) {
					echo "<script>setTimeout(() => toastr.error('Toplamda sadece bir yorum hakkınız bulunmaktadır.'), 500)</script>";
					$insert = false;
				} else if (preg_match('/http(s)?:\/\/[^\s]+/', $comment)) {
					echo "<script>setTimeout(() => toastr.error('Linkler kullanıma kapalı!'), 500)</script>";
					$insert = false;
				} else {
					$insert = true;

					if ($insert == true) {
						$sql = "INSERT INTO `news_comments` (user_hash, date_text, preview, hash) VALUES (:user_hash, :date_text, :preview, :hash)";
						$stmt = $db->prepare($sql);
						$stmt->bindParam(':user_hash', $post_user_hash);
						$stmt->bindParam(':date_text', $post_date_text);
						$stmt->bindParam(':preview', $post_preview);
						$stmt->bindParam(':hash', $post_hash);
						$stmt->execute();

						echo "<script>setTimeout(() => toastr.success('Yorum başarıyla eklendi!'), 500);</script>";
					} else {
						echo "<script>setTimeout(() => toastr.error('Bilinmeyen bir hata oluştu!'), 500)</script>";
					}
				}
			}




			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="d-flex flex-column flex-lg-row">
								<div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
									<div class="card">
										<div class="card-header align-items-center py-5 gap-5">
											<div class="d-flex">
												<a href="notification" class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Back" data-bs-original-title="Back" data-kt-initialized="1">
													<i class="ki-duotone ki-arrow-left fs-1 m-0"><span class="path1"></span><span class="path2"></span></i> </a>
												<h2 class="fw-semibold me-4 my-2"><?= $title; ?></h2>
											</div>
										</div>
										<div class="card-body">
											<div data-kt-inbox-message="message_wrapper">
												<div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">
													<div class="d-flex align-items-center">
														<div class="symbol symbol-50 me-4">
															<span class="symbol-label" style="background-image:url(<?= $get_image; ?>);"></span>
														</div>
														<div class="pe-5">
															<div class="d-flex align-items-center flex-wrap gap-1">
																<a href="#" class="fw-bold text-white text-hover-primary"><?= base64_decode($get_username); ?></a>
																<i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3"><span class="path1"></span><span class="path2"></span></i>
																<span class="text-muted fw-bold">
																	<?php
																	$verilenTarih = $history;
																	$hedefTarih = DateTime::createFromFormat('d.m.Y H:i', $verilenTarih);
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
																</span>
															</div>
															<div data-kt-inbox-message="details">
																<span class="text-muted fw-semibold">Detaylı Bilgi</span>
																<a href="#" class="me-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
																	<i class="ki-duotone ki-down fs-5 m-0"></i> </a>

																<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-300px p-5" data-kt-menu="true">
																	<table class="table mb-0">
																		<tbody>
																			<tr>
																				<td class="text-muted">Başlık</td>
																				<td><?= $title; ?></td>
																			</tr>
																			<tr>
																				<td class="text-muted">Paylaşılan Tarih</td>
																				<td><?= $history; ?></td>
																			</tr>
																			<tr>
																				<td class="w-140px text-muted">Görüntülenme Sayısı</td>
																				<td><?= $view; ?> &nbsp;<i class="fa fa-eye"></i></td>
																			</tr>
																			<tr>
																				<td class="text-muted">Bildirim Türü</td>
																				<td><?= $result; ?></td>
																			</tr>
																			<tr>
																				<td class="text-muted">Görüntüleyen Kullanıcı</td>
																				<td><?= $username; ?></td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="collapse fade show" data-kt-inbox-message="message">
													<div class="py-5 pb-0">
														<p>
															<?= $content; ?>
														</p>
														<p>
															Saygılarımızla,
														</p>
														<p class="mb-0">
															<?= $site_name; ?>
														</p>
													</div>
												</div>
											</div>

											<?php

											$query = "SELECT * FROM `news_comments` WHERE hash = '$get' ORDER BY id DESC LIMIT 6";
											$stmt = $db->query($query);
											$count = $stmt->rowCount();
											$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

											// if ($count < 1){
											// 	echo "<div class='alert alert-danger'>Yorum bulunamadı.</div>";
											// }

											foreach ($messages as $message) {

												$user_hash = $message['user_hash'];

												$user_query = $db->query("SELECT * FROM `accounts` WHERE hash = '$user_hash'");

												while ($user_data = $user_query->fetch()) {
													$getUsername = base64_decode($user_data['username']);
													$getImage = $user_data['profile_image'];
												}

												if (empty($getImage)) {
													$output = "assets/media/svg/avatars/blank.jpg";
												} else {
													$output = $image;
												}


												$verilenTarih = $message['date_text'];

												$hedefTarih = DateTime::createFromFormat('Y-m-d H:i:s', $verilenTarih);
												$bugun = new DateTime();

												$interval = $hedefTarih->diff($bugun);

												if ($interval->y > 0) {
													$dateText = $interval->y . " yıl önce";
												} elseif ($interval->m > 0) {
													$dateText = $interval->m . " ay önce";
												} elseif ($interval->d > 0) {
													$dateText = $interval->d . " gün önce";
												} elseif ($interval->h > 0) {
													$dateText = $interval->h . " saat önce";
												} elseif ($interval->i > 0) {
													$dateText = $interval->i . " dakika önce";
												} else {
													$dateText = "Az önce";
												}


												$preview = $message['preview'];

												echo '<div class="separator my-6"></div>';
												echo '<div data-kt-inbox-message="message_wrapper">';
												echo '<div class="d-flex flex-wrap gap-2 flex-stack cursor-pointer" data-kt-inbox-message="header">';
												echo '<div class="d-flex align-items-center">';
												echo '<div class="symbol symbol-50 me-4">';
												echo '<span class="symbol-label" style="background-image:url(' . $output . ');"></span>';
												echo '</div>';
												echo '<div class="pe-5">';
												echo '<div class="d-flex align-items-center flex-wrap gap-1">';
												echo '<a href="#" class="fw-bold text-white text-hover-primary">' . $getUsername . '</a>';
												echo '<i class="ki-duotone ki-abstract-8 fs-7 text-success mx-3"><span class="path1"></span><span class="path2"></span></i>';
												echo '<span class="text-muted fw-bold">' . $dateText . '</span>';
												echo '</div>';
												echo '<div class="text-muted fw-semibold mw-450px" data-kt-inbox-message="preview">';
												echo $preview;
												echo '</div>';
												echo '</div>';
												echo '</div>';
												echo '</div>';
												echo '</div>';
											}
											?>

											<form method="POST" action="" id="kt_inbox_reply_form" class="rounded border mt-10">
												<div class="form-group">
													<textarea class="form-control border-0 px-4 py-3" id="comment" name="comment" rows="4" placeholder="Yorum ekleyin..." required></textarea>
												</div>

												<div class="d-flex flex-column-reverse flex-md-row justify-content-md-left py-3 px-4 border-top">
													<div class="mb-2 mb-md-0">
														<button name="commentSend" class="btn btn-primary fs-bold px-4">
															<span class="indicator-label">
																Yorum Yap
															</span>
														</button>
														<button type="button" onclick="clearText();" class="btn btn-danger">
															İptal
														</button>
													</div>
												</div>
											</form>
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

	<script>
		function clearText() {
			var comment = document.getElementById('comment');

			comment.value = '';
		}
	</script>

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