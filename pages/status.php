<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Sunucu Durumu";

?>
<!DOCTYPE html>

<html lang="tr">


<head>
	<?php include 'inc/header_main.php'; ?>
	<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
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
											<div class="row mb-12">

											<div class="card-body p-10 p-lg-15">

												<div class="mb-13">

													<div class="mb-15">

														<h4 class="fs-2x text-gray-800 w-bolder mb-6">
															Sunucu Durumu
														</h4>



														<p class="fw-semibold fs-4 text-gray-600 mb-2">
															Sunucu durumunu bu sayfada görüntüleyebilirsiniz.
														</p>

													</div>

													<div class="row mb-6">
														<div class="col-md-6 pe-md-10 mb-10 mb-md-0">
															<h2 class="text-gray-800 fw-bold mb-4">
																Sunucu Durumu
															</h2>
															<br>
															<div>
																<p><span>Hayat Hikayesi Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="0"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>Ad Soyad Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>TC Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>Aile Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>Soyağacı Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>Akraba Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>Adres Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
															<br>
															<div>
																<p><span>Hane Sorgu</span></p>
																<div class="progress">
																	<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
																</div>

															</div>
														</div>
														<div class="col-md-6 pe-md-10 mb-10 mb-md-0">
															<h2 class="text-gray-800 fw-bold mb-4">
																API Durumu
															</h2>
															<br>
															<?php
															$jsonDosyaYolu = 'json/api.json';

															$jsonIcerik = file_get_contents($jsonDosyaYolu);
															$veriDizisi = json_decode($jsonIcerik, true);
															$response = "";
															
															foreach ($veriDizisi as $veri) {
																if (isset($veri['ApiName'], $veri['Status'])) {
																	$apiName = $veri['ApiName'];
																	$status = $veri['Status'];
																	
																	if($status == "true") {
																		$response = 100;
																	} else if($status == "false") {
																		$response = 0;
																	} else {
																		$response = 0;
																	}
																
															?>
															<div>
																<div>
																	<p><span><?= $apiName; ?></span></p>
																	<div class="progress">
																		<div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: <?php echo $response; ?>%;" aria-valuenow="<?php echo $response; ?>" aria-valuemin="0" aria-valuemax="100"></div>
																	</div><br>
																</div>
															</div>
															<?php
																}
															}
															?>
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