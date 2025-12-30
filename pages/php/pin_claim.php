<?php

include "../../server/database.php";

$session = $_SESSION['GET_USER_SSID'];

$sql = $db->query("SELECT * FROM accounts WHERE hash = '$session'");

while ($data = $sql->fetch()) {
    $pin = $data['pin_claim'];
}

$newPinClaim = $pin - 1;

$sql2 = $db->query("UPDATE `accounts` SET `pin_claim`='$newPinClaim' WHERE `hash` = '$session'");

echo $newPinClaim;


?>