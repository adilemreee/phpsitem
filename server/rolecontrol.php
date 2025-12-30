<?php

include 'database.php';

$SessionID = $_SESSION['GET_USER_SSID'];

$SessionQuery = $db->query("SELECT * FROM `accounts` WHERE hash = '$SessionID'");

$SessionCount = $SessionQuery->rowCount();

while ($SessionData = $SessionQuery->fetch()) {
    $BanValue = $SessionData['access_level'];
    $premiumvalue = $SessionData['premium'];
}

if ($SessionID == "" || $SessionCount != 1) {
    Header("location: ../login/");
    exit;
} else if ($SessionCount == 1 && $BanValue == "-1") {
    Header("location: ../logout");
    exit;
} else {
    $systemStmt = $db->query("SELECT multiSystem FROM `systems` LIMIT 1");
    $systemData = $systemStmt->fetch(PDO::FETCH_ASSOC);
    $multiSystem = $systemData['multiSystem'] ?? 'no';

    if ($multiSystem === "yes" && $BanValue < 6) {
        Header("location: ../bakim");
        exit;
    }

    $DateTimeNow = date('Y-m-d H:i:s');
    $stmt = $db->prepare("UPDATE `accounts` SET last_login_time = :last_login_time WHERE hash = :hash");
    $stmt->bindParam(':last_login_time', $DateTimeNow);
    $stmt->bindParam(':hash', $SessionID);
    $stmt->execute();
}


?>
