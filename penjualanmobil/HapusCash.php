<?php
include "koneksi.php";
$kode_cash = $_POST['kode_cash'] ?? '';

$response = ["status" => 0, "message" => "Gagal menghapus"];

if (!empty($kode_cash)) {
    $query = "DELETE FROM beli_cash WHERE kode_cash='$kode_cash'";
    if (mysqli_query($conn, $query)) {
        $response["status"] = 1;
        $response["message"] = "Berhasil dihapus";
    }
}
echo json_encode($response);
?>

