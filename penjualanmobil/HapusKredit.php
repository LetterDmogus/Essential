<?php
include "koneksi.php";
$kode_kredit = $_POST['kode_kredit'] ?? '';

$response = ["status" => 0, "message" => "Gagal menghapus"];

if (!empty($kode_kredit)) {
    $query = "DELETE FROM kredit WHERE kode_kredit='$kode_kredit'";
    if (mysqli_query($conn, $query)) {
        $response["status"] = 1;
        $response["message"] = "Berhasil dihapus";
    }
}
echo json_encode($response);
?>

