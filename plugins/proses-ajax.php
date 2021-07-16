<?php
include '../inc/koneksi.php';
$strip=' - ';

 $output = '';  
 if(isset($_POST["id_santri"])) {  
        $sql = "select * from tb_santri where id_santri= '".$_POST["id_santri"]."'";
        $hasil = mysqli_query($koneksi, $sql);  
        while($row = mysqli_fetch_array($hasil)) {  
            $nama = $row["nama"];
            $alamat = $row["alamat"];
        }  
        echo $nama;
        echo $strip;
        echo $alamat;
    }
