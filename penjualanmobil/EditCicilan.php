<?php
include "Koneksi.php";
header("Content-Type: application/json");

$kode_cicilan = $_POST["kode_cicilan"] ?? "";
$kode_kredit = $_POST["kode_kredit"] ?? "";
$tanggal_cicilan = $_POST["tanggal_cicilan"] ?? "";
$cicilanke = $_POST["cicilanke"] ?? "";
$jumlah_cicilan = $_POST["jumlah_cicilan"] ?? "";
$sisa_cicilan = $_POST["sisa_cicilan"] ?? "";

$response = ["status" => 0, "message" => "Data tidak lengkap"];

if (
    $kode_cicilan && $kode_kredit && $tanggal_cicilan &&
    $cicilanke !== "" && $jumlah_cicilan !== "" && $sisa_cicilan !== ""
) {
    $stmt = $conn->prepare("UPDATE bayar_cicilan
        SET kode_kredit = ?, tanggal_cicilan = ?, cicilanke = ?, jumlah_cicilan = ?, sisa_cicilan = ?
        WHERE kode_cicilan = ?");

    if ($stmt) {
        $stmt->bind_param(
            "ssiiis",
            $kode_kredit,
            $tanggal_cicilan,
            $cicilanke,
            $jumlah_cicilan,
            $sisa_cicilan,
            $kode_cicilan
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

