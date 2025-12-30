<?php

include "../../server/database.php";

$session = $_SESSION['GET_USER_SSID'];

$sql = $db->query("SELECT * FROM accounts WHERE hash = '$session'");

while ($data = $sql->fetch()) {
    $pin = $data['pin_claim'];
}

echo $pin;


?>