<?php
include 'Koneksi.php';

$sql = "SELECT * FROM mobil ORDER BY kode_mobil ASC";
$result = $conn->query($sql);

$mobil = [];
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$script_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$base_url = $scheme . '://' . $host . $script_dir . '/';

while ($row = $result->fetch_assoc()) {
    $row['foto'] = $base_url . ltrim($row['gambar'], '/\\');
    $mobil[] = $row;
}

header('Content-Type: application/json');
echo json_encode($mobil);
?>
