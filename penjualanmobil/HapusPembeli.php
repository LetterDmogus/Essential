<?php
include "koneksi.php";
$ktp = $_POST['ktp'] ?? '';

$response = ["status" => 0, "message" => "Gagal menghapus"];

if (!empty($ktp)) {
    $query = "DELETE FROM pembeli WHERE ktp='$ktp'";
    if (mysqli_query($conn, $query)) {
        $response["status"] = 1;
        $response["message"] = "Berhasil dihapus";
    }
}
echo json_encode($response);
?>

