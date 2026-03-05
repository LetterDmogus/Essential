<?php
include "Koneksi.php";
header("Content-Type: application/json");

$ktp = $_POST["ktp"] ?? "";
$nama_pembeli = $_POST["nama_pembeli"] ?? "";
$alamat_pembeli = $_POST["alamat_pembeli"] ?? "";
$telp_pembeli = $_POST["telp_pembeli"] ?? "";

$response = ["status" => 0, "message" => "Data tidak lengkap"];

if ($ktp && $nama_pembeli && $alamat_pembeli && $telp_pembeli) {
    $stmt = $conn->prepare("UPDATE pembeli
        SET nama_pembeli = ?, alamat_pembeli = ?, telp_pembeli = ?
        WHERE ktp = ?");

    if ($stmt) {
        $stmt->bind_param("ssss", $nama_pembeli, $alamat_pembeli, $telp_pembeli, $ktp);

        if ($stmt->execute()) {
            $response = ["status" => 1, "message" => "Update berhasil"];
        } else {
            $response = ["status" => 0, "message" => "Update gagal: " . $stmt->error];
        }
        $stmt->close();
    } else {
        $response = ["status" => 0, "message" => "Prepare gagal: " . $conn->error];
    }
}

echo json_encode($response);

