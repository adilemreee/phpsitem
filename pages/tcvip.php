<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "TC PRO";

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
												<h4 class="card-title mb-4"> TC PRO</h4>
												<div style="padding: 3.8px;"></div>
												<div class="block-content tab-content">
													<form action="tcvip" method="POST">
														<div class="tab-pane active" id="tc" role="tabpanel">
															<input autocomplete="off" name="tcno"
																class="form-control form-control-solid" type="text"
																minlength="11" maxlength="11"
																placeholder="TC Kimlik Numarası" required>
														</div>
														<br>
														<center class="nw">
															<button onclick="checkNumber()" id="sorgula" name="Sorgula"
																type="submit"
																class="btn waves-effect waves-light btn-rounded btn-success"
																style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Sorgula </button>
															<button onclick="clearTable()" id="durdurButon"
																type="button"
																class="btn waves-effect waves-light btn-rounded btn-danger"
																style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Sıfırla </button>
															<button onclick="copyTable()" id="copy_btn" type="button"
																class="btn waves-effect waves-light btn-rounded btn-primary"
																style="font-weight: 400;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Kopyala </button>
															<button onclick="printTable()" id="yazdirTable"
																type="button"
																class="btn waves-effect waves-light btn-rounded btn-info"
																style="font-weight: 400;;width: 180px; height: 45px; outline: none; margin-left: 5px;">
																Yazdır</button><br><br>
														</center>
													</form>

													<div class="table-responsive">
														<?php

														if (isset($_POST['Sorgula'])) {

															if ($access_level <= 3) {
																echo "<script>toastr.info('Üyeliğinizinizden Dolayı Herhangi Bir Sorgu İşlemi Yapamazsınız.');</script>";
																exit;
															} else {
																$tcno = htmlspecialchars(strip_tags($_POST['tcno']));

																if ($tcvip < 1) {
																	echo "<script>toastr.error('Limit yeterli değil!');</script>";
																	echo "<script>toastr.info('Marketten limit satın alabilirsiniz.');</script>";
																	exit;
																}

																$output = $tcvip - 1;

																totalLog("tcvipsrg");
																countAdd();

																$sql = "UPDATE `accounts` SET tcvip = :tcvip WHERE hash = :hash";
																$stmt = $db->prepare($sql);
																$stmt->bindParam(':tcvip', $output);
																$stmt->bindParam(':hash', $_SESSION['GET_USER_SSID']);
																$stmt->execute();

																$db = new PDO("mysql:host=localhost;dbname=101m;charset=utf8", "root", "");

																if ($tcno != "" && strlen($tcno) == 11) {
																	$query = $db->query("SELECT * FROM 101m WHERE TC = '$tcno'");
																	echo "<script>toastr.info('Kişi bilgileri getirildi!');</script>";
																	echo "<script>toastr.success('Sorgu işlemi başarıyla tamamlandı!');</script>";
																}

																while ($data = $query->fetch()) {


																	?>
																</div>
																<br><br>
																<center>
																	<div class="alert alert-secondary text-white"
																		style="padding: 15px;">
																		Kişi Bilgileri
																	</div>
																</center>
																<div class="table-responsive">
																	<table class="table table-bordered">
																		<tbody>
																			<tr>
																				<th>Kimlik Numarası </th>
																				<td id="tcno">
																					<?php echo $data['TC']; ?>
																				</td>
																			</tr>
																			<tr>
																				<th>Adı Soyadı </th>
																				<td id="ad">
																					<?php echo $data['ADI']; ?>
																					<?php echo $data['SOYADI']; ?>
																				</td>
																			</tr>
																			<tr>
																				<th>Doğum Tarihi </th>
																				<td id="dt">
																					<?php echo $data['DOGUMTARIHI']; ?>
																				</td>
																			</tr>

																			<tr>
																				<th>Anne Adı</th>
																				<td id="anneadi">
																					<?php echo $data['ANNEADI']; ?>
																				</td>
																			</tr>

																			<tr>
																				<th>Anne TC</th>
																				<td id="annetc">
																					<?php echo $data['ANNETC']; ?>
																				</td>
																			</tr>

																			<tr>
																				<th>Baba Adı</th>
																				<td id="babaadi">
																					<?php echo $data['BABAADI']; ?>
																				</td>
																			</tr>
																			<tr>
																				<th>Baba TC</th>
																				<td id="babatc">
																					<?php echo $data['BABATC']; ?>
																				</td>
																			</tr>

																			<tr>
																				<th>Adres İl</th>
																				<td id="adresil">
																					<?php echo $data['NUFUSIL']; ?>
																				</td>
																			</tr>

																			<tr>
																				<th>Adres İlçe</th>
																				<td id="adresilce">
																					<?php echo $data['NUFUSILCE']; ?>
																				</td>
																			</tr>

																		</tbody>
																	</table>
																</div>
																<center>
																	<div class="alert alert-secondary text-white"
																		style="padding: 15px;">
																		Aile Bilgileri
																	</div>
																</center>
																<div class="table-responsive">
																	<table class="table table-bordered">
																		<tbody>
																			<tr>
																				<th>Yakınlık</th>
																				<th>TC</th>
																				<th>Ad</th>
																				<th>Soyad</th>
																				<th>Doğum Tarihi</th>
																				<th>Anne Adı</th>
																				<th>Anne TC</th>
																				<th>Baba Adı</th>
																				<th>Baba TC</th>
																				<th>Adres İl</th>
																				<th>Adres İlçe</th>
																			</tr>
																		</tbody>
																		<tbody>
																			<?php

																			#region Aile
																
																			$str = htmlspecialchars(strip_tags($_POST['tcno']));

																			$baglanti = new mysqli('localhost', 'root', '', '101m');

																			$sth = $baglanti->prepare("SELECT * FROM `101m`");

																			$sql = "SELECT * FROM `101m` WHERE `TC` = '$str'";
																			$result = $baglanti->query($sql);

																			while ($row = $result->fetch_assoc()) {

																				echo "<tr>
<td> Kendisi </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																				$sqlcocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																				$resultcocugu = $baglanti->query($sqlcocugu);

																				$sqlkardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																				$resultkardesi = $baglanti->query($sqlkardesi);
																				$sqlbabasi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																				$resultbabasi = $baglanti->query($sqlbabasi);
																				$sqlanasi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																				$resultanasi = $baglanti->query($sqlanasi);

																				$sqlkendicocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																				$resultkendicocugu = $baglanti->query($sqlkendicocugu);
																			}

																			while ($row = $resultkendicocugu->fetch_assoc()) {

																				echo "<tr>
<td> Çocuğu </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																			}
																			while ($row = $resultkardesi->fetch_assoc()) {


																				echo "<tr>
<td> Kardeşi </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																			}

																			while ($row = $resultbabasi->fetch_assoc()) {

																				$tcrow5 = $row['TC'];

																				echo "<tr>
<td> Babası </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																			}

																			while ($row = $resultanasi->fetch_assoc()) {

																				echo "<tr>
<td> Annesi </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>
</tr>";
																			}

																			#endregion
																			?>
																		</tbody>
																	</table>
																</div>
																<center>
																	<div class="alert alert-secondary text-white"
																		style="padding: 15px;">
																		Yakın Akraba Bilgileri
																	</div>
																</center>
																<div class="table-responsive">
																	<table class="table table-bordered">
																		<tbody>
																			<tr>
																				<th>Yakınlık</th>
																				<th>TC</th>
																				<th>Ad</th>
																				<th>Soyad</th>
																				<th>Doğum Tarihi</th>
																				<th>Anne Adı</th>
																				<th>Anne TC</th>
																				<th>Baba Adı</th>
																				<th>Baba TC</th>
																				<th>Adres İl</th>
																				<th>Adres İlçe</th>
																			</tr>
																		</tbody>
																		<tbody>
																			<?php

																			#region akraba
																
																			$number = htmlspecialchars(strip_tags($_POST['tcno']));

																			$baglanti = new mysqli('localhost', 'root', '', '101m');

																			$str = $number;
																			$sth = $baglanti->prepare("SELECT * FROM `101m`");

																			$sql = "SELECT * FROM `101m` WHERE `TC` = '$str'";
																			$result = $baglanti->query($sql);

																			while ($row = $result->fetch_assoc()) {

																				$sqlcocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																				$resultcocugu = $baglanti->query($sqlcocugu);

																				$sqlkardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																				$resultkardesi = $baglanti->query($sqlkardesi);
																				$sqlBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																				$resultBabası = $baglanti->query($sqlBabası);
																				$sqlAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																				$resultAnnesi = $baglanti->query($sqlAnnesi);

																				$sqlkendicocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																				$resultkendicocugu = $baglanti->query($sqlkendicocugu);
																				while ($row = $resultkendicocugu->fetch_assoc()) {

																					$sqlkendikendicocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																					$resultkendikendicocugu = $baglanti->query($sqlkendikendicocugu);
																					while ($row = $resultkendikendicocugu->fetch_assoc()) {

																						$sqlkendikendikendicocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																						$resultkendikendikendicocugu = $baglanti->query($sqlkendikendikendicocugu);
																						while ($row = $resultkendikendikendicocugu->fetch_assoc()) {
																						}
																					}
																				}
																				while ($row = $resultkardesi->fetch_assoc()) {

																					$sqlkardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																					$resultkardescocugu = $baglanti->query($sqlkardescocugu);
																					while ($row = $resultkardescocugu->fetch_assoc()) {

																						$sqlkardeskardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																						$resultkardeskardescocugu = $baglanti->query($sqlkardeskardescocugu);
																						while ($row = $resultkardeskardescocugu->fetch_assoc()) {

																							$sqlkardeskardeskardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultkardeskardeskardescocugu = $baglanti->query($sqlkardeskardeskardescocugu);
																							while ($row = $resultkardeskardeskardescocugu->fetch_assoc()) {
																							}
																						}
																					}
																				}

																				while ($row = $resultBabası->fetch_assoc()) {

																					$sqlbabakardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																					$resultbabakardesi = $baglanti->query($sqlbabakardesi);
																					$sqlbabaBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																					$resultbabaBabası = $baglanti->query($sqlbabaBabası);
																					$sqlbabaAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																					$resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

																					while ($row = $resultbabakardesi->fetch_assoc()) {
																						echo "<tr>
<td> Halası/Amcası </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																						$sqlbabakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																						$resultbabakardescocugu = $baglanti->query($sqlbabakardescocugu);
																						while ($row = $resultbabakardescocugu->fetch_assoc()) {
																							echo "<tr>
<td> Kuzeni </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																							$sqlbabakardesbabakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultbabakardesbabakardescocugu = $baglanti->query($sqlbabakardesbabakardescocugu);
																							while ($row = $resultbabakardesbabakardescocugu->fetch_assoc()) {
																								$sqlbabakardesbabakardesbabakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																								$resultbabakardesbabakardesbabakardescocugu = $baglanti->query($sqlbabakardesbabakardesbabakardescocugu);
																								while ($row = $resultbabakardesbabakardesbabakardescocugu->fetch_assoc()) {
																								}
																							}
																						}
																					}

																					while ($row = $resultbabaBabası->fetch_assoc()) {
																						$sqlbabakardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																						$resultbabakardesi = $baglanti->query($sqlbabakardesi);
																						$sqlbabaBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																						$resultbabaBabası = $baglanti->query($sqlbabaBabası);
																						$sqlbabaAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																						$resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

																						while ($row = $resultbabakardesi->fetch_assoc()) {
																							$sqlbabababakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultbabababakardescocugu = $baglanti->query($sqlbabababakardescocugu);
																							while ($row = $resultbabababakardescocugu->fetch_assoc()) {
																								$sqlbabababakardesbabababakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																								$resultbabababakardesbabababakardescocugu = $baglanti->query($sqlbabababakardesbabababakardescocugu);
																								while ($row = $resultbabababakardesbabababakardescocugu->fetch_assoc()) {
																									$sqlbabababakardesbabababakardesbabababakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																									$resultbabababakardesbabababakardesbabababakardescocugu = $baglanti->query($sqlbabababakardesbabababakardesbabababakardescocugu);
																									while ($row = $resultbabababakardesbabababakardesbabababakardescocugu->fetch_assoc()) {
																									}
																								}
																							}
																						}
																						while ($row = $resultbabaBabası->fetch_assoc()) {
																						}
																						while ($row = $resultbabaAnnesi->fetch_assoc()) {
																						}
																					}
																					while ($row = $resultbabaAnnesi->fetch_assoc()) {
																						$sqlbabakardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																						$resultbabakardesi = $baglanti->query($sqlbabakardesi);
																						$sqlbabaBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																						$resultbabaBabası = $baglanti->query($sqlbabaBabası);
																						$sqlbabaAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																						$resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

																						while ($row = $resultbabakardesi->fetch_assoc()) {
																							$sqlbabaannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultbabaannekardescocugu = $baglanti->query($sqlbabaannekardescocugu);
																							while ($row = $resultbabaannekardescocugu->fetch_assoc()) {
																								$sqlbabaannekardesbabaannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																								$resultbabaannekardesbabaannekardescocugu = $baglanti->query($sqlbabaannekardesbabaannekardescocugu);
																								while ($row = $resultbabaannekardesbabaannekardescocugu->fetch_assoc()) {
																									$sqlbabaannekardesbabaannekardesbabaannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																									$resultbabaannekardesbabaannekardesbabaannekardescocugu = $baglanti->query($sqlbabaannekardesbabaannekardesbabaannekardescocugu);
																									while ($row = $resultbabaannekardesbabaannekardesbabaannekardescocugu->fetch_assoc()) {
																									}
																								}
																							}
																						}

																						while ($row = $resultbabaBabası->fetch_assoc()) {
																						}
																						while ($row = $resultbabaAnnesi->fetch_assoc()) {
																						}
																					}
																				}
																			}
																			while ($row = $resultAnnesi->fetch_assoc()) {
																				$sqlannekardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																				$resultannekardesi = $baglanti->query($sqlannekardesi);
																				$sqlanneBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																				$resultanneBabası = $baglanti->query($sqlanneBabası);
																				$sqlanneAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																				$resultanneAnnesi = $baglanti->query($sqlanneAnnesi);

																				while ($row = $resultannekardesi->fetch_assoc()) {
																					echo "<tr>
<td> Teyzesi/Amcası </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																					$sqlannekardescocugu = "SELECT * FROM `101m` WHERE `BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ";
																					$resultannekardescocugu = $baglanti->query($sqlannekardescocugu);
																					while ($row = $resultannekardescocugu->fetch_assoc()) {
																						echo "<tr>
<td> Kuzeni </td>
<td>" . $row["TC"] . "</td>
<td>" . $row["ADI"] . "</td>
<td>" . $row["SOYADI"] . "</td>
<td>" . $row["DOGUMTARIHI"] . "</td>
<td>" . $row["ANNEADI"] . "</td>
<td>" . $row["ANNETC"] . "</td>
<td>" . $row["BABAADI"] . "</td>
<td>" . $row["BABATC"] . "</td>
<td>" . $row["NUFUSIL"] . "</td>
<td>" . $row["NUFUSILCE"] . "</td>

</tr>";
																						$sqlannekardesannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																						$resultannekardesannekardescocugu = $baglanti->query($sqlannekardesannekardescocugu);
																						while ($row = $resultannekardesannekardescocugu->fetch_assoc()) {
																							$sqlannekardesannekardesannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultannekardesannekardesannekardescocugu = $baglanti->query($sqlannekardesannekardesannekardescocugu);
																							while ($row = $resultannekardesannekardesannekardescocugu->fetch_assoc()) {
																							}
																						}
																					}
																				}

																				while ($row = $resultanneBabası->fetch_assoc()) {
																					$sqlbabakardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																					$resultbabakardesi = $baglanti->query($sqlbabakardesi);
																					$sqlbabaBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																					$resultbabaBabası = $baglanti->query($sqlbabaBabası);
																					$sqlbabaAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																					$resultbabaAnnesi = $baglanti->query($sqlbabaAnnesi);

																					while ($row = $resultbabakardesi->fetch_assoc()) {
																						$sqlannebabakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																						$resultannebabakardescocugu = $baglanti->query($sqlannebabakardescocugu);
																						while ($row = $resultannebabakardescocugu->fetch_assoc()) {
																							$sqlannebabakardesannebabakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultannebabakardesannebabakardescocugu = $baglanti->query($sqlannebabakardesannebabakardescocugu);
																							while ($row = $resultannebabakardesannebabakardescocugu->fetch_assoc()) {
																								$sqlannebabakardesannebabakardesannebabakardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																								$resultannebabakardesannebabakardesannebabakardescocugu = $baglanti->query($sqlannebabakardesannebabakardesannebabakardescocugu);
																								while ($row = $resultannebabakardesannebabakardesannebabakardescocugu->fetch_assoc()) {
																								}
																							}
																						}
																					}

																					while ($row = $resultbabaBabası->fetch_assoc()) {
																					}
																					while ($row = $resultbabaAnnesi->fetch_assoc()) {
																					}
																				}
																				while ($row = $resultanneAnnesi->fetch_assoc()) {
																					$sqlannekardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["BABATC"] . "' OR `ANNETC` = '" . $row["ANNETC"] . "' ) ";
																					$resultannekardesi = $baglanti->query($sqlannekardesi);
																					$sqlanneBabası = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] . "' ";
																					$resultanneBabası = $baglanti->query($sqlanneBabası);
																					$sqlanneAnnesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] . "' ";
																					$resultanneAnnesi = $baglanti->query($sqlanneAnnesi);

																					while ($row = $resultannekardesi->fetch_assoc()) {
																						$sqlanneannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																						$resultanneannekardescocugu = $baglanti->query($sqlanneannekardescocugu);
																						while ($row = $resultanneannekardescocugu->fetch_assoc()) {
																							$sqlanneannekardesanneannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																							$resultanneannekardesanneannekardescocugu = $baglanti->query($sqlanneannekardesanneannekardescocugu);
																							while ($row = $resultanneannekardesanneannekardescocugu->fetch_assoc()) {
																								$sqlanneannekardesanneannekardesanneannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																								$resultanneannekardesanneannekardesanneannekardescocugu = $baglanti->query($sqlanneannekardesanneannekardesanneannekardescocugu);
																								while ($row = $resultanneannekardesanneannekardesanneannekardescocugu->fetch_assoc()) {
																									$sqlanneannekardesanneannekardesanneannekardesanneannekardescocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '" . $row["TC"] . "'  AND (`BABATC` = '" . $row["TC"] . "' OR `ANNETC` = '" . $row["TC"] . "' ) ";
																									$resultanneannekardesanneannekardesanneannekardesanneannekardescocugu = $baglanti->query($sqlanneannekardesanneannekardesanneannekardesanneannekardescocugu);
																									while ($row = $resultanneannekardesanneannekardesanneannekardesanneannekardescocugu->fetch_assoc()) {
																									}
																								}
																							}
																						}
																						while ($row = $resultanneBabası->fetch_assoc()) {
																						}
																						while ($row = $resultanneAnnesi->fetch_assoc()) {
																						}
																					}
																				}
																			}
																}
															}
														}

														#endregion
														
														?>
															</tbody>
														</table>
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

	<style>
		#kt_datatable_dom_positioning_filter {
			text-align: left;
			margin-right: 15px;
		}

		.dt-buttons button:nth-child(3) {
			background-color: #dc3545 !important;
			color: #fff;
			border-color: #dc3545;
		}
	</style>

	<script>
		$(document).ready(function () {
			var table = $('#kt_datatable_dom_positioning').DataTable({
				"language": {
					"lengthMenu": "Sayfada _MENU_ kayıt göster",
					"emptyTable": "Tabloda herhangi bir veri bulunmamaktadır",
					"info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
					"infoEmpty": "Gösterilecek kayıt bulunamadı",
					"infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
					"zeroRecords": "Eşleşen kayıt bulunamadı",
					"search": "Ara:",
					"processing": "İşleniyor...",
					"loadingRecords": "Kayıtlar yükleniyor...",
					"paginate": {
						"first": "İlk",
						"last": "Son",
						"next": "Sonraki",
						"previous": "Önceki"
					},
					"buttons": {
						"copy": "Kopyala",
						"excel": "Excel",
						"pdf": "PDF"
					}
				},
				"dom": "<'row'" +
					"<'col-sm-12 d-flex align-items-center justify-content-start'l>" +
					"<'col-sm-12 d-flex align-items-center justify-content-end'f>" +
					">" +
					"<'table-responsive'tr>" +
					"<'row'" +
					"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-start justify-content-md-start'i>" +
					"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-start justify-content-md-end'p>" +
					">",
				"sDom": '<"refresh"i<"clear">>rt<"top"lf<"clear">>rt<"bottom"p<"clear">>',
				"paging": false,
				"ordering": false,
				"info": false
			});

			new $.fn.dataTable.Buttons(table, {
				buttons: [
					'excel',
					{
                        extend: 'pdfHtml5',
                        customize: function (doc) {
                            // Özel PDF ayarları buraya eklenir
                            doc.defaultStyle.fontSize = 5;
                            doc.styles.tableHeader.fontSize = 5;
                            doc.styles.tableBodyOdd.fontSize = 5;
                            doc.styles.tableBodyEven.fontSize = 5;
                        }
                    },
					{
						text: 'Sorun Bildir',
						action: function (e, dt, node, config) {
							// SweetAlert ile kullanıcıya bir form göster
							Swal.fire({
								title: 'Sorun Bildir',
								html: '<textarea max="200" min="10" id="sorun" class="form-control" placeholder="Sorununuzu yazın">',
								focusConfirm: false,
								preConfirm: () => {
									// Kullanıcının girdiği değeri al
									const sorun = Swal.getPopup().querySelector('#sorun').value;
									// Discord webhook'a post at
									postToDiscordWebhook(sorun);
								}
							});
						}
					}
				]
			}).container().appendTo($('#kt_datatable_dom_positioning_wrapper .col-sm-12:eq(1)'));

			$('#kt_datatable_dom_positioning_filter input').on('keyup', function () {
				table.search(this.value).draw();
			});
		});

		function postToDiscordWebhook(sorun) {
			// Post verilerini ayarla
			var postData = {
				content: ` **Sorun:** ${sorun} \n**Gönderen: ** <?= $username; ?> \n**Sayfa Başlığı: ** <?= $page_title; ?> \n**Gönderilen Tarih** <?= date('d.m.Y H:i'); ?>`
			};

			// BİZLE SADECE BURDAN İLETİŞİM KURABİLECEĞİNİZ İÇİN BURAYI AÇIK BIRAKIYORUM
			// VELİ İZNİNİZİ ALIN MESAJINIZI ÖYLE ATIN BOHOHOHOYT
			var webhookUrl = '<?= $web6 ?>'; // Kendi webhook URL'nizi buraya ekleyin

			// jQuery ile post isteği gönder
			$.ajax({
				type: 'POST',
				url: "../pages/php/check_data.php",
				success: function (response) {

					if (response == 0) {
						toastr.error("Günlük Limite Ulaştınız.");
					} else {
						$.ajax({
							type: 'POST',
							url: webhookUrl,
							contentType: 'application/json',
							data: JSON.stringify(postData),
							success: function (response) {
								// Başarılıysa işlemleri burada yapabilirsiniz
								toastr.success("Sorun başarıyla yöneticilere bildirildi.")
							},
							error: function (error) {
								// Hata oluştuysa işlemleri burada yapabilirsiniz
								toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
							}
						});

						$.ajax({
							type: 'POST',
							url: "../pages/php/pin_claim.php",
							success: function (response) {
								// Başarılıysa işlemleri burada yapabilirsiniz
								toastr.success("Kalan Kullanım Hakkınız " + response)
							},
							error: function (error) {
								// Hata oluştuysa işlemleri burada yapabilirsiniz
								toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
							}
						});
					}

				},
				error: function (error) {
					// Hata oluştuysa işlemleri burada yapabilirsiniz
					toastr.success("Hata oluştu! Yöneticiler ile iletişime geçiniz!")
				}
			});
		}
	</script>

	<script id="clearTable">
		function clearTable() {
			window.location.reload();
		}
	</script>

	<script id="copyTable">
		function copyTable() {
			var copiedText = "";

			// Tabloyu seçin
			var table = document.getElementById('kt_datatable_dom_positioning'); // your_table_id, HTML tablonuzun ID'siyle değiştirilmelidir

			// Tablonun satırlarını döngüye alın
			for (var i = 0; i < table.rows.length; i++) {
				var row = table.rows[i];
				// Her satırın hücrelerini döngüye alın
				for (var j = 0; j < row.cells.length; j++) {
					copiedText += row.cells[j].textContent + "\t"; // Hücreler arasına bir sekme ekleyebilirsiniz
				}
				// Her satırın sonunda yeni bir satır ekleyin
				copiedText += "\n";
			}

			// Kopyalanan metni panoya kopyalayın
			var textarea = document.createElement("textarea");
			textarea.value = copiedText;
			document.body.appendChild(textarea);
			textarea.select();
			document.execCommand("copy");
			document.body.removeChild(textarea);

			toastr.success('Tablo içeriği panoya kopyalandı.');
		}
	</script>

	<script id="printTable">
		function printTable() {
			var table = document.getElementById("kt_datatable_dom_positioning");
			var windowContent = '<table border="1">';
			for (var i = 0; i < table.rows.length; i++) {
				windowContent += "<tr>";
				for (var j = 0; j < table.rows[i].cells.length; j++) {
					windowContent += "<td>" + table.rows[i].cells[j].innerHTML + "</td>";
				}
				windowContent += "</tr>";
			}
			windowContent += "</table>";

			var printWin = window.open('', '', 'width=600,height=600');
			printWin.document.open();
			printWin.document.write('<html><head><title>Tablo Yazdırma</title></head><body onload="window.print()">' + windowContent + '</body></html>');
			printWin.document.close();
			printWin.focus();
		}
	</script>

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