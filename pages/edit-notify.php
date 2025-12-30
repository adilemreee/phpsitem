<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

$page_title = "Bildirim Düzenle";

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

			if (isset($_POST['update'])) {

				$post_title = htmlspecialchars(strip_tags($_POST['title']));
				$post_content = htmlspecialchars(strip_tags($_POST['content']));
				$post_type = htmlspecialchars(strip_tags($_POST['type']));
				$post_view = htmlspecialchars(strip_tags($_POST['view']));
				$post_history = htmlspecialchars(strip_tags($_POST['history']));

				if ($post_title == "" || $post_content == "" || $post_type == "" || $post_view == "" || $post_history == "") {

					echo "<script>toastr.error('Boş alan olamaz');</script>";
				} else {
					$sql = "UPDATE `news` SET title = :title, content = :content, type = :type, view = :view, history = :history WHERE hash = :hash";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':title', $post_title);
					$stmt->bindParam(':content', $post_content);
					$stmt->bindParam(':type', $post_type);
					$stmt->bindParam(':view', $post_view);
					$stmt->bindParam(':history', $post_history);
					$stmt->bindParam(':hash', $get);
					$stmt->execute();

					echo "<script>toastr.success('Bildirim başarıyla güncellendi.');</script>";
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
										<i class="ki-duotone ki-notification fs-2hx text-primary me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
										<div class="d-flex flex-column pe-0 pe-sm-10">
											<h5 class="mb-1">Bildirim Düzenle</h5>
											<div style="padding: 1px;"></div>
											<span class="text-gray-800">Bildirimleri bu sayfadan düzenleyebilirsiniz.</span>
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
											<input type="text" name="title" class="form-control form-control-solid" value="<?= $title; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">İçerik</label>
											<div style="padding: 3px;"></div>
											<textarea id="textarea" type="text" name="content" class="form-control form-control-solid"><?= $content; ?></textarea>
										</div>

										<div class="form-group mt-5">
											<label class="required">Görüntülenme Sayısı</label>
											<div style="padding: 3px;"></div>
											<input type="text" name="view" class="form-control form-control-solid" value="<?= $view; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Tarih</label>
											<div style="padding: 3px;"></div>
											<input type="text" name="history" class="form-control form-control-solid" value="<?= $history; ?>">
										</div>

										<div class="form-group mt-5">
											<label class="required">Tür</label>
											<div style="padding: 3px;"></div>
											<select name="type" class="form-control form-control-solid">
												<option value="event" <?= ($type == "event") ? 'selected' : ''; ?>>Etkinlik</option>
												<option value="update" <?= ($type == "update") ? 'selected' : ''; ?>>Bakım Notu</option>
												<option value="news" <?= ($type == "news") ? 'selected' : ''; ?>>Duyuru</option>
											</select>
										</div>
										<br>

										<button type="submit" name="update" class="btn btn-light-primary form-control">Güncelle</button>
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

	<script src='https://cdn.tiny.cloud/1/z8lwefpn5qkuk59l9n15xdv5ypg75w904zh6qsap0veac1pc/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
	<script>
		tinymce.init({
			selector: '#textarea'
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