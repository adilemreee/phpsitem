<?php

header('Content-Type: application/json');

$host = "localhost:8889";
$user = "root";
$password = "";
$dbname1 = "data";
$dbname2 = "veri";

$conn1 = mysqli_connect($host, $user, $password, $dbname1);
$conn2 = mysqli_connect($host, $user, $password, $dbname2);

if (!$conn1 || !$conn2) {
  die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

mysqli_set_charset($conn1, "utf8");
mysqli_set_charset($conn2, "utf8");

$start_time = microtime(true); // İstek gönderildiği zamanı al

$tc = isset($_GET['tc']) ? $_GET['tc'] : '';
$authdeger = isset($_GET['auth']) ? $_GET['auth'] : '';

if (empty($tc)) {
  $hata = array('success' => false, 'message' => 'tc söyle amq');
  echo json_encode($hata, JSON_UNESCAPED_UNICODE);
  exit;
}

$dogruauth = "crasherbaba31";

if ($authdeger != $dogruauth) {
    $hata = array('success' => false, 'message' => 'AHA AUTH YANLIŞ İP ADRESİNİ ALDIM DDOS GELİYO YARRAM');
    echo json_encode($hata, JSON_UNESCAPED_UNICODE);
    exit;
}

// Güvenli sorgu kullanımı
$sql1 = "SELECT * FROM datam WHERE KimlikNo = '$tc'";
$result1 = mysqli_query($conn1, $sql1);

$sql2 = "SELECT * FROM datam WHERE KimlikNo = '$tc'";
$result2 = mysqli_query($conn2, $sql2);

$data = array();

// İlk veritabanından sonuç alındıysa, veritabanından verileri al
if (mysqli_num_rows($result1) > 0) {
  while($row = mysqli_fetch_assoc($result1)) {
    $data[] = array(
      'Tc' => $row["KimlikNo"],
      'Adı-Soyadı' => $row["AdSoyad"],
      'Doğum-Yeri'=> $row["DogumYeri"],
      'Vergi-Numarası' => $row["VergiNumarasi"],
      'Adres' => $row["Ikametgah"]
    );
  }
} 
// İkinci veritabanından sonuç alındıysa, veritabanından verileri al
elseif (mysqli_num_rows($result2) > 0) {
  while($row = mysqli_fetch_assoc($result2)) {
    $data[] = array(
      'Tc' => $row["KimlikNo"],
      'Adı-Soyadı' => $row["AdSoyad"],
      'Doğum-Yeri' => $row['DogumYeri'],
      'Vergi-Numarası' => $row["VergiNumarasi"],
      'Adres' => $row["Ikametgah"]
    );
  }
} 
// Her iki veritabanında da sonuç bulunamazsa hata döndür
else {
  $hata = array('success' => false, 'message' => 'data yok amq');
  echo json_encode($hata, JSON_UNESCAPED_UNICODE);
  exit;
}

// Cevap alındığı zamanı al
$end_time = microtime(true);
// Gecikme süresini hesapla
$response_time = $end_time - $start_time;

// Diğer bilgileri ekleyelim
$info = array(
  'Author' => 'NeCo & Randy & Ludexn',
  'Api İsmi' => 'Adres',
  'Gecikme Süresi' => number_format($response_time, 2) . ' saniye'
);

// Tüm bilgileri birleştirelim
$output = array(
  'success' => true,
  'message' => 'Dengesizler Api Service',
  'info' => $info,
  'data' => $data
);

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE, 4);

mysqli_close($conn1);
mysqli_close($conn2);

?>
