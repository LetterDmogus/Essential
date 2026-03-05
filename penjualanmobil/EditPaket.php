<?php
include "Koneksi.php";
header("Content-Type: application/json");

$kode_paket = $_POST["kode_paket"] ?? "";
$uang_muka = $_POST["uang_muka"] ?? "";
$tenor = $_POST["tenor"] ?? "";
$bunga_cicilan = $_POST["bunga_cicilan"] ?? "";

$response = ["status" => 0, "message" => "Data tidak lengkap"];

if ($kode_paket && $uang_muka !== "" && $tenor !== "" && $bunga_cicilan !== "") {
    $stmt = $conn->prepare("UPDATE paket
        SET uang_muka = ?, tenor = ?, bunga_cicilan = ?
        WHERE kode_paket = ?");

    if ($stmt) {
        $stmt->bind_param("iiis", $uang_muka, $tenor, $bunga_cicilan, $kode_paket);

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

