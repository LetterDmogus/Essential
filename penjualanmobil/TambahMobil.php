<?php
include 'Koneksi.php';
header('Content-Type: text/plain');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode  = $_POST['kode_mobil'] ?? '';
    $merk  = $_POST['merk'] ?? '';
    $type  = $_POST['type'] ?? '';
    $warna = $_POST['warna'] ?? '';
    $harga = $_POST['harga'] ?? '';

    if (empty($kode) || empty($merk)) {
        echo "Data tidak lengkap!";
        exit;
    }

    $sql = "INSERT INTO mobil (kode_mobil, merk, type, warna, harga)
            VALUES ('$kode', '$merk', '$type', '$warna', '$harga')";

    if (mysqli_query($conn, $sql)) {
        echo "Data berhasil disimpan";
    } else {
        echo "Gagal menyimpan ke database: " . mysqli_error($conn);
    }
} else {
    echo "Metode tidak valid";
}
?>
