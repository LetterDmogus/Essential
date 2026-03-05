<?php
include "Koneksi.php";
header("Content-Type: application/json");

$kode_kredit = $_POST["kode_kredit"] ?? "";
$ktp = $_POST["ktp"] ?? "";
$kode_paket = $_POST["kode_paket"] ?? "";
$kode_mobil = $_POST["kode_mobil"] ?? "";
$tanggal_kredit = $_POST["tanggal_kredit"] ?? "";
$bayar_kredit = $_POST["bayar_kredit"] ?? "";
$tenor = $_POST["tenor"] ?? "";
$totalcicil = $_POST["totalcicil"] ?? "";

$response = ["status" => 0, "message" => "Data tidak lengkap"];

if (
    $kode_kredit && $ktp && $kode_paket && $kode_mobil &&
    $tanggal_kredit && $bayar_kredit !== "" && $tenor !== "" && $totalcicil !== ""
) {
    $stmt = $conn->prepare("UPDATE kredit
        SET ktp = ?, kode_paket = ?, kode_mobil = ?, tanggal_kredit = ?, bayar_kredit = ?, tenor = ?, totalcicil = ?
        WHERE kode_kredit = ?");

    if ($stmt) {
        $stmt->bind_param(
            "ssssiiis",
            $ktp,
            $kode_paket,
            $kode_mobil,
            $tanggal_kredit,
            $bayar_kredit,
            $tenor,
            $totalcicil,
            $kode_kredit
        );

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

