<?php

include 'database.php';

$SessionID = $_SESSION['GET_USER_SSID'];

$SessionQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$SessionID'");

$SessionCount = $SessionQuery->rowCount();

while ($SessionData = $SessionQuery->fetch()) {
    $premium = $SessionData['premium'];
    $access_level = $SessionData['access_level'];
}

$zaman = time();
$olacak = 0;

if ($premium < time() && $premium > 0) {
    $stmt = $db->prepare("UPDATE `accounts` SET access_level = :access, premium = :premium WHERE hash = :hash");
    $stmt->bindParam(':access', $olacak);
    $stmt->bindParam(':premium', $olacak);
    $stmt->bindParam(':hash', $SessionID);
    $stmt->execute();
}

if ($access_level != 6 && $premium < time()) {
    Header("location: ../buy");
    exit;
} 

?>