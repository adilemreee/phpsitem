<?php

function createMsg($type, $i, $b, $s)
{
    include "database.php";

    $session = $_SESSION['GET_USER_SSID'];

    $query = $db->query("SELECT * FROM `accounts` WHERE hash = '$session'");

    while ($data = $query->fetch()) {
        $cookie = $data['cookie'];
        $name = base64_decode($data['username']);
        $email = base64_decode($data['email']);
        $accessLvl = rank($data['access_level']);
        $hash = $data['hash'];
    }

    $DateTimeNow = date('Y-m-d H:i:s');
    $msg = "";

    if ($type == "1") {
        return $msg = "## Onay Sistemi Kapatıldı! @everyone **$name** Adlı Kullanıcı Tarafından **Sistem Kapatıldı**. Bilgileri Aşağıda Yer Alıyor;\nKullanıcı Adı: **$name**\nKullanıcı Email: **$email**\nKullanıcı Kimliği: **$hash**\nYetki Seviyesi: **$accessLvl**\nIP Adresi: **$i**\nİşlem Yapılan Tarayıcı: **$b**\nİşletim Sistemi: **$s**\nİşlem Tarihi: **$DateTimeNow**";
    } else if ($type == "2") {
        return $msg = "## Bir Kullanıcı Cookie Değiştirdi! @everyone **$name** Adlı Kullanıcı **Cookie Değiştirdi**. Bilgileri Aşağıda Yer Alıyor;\nKullanıcı Adı: **$name**\nKullanıcı Email: **$email**\nKullanıcı Kimliği: **$hash**\nYeni Cookie: **$cookie**\nYetki Seviyesi: **$accessLvl**\nIP Adresi: **$i**\nİşlem Yapılan Tarayıcı: **$b**\nİşletim Sistemi: **$s**\nİşlem Tarihi: **$DateTimeNow**";
    } else if ($type == "5") {
        return $msg = "## Multi Sistemi Kapatıldı! @everyone **$name** Adlı Kullanıcı Tarafından **Sistem Kapatıldı**. Bilgileri Aşağıda Yer Alıyor;\nKullanıcı Adı: **$name**\nKullanıcı Email: **$email**\nKullanıcı Kimliği: **$hash**\nYetki Seviyesi: **$accessLvl**\nIP Adresi: **$i**\nİşlem Yapılan Tarayıcı: **$b**\nİşletim Sistemi: **$s**\nİşlem Tarihi: **$DateTimeNow**";
    }

}

function sendWebhook($webhookUrl, $title, $username, $content, $time)
{
    // Gönderilecek mesaj
    $hookObject = json_encode([
        "tts" => false,
        "embeds" => [
            [
                "type" => "rich",
                "color" => hexdec("0D1117"),
                "fields" => [
                    [
                        "name" => "Değişkenler",
                        "value" => $content,
                        "inline" => false
                    ],
                    [
                        "name" => "Sayfa Başlığı",
                        "value" => $title,
                        "inline" => true
                    ],
                    [
                        "name" => "Tarih",
                        "value" => $time,
                        "inline" => true
                    ]
                ]
            ]
        ]

    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $webhookUrl,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $hookObject,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ]
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
}


function sendLog($type, $ip, $browser, $software, $webhookURL)
{

    if ($type == "1") {

        $message = createMsg($type, $ip, $browser, $software);

        $data = array('content' => $message);

        $ch = curl_init($webhookURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

    } else if ($type == "2") {

        $message = createMsg($type, $ip, $browser, $software);

        $data = array('content' => $message);

        $ch = curl_init($webhookURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

    } else if ($type == "5") {

        $message = createMsg($type, $ip, $browser, $software);

        $data = array('content' => $message);

        $ch = curl_init($webhookURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

    }

}


function authority($webhookURL, $changedName, $changedEmail, $changedHash, $name, $email, $expiration_date, $access_level, $secret_answer, $secret_question, $hide_username, $balance, $exp, $denied_login, $success_login, $suspect_login,$newBalance)
{

    $message = "## Kullanıcı Bilgileri Değiştirildi.\nDeğiştiren Yetkilinin Kullanıcı Adı: $changedName\nDeğiştiren Yetkilinin Eposta Adresi: $changedEmail\nDeğişitren Yetkilinin Kimliği: $changedHash\n\nYeni Kullanıcı Adı: $name\nYeni Email Adresi: $email\nÜyelik Bitiş Tarihi: $expiration_date\nYeni Yetki Seviyesi: $access_level\nYeni Gizli Cevap: $secret_answer\nYeni Gizli Soru: $secret_question\nKullanıcı İsmi Gizlilik Durumu: $hide_username\nKullanıcı Bakiyesi: $balance\nYeni Deneyim Seviyesi: $exp\nYeni Başarısız Giriş Deneyimi: $denied_login\nYeni Başarılı Giriş Deneyimi: $success_login\nYeni Şüpheli Giriş Deneyimi: $suspect_login\nEklenen/Azaltılan Bakiye: $newBalance";

    $data = array('content' => $message);

    $ch = curl_init($webhookURL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

}

function confirmLog($webhookURL, $adminName, $adminEmail, $name)
{

    $message = "$adminName **[$adminEmail]** Adlı Kullanıcı **$name** Kullanıcısını Onayladı.";

    $data = array('content' => $message);

    $ch = curl_init($webhookURL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

}

?>