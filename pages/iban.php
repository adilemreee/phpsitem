<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "IBAN Sorgu";

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
		
	#iban{
    width: 100% !important;
    height: 100% !important;; 
    background-color: transparent !important;; 
    opacity: 1 !important;;
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
							<div class="card">
								<div class="card-body">

									<div class="d-flex flex-column pe-0">
										<h5 class="mb-1">IBAN Sorgu</h5>
										<br>
										<div style="padding: 1px;"></div>
										<form action="iban" method="POST">
											<div class="tab-pane active" id="tc" role="tabpanel">
												<input class="form-control form-control-solid" autocomplete="off" type="text" id="kt_inputmask_2" name="iban" placeholder="IBAN Giriniz" required>
												<br>
											</div>
											<center class="button-list">
												<button name="Sorgula" type="submit" class="btn waves-effect waves-light btn-rounded bg-success" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Sorgula </button>
												<button onclick="clearTable()" type="button" class="btn waves-effect waves-light btn-rounded bg-danger" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Sıfırla </button>
												<button onclick="copyTable()" type="button" class="btn waves-effect waves-light btn-rounded bg-primary" style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Kopyala </button>
												<button onclick="printTable()" type="button" class="btn waves-effect waves-light btn-rounded bg-info" style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;"> Yazdır</button><br><br>
											</center>
										</form>
									</div>
<?php
if (isset($_POST['Sorgula'])) {
	$currentTime = time();
	$lastQueryTime = $_SESSION['last_query_time'];
	$timeDifference = $currentTime - $lastQueryTime;
	$ibanno = htmlspecialchars($_POST['iban']);
	if ($access_level != 6) {

		if ($timeDifference < 10) {
				echo '<script type="text/javascript">toastr.error("10 saniyede 1 kere sorgu atabilirsiniz.");</script>';
		exit;
		} else {
			$_SESSION['last_query_time'] = time();
		}
	}
    // Post verilerini ayarla
    $postData = [
        'iban' => htmlspecialchars(strip_tags($_POST['iban'])),
        'x' => '80',
        'y' => '28',
    ];
    $metin = str_replace(" ", "", $postData);
    $myip = "TR36 0006 2001 0660 0006 6113 07";
    $myip2 = "TR360006200106600006611307";

	if ($ibanno == $myip || $ibanno == $myip2) {
		echo "<script>toastr.error('Maalesef, aradığınız IBAN bilgisi bulunamadı.');</script>";
		exit;
	}

    // POST isteği oluştur
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://hesapno.com/cozumle_iban');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $metin);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // İsteği gönder ve cevabı al
    $response = curl_exec($ch);

    // Hata kontrolü
    if ($response === false) {
        die('Curl hatası: ' . curl_error($ch));
    }

    // CURL bağlantısını kapat
    curl_close($ch);

    // HTML içeriğini DOMDocument kullanarak analiz et
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($response);
    libxml_use_internal_errors(false);

    // XPath nesnesini oluştur
    $xpath = new DOMXPath($dom);

    // IBAN id'sine sahip div'i seç
    $ibanDivs = $xpath->query("//div[@id='iban']");

    // Eğer IBAN id'sine sahip div bulunduysa
    if ($ibanDivs->length > 0) {
        // İlk IBAN id'si içindeki tüm içeriği al
        $ibanContent = $dom->saveHTML($ibanDivs->item(0));

        // src attribute'una https://hesapno.com/ ekle
        $ibanContent = str_replace('src="assets/', 'src="https://hesapno.com/assets/', $ibanContent);

        // Tabloyu oluştur
        echo '<table class="table table-striped table-row-bordered gy-5 gs-7 border rounded">';
        echo '<tr><td>' . $ibanContent . '</td></tr>';
        echo '</table>';
    } else {
echo '<script type="text/javascript">toastr.error("IBAN Bulunamadı.");</script>';
    }
}
?>


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