<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "CC Checker";


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

		:root {
			--card-height: 2.125in;
			--card-width: 3.375in;
			--card-radius: 0.125in;
			--card-thickness: 0in;
		}

		.wrapper::-webkit-scrollbar {
			display: none;
		}

		.credit-card {
			background: linear-gradient(#000000, #000000);
			padding: 1rem;
			height: 100%;
			width: auto;
			width: var(--card-width);
			height: var(--card-height);
			border-radius: var(--card-radius);
			backdrop-filter: blur(10px);
			-webkit-backdrop-filter: blur(10px);
			background-color: rgba(255, 255, 255, 0.1);

			color: white;
		}

		.card-details {
			display: grid;
			display: flex;
			flex-flow: column;
			height: 100%;
		}

		.top {
			display: flex;
			flex-flow: column;
			flex: 1;
			position: relative;
		}

		.name {
			line-height: 16px;
			letter-spacing: 1px;
			margin-top: 3px;
			width: 50%;
		}

		.name::first-line {
			font-size: 22px;
		}

		.title {
			display: flex;
			flex-flow: row nowrap;
			gap: 0 5px;
		}

		.bottom {
			display: flex;
			flex-flow: row nowrap;
			justify-content: space-between;
			align-items: center;
		}

		.reader {
			margin: 5px 0 0 20px;
		}

		.type {
			text-align: right;
			line-height: 25px;
			position: relative;
			margin: 0 -5px -25px;
		}

		.category {
			font-size: 36px;
		}

		.subcategory {
			font-weight: 300;
		}

		.cardholder {
			margin-left: 10px;
		}

		.logo img,
		.chip img,
		.number,
		.from,
		.to,
		.ring {
			position: absolute;
		}

		.logo img {
			width: 80px;
			height: auto;
			right: 0;
			bottom: 25px;
		}

		.chip img {
			top: 50px;
			left: 20px;
			width: 60px;
			height: 40px;
		}

		.hexagon {
			position: relative;
			width: 45px;
		}

		.trapezoid {
			position: absolute;
			border-bottom: 10px solid #fff;
			border-left: 0px solid transparent;
			border-right: 10px solid transparent;
			height: 0;
			width: 25px;
		}

		#t-1 {
			top: 0;
			left: 15px;
		}

		#t-2 {
			transform: rotate(90deg);
			top: 19px;
			left: 23px;
		}

		#t-3 {
			transform: rotate(180deg);
			top: 27px;
			left: 4px;
		}

		#t-4 {
			transform: rotate(-90deg);
			top: 8px;
			left: -4px;
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
						<div id="kt_content_container" class="container-xxl">
							<div class="row">
								<div class="col-xl-12 col-md-12">
									<div class="col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="md-form">
													<div class="col-md-12">
														<center>
															<div class="md-form">
																<span>Ücretsiz proxy sunucularını <a href="proxy">burada</a> paylaştık. Bu proxy'ler düzenli olarak kontrol edilir ve her 10 dakikada bir güncellenir.</span>
																<br>
																<br>
																<div class='credit-wrapper'>
																	<div class="credit-card">
																		<div class='card-details'>
																			<div class='top'>
																				<div class='title'>
																					<div class='hexagon'>
																						<div id='t-1' class='trapezoid'></div>
																						<div id='t-2' class='trapezoid'></div>
																						<div id='t-3' class='trapezoid'></div>
																						<div id='t-4' class='trapezoid'></div>
																					</div>
																					<p class='name'>
																						<?= $site_name; ?> Crew
																					</p>
																				</div>
																				<div class="chip">
																					<img src="../assets/img/chip.png" alt="chip">
																				</div>
																			</div>
																			<div class='bottom'>
																				<h3 class='cardholder' style="font-size: 13px;"><span><?= $username; ?></span> <span>-></span> <span><?= $site_name; ?></span></h3>
																				<div class='type'>
																					<div class="logo">
																						<img src="../assets/img/visa.png" alt="Visa">
																					</div>
																					<br>
																					<br>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
																<br>
																<textarea class="form-control form-control-solid" type="text" id="lista" name="lista" style="text-align: center;" placeholder="Datayı bu alana giriniz
