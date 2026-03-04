<?php
    $host="localhost";
    $user="root";
    $pass="";
    $db="penjualan_mobil";
     
    $conn= new mysqli($host,$user,$pass,$db);

    //cek apakah database sudah terkoneksi

    if($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }
    
?>