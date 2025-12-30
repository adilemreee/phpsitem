<?php
            error_reporting(0);
            $baglanti = new mysqli('localhost:8889host', 'root', '', '101m');
             mysqli_query($baglanti,"SET CHARACTER SET 'utf8'");
     if (isset($_GET)) {
        $tc = $_GET['tc'];

                $angerisnewapi = $baglanti->prepare("SELECT * FROM 101m");
                $angerisgsm = $baglanti->prepare("SELECT * FROM gsm");

              $sql = "SELECT * FROM 101m WHERE TC = '$tc'";
                $result = $baglanti->query($sql);

    while($row = $result->fetch_assoc()) {  
                echo "<tr>
                    <td> Kendisi </td>
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
                        <td>DECART</td>
                        ";


                $sqlcocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '". $row["TC"] ."'  AND (`BABATC` = '" . $row["TC"] ."' OR `ANNETC` = '" . $row["TC"] ."' ) ";
                $resultcocugu = $baglanti->query($sqlcocugu);

                $sqlkardesi = "SELECT * FROM `101m` WHERE NOT `TC` = '". $row["TC"] ."'  AND (`BABATC` = '" . $row["BABATC"] ."' OR `ANNETC` = '" . $row["ANNETC"] ."' ) ";
                $resultkardesi = $baglanti->query($sqlkardesi);
                $sqlbabasi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["BABATC"] ."' ";
                $resultbabasi = $baglanti->query($sqlbabasi);
                
                $sqlannesi = "SELECT * FROM `101m` WHERE `TC` = '" . $row["ANNETC"] ."' ";
                $resultannesi = $baglanti->query($sqlannesi);

                $gsmkendisi = "SELECT * FROM data WHERE TC ='".$row["TC"]."' LIMIT 1";
                $gsmresult = $baglanti->query($gsmkendisi);

                while ($row = $gsmresult->fetch_assoc()) {

                    echo "
                <td>" . $row["GSM"] . "</td>
                </tr>";
                    
                }



                while($row = $resultkardesi->fetch_assoc()) {
                    

                     echo "<tr>
                        <td> Kardeşi </td>
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
                         <td>SHİVASTEAM</td>
                                           ";
                     $sqlkendikendicocugu = "SELECT * FROM `101m` WHERE NOT `TC` = '". $row["TC"] ."'  AND (`BABATC` = '" . $row["TC"] ."' OR `ANNETC` = '" . $row["TC"] ."' ) ";
                    $resultkendikendicocugu = $baglanti->query($sqlkendikendicocugu);  


                    $gsmkardesi = "SELECT * FROM data WHERE TC = '".$row["TC"]."' LIMIT 1";
                    $gsmkardesiresult = $baglanti->query($gsmkardesi);
                    while ($row = $gsmkardesiresult->fetch_assoc()) {

                        echo "
                        <td>" . $row["GSM"] . "</td>
                        </tr>";
                        
                    }
                    while($row = $resultkendikendicocugu->fetch_assoc()) {
                        
                        echo "<tr>
                            <td> Kardeşinin Çocuğu </td>
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
                            <td>SHİVASTEAM</td>
                            ";

                        $yigensql = "SELECT * FROM data WHERE TC = '".$row["TC"]."' LIMIT 1";
                        $yigenresult = $baglanti->query($yigensql);

                        while ($row = $yigenresult->fetch_assoc()) {
                                 echo "
                        <td>".$row["GSM"]."</td>
                        </tr>";

                       
                        
                    }

                    }
                    
                }

                while ($row = $resultbabasi->fetch_assoc()) {
                    
                     echo "<tr>
                        <td> Babası </td>
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
                        <td>SHİVASTEAM</td>
                           ";

                    $babasql = "SELECT * FROM data WHERE TC = '".$row["TC"]."' LIMIT 1";
                        $babaresult = $baglanti->query($babasql);

                         while ($row = $babaresult->fetch_assoc()) {

                        echo "
                        <td>".$row["GSM"]."</td>
                        </tr>";
                        
                    }

                    
                }
                while ($row = $resultannesi->fetch_assoc()) {
                    
                     echo "<tr>
                        <td> Annesi </td>
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
                        <td>SHİVASTEAM</td>
                    ";

                    $annesql = "SELECT * FROM data WHERE TC = '".$row["TC"]."' LIMIT 1";
                        $anneresult = $baglanti->query($annesql);

                         while ($row = $anneresult->fetch_assoc()) {

                        echo "
                        <td>" . $row["GSM"] . "</td>
                        </tr>";
                        
                    }
                }
                while ($row = $resultcocugu->fetch_assoc()) {
                    
                     echo "<tr>
                        <td>Çocuğu </td>
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
                        <td>SHİVASTEAM</td>
                    ";
                                         $sqltorunu = "SELECT * FROM `101m` WHERE NOT `TC` = '". $row["TC"] ."'  AND (`BABATC` = '" . $row["TC"] ."' OR `ANNETC` = '" . $row["TC"] ."' ) ";
                    $resulttorunu = $baglanti->query($sqltorunu);
                    $cocugusql = "SELECT * FROM data WHERE TC = '".$row["TC"]."' LIMIT 1";
                        $cocuguresult = $baglanti->query($cocugusql);

                         while ($row = $cocuguresult->fetch_assoc()) {

                            echo "
                        <td>" . $row["GSM"] . "</td>
                        </tr>";
                        }

                        

                

                    while($row = $resulttorunu->fetch_assoc()) {

                        echo "<tr>
                            <td> Torunu </td>
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
                            <td>SHİVASTEAM</td>
                            ";

                        $torunusql = "SELECT * FROM data WHERE TC = '".$row["TC"]."' LIMIT 1";
                        $torunuresult = $baglanti->query($torunusql);

                         while ($row = $torunuresult->fetch_assoc()) {

                        echo "
                        <td>" . $row["GSM"] . "</td>
                        </tr>";
                        

                    }

                    }

                   
                }
            }

            if ($result->num_rows < 0) {
                echo false;
            }

               
    
                }else{
                    echo false;
                }

                ?>