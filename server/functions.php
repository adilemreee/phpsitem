<?php

function rank($access_level)
{
    if ($access_level = 6) {
        $rank = "Admin";
    } else if ($access_level = 5) {
        $rank = "Premium Üye";
    } else if ($access_level = 4) {
        $rank = "V.I.P Üye";
    } else if ($access_level <= 3) {
        $rank = "Normal Üye";
    }
    return $rank;
}

function getbrowser()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $browsers = array(
        'Google Chrome' => 'Chrome',
        'Firefox' => 'Firefox',
        'Safari' => 'Safari',
        'Microsoft Edge' => 'Edge',
        'Opera' => 'Opera',
        'Internet Explorer' => 'MSIE|Trident',
    );
    foreach ($browsers as $browser => $pattern) {
        if (preg_match('/\b(' . $pattern . ')\b/i', $userAgent)) {
            return $browser;
        }
    }
    return 'Bilinmeyen Tarayıcı';
}

function getsoftware()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android Device',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile Device'
    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

function totalLog($h)
{
    include 'database.php';
    $sql = $db->query("SELECT * FROM query WHERE queryHash = '$h'");

    while ($data = $sql->fetch()) {

        $queryTotal = $data['queryTotal'];
        $queryHash = $data['queryHash'];
        $queryName = $data['queryName'];

    }

    $newTotal = $queryTotal + 1;

    $upd = $db->query("UPDATE `query` SET `queryTotal`= $newTotal WHERE queryHash = '$queryHash'");
}

function countAdd()
{

    include "database.php";

    $session = $_SESSION['GET_USER_SSID'];

    $query = $db->query("SELECT * FROM `accounts` WHERE hash = '$session'");

    while ($data = $query->fetch()) {
        $totalQuery = $data['total_query'];
        $hash = $data['hash'];
    }

    $newTotalQuery = $totalQuery + 1;

    $upd = $db->query("UPDATE `accounts` SET `total_query`= $newTotalQuery WHERE hash = '$hash'");
    

}

?>