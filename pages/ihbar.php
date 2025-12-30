<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/vipcontrol.php';

$page_title = "EGM İhbar";

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
			<?php include 'inc/header_sidebar.php'; ?>
			<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
				<?php include 'inc/header_navbar.php'; ?>
				<div class="content d-flex flex-column flex-column-fluid " id="kt_content">
					<div class="post d-flex flex-column-fluid" id="kt_post">
						<div id="kt_content_container" class="container-xxl">
							<div class="row">
								<div class="col-xl-12">
									<div class="col-lg-12">
										<div class="card">
											<div class="card-body">
												<h4 class="card-title mb-4"> İhbar Formu</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="ihbar" method="POST" autocomplete="off">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<div style="display: flex; flex-direction: row;">
																<input style="margin-right: 50px;" autocomplete="off" name="txtad" class="form-control" type="text" placeholder="Ad" required>
																<br>
																<input class="form-control form-control" autocomplete="off" type="text" name="txtsoyad" placeholder="Soyad" required>
																<br>
															</div>
															<br>
															<select class="form-control">
																<option selected="selected" value="İl Seçiniz">İl Seçiniz</option>
																<option value="ADANA İL EMNİYET MÜDÜRLÜĞÜ">ADANA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ADIYAMAN İL EMNİYET MÜDÜRLÜĞÜ">ADIYAMAN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="AFYONKARAHİSAR İL EMNİYET MÜDÜRLÜĞÜ">AFYONKARAHİSAR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="AĞRI İL EMNİYET MÜDÜRLÜĞÜ">AĞRI İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="AKSARAY İL EMNİYET MÜDÜRLÜĞÜ">AKSARAY İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="AMASYA İL EMNİYET MÜDÜRLÜĞÜ">AMASYA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ANKARA İL EMNİYET MÜDÜRLÜĞÜ">ANKARA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ANTALYA İL EMNİYET MÜDÜRLÜĞÜ">ANTALYA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ARDAHAN İL EMNİYET MÜDÜRLÜĞÜ">ARDAHAN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ARTVİN İL EMNİYET MÜDÜRLÜĞÜ">ARTVİN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="AYDIN İL EMNİYET MÜDÜRLÜĞÜ">AYDIN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BALIKESİR İL EMNİYET MÜDÜRLÜĞÜ">BALIKESİR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BARTIN İL EMNİYET MÜDÜRLÜĞÜ">BARTIN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BATMAN İL EMNİYET MÜDÜRLÜĞÜ">BATMAN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BAYBURT İL EMNİYET MÜDÜRLÜĞÜ">BAYBURT İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BİLECİK İL EMNİYET MÜDÜRLÜĞÜ">BİLECİK İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BİNGÖL İL EMNİYET MÜDÜRLÜĞÜ">BİNGÖL İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BİTLİS İL EMNİYET MÜDÜRLÜĞÜ">BİTLİS İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BOLU İL EMNİYET MÜDÜRLÜĞÜ">BOLU İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BURDUR İL EMNİYET MÜDÜRLÜĞÜ">BURDUR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="BURSA İL EMNİYET MÜDÜRLÜĞÜ">BURSA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ÇANAKKALE İL EMNİYET MÜDÜRLÜĞÜ">ÇANAKKALE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ÇANKIRI İL EMNİYET MÜDÜRLÜĞÜ">ÇANKIRI İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ÇORUM İL EMNİYET MÜDÜRLÜĞÜ">ÇORUM İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="DENİZLİ İL EMNİYET MÜDÜRLÜĞÜ">DENİZLİ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="DİYARBAKIR İL EMNİYET MÜDÜRLÜĞÜ">DİYARBAKIR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="DÜZCE İL EMNİYET MÜDÜRLÜĞÜ">DÜZCE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="EDİRNE İL EMNİYET MÜDÜRLÜĞÜ">EDİRNE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ELAZIĞ İL EMNİYET MÜDÜRLÜĞÜ">ELAZIĞ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ERZİNCAN İL EMNİYET MÜDÜRLÜĞÜ">ERZİNCAN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ERZURUM İL EMNİYET MÜDÜRLÜĞÜ">ERZURUM İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ESKİŞEHİR İL EMNİYET MÜDÜRLÜĞÜ">ESKİŞEHİR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="GAZİANTEP İL EMNİYET MÜDÜRLÜĞÜ">GAZİANTEP İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="GİRESUN İL EMNİYET MÜDÜRLÜĞÜ">GİRESUN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="GÜMÜŞHANE İL EMNİYET MÜDÜRLÜĞÜ">GÜMÜŞHANE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="HAKKARİ İL EMNİYET MÜDÜRLÜĞÜ">HAKKARİ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="HATAY İL EMNİYET MÜDÜRLÜĞÜ">HATAY İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="IĞDIR İL EMNİYET MÜDÜRLÜĞÜ">IĞDIR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ISPARTA İL EMNİYET MÜDÜRLÜĞÜ">ISPARTA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="MERSİN İL EMNİYET MÜDÜRLÜĞÜ">MERSİN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="İSTANBUL İL EMNİYET MÜDÜRLÜĞÜ">İSTANBUL İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="İZMİR İL EMNİYET MÜDÜRLÜĞÜ">İZMİR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KARS İL EMNİYET MÜDÜRLÜĞÜ">KARS İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KAHRAMANMARAŞ İL EMNİYET MÜDÜRLÜĞÜ">KAHRAMANMARAŞ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KARABÜK İL EMNİYET MÜDÜRLÜĞÜ">KARABÜK İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KARAMAN İL EMNİYET MÜDÜRLÜĞÜ">KARAMAN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KASTAMONU İL EMNİYET MÜDÜRLÜĞÜ">KASTAMONU İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KAYSERİ İL EMNİYET MÜDÜRLÜĞÜ">KAYSERİ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KIRIKKALE İL EMNİYET MÜDÜRLÜĞÜ">KIRIKKALE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KIRKLARELİ İL EMNİYET MÜDÜRLÜĞÜ">KIRKLARELİ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KIRŞEHİR İL EMNİYET MÜDÜRLÜĞÜ">KIRŞEHİR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KİLİS İL EMNİYET MÜDÜRLÜĞÜ">KİLİS İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KOCAELİ İL EMNİYET MÜDÜRLÜĞÜ">KOCAELİ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KONYA İL EMNİYET MÜDÜRLÜĞÜ">KONYA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="KÜTAHYA İL EMNİYET MÜDÜRLÜĞÜ">KÜTAHYA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="MALATYA İL EMNİYET MÜDÜRLÜĞÜ">MALATYA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="MANİSA İL EMNİYET MÜDÜRLÜĞÜ">MANİSA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="MARDİN İL EMNİYET MÜDÜRLÜĞÜ">MARDİN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="MUĞLA İL EMNİYET MÜDÜRLÜĞÜ">MUĞLA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="MUŞ İL EMNİYET MÜDÜRLÜĞÜ">MUŞ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="NEVŞEHİR İL EMNİYET MÜDÜRLÜĞÜ">NEVŞEHİR İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="NİĞDE İL EMNİYET MÜDÜRLÜĞÜ">NİĞDE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="OSMANİYE İL EMNİYET MÜDÜRLÜĞÜ">OSMANİYE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ORDU İL EMNİYET MÜDÜRLÜĞÜ">ORDU İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="RİZE İL EMNİYET MÜDÜRLÜĞÜ">RİZE İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="SAKARYA İL EMNİYET MÜDÜRLÜĞÜ">SAKARYA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="SAMSUN İL EMNİYET MÜDÜRLÜĞÜ">SAMSUN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="SİİRT İL EMNİYET MÜDÜRLÜĞÜ">SİİRT İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="SİNOP İL EMNİYET MÜDÜRLÜĞÜ">SİNOP İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="SİVAS İL EMNİYET MÜDÜRLÜĞÜ">SİVAS İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ŞANLIURFA İL EMNİYET MÜDÜRLÜĞÜ">ŞANLIURFA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ŞIRNAK İL EMNİYET MÜDÜRLÜĞÜ">ŞIRNAK İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="TEKİRDAĞ İL EMNİYET MÜDÜRLÜĞÜ">TEKİRDAĞ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="TOKAT İL EMNİYET MÜDÜRLÜĞÜ">TOKAT İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="TRABZON İL EMNİYET MÜDÜRLÜĞÜ">TRABZON İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="TUNCELİ İL EMNİYET MÜDÜRLÜĞÜ">TUNCELİ İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="UŞAK İL EMNİYET MÜDÜRLÜĞÜ">UŞAK İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="VAN İL EMNİYET MÜDÜRLÜĞÜ">VAN İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="YALOVA İL EMNİYET MÜDÜRLÜĞÜ">YALOVA İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="YOZGAT İL EMNİYET MÜDÜRLÜĞÜ">YOZGAT İL EMNİYET MÜDÜRLÜĞÜ</option>
																<option value="ZONGULDAK İL EMNİYET MÜDÜRLÜĞÜ">ZONGULDAK İL EMNİYET MÜDÜRLÜĞÜ</option>
															</select>
															<br>
															<input class="form-control" autocomplete="off" type="text" name="konu" placeholder="Konu">
															<br>
															<input class="form-control" autocomplete="off" type="text" name="olayyeri" placeholder="Olay Yeri">
															<br>
															<textarea class="form-control" rows="4" autocomplete="off" type="text" name="aciklama" placeholder="Açıklama"></textarea>
															<br>
															<button name="sorgula" class="btn form-control btn-light-success">Gönder</button>

															<?php if (isset($_POST['sorgula'])) {
																	$currentTime = time();
																	$lastQueryTime = $_SESSION['last_query_time'];
																	$timeDifference = $currentTime - $lastQueryTime;

																	if ($access_level != 6) {

																		if ($timeDifference < 10) {
																			echo '<script type="text/javascript">toastr.error("60 saniyede 1 kere ihbar gönderebilirsiniz.");</script>';
																			exit;
																		} else {
																			$_SESSION['last_query_time'] = time();
																		}
																	}
																	$konu = htmlspecialchars(strip_tags($_POST['konu']));
																	$olay = htmlspecialchars(strip_tags($_POST['olayyeri']));
																	$aciklama = htmlspecialchars(strip_tags($_POST['aciklama']));
																	if ($konu == "" || $olay == "" || $aciklama = "") {
																		echo "<script>toastr.error('Lütfen Boş alanları doldurunuz!');</script>";
																		exit;
																	} else {
																		echo "<script>toastr.success('Başarıyla, ihbarınız gönderildi!');</script>";
																		exit;
																	}
																}
															?>
														</div>
													</form>
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
	<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
	<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<script src="assets/js/widgets.bundle.js"></script>
	<script src="assets/js/custom/widgets.js"></script>
	<script src="assets/js/custom/apps/chat/chat.js"></script>
	<script src="assets/js/custom/utilities/modals/users-search.js"></script>

</body>


</html>