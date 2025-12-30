<?php

include 'database.php';

$sessionId = $_SESSION['GET_USER_SSID'] ?? null;

if (empty($sessionId)) {
    Header("location: ../login");
    exit;
}

$stmt = $db->prepare("SELECT access_level, premium FROM `accounts` WHERE hash = :hash LIMIT 1");
$stmt->bindParam(':hash', $sessionId);
$stmt->execute();
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    Header("location: ../login");
    exit;
}

$accessLevel = (int)$account['access_level'];
$premiumUntil = (int)$account['premium'];

if ($accessLevel != 6 && $premiumUntil < time()) {
    Header("location: ../buy");
    exit;
}

?>