Örnek: 4444555566667777|01|21|001" class="md-textarea form-control" rows="5"></textarea>
																<br>
																<div class="mb-3 mt-3"><label class="form-label"></label>
																	<button id="testar" onclick="enviar()" type="submit" class="btn waves-effect waves-light btn-rounded btn-success" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"> Başlat</button>
																	<button id="stoper" type="submit" class="btn waves-effect waves-light btn-rounded btn-danger" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"> Durdur</button>
																	<button onclick="window.location.reload();" type="submit" class="btn waves-effect waves-light btn-rounded btn-primary" style="width: 180px; height: 45px; outline: none; margin-left: 5px;"> Temizle</button>
																</div>
															</div>
														</center>
													</div>

													<div class="card-body">
														<div class="alert alert-success" style="font-weight: bold;background-color: #1c3238 !important;border: none;" role="alert"><i class="fa text-success fa-check-circle"></i> <b>&nbsp;Live</b> - <span class="badge badge-success" id="cCharge2">0</span></h6>
														</div>
														<div class="alert alert-danger" style="font-weight: bold;background-color: #3a2434 !important;border: none;" role="alert"><i class="fa text-danger fa-skull"></i> <b>&nbsp;DIE</b> - <span class="badge badge-danger" id="cDie2">0</span></h6>
														</div>
													</div>
												</div>
											</div>

											<script>
												function enviar() {
													var linha = $("#lista").val();
													var linhaenviar = linha.split("\n");
													var total = linhaenviar.length;
													var ap = 0;
													var rp = 0;
													var rCredits;
													linhaenviar.forEach(function(value, index) {
														setTimeout(
															function() {
																Array.prototype.randomElement = function() {
																	return this[Math.floor(Math.random() * this.length)]
																}
																$.ajax({
																	url: 'pages/api/api.php?lista=' + value,
																	async: true,
																	success: function(resultado) {
																		if (resultado.match("#Aktif")) {
																			removelinha();
																			ap++;
																			aprovadas(resultado + "");
																		} else {
																			removelinha();
																			rp++;
																			reprovadas(resultado + "");
																		}

																		$('#carregadas').html(total);

																		var fila = parseInt(ap) + parseInt(rp);
																		$('#cCharge2').html(ap);
																		$('#cDie2').html(rp);
																		$('#total').html(fila);
																		$('#cCharge2').html(ap);
																		$('#cDie2').html(rp);
																	}
																});
															}, 100 * index);
													});
												}

												function aprovadas(str) {
													$(".aprovadas").append(str);
												}

												function reprovadas(str) {
													$(".reprovadas").append(str);
												}

												function removelinha() {
													var lines = $("#lista").val().split('\n');
													lines.splice(0, 1);
													$("#lista").val(lines.join("\n"));
												}
											</script>
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


	<script>
		const constrain = 200;
		const mouseOverContainer = document.querySelector(".credit-wrapper");
		const cardLayer = document.querySelector(".credit-card");

		function transforms(x, y, el) {
			const box = el.getBoundingClientRect();
			const calcX = -(y - box.y - (box.height / 2)) / constrain;
			const calcY = (x - box.x - (box.width / 2)) / constrain;

			return `perspective(100px) rotateX(${calcX}deg) rotateY(${calcY}deg)`;
		};

		function transformElement(el, xyEl) {
			el.style.transform = transforms.apply(null, xyEl);
		}

		mouseOverContainer.onmousemove = function(e) {
			const xy = [e.clientX, e.clientY];
			const position = xy.concat([cardLayer]);

			window.requestAnimationFrame(function() {
				transformElement(cardLayer, position);
			});
		};
	</script>

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