<?php

header('Content-Type: application/json; charset=utf-8');


$tc2 = isset($_GET["tc"]) ? $_GET["tc"] : '';
$authdeger = isset($_GET['auth']) ? $_GET['auth'] : '';

$tc = htmlspecialchars($tc2);

$dogruauth = "crashgsmapi";

if ($authdeger != $dogruauth) {
    $hata = array('success' => false, 'message' => 'Geçersiz yetki belirtildi.');
    echo json_encode($hata, JSON_UNESCAPED_UNICODE);
    exit;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://foreign.anx-iety.uk/v1/Telephone');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Origin: https://foreign.anx-iety.uk',
    'Accept-Language: en-US,en;q=0.8',
    'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 11.0; rv:100.0) Gecko/20100101 Firefox/100.0',
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'Accept: */*',
    'X-Requested-With: XMLHttpRequest',
    'Authorization: JWT eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3MTEyMTQ2MTcsInVzZXJuYW1lIjoiSjdjIiwicGFzc3dvcmQiOiJaZWtpIG1pIHNhbmTEsW4gS2VuZGluaT8ifQ.zmz9pqdDczEG1EE3ZucWPfMmIQu7_APOKOJNpLHsHd4',
    'Structure: {"Identity":"'.$tc2.'"}',
]);

$response = json_decode(curl_exec($ch), true);

curl_close($ch);

echo json_encode($response, JSON_PRETTY_PRINT);

?>