<?php

include '../server/database.php';

$settingsQry = $db->query("SELECT * FROM `settings`");

while ($settingsData = $settingsQry->fetch()) {
    $telegram = $settingsData['telegram'];
    $discord = $settingsData['discord'];
    $site_domain = $settingsData['site_domain'];
    $site_name = $settingsData['site_name'];
    $webhookUrl = $settingsData['webhook'];
    $logo = $settingsData['logo'];
}

?>
<title><?= $site_name; ?> <3 </title>
<meta charset="utf-8">
<link rel="shortcut icon" href="<?= $logo; ?>">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="adil emre - Ücretsiz veya premium olarak sunduğumuz sorgu çözümlerimizden faydalanmak için sizde kayıt olarak 🤩">
<meta name="keywords" content="TC SORGU, ADRES SORGU, PLAKA SORGU, ÜCRETSİZ SORGU PANELİ, SORGU, VESİKA SORGU,">
<meta name="cryptomus" content="01e48a0b" />
<link href=".././assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css">
<link href=".././assets/css/style.bundleeeeee.css" rel="stylesheet" type="text/css">
<link href=".././assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css">
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>
    document.documentElement.setAttribute("data-bs-theme", "dark");

    document.addEventListener('keydown', event => {
        if (event.ctrlKey && event.key === 'u') {
            event.preventDefault();
            toastr.error("Güvenlik için CTRL + U tuşu engellenmiştir.");
        }
        if (event.ctrlKey && event.key === 's') {
            event.preventDefault();
            toastr.error("Güvenlik için CTRL + S tuşu engellenmiştir.");
        }
        if (event.key === 'F12') {
            event.preventDefault();
            toastr.error("Güvenlik için F12 tuşu engellenmiştir.");
        }

    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    // Maksimum çalışma süresini 30 dakika (1800000 milisaniye) olarak ayarlayın
    const max_execution_time = 1800000;

    // Başlangıç zamanını kaydedin
    let start_time = Date.now();

    // Javascript onayı için fonksiyon oluşturun
    function confirmExecution() {
        let confirmed = confirm("30 dakika boyunca herhangi bir işlem yapılmadı. Devam etmek istiyor musunuz?");
        if (confirmed) {
            // Kullanıcı devam etmek istiyor, başlangıç zamanını güncelleyin
            start_time = Date.now();
        } else {
            // Kullanıcı devam etmek istemiyor, scripti durdurun
            clearInterval(interval_id);
            window.location = '/logout/';
        }
    }

    // 30 dakikada bir javascript onayı isteyen fonksiyon
    function checkExecution() {
        if (Date.now() - start_time >= max_execution_time) {
            // Maksimum çalışma süresi aşıldı, javascript onayı isteyin
            confirmExecution();
        }
    }

    // İlk kontrolü yapın
    checkExecution();

    // 30 dakikada bir kontrol yapmak için setInterval kullanın
    const interval_id = setInterval(checkExecution, max_execution_time);
</script>
<script src=".././assets/plugins/global/plugins.bundle.js"></script>
<script src=".././assets/js/scripts.bundle.js"></script>