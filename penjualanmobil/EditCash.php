<?php
include "Koneksi.php";
header("Content-Type: application/json");

$kode_cash = $_POST["kode_cash"] ?? "";
$ktp = $_POST["ktp"] ?? "";
$kode_mobil = $_POST["kode_mobil"] ?? "";
$cash_tgl = $_POST["cash_tgl"] ?? "";

$response = ["status" => 0, "message" => "Data tidak lengkap"];

if ($kode_cash && $ktp && $kode_mobil && $cash_tgl) {
    // Ikuti logika TambahCash: cash_bayar selalu dari harga mobil saat ini.
    $cek = $conn->prepare("SELECT harga FROM mobil WHERE kode_mobil = ?");
    if ($cek) {
        $cek->bind_param("s", $kode_mobil);
        $cek->execute();
        $cek->bind_result($harga);
        $cek->fetch();
        $cek->close();

        if ($harga !== null) {
            $stmt = $conn->prepare("UPDATE beli_cash
                SET ktp = ?, kode_mobil = ?, cash_tgl = ?, cash_bayar = ?
                WHERE kode_cash = ?");

            if ($stmt) {
                $stmt->bind_param("sssds", $ktp, $kode_mobil, $cash_tgl, $harga, $kode_cash);

                if ($stmt->execute()) {
                    $response = ["status" => 1, "message" => "Update berhasil"];
                } else {
                    $response = ["status" => 0, "message" => "Update gagal: " . $stmt->error];
                }
                $stmt->close();
            } else {
                $response = ["status" => 0, "message" => "Prepare gagal: " . $conn->error];
            }
        } else {
            $response = ["status" => 0, "message" => "Harga mobil tidak ditemukan"];
        }
    } else {
        $response = ["status" => 0, "message" => "Prepare gagal: " . $conn->error];
    }
}

echo json_encode($response);

