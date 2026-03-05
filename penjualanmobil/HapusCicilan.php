<?php
include "koneksi.php";
$kode_cicilan = $_POST['kode_cicilan'] ?? '';

$response = ["status" => 0, "message" => "Gagal menghapus"];

if (!empty($kode_cicilan)) {
    $query = "DELETE FROM bayar_cicilan WHERE kode_cicilan='$kode_cicilan'";
    if (mysqli_query($conn, $query)) {
        $response["status"] = 1;
        $response["message"] = "Berhasil dihapus";
    }
}
echo json_encode($response);
?>

