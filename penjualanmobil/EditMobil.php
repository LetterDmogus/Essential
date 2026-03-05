<?php
include "Koneksi.php";

$kode_mobil = $_POST['kode_mobil'] ?? '';
$merk = $_POST['merk'] ?? '';
$type = $_POST['type'] ?? '';
$warna = $_POST['warna'] ?? '';
$harga = $_POST['harga'] ?? '';

$response = ["status"=>0, "message"=>"Data tidak lengkap"];

if ($kode_mobil && $merk && $type && $warna && $harga) {
    $sql = "UPDATE mobil 
            SET merk='$merk', type='$type', warna='$warna', harga='$harga' 
            WHERE kode_mobil='$kode_mobil'";
    if (mysqli_query($conn, $sql)) {
        $response = ["status"=>1, "message"=>"Update berhasil"];
    } else {
        $response = ["status"=>0, "message"=>"Update gagal: " . mysqli_error($conn)];
    }
}

echo json_encode($response);
