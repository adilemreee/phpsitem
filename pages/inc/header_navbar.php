<div id="kt_header" class="header align-items-stretch">
    <div class="header-brand">
        <a href="home">
            <img alt="Logo" src="../assets/img/logoadilemre.png" class="img-fluid" style="max-width: 30px;">

            <span class="fs-3 font-bold m-4 text-white">ADİL EMRE</span>
        </a>
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-minimize" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <i class="ki-duotone ki-entrance-right fs-1 me-n1 minimize-default"><span class="path1"></span><span class="path2"></span></i>
            <i class="ki-duotone ki-entrance-left fs-1 minimize-active"><span class="path1"></span><span class="path2"></span></i>
        </div>
        <div class="d-flex align-items-center d-lg-none me-n2" title="Show aside menu">
            <div class="btn btn-icon btn-active-color-primary w-30px h-30px" id="kt_aside_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span class="path2"></span></i>
            </div>
        </div>
    </div>
    <div class="toolbar d-flex align-items-stretch">
        <div class="container-xxl  py-6 py-lg-0 d-flex flex-column flex-lg-row align-items-lg-stretch justify-content-lg-between">
            <div class="page-title d-flex justify-content-center flex-column me-5">
                <h1 class="d-flex flex-column text-white fw-bold fs-3 mb-0">
                    <?= $page_title; ?> </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="home" class="text-muted text-hover-primary">
                            Ana Sayfa </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-300 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-white">
                        <?= $page_title; ?>
                    </li>
                </ul>
            </div>
            <div id="kt_header_search" class="header-search d-flex align-items-center topbar-search w-lg-325px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end" data-kt-search="true">
                <div data-kt-search-element="toggle" class="search-toggle-mobile d-flex d-lg-none align-items-center">
                    <div class="d-flex btn btn-icon btn-icon-gray-300 w-30px h-30px w-md-40px h-md-40px">
                        <i class="ki-duotone ki-magnifier fs-1 "><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form action="notification" method="GET" data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                    <input type="hidden">
                    <i class="ki-duotone ki-magnifier fs-2 fs-lg-3 text-gray-800 position-absolute top-50 translate-middle-y ms-5"><span class="path1"></span><span class="path2"></span></i> <!--end::Icon-->
                    <input type="text" class="search-input form-control form-control-solid ps-13" name="search" value="" placeholder="Ara" data-kt-search-element="input">
                    <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
                        <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                    </span>
                    <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
                        <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0"><span class="path1"></span><span class="path2"></span></i> </span>
                </form>
            </div>
            <div class="d-flex align-items-stretch overflow-auto pt-3 pt-lg-0">

             <div class="d-flex align-items-center ms-2 ms-lg-3">
                    <div class="menu-item">                  
                    <?php 
                        $next_spin_timee = strtotime('+1 day', $ts_last_spin);
                        if ($next_spin_timee < time()) { 
                                echo "<span class='bullet bullet-dot bg-success h-9px w-9px position-absolute translate-middle top-60 start-90 animation-blink'></span>"; 
                          } 
                          ?>      
                               <a href="hediyecarki" class="menu-link px-4">  

                                    <img src="https://i.hizliresim.com/svp8yqi.png" width="25">


                                </a>
                            </div>
                        </div>
                <div class="topbar d-flex align-items-stretch flex-shrink-0" id="kt_topbar">

                    <div class="d-flex align-items-center ms-2 ms-lg-3">
                    </div>
                                    <div class="d-flex align-items-center ms-2 ms-lg-2">
                    <div class="d-flex text-center flex-column text-white">
                        <span class="fw-semibold fs-9">Toplam Bakiye</span>
                        <?php

                        if ($balance == 0) {
                            $getBalanceColor = "text-danger";
                        } else {
                            $getBalanceColor = "text-success";
                        }

                        ?>
                        <span class="fw-bold fs-9 pt-1 Toplam Bakiye <?= $getBalanceColor; ?>"><?= $balance; ?>.00 TL</span>
                    </div>
                </div>

                    <div class="d-flex align-items-center ms-2 ms-lg-3">
                        <div onclick="window.location = 'market'" class="btn btn-icon btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-basket fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                        </div>
                    </div>

                    <div class="d-flex align-items-center ms-2 ms-lg-3">
                        <div onclick="window.location = 'statistics'" class="btn btn-icon btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_activities_toggle">
                            <i class="ki-duotone ki-chart-simple fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                        </div>
                    </div>

                    <div class="d-flex align-items-center ms-2 ms-lg-3">
                        <div onclick="window.location = 'overview'" class="btn btn-icon btn-custom w-30px h-30px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-user fs-2"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="d-flex align-items-center ms-2 ms-lg-3">
                        <div class="btn btn-icon btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-notification fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                        </div>

                        <?php

                        $newsQuery = $db->query("SELECT * FROM `news`");
                        $newsCount = $newsQuery->rowCount();

                        ?>
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('/metronic8/demo19/assets/media/misc/menu-header-bg.jpg')">
                                <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                                    Bildirimleriniz &nbsp;<span class="badge badge-light-primary"><?= $newsCount; ?> bildirim</span>
                                </h3>

                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1" aria-selected="false" tabindex="-1" role="tab">Hepsi</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_2" aria-selected="true" role="tab">Duyurular</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3" aria-selected="true" role="tab">Etkinlikler</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 " data-bs-toggle="tab" href="#kt_topbar_notifications_4" aria-selected="true" role="tab">Bakım Notu</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <?php

                                        $newsCheck = $db->query("SELECT * FROM `news` ORDER BY id DESC LIMIT 7");

                                        while ($newsData = $newsCheck->fetch()) {


                                            if ($newsData['type'] == "event") {
                                                $icon = "ki-notification";
                                                $class = "warning";
                                            } else if ($newsData['type'] == "news") {
                                                $icon = "ki-notification-bing";
                                                $class = "primary";
                                            } else {
                                                $icon = "ki-notification-status";
                                                $class = "success";
                                            }

                                            ?>
                                            <div class="d-flex flex-stack py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-4">
                                                        <span class="symbol-label bg-light-<?= $class; ?>">
                                                            <i class="ki-duotone <?= $icon; ?> fs-2 text-<?= $class; ?>">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                                <span class="path7"></span>
                                                                <span class="path8"></span>
                                                                <span class="path9"></span>
                                                                <span class="path10"></span>
                                                                <span class="path11"></span>
                                                                <span class="path12"></span>
                                                                <span class="path13"></span>
                                                                <span class="path14"></span>
                                                                <span class="path15"></span>
                                                                <span class="path16"></span>
                                                                <span class="path17"></span>
                                                                <span class="path18"></span>
                                                                <span class="path19"></span>
                                                                <span class="path20"></span>
                                                                <span class="path21"></span>
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div class="mb-0 me-2">
                                                        <a href="view?hex=<?= $newsData['hash']; ?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?= $newsData['title']; ?></a>
                                                    </div>
                                                </div>
                                                <span class="badge badge-light fs-8">
                                                    <?php

                                                    echo $newsData['history'];

                                                    ?>
                                                </span>
                                            </div>
                                        <?php

                                        }

                                        ?>
                                    </div>

                                    <div class="py-3 text-center border-top">
                                        <a href="notification" class="btn btn-color-gray-600 btn-active-color-primary">Hepsini Görüntüle <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span class="path2"></span></i> </a>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="kt_topbar_notifications_2" role="tabpanel">
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <?php

                                        $newsCheck = $db->query("SELECT * FROM `news` WHERE type = 'news' ORDER BY id DESC LIMIT 7");

                                        while ($newsData = $newsCheck->fetch()) {


                                            if ($newsData['type'] == "event") {
                                                $icon = "ki-notification";
                                                $class = "warning";
                                            } else if ($newsData['type'] == "news") {
                                                $icon = "ki-notification-bing";
                                                $class = "primary";
                                            } else {
                                                $icon = "ki-notification-status";
                                                $class = "success";
                                            }

                                            ?>
                                            <div class="d-flex flex-stack py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-4">
                                                        <span class="symbol-label bg-light-<?= $class; ?>">
                                                            <i class="ki-duotone <?= $icon; ?> fs-2 text-<?= $class; ?>">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                                <span class="path7"></span>
                                                                <span class="path8"></span>
                                                                <span class="path9"></span>
                                                                <span class="path10"></span>
                                                                <span class="path11"></span>
                                                                <span class="path12"></span>
                                                                <span class="path13"></span>
                                                                <span class="path14"></span>
                                                                <span class="path15"></span>
                                                                <span class="path16"></span>
                                                                <span class="path17"></span>
                                                                <span class="path18"></span>
                                                                <span class="path19"></span>
                                                                <span class="path20"></span>
                                                                <span class="path21"></span>
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div class="mb-0 me-2">
                                                        <a href="view?hex=<?= $newsData['hash']; ?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?= $newsData['title']; ?></a>
                                                    </div>
                                                </div>
                                                <span class="badge badge-light fs-8">
                                                    <?php

                                                    echo $newsData['history'];

                                                    ?>
                                                </span>
                                            </div>
                                        <?php

                                        }

                                        ?>
                                    </div>

                                    <div class="py-3 text-center border-top">
                                        <a href="notification" class="btn btn-color-gray-600 btn-active-color-primary">Hepsini Görüntüle <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span class="path2"></span></i> </a>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="kt_topbar_notifications_3" role="tabpanel">
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <?php

                                        $newsCheck = $db->query("SELECT * FROM `news` WHERE type = 'event' ORDER BY id DESC LIMIT 7");

                                        while ($newsData = $newsCheck->fetch()) {


                                            if ($newsData['type'] == "event") {
                                                $icon = "ki-notification";
                                                $class = "warning";
                                            } else if ($newsData['type'] == "news") {
                                                $icon = "ki-notification-bing";
                                                $class = "primary";
                                            } else {
                                                $icon = "ki-notification-status";
                                                $class = "success";
                                            }

                                            ?>
                                            <div class="d-flex flex-stack py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-4">
                                                        <span class="symbol-label bg-light-<?= $class; ?>">
                                                            <i class="ki-duotone <?= $icon; ?> fs-2 text-<?= $class; ?>">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                                <span class="path7"></span>
                                                                <span class="path8"></span>
                                                                <span class="path9"></span>
                                                                <span class="path10"></span>
                                                                <span class="path11"></span>
                                                                <span class="path12"></span>
                                                                <span class="path13"></span>
                                                                <span class="path14"></span>
                                                                <span class="path15"></span>
                                                                <span class="path16"></span>
                                                                <span class="path17"></span>
                                                                <span class="path18"></span>
                                                                <span class="path19"></span>
                                                                <span class="path20"></span>
                                                                <span class="path21"></span>
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div class="mb-0 me-2">
                                                        <a href="view?hex=<?= $newsData['hash']; ?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?= $newsData['title']; ?></a>
                                                    </div>
                                                </div>
                                                <span class="badge badge-light fs-8">
                                                    <?php

                                                    echo $newsData['history'];

                                                    ?>
                                                </span>
                                            </div>
                                        <?php

                                        }

                                        ?>
                                    </div>

                                    <div class="py-3 text-center border-top">
                                        <a href="notification" class="btn btn-color-gray-600 btn-active-color-primary">Hepsini Görüntüle <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span class="path2"></span></i> </a>
                                    </div>
                                </div>
                                <div class="tab-pane fade show" id="kt_topbar_notifications_4" role="tabpanel">
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <?php

                                        $newsCheck = $db->query("SELECT * FROM `news` WHERE type = 'update' ORDER BY id DESC LIMIT 7");

                                        while ($newsData = $newsCheck->fetch()) {


                                            if ($newsData['type'] == "event") {
                                                $icon = "ki-notification";
                                                $class = "warning";
                                            } else if ($newsData['type'] == "news") {
                                                $icon = "ki-notification-bing";
                                                $class = "primary";
                                            } else {
                                                $icon = "ki-notification-status";
                                                $class = "success";
                                            }

                                            ?>
                                            <div class="d-flex flex-stack py-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-35px me-4">
                                                        <span class="symbol-label bg-light-<?= $class; ?>">
                                                            <i class="ki-duotone <?= $icon; ?> fs-2 text-<?= $class; ?>">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                                <span class="path7"></span>
                                                                <span class="path8"></span>
                                                                <span class="path9"></span>
                                                                <span class="path10"></span>
                                                                <span class="path11"></span>
                                                                <span class="path12"></span>
                                                                <span class="path13"></span>
                                                                <span class="path14"></span>
                                                                <span class="path15"></span>
                                                                <span class="path16"></span>
                                                                <span class="path17"></span>
                                                                <span class="path18"></span>
                                                                <span class="path19"></span>
                                                                <span class="path20"></span>
                                                                <span class="path21"></span>
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div class="mb-0 me-2">
                                                        <a href="view?hex=<?= $newsData['hash']; ?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?= $newsData['title']; ?></a>
                                                    </div>
                                                </div>
                                                <span class="badge badge-light fs-8">
                                                    <?php

                                                    echo $newsData['history'];

                                                    ?>
                                                </span>
                                            </div>
                                        <?php

                                        }

                                        ?>
                                    </div>

                                    <div class="py-3 text-center border-top">
                                        <a href="notification" class="btn btn-color-gray-600 btn-active-color-primary">Hepsini Görüntüle <i class="ki-duotone ki-arrow-right fs-5"><span class="path1"></span><span class="path2"></span></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center ms-2 ms-lg-3 d-flex align-items-center">
                    <a href="#" class="btn btn-sm btn-icon btn-icon-muted btn-active-icon-primary" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day theme-light-show fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span></i> <i class="ki-duotone ki-moon theme-dark-show fs-1"><span class="path1"></span><span class="path2"></span></i></a>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <div class="menu-item px-1 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-night-day fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span></i> </span>
                                <span class="menu-title">
                                    Aydınlık Tema
                                </span>
                            </a>
                        </div>
                        <div class="menu-item px-1 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span class="path2"></span></i> </span>
                                <span class="menu-title">
                                    Karanlık Tema
                                </span>
                            </a>
                        </div>
                        <div class="menu-item px-1 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-screen fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i> </span>
                                <span class="menu-title">
                                    Sistem Rengi
                                </span>
                            </a>
                        </div>
                    </div>
                                                        <div class="d-flex align-items-center ms-2 ms-lg-3">
                        <div onclick="window.location = 'logout'" class="btn btn-icon btn-custom w-30px h-30px w-md-40px h-md-40px position-relative" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-duotone ki-toggle-off fs-2"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>