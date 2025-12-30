<?php

$host = 'localhost:8889host';
$dbname = 'sorguuu';
$username = 'root';
$password = '';

try {
$baglanti = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
echo json_encode(['error' => 'Veritabanı bağlantısı başarısız: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
exit;
}

$tc2 = isset($_GET["tc"]) ? $_GET["tc"] : '';
$authdeger = isset($_GET['auth']) ? $_GET['auth'] : '';

$tc = htmlspecialchars(strip_tags($tc2));

$dogruauth = "crashburcapi";

if ($authdeger != $dogruauth) {
    $hata = array('success' => false, 'message' => 'Geçersiz yetki belirtildi.');
    echo json_encode($hata, JSON_UNESCAPED_UNICODE);
    exit;
}


if (empty($tc)) {
echo json_encode(['error' => 'TC kimlik numarası zorunludur.'], JSON_UNESCAPED_UNICODE);
exit;
}

$sql = "SELECT * FROM 109m WHERE TC = :tc";
$sth = $baglanti->prepare($sql);
$sth->bindParam(':tc', $tc);

try {
$sth->execute();
$result = $sth->fetch(PDO::FETCH_ASSOC);

if (!$result) {
echo json_encode(['error' => 'TC kimlik numarasına ait bilgi bulunamadı.'], JSON_UNESCAPED_UNICODE);
exit;
}

$adi = $result['ADI'];
$soyadi = $result['SOYADI'];
$dth = $result['DOGUMTARIHI'];

function findBurc($birthdate) {
$date = new DateTime($birthdate);
$day = $date->format('j');
$month = $date->format('n');

// Burçları kontrol et
if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 20)) {
return ['name' => 'Koç', 'comment' => 'Koç burcu, cesur ve lider ruhlu insanlara işaret eder.'];
} elseif (($month == 4 && $day >= 21) || ($month == 5 && $day <= 21)) {
return ['name' => 'Boğa', 'comment' => 'Boğa burcu, sabırlı ve kararlı bir karakteri yansıtır.'];
} elseif (($month == 5 && $day >= 22) || ($month == 6 && $day <= 21)) {
return ['name' => 'İkizler', 'comment' => 'İkizler burcu, esnek ve zeki kişilere işaret eder.'];
} elseif (($month == 6 && $day >= 22) || ($month == 7 && $day <= 22)) {
return ['name' => 'Yengeç', 'comment' => 'Yengeç burcu, duygusal ve koruyucu bir doğaya sahip olabilir.'];
} elseif (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) {
return ['name' => 'Aslan', 'comment' => 'Aslan burcu, liderlik yetenekleri ve cömertliği simgeler.'];
} elseif (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) {
return ['name' => 'Başak', 'comment' => 'Başak burcu, düzenli ve titiz bir karakteri yansıtır.'];
} elseif (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) {
return ['name' => 'Terazi', 'comment' => 'Terazi burcu, adalet ve uyum arayışında olan kişilere işaret eder.'];
} elseif (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) {
return ['name' => 'Akrep', 'comment' => 'Akrep burcu, derin duygulara sahip ve güçlü karakterli kişileri simgeler.'];
} elseif (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) {
return ['name' => 'Yay', 'comment' => 'Yay burcu, maceracı ve iyimser bir doğaya sahip olabilir.'];
} elseif (($month == 12 && $day >= 22) || ($month == 1 && $day <= 20)) {
return ['name' => 'Oğlak', 'comment' => 'Oğlak burcu, disiplinli ve hırslı bir yapıyı temsil eder.'];
} elseif (($month == 1 && $day >= 21) || ($month == 2 && $day <= 19)) {
return ['name' => 'Kova', 'comment' => 'Kova burcu, yenilikçi ve bağımsız kişilere işaret eder.'];
} elseif (($month == 2 && $day >= 20) || ($month == 3 && $day <= 20)) {
return ['name' => 'Balık', 'comment' => 'Balık burcu, duyarlı ve hayalperest bir karakteri yansıtır.'];
} else {
return ['name' => 'Geçersiz Tarih', 'comment' => 'Geçersiz tarih.'];
}
}

$burc = findBurc($dth);

echo json_encode([
'data' => [
'AWS' => 'burç sorgu',
'CODER' => 'crasher',
'STATUS' => true,
],
'AD' => $adi,
'SOYAD' => $soyadi,
'BURC' => [
'name' => $burc['name'],
'comment' => $burc['comment']
]
], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
echo json_encode(['error' => 'Veritabanı sorgusu başarısız: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
exit;
}
?>