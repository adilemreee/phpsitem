<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Premium Satın Al";

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

			?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl ">
							<div class="row">
								<div class="col-xl-12 col-md-12">
									<div class="col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													🌟 Premium Hizmetlerimiz Şimdi Sizin İçin Burada! 🌟

													<br><br>

													Sevgili <?= $username; ?>,

													<br><br>

													Sizi daha iyi hizmet sunabilmek için Premium üyeliklerimizle geldik! Artık deneyiminizi bir üst seviyeye taşımanın tam zamanı. Premium üyeliğinizle birlikte eksiksiz ve özel hizmetlerimizden yararlanın.

													<br><br>

													Neler Sunuyoruz?

													<br><br>

													🚀 Hız ve İstikrar: Premium üyeler olarak, sunucularımızın hızını ve istikrarını en üst düzeye çıkarıyoruz. Sorgularınız kesilmeden ve gecikmeden devam edecek.

													<br><br>

													🔒 Özel Destek: Herhangi bir sorunuz veya talebiniz olduğunda, 7/24 hızlı ve öncelikli destek alın. Sorunlarınıza anında çözüm sunuyoruz.

													<br><br>

													📦 Premium Çözümleri: Premium üyelerimiz, özel sorgu çözümlerine ve ayrıcalıklara eksiksiz bir erişim sağlarlar.

													<br><br>

													🔄 Daha Hızlı Güncellemeler: Yeni özellikler ve güncellemeler daha önce deneyimlemeniz için Premium üyelere sunulur.

													<br><br>

													Premium Nasıl Alınır?

													<br><br>

													Premium üyeliklerimizi edinmek için, aşağıdaki iletişim adreslerinden birini kullanarak bizimle iletişime geçin:

													<br><br>

													<div class="m-0 p-0">📩 Discord: <a href="<?= $discord; ?>" target="_blank"><?= $discord; ?></a></div>

													<br><br>

													<div class="m-0 p-0">📣 Telegram: <a href="<?= $telegram; ?>" target="_blank"><?= $telegram; ?></a></div>

													<br>

													Ekibimiz, size nasıl başlayacağınız konusunda yardımcı olacak ve herhangi bir sorunuzun yanıtını verecektir.

													<br><br>

													Daha iyi bir deneyim için Premium üyeliğe geçin ve ayrıcalıkların tadını çıkarın. Sizleri aramızda görmek için sabırsızlanıyoruz!

													<br><br>

													Saygılarımızla, <br>
													<?= $site_name; ?>
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