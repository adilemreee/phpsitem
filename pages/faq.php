<?php

include '../server/database.php';

include '../server/rolecontrol.php';

$page_title = "Sıkça Sorulan Sorular";

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
<img src="../assets/img/welcome2.png" style="width: 100%;height: 430px;object-fit: cover;border-radius: 8px;" alt="">

											<div class="card-body">
												<div class="row mb-12">

        <!--begin::Col-->
        <div class="col-md-4 pe-md-10 mb-10 mb-md-0">
            <!--begin::Title-->
            <h2 class="text-gray-800 fw-bold mb-4">                           
                Sistem Süreci          
            </h2>
            <!--end::Title-->
            
            <!--begin::Accordion-->
 
    
    <!--begin::Section-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_4_1">
            <!--begin::Icon-->
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1"><span class="path1"></span><span class="path2"></span></i>                
                <i class="ki-duotone ki-plus-square toggle-off fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 
            </div>
            <!--end::Icon-->
            
            <!--begin::Title-->
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">                           
                Çözümlerinizi nasıl kullanabilirim?                              
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->  

        <!--begin::Body-->
        <div id="kt_job_4_1" class="collapse fs-6 ms-1">
                            <!--begin::Text-->
                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                    Sidebar kısmında bulunan çözümlerimizi kullanabilmeniz için ücretsiz üyeliğinizin olması yeterlidir, eğer ek özelliklere sahip olmak istiyorsanız Market kısmından premium üyelik satın alabilirsiniz.              </div>
                <!--end::Text-->
                    </div>                
        <!--end::Content-->

        
        <!--begin::Separator-->
        <div class="separator separator-dashed"></div>
        <!--end::Separator-->
            </div>
    <!--end::Section-->
 
    
    <!--begin::Section-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_4_2">
            <!--begin::Icon-->
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1"><span class="path1"></span><span class="path2"></span></i>                
                <i class="ki-duotone ki-plus-square toggle-off fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 
            </div>
            <!--end::Icon-->
            
            <!--begin::Title-->
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">                           
                Sizlere her türlü iş için ulaşabilir miyiz?                               
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->  

        <!--begin::Body-->
        <div id="kt_job_4_2" class="collapse  fs-6 ms-1">
                            <!--begin::Text-->
                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                    Bizlere her türlü iş için ulaşabilirsiniz, bizler sizin hayatınızı kolaylaştırmak için hizmetlerimizi üst düzeye çıkarmayı planlıyoruz. Aklınıza gelebilecek herşey için sordurabilirsiniz. <a href="https://t.me/biripolisiarasin" target="_blank" rel="nofollow"><span style="text-shadow: #ff0000 0px 0px 2px;"><font color="red"><b>@biripolisiarasin</b></font></a> </div>
                <!--end::Text-->
                    </div>                
        <!--end::Content-->

        
        <!--begin::Separator-->
        <div class="separator separator-dashed"></div>
        <!--end::Separator-->
            </div>
    <!--end::Section-->
 
    
    <!--begin::Section-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_4_3">
            <!--begin::Icon-->
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1"><span class="path1"></span><span class="path2"></span></i>                
                <i class="ki-duotone ki-plus-square toggle-off fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 
            </div>
            <!--end::Icon-->
            
            <!--begin::Title-->
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">                           
                Bayilik süreci nasıl işliyor?                           
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->  

        <!--begin::Body-->
        <div id="kt_job_4_3" class="collapse  fs-6 ms-1">
                            <!--begin::Text-->
                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                    Eğer bizim alt bayimiz olursanız artık sizde premium üyelik satışlarına başlayabileceksiniz, kendi topluluğunuz veya kendi kitlenize sitemizde premium üyelik satabilirsiniz. Bunu yapmanız için ufak bir teminat yatırmanız gerekte yani bayilik sistemini satın almanız gerekmekte.               </div>
                <!--end::Text-->
                    </div>                

                </div>
        </div>
                <div class="col-md-4 pe-md-10 mb-10 mb-md-0">
            <!--begin::Title-->
            <h2 class="text-gray-800 fw-bold mb-4">                           
                Ödeme Süreci        
            </h2>
            <!--end::Title-->
            
            <!--begin::Accordion-->
 
    
    <!--begin::Section-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_4_5">
            <!--begin::Icon-->
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1"><span class="path1"></span><span class="path2"></span></i>                
                <i class="ki-duotone ki-plus-square toggle-off fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 
            </div>
            <!--end::Icon-->
            
            <!--begin::Title-->
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">                           
                Ödeme yaptım, süreç nasıl işliyor?                          
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->  

        <!--begin::Body-->
        <div id="kt_job_4_5" class="collapse fs-6 ms-1">
                            <!--begin::Text-->
                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                    Ödeme talepleriniz bize yollandıktan sonra kontrol aşamasına geçiyoruz, bu süreç 5-10 dakika arası sürüyor, kontrolleri sağladıktan sonra ödeme talebiniz onaylanarak sistemin otomatik olarak bakiyeyi aktarıyor. </div>
                <!--end::Text-->
                    </div>                
        <!--end::Content-->

        
        <!--begin::Separator-->
        <div class="separator separator-dashed"></div>
        <!--end::Separator-->
            </div>
    <!--end::Section-->
 
    
    <!--begin::Section-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_4_6">
            <!--begin::Icon-->
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1"><span class="path1"></span><span class="path2"></span></i>                
                <i class="ki-duotone ki-plus-square toggle-off fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 
            </div>
            <!--end::Icon-->
            
            <!--begin::Title-->
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">                           
                Bakiyem eklendikten sonra nasıl satın alım yapabilirim?                             
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->  

        <!--begin::Body-->
        <div id="kt_job_4_6" class="collapse  fs-6 ms-1">
                            <!--begin::Text-->
                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                    Bakiyeniz sisteme işlendikten sonra market kısmına giderek bakiyenizin yettiği, seçmek istediğiniz ürünün altında bulunan Satın Al butonuna tıklayarak otomatik olarak satın alma işlemini gerçekleştirebilirsiniz.               </div>
                <!--end::Text-->
                    </div>                
        <!--end::Content-->

        
        <!--begin::Separator-->
        <div class="separator separator-dashed"></div>
        <!--end::Separator-->
            </div>
    <!--end::Section-->
 
    
    <!--begin::Section-->
    <div class="m-0">
        <!--begin::Heading-->
        <div class="d-flex align-items-center collapsible py-3 toggle collapsed mb-0" data-bs-toggle="collapse" data-bs-target="#kt_job_4_7">
            <!--begin::Icon-->
            <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-duotone ki-minus-square toggle-on text-primary fs-1"><span class="path1"></span><span class="path2"></span></i>                
                <i class="ki-duotone ki-plus-square toggle-off fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> 
            </div>
            <!--end::Icon-->
            
            <!--begin::Title-->
            <h4 class="text-gray-700 fw-bold cursor-pointer mb-0">                           
                Bir sorun durumunda sizlere nasıl ulaşabilirim?                                
            </h4>
            <!--end::Title-->
        </div>
        <!--end::Heading-->  

        <!--begin::Body-->
        <div id="kt_job_4_7" class="collapse  fs-6 ms-1">
                            <!--begin::Text-->
                <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                    Bir sorun durumunda telegramda isimlerimiz bulunuyor, <a href="https://t.me/biripolisiarasin" target="_blank" rel="nofollow"><span style="text-shadow: #ff0000 0px 0px 2px;"><font color="red"><b>@biripolisiarasin</b></font></a> isimli telegram hesabına ulaşarak sorununuzu bire bir çözdürebilirsiniz.               </div>
                <!--end::Text-->
                    </div>                

                </div>
        </div>	<div class="col-md-4 pe-md-10 mb-10 mb-md-0">
        											<br>
												<h1>Sıkça Sorulan Sorular (S.S.S)</h1>
												<br>

												<div class="accordion" id="accordionExample">
													<div class="accordion-item">
														<h2 class="accordion-header">
															<button class="accordion-button collapsed" type="button"
																data-bs-toggle="collapse" data-bs-target="#collapseOne"
																aria-expanded="false" aria-controls="collapseOne">
																Kullanıcı verilerim nasıl tutuluyor, başıma bir iş gelir mi?
															</button>
														</h2>
														<div id="collapseOne" class="accordion-collapse collapse"
															data-bs-parent="#accordionExample">
															<div class="accordion-body">
																Kullanıcı verileriniz veritabanımızda md5 olarak şifrelenerek işlenmektedir, çözülmesi zor bir şifreleme türüdür. Ekstra olarak sistemimizden istediğiniz zaman kendinizi sildirme özelliğini Profil > Hesabımı Sil kısmında sizlere sunuyoruz.
															</div>
														</div>
													</div>

												</div>

											</div>


										</div>
									</div>


								</div>
							</div>
													<div class="card mb-4 bg-light text-center ">
    <div class="card-body py-6">
        <a href="https://t.me/ezikworld" target=”_blank”  rel="nofollow" class="mx-4">
            <img src="../assets/img/telegram2.png" class="h-30px my-2" alt=""/>  
        </a>

        <!--begin::Icon-->
        <a href="https://discord.gg/ezik" target=”_blank” rel="nofollow" class="mx-4">
            <img src="../assets/img/discord.png" class="h-30px my-2" alt=""/>  
        </a>

    </div>
    <!--end::Body-->     
</div>
<!--end::Card-->       
    </div>
    <!--end::Body-->
</div>
<!--end::FAQ card-->
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