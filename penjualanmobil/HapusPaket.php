<?php
include "koneksi.php";
$kode_paket = $_POST['kode_paket'] ?? '';

$response = ["status" => 0, "message" => "Gagal menghapus"];

if (!empty($kode_paket)) {
    $query = "DELETE FROM paket WHERE kode_paket='$kode_paket'";
    if (mysqli_query($conn, $query)) {
        $response["status"] = 1;
        $response["message"] = "Berhasil dihapus";
    }
}
echo json_encode($response);
?>

