<?php

$ad = htmlspecialchars($_POST["ad"]);
$soyad = htmlspecialchars($_POST["soyad"]);
$il = htmlspecialchars($_POST["il"]);
$ilce = htmlspecialchars($_POST["ilce"]);

$baglanti = new mysqli("localhost:8889host", "root", "", "101m");
mysqli_query($baglanti,"SET CHARACTER SET 'utf8'");
error_reporting(0);

if (isset($_POST)) {
 $ad = htmlspecialchars($_POST['name']);
 $soyad = htmlspecialchars($_POST['surname']);
 $il = htmlspecialchars($_POST['nufus']);
 $dtarihi = $_POST['dogum'];


  if (!empty($ad) && !empty($soyad) && empty($il) && empty($dtarihi)) {
    $sql = "SELECT * FROM 101m WHERE ADI='$ad' AND SOYADI='$soyad'";
    $result = $baglanti->query($sql);
  }
  if (!empty($ad) && !empty($soyad) && !empty($il) && empty($dtarih)) {
    $sql = "SELECT * FROM 101m WHERE ADI='$ad' AND SOYADI='$soyad' AND NUFUSIL='$il'";
    $result = $baglanti->query($sql);
  }
  if (!empty($ad) && !empty($dtarihi) && empty($soyad) && empty($il)) {
    $sql = "SELECT * FROM 101m WHERE ADI='$ad' AND DOGUMTARIHI='$dtarihi'";
    $result = $baglanti->query($sql);
  }

  if (!empty($soyad) && !empty($dtarihi) && empty($ad) && empty($il)) {
    $sql = "SELECT * FROM 101m WHERE SOYADI='$soyad' AND DOGUMTARIHI='$dtarihi'";
    $result = $baglanti->query($sql);
  }

  if (!empty($ad) && !empty($il) && !empty($dtarih) && empty($soyad)) {
    $sql = "SELECT * FROM 101m WHERE ADI='$ad' AND NUFUSIL='$il' AND DOGUMTARIHI='$dtarihi'";
    $result = $baglanti->query($sql);
  }

  if (!empty($ad) && !empty($il) && empty($soyad) && empty($dtarihi)) {
    $sql = "SELECT * FROM 101m WHERE ADI='$ad' AND NUFUSIL='$il'";
    $result = $baglanti->query($sql);
  }

  
   $resultangeris = array();
   if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<tr>
      <td>" . $row["TC"] . "</td>
      <td>" . $row["ADI"] . "</td>
      <td>" . $row["SOYADI"] . "</td>
      <td>" . $row["DOGUMTARIHI"] . "</td>
      <td>" . $row["ANNEADI"] . "</td>
      <td>" . $row["ANNETC"] . "</td>
      <td>" . $row["BABAADI"] . "</td>
      <td>" . $row["BABATC"] . "</td>
      <td>" . $row["NUFUSIL"] . "</td>
      <td>" . $row["NUFUSILCE"] . "</td>
      <td>" . $row["UYRUK"] . "</td>
      <td>ZenithCity</td>
  </tr>";
       }
   }else{
    echo false;
   }

}else{
    echo false;
}
