<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Kimlik Oluşturucu";

?>
<!DOCTYPE html>

<html lang="tr">

<head>
	<?php include 'inc/header_main.php'; ?>
	<style>
		.form-label {
			padding-bottom: 5px;
			padding-top: 13px;
		}

		::-webkit-calendar-picker-indicator {
			cursor: pointer;
		}

		.front {
			background-color: #ddd;
			width: 1200px;
			height: 700px;
			border-radius: 2rem;
			background-image: url(../assets/img/front.png) !important;
			background-size: cover;
			color: #000;
			font-family: Calibri;
			position: relative;
			font-weight: 500;
			filter: brightness(110%)
		}

		.back {
			background-color: #ddd;
			width: 1200px;
			height: 700px;
			border-radius: 2rem;
			background-image: url(../assets/img/back.png) !important;
			background-size: cover;
			color: #000;
			font-family: Calibri;
			position: relative;
			font-weight: 500;
			filter: brightness(90%)
		}

		.side-container {
			position: absolute;
			top: 0;
			left: 0;
			z-index: -9999;
			height: 0;
			overflow: hidden
		}

		.front * {
			position: absolute;
			filter: blur(1px);
			white-space: nowrap
		}

		.back * {
			position: absolute;
			filter: blur(1px);
			white-space: nowrap
		}

		.tckn {
			top: 160px;
			left: 70px;
			font-size: 47px;
			line-height: 47px
		}

		.surname {
			top: 280px;
			left: 410px;
			font-size: 44px;
			line-height: 44px
		}

		.name {
			top: 360px;
			left: 410px;
			font-size: 44px;
			line-height: 44px
		}

		.birth_date {
			top: 445px;
			left: 409px;
			font-size: 44px;
			line-height: 44px
		}

		.gender {
			top: 445px;
			left: 730px;
			font-size: 44px;
			line-height: 44px
		}

		.document_number {
			top: 529px;
			left: 408px;
			font-size: 44px;
			line-height: 44px
		}

		.valid_until {
			top: 610px;
			left: 407px;
			font-size: 44px;
			line-height: 44px
		}

		.face {
			width: 300px;
			left: 50px;
			bottom: 70px;
			filter: grayscale(1)
		}

		.face-right {
			width: 100px;
			right: 85px;
			bottom: 190px;
			opacity: .1;
			filter: grayscale(1) brightness(110%)
		}

		.mother_name {
			top: 165px;
			left: 375px;
			font-size: 44px;
			line-height: 44px
		}

		.father_name {
			top: 250px;
			left: 375px;
			font-size: 44px;
			line-height: 44px
		}

		.mrz {
			font-family: 'OCR-B', monospace;
			top: 450px;
			left: 85px;
			font-size: 47px;
			line-height: 40px;
			filter: none !important
		}
	</style>
</head>


