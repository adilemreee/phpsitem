<?php
// Kullanıcıdan gelen veriyi güvenli bir şekilde alın
$auth = isset($_GET['auth']) ? $_GET['auth'] : '';
$id = isset($_GET['id']) ? $_GET['id'] : '';
// Auth kontrolü
if ($auth !== 'baba31') {
echo json_encode(['error' => 'Yetkilendirme başarısız.'], JSON_UNESCAPED_UNICODE);
exit;
}
// input değeri boşsa hataya düşür
if (empty($id)) {
echo json_encode(['error' => 'input alanı zorunludur.'], JSON_UNESCAPED_UNICODE);
exit;
}
// API'ye gönderilecek veri
$data = [
'input' => $id,
];
// API URL
$apiUrl = 'https://lookupguru.herokuapp.com/lookup';
// cURL ile API'ye istek yapma
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
// Başlık bilgilerini ayarla
curl_setopt($ch, CURLOPT_HTTPHEADER, [
'Content-Type: application/json',
'Accept: application/json',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
'Access-Control-Allow-Credentials: true',
'Connection: keep-alive',
'Dnt: 1',
'Host: lookupguru.herokuapp.com',
'Origin: https://lookup.guru',
'Referer: https://lookupguru.herokuapp.com/',
'Sec-Ch-Ua: "Chromium";v="118", "Google Chrome";v="118", "Not=A?Brand";v="99"',
'Sec-Ch-Ua-Mobile: ?0',
'Sec-Ch-Ua-Platform: "Windows"',
'Sec-Fetch-Dest: empty',
'Sec-Fetch-Mode: cors',
'Sec-Fetch-Site: cross-site',
'Sec-Gpc: 1',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36',
]);
// API'den gelen yanıtı al
$response = curl_exec($ch);
// Hata olup olmadığını kontrol et
if ($response !== false) {
// Yanıtı ekrana yazdır
header('Content-Type: application/json; charset=utf-8');
echo $response;
} else {
// Hata durumunda hata mesajını ekrana yazdır
echo json_encode(['error' => 'POST isteği başarısız.'], JSON_UNESCAPED_UNICODE);
}
// cURL bağlantısını kapat
curl_close($ch);
?>
