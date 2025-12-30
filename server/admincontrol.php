<?php

include 'database.php';

$adminSessionID = $_SESSION['GET_USER_SSID'];

$adminQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$adminSessionID'");

while ($adminData = $adminQuery->fetch()) {
    $adminRole = $adminData['access_level'];

    if ($adminRole !== "6") {
        exit('Erişiminiz yok!');
        die();
    }
}

?>