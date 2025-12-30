<?php

error_reporting(0);

session_start();

date_default_timezone_set('Europe/Istanbul');

// include 'ratelimit.php';

$userAgent = $_SERVER['HTTP_USER_AGENT'];

if ($userAgent == "" || $userAgent == '' || $userAgent == null || empty($userAgent)) {
	exit;
	die;
}

$serverName = "YOUR_SERVER_NAME"; // e.g., localhost:8889
$username = "YOUR_USERNAME"; // e.g., root
$password = "YOUR_PASSWORD"; // e.g., root
$dbName = "YOUR_DB_NAME"; // e.g., ezik2024

try {
	$db = new PDO("mysql:host=$serverName;dbname=$dbName", $username, $password);
} catch (PDOException $ex) {
	echo "Veritabanına istek gönderilirken bir hata oluştu. Bağlantı bilgilerini kontrol edin.";
	exit;
}