<body id="kt_body" class="aside-enabled">
	<div class="d-flex flex-column flex-root">
		<div class="page d-flex flex-row flex-column-fluid">
			<?php include 'inc/header_sidebar.php'; ?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl">
							<div class="row">
								<div class="container-fluid">
									<div class="content-body">
										<div class="row">
											<div class="col-md-12">
												<div class="card">
													<form action="#" autocomplete="off" method="POST" class="row" id="form">
														<div class="card-body" style="margin-top: -20px;">
															<div class="row">
																<div class="col-xl-4 col-md-12 col-12">
																	<div class="mb-1">
																		<label class="form-label" for="basicInput">İsim</label>
																		<input type="text" class="form-control form-control-solid" name="name" placeholder="Kimlik üzerinde yazacak ismi girin." required />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12">
																	<div class="mb-1">
																		<label class="form-label" for="helpInputTop">Soyisim</label>
																		<input type="text" class="form-control form-control-solid" name="surname" placeholder="Kimlik üzerinde yazacak soyismi girin." required />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12">
																	<div class="mb-1">
																		<label class="form-label" for="disabledInput">Doğum Tarihi</label>
																		<input class="form-control form-control-solid" id="kt_daterangepicker_1" name="birth_date" type="date" required />
																	</div>
																</div>
																<div class="mb-1">
																	<label class="form-label" for="basicSelect">Cinsiyet</label>
																	<select name="gender" class="form-control form-control-solid" id="basicSelect">
																		<option value="E / M" option>Erkek</option>
																		<option value="K / F">Kadın</option>
																	</select>
																</div>
																<div class="col-xl-4 col-md-12 col-12">
																	<div class="mb-1">
																		<label class="form-label" for="helperText">T.C. Kimlik Numarası</label>
																		<input type="number" minlength="11" name="tckn" placeholder="Kimlik üzerinde yazacak TC numarasını girin." required class="form-control form-control-solid" />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12 mb-1 mb-md-0">
																	<div class="mb-1">
																		<label class="form-label" for="disabledInput">Seri Numarası</label>
																		<input type="text" class="form-control form-control-solid" name="document_number" placeholder="Kimlik üzerinde yazacak seri numarasını girin." required />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12 mb-1 mb-md-0">
																	<div class="mb-1">
																		<label class="form-label" for="disabledInput">Son Geçerlilik Tarihi</label>
																		<input class="form-control form-control-solid" id="kt_daterangepicker_2" name="valid_until" type="date" required />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12 mb-1 mb-md-0">
																	<div class="mb-1">
																		<label class="form-label" for="disabledInput">Uyruk</label>
																		<input class="form-control form-control-solid" value="T.C./TUR" readonly />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12 mb-1 mb-md-0">
																	<div class="mb-1">
																		<label class="form-label" for="disabledInput">Anne Adı</label>
																		<input type="text" class="form-control form-control-solid" name="mother_name" placeholder="Kimlik üzerinde yazacak anne ismini girin." required />
																	</div>
																</div>
																<div class="col-xl-4 col-md-12 col-12 mb-1 mb-md-0">
																	<div class="mb-1">
																		<label class="form-label" for="disabledInput">Baba Adı</label>
																		<input type="text" class="form-control form-control-solid" name="father_name" placeholder="Kimlik üzerinde yazacak baba ismini girin." required" />
																	</div>
																</div>
																<div class="mb-1">
																	<label class="form-label" for="disabledInput">Kimlik Fotoğrafı</label>
																	<input class="form-control form-control-solid" type="file" name="image" accept="image/*" required />
																</div>
																<div class="content-body mb-0">
																	<br>
																	<button class="btn btn-light-primary mt-2 form-control" type="submit">Kimlik Oluştur</button>
																</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card" style="margin-top: 10px;">
									<div class="card-body mt-0">
										<div class="row">
											<div class="text-one" style="margin-top: -11px;">Yukarıdaki form aracılığı ile kimlik oluşturduğunuzda burada gözükecektir.
											</div>
											<div class="text-two d-none" style="margin-top: -11px;">Oluşturulan kimlik görselleri aşağıda gösterilmiştir. Butona tıklayarak cihazınıza indirebilirsiniz.</div>
											<div class="col-lg-6 mt-5">
												<img src="assets/img/front-empty.png" class="front-image mw-100">
												<button class="btn btn-light-success shadow mt-3" id="download-front" disabled>Görseli İndir</button>
											</div>
											<div class="col-lg-6 mt-5">
												<img src="assets/img/back-empty.png" class="back-image mw-100">
												<button class="btn btn-light-success shadow mt-3" id="download-back" disabled>Görseli İndir</button>
											</div>
										</div>
									</div>

									<div class="side-container">
										<div class="front">
											<img src="#" class="face">
											<img src="#" class="face-right">
											<div class="tckn"></div>
											<div class="name"></div>
											<div class="surname"></div>
											<div class="birth_date"></div>
											<div class="gender"></div>
											<div class="document_number"></div>
											<div class="valid_until"></div>
										</div>
										<div class="back">
											<div class="mother_name"></div>
											<div class="father_name"></div>
											<div class="mrz"></div>
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

	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/utilities/modals/create-campaign.js"></script>
	<script src="assets/js/custom/utilities/modals/new-target.js"></script>
	<script src="assets/js/custom/utilities/modals/users-search.js"></script>
	<script src="assets/js/domtoimage.min.js"></script>
	<script src="assets/js/script.min.js"></script>



</body>


</html>