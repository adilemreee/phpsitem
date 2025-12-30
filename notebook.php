<?php

if ($access_level == 5) {
    echo "<script>toastr.info('Bu Sorguyu Kullanabilmek İçin VIP olmanız gerekiyor.');</script>";
    exit;
}

// Bu Kod bloğu vip'lerini girip kullanabildiği fakat premium üyelerin kullanamayacağı sayfalara konulabilir.


if ($access_level <= 3) {
    echo "<script>toastr.info('Üyeliğinizinizden Dolayı Herhangi Bir Sorgu İşlemi Yapamazsınız.');</script>";
    exit;
}

// Bu Kod bloğu üyelerin sorgu atamamasını sağlar.
?>