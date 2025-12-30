<?php

include '../server/database.php';

include '../server/rolecontrol.php';

include '../server/admincontrol.php';

include '../server/webhook.php';

include '../server/functions.php';


$page_title = "Genel Ayarlar";

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
								<div class="d-flex flex-row flex-column-fluid align-items-stretch">
									<div class="content flex-row-fluid" id="kt_content">
										<div class="card card-flush">
											<div class="card-body">
												<ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-semibold mb-15"
													role="tablist">
													<li class="nav-item" role="presentation">
														<a class="nav-link text-active-primary d-flex align-items-center pb-5 active"
															data-bs-toggle="tab" href="#settings" aria-selected="true"
															role="tab">
															<i class="ki-duotone ki-gear fs-2 me-2"><i
																	class="path1"></i><i class="path2"></i></i> Genel
															Ayarlar
														</a>
													</li>
													<li class="nav-item" role="presentation">
														<a class="nav-link text-active-primary d-flex align-items-center pb-5"
															data-bs-toggle="tab" href="#social" aria-selected="false"
															tabindex="-1" role="tab">
															<i class="ki-duotone ki-social-media fs-2 me-2"><span
																	class="path1"></span><span class="path2"></span></i>
															Sosyal Bağlantılar
														</a>
													</li>
													<li class="nav-item" role="presentation">
														<a class="nav-link text-active-primary d-flex align-items-center pb-5"
															data-bs-toggle="tab" href="#ddos" aria-selected="false"
															tabindex="-1" role="tab">
															<i class="ki-duotone ki-package fs-2 me-2"><span
																	class="path1"></span><span
																	class="path2"></span><span class="path3"></span></i>
															DDoS Koruması
														</a>
													</li>
													<li class="nav-item" role="presentation">
														<a class="nav-link text-active-primary d-flex align-items-center pb-5"
															data-bs-toggle="tab" href="#system" aria-selected="false"
															tabindex="-1" role="tab">
															<i class="ki-duotone ki-gear fs-2 me-2"><span
																	class="path1"></span><span
																	class="path2"></span><span class="path3"></span></i>
															Sistem Ayarları
														</a>
													</li>
													<li class="nav-item" role="presentation">
														<a class="nav-link text-active-primary d-flex align-items-center pb-5"
															data-bs-toggle="tab" href="#webhook" aria-selected="false"
															tabindex="-1" role="tab">
															<i class="ki-duotone ki-gear fs-2 me-2"><span
																	class="path1"></span><span
																	class="path2"></span><span class="path3"></span></i>
															Webhook Ayarları
														</a>
													</li>
												</ul>

												<?php

												$settingsQry = $db->query("SELECT * FROM `settings`");

												while ($settingsData = $settingsQry->fetch()) {
													$site_name = $settingsData['site_name'];
													$site_domain = $settingsData['site_domain'];
													$telegram = $settingsData['telegram'];
													$discord = $settingsData['discord'];
													$webhook = $settingsData['webhook'];
												}

												$ddosquery = $db->query("SELECT * FROM `rate_limit_exceptions`");

												while ($ddosdata = $ddosquery->fetch()) {
													$max_request = $ddosdata['max_request'];
													$second = $ddosdata['second'];
													$status = $ddosdata['status'];
												}

												$systemquery = $db->query("SELECT * FROM `systems`");

												while ($systemdata = $systemquery->fetch()) {
													$multiSystem = $systemdata['multiSystem'];
													$confirmationSystem = $systemdata['confirmationSystem'];
												}

												?>

												<div class="tab-content" id="myTabContent">

													<?php

													if (isset($_POST['settings'])) {
														$post_site_name = htmlspecialchars(strip_tags($_POST['site_name']));
														$post_site_domain = htmlspecialchars(strip_tags($_POST['site_domain']));
														$post_webhook = htmlspecialchars(strip_tags($_POST['webhook']));

														if (empty($post_site_name) || empty($post_site_domain) || empty($post_webhook)) {
															echo "<script>toastr.error('Boş alan olamaz.');</script>";
														} else {
															$update = $db->prepare("UPDATE `settings` SET `site_name` = ?, `site_domain` = ?, `webhook` = ?");
															if ($update->execute([$post_site_name, $post_site_domain, $post_webhook])) {
																echo "<script>toastr.success('Başarıyla güncellendi.');setTimeout(() => window.location.reload(), 1000);</script>";
															} else {
																echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
															}
														}
													}

													?>

													<div class="tab-pane fade show active" id="settings"
														role="tabpanel">
														<form action="" autocomplete="off" method="POST"
															id="settings_form"
															class="form fv-plugins-bootstrap5 fv-plugins-framework">
															<div class="row mb-7">
																<div class="col-md-9 offset-md-3">
																	<h2>Genel Ayarlar</h2>
																</div>
															</div>
															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Site Adı</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="site_name" value="<?= $site_name; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Site Domain</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="site_domain" value="<?= $site_domain; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Discord Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="webhook" value="<?= $webhook; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row py-5">
																<div class="col-md-9 offset-md-3">
																	<div class="d-flex">
																		<button type="submit" name="settings"
																			data-kt-ecommerce-settings-type="submit"
																			class="btn btn-primary me-3">
																			<span class="indicator-label">
																				Gönder
																			</span>
																		</button>
																		<button type="reset"
																			data-kt-ecommerce-settings-type="cancel"
																			class="btn btn-light ">
																			Sıfırla
																		</button>

																	</div>
																</div>
															</div>
														</form>
													</div>
													
													<div class="tab-pane fade show" id="social" role="tabpanel">

														<?php

														if (isset($_POST['social'])) {
															$post_discord = htmlspecialchars(strip_tags($_POST['discord']));
															$post_telegram = htmlspecialchars(strip_tags($_POST['telegram']));

															if (empty($post_discord) || empty($post_telegram)) {
																echo "<script>toastr.error('Boş alan olamaz.');</script>";
															} else {
																$update = $db->prepare("UPDATE `settings` SET `discord` = ?, `telegram` = ?");
																if ($update->execute([$post_discord, $post_telegram])) {
																	echo "<script>toastr.success('Başarıyla güncellendi.');setTimeout(() => window.location.reload(), 1000);</script>";
																} else {
																	echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
																}
															}
														}


														?>

														<form action="" autocomplete="off" method="POST"
															id="social_form"
															class="form fv-plugins-bootstrap5 fv-plugins-framework">
															<div class="row mb-7">
																<div class="col-md-9 offset-md-3">
																	<h2>Sosyal Bağlantılar</h2>
																</div>
															</div>
															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Discord Adresi</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="discord" value="<?= $discord; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Telegram Adresi</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="telegram" value="<?= $telegram; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row py-5">
																<div class="col-md-9 offset-md-3">
																	<div class="d-flex">
																		<button type="submit" name="social"
																			data-kt-ecommerce-settings-type="submit"
																			class="btn btn-primary me-3">
																			<span class="indicator-label">
																				Gönder
																			</span>
																		</button>
																		<button type="reset"
																			data-kt-ecommerce-settings-type="cancel"
																			class="btn btn-light ">
																			Sıfırla
																		</button>

																	</div>
																</div>
															</div>
														</form>
													</div>

													<div class="tab-pane fade show" id="webhook" role="tabpanel">

														<?php

														if (isset($_POST['webhook'])) {
															$web1 = htmlspecialchars(strip_tags($_POST['web1']));
															$web2 = htmlspecialchars(strip_tags($_POST['web2']));
															$web5 = htmlspecialchars(strip_tags($_POST['web5']));
															$web6 = htmlspecialchars(strip_tags($_POST['web6']));
															$web7 = htmlspecialchars(strip_tags($_POST['web7']));
															$web8 = htmlspecialchars(strip_tags($_POST['web8']));
															$web9 = htmlspecialchars(strip_tags($_POST['web9']));

															if (empty($web1) || empty($web2) || empty($web5) || empty($web6) || empty($web7) || empty($web8) || empty($web9)) {
																echo "<script>toastr.error('Boş alan olamaz.');</script>";
															} else {
																$update = $db->prepare("UPDATE `webhooks` SET `confirmationHook` = ?, `cookieChangeHook` = ?, `multiHook` = ?, `reportHook` = ?, `adminHook`= ? , `queryHook`= ? , `vipqueryHook`= ?");
																if ($update->execute([$web1, $web2, $web5, $web6, $web7, $web8, $web9])) {
																	echo "<script>toastr.success('Başarıyla güncellendi.');setTimeout(() => window.location.reload(), 1000);</script>";
																} else {
																	echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
																}
															}
														}


														?>

														<form action="" autocomplete="off" method="POST"
															id="webhook_form"
															class="form fv-plugins-bootstrap5 fv-plugins-framework">
															<div class="row mb-7">
																<div class="col-md-9 offset-md-3">
																	<h2>Webhook Bağlantıları</h2>
																</div>
															</div>
															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Confirmation Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web1" value="<?= $web1; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Cookie Change Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web2" value="<?= $web2; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Multi System Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web5" value="<?= $web5; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Report Log Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web6" value="<?= $web6; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>
															
															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Yetkili Log Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web7" value="<?= $web7; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Query Log Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web8" value="<?= $web8; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Premium Query Log Webhook</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="web9" value="<?= $web9; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row py-5">
																<div class="col-md-9 offset-md-3">
																	<div class="d-flex">
																		<button type="submit" name="webhook"
																			data-kt-ecommerce-settings-type="submit"
																			class="btn btn-primary me-3">
																			<span class="indicator-label">
																				Gönder
																			</span>
																		</button>
																		<button type="reset"
																			data-kt-ecommerce-settings-type="cancel"
																			class="btn btn-light ">
																			Sıfırla
																		</button>

																	</div>
																</div>
															</div>
														</form>
													</div>


													<?php

													if (isset($_POST['ddos'])) {
														$post_max_request = htmlspecialchars(strip_tags($_POST['max_request']));
														$post_second = htmlspecialchars(strip_tags($_POST['second']));
														$post_status = htmlspecialchars(strip_tags($_POST['status']));

														if (empty($post_max_request) || empty($post_second) || empty($post_status)) {
															echo "<script>toastr.error('Boş alan olamaz.');</script>";
														} else {
															$update = $db->prepare("UPDATE `rate_limit_exceptions` SET `max_request` = ?, `second` = ?, `status` = ?");
															if ($update->execute([$post_max_request, $post_second, $post_status])) {
																echo "<script>toastr.success('Başarıyla güncellendi.');setTimeout(() => window.location.reload(), 1000);</script>";
															} else {
																echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
															}
														}
													}


													?>
													<div class="tab-pane fade show" id="ddos" role="tabpanel">
														<form action="" autocomplete="off" method="POST" id="ddos_form"
															class="form fv-plugins-bootstrap5 fv-plugins-framework">
															<div class="row mb-7">
																<div class="col-md-9 offset-md-3">
																	<h2>DDoS Koruması</h2>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Durum</span>
																</div>

																<div class="col-md-9">
																	<select name="status"
																		class="form-control form-control-solid">
																		<?php

																		if ($status == "yes") {

																			?>
																			<option value="yes" selected>Aktif</option>
																			<option value="no">Kapalı</option>
																			<?php
																		} else {
																			?>
																			<option value="no" selected>Kapalı</option>
																			<option value="yes">Aktif</option>
																			<?php
																		}
																		?>
																	</select>
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Maximum İstek</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="max_request" value="<?= $max_request; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Saniye</span>
																</div>

																<div class="col-md-9">
																	<input type="text"
																		class="form-control form-control-solid"
																		name="second" value="<?= $second; ?>">
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>


															<div class="row py-5">
																<div class="col-md-9 offset-md-3">
																	<div class="d-flex">
																		<button type="submit" name="ddos"
																			data-kt-ecommerce-settings-type="submit"
																			class="btn btn-primary me-3">
																			<span class="indicator-label">
																				Gönder
																			</span>
																		</button>
																		<button type="reset"
																			data-kt-ecommerce-settings-type="cancel"
																			class="btn btn-light ">
																			Sıfırla
																		</button>

																	</div>
																</div>
															</div>
														</form>
													</div>

													<?php

                                                    if (isset($_POST['multi'])) {
                                                        $multiSystem = htmlspecialchars(strip_tags($_POST['multiStatus']));

                                                        $b = getbrowser();
                                                        $s = getsoftware();

                                                        if ($multiSystem == "no") {
                                                            sendLog("5", $ip, $b, $s, $web5);
                                                        }

                                                        $update = $db->prepare("UPDATE `systems` SET `multiSystem` = ?");
                                                        if ($update->execute([$multiSystem])) {
                                                            echo "<script>toastr.success('Başarıyla güncellendi.');setTimeout(() => window.location.reload(), 1000);</script>";

                                                            // Eğer multiSystem "yes" olarak ayarlanmışsa, bakım sayfasına yönlendir
                                                            if ($multiSystem == "yes") {
                                                                echo "<script>setTimeout(() => window.location.href = '/bakim', 1500);</script>";
                                                            }
                                                        } else {
                                                            echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
                                                        }
                                                    }


                                                    if (isset($_POST['confirmation'])) {
														$confirmationSystem = htmlspecialchars(strip_tags($_POST['confirmationStatus']));

														$b = getbrowser();
														$s = getsoftware();

														if ($confirmationSystem == "no") {
														 	sendLog("1", $ip, $b, $s, $web1);
														}

														$update = $db->prepare("UPDATE `systems` SET `confirmationSystem` = ?");
														if ($update->execute([$confirmationSystem])) {
															echo "<script>toastr.success('Başarıyla güncellendi.');setTimeout(() => window.location.reload(), 1000);</script>";
														} else {
															echo "<script>toastr.error('Güncelleme sırasında bir hata oluştu.');</script>";
														}

													}


													?>
													<div class="tab-pane fade show" id="system" role="tabpanel">
														<form action="" autocomplete="off" method="POST"
															id="system_forms"
															class="form fv-plugins-bootstrap5 fv-plugins-framework">
															<div class="row mb-7">
																<div class="col-md-9 offset-md-3">
																	<h2>Sistem Ayarları</h2>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Bakım Durumu</span>
																</div>

																<div class="col-md-9">
																	<select name="multiStatus"
																		class="form-control form-control-solid">
																		<?php

																		if ($multiSystem == "yes") {

																			?>
																			<option value="yes" selected>Aktif</option>
																			<option value="no">Kapalı</option>
																			<?php
																		} else {
																			?>
																			<option value="no" selected>Kapalı</option>
																			<option value="yes">Aktif</option>
																			<?php
																		}
																		?>
																	</select>
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row fv-row mb-7 fv-plugins-icon-container">
																<div class="col-md-3 text-md-end">
																	<label class="fs-6 fw-semibold form-label mt-3">
																		<span class="required">Onay Sistem
																			Durumu</span>
																</div>

																<div class="col-md-9">
																	<select name="confirmationStatus"
																		class="form-control form-control-solid">
																		<?php

																		if ($confirmationSystem == "yes") {

																			?>
																			<option value="yes" selected>Aktif</option>
																			<option value="no">Kapalı</option>
																			<?php
																		} else {
																			?>
																			<option value="no" selected>Kapalı</option>
																			<option value="yes">Aktif</option>
																			<?php
																		}
																		?>
																	</select>
																	<div
																		class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
																	</div>
																</div>
															</div>

															<div class="row py-5">
																<div class="col-md-9 offset-md-3">
																	<div class="d-flex">
																		<button type="submit" name="multi"
																			data-kt-ecommerce-settings-type="submit"
																			class="btn btn-primary me-3">
																			<span class="indicator-label">
																				Multi Sistemini Kaydet
																			</span>
																		</button>
																		<button type="submit" name="confirmation"
																			data-kt-ecommerce-settings-type="submit"
																			class="btn btn-primary me-3">
																			<span class="indicator-label">
																				Onay Sistemini Kaydet
																			</span>
																		</button>
																		<button type="reset"
																			data-kt-ecommerce-settings-type="cancel"
																			class="btn btn-light ">
																			Sıfırla
																		</button>

																	</div>
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
