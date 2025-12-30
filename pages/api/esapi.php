<?php
$xx = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES;
$tc = htmlspecialchars($_GET['tc']);
$token = "cf850c2405f44db700642613f3bc52814c524c0fc8548a823 51eb0bdf827b2eb386f5fb9a813bb294973096e246367077c8 17a16708ada98298e58aacae49cc4";
$auth_key = "baba";
if($_GET['auth_key'] != $auth_key) {
echo json_encode(['status' => false, 'Mesaj' => 'Auth Yanlıs'], $xx);
die();
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://intvrg.gib.gov.tr/intvrg_server/dispatch');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'Accept: application/json, text/javascript, */*; q=0.01',
'Accept-Language: tr-TR,tr;q=0.9',
'Connection: keep-alive',
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
'Origin: https://intvrg.gib.gov.tr',
'Referer: https://intvrg.gib.gov.tr/intvrg_sid...4&appName=tdvd',
'Sec-Fetch-Dest: empty',
'Sec-Fetch-Mode: cors',
'Sec-Fetch-Site: same-origin',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
'sec-ch-ua: "Not A(Brand";v="99", "Google Chrome";v="121", "Chromium";v="121"',
'sec-ch-ua-mobile: ?0',
'sec-ch-ua-platform: "Windows"',
]);
curl_setopt($ch, CURLOPT_COOKIE, '_ga=GA1.3.1243555909.1708104644; _gid=GA1.3.2028729979.1708104644; _ga_YY759P3QPW=GS1.3.1708104644.1.0.1708104644.0.0 .0');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'cmd=OKCIzniIslemleri_OKCIzniAl&callid=932e4983211 b8-107&token='.$token.'&jp=%7B%22mukVergiKimlikNo%22%3A%22%22%2C%22mukTC KimlikNo%22%3A%22'.$tc.'%22%7D');
$response = curl_exec($ch);


echo $response;
?>