<?php
include 'Koneksi.php';
header('Content-Type: application/json');

$periode = $_GET['periode'] ?? 'bulan';
$tanggal = $_GET['tanggal'] ?? date('Y-m');

if ($periode === 'tahun') {
    $sql = "SELECT b.kode_cicilan, b.kode_kredit, p.nama_pembeli, b.tanggal_cicilan, b.jumlah_cicilan
            FROM bayar_cicilan b
            JOIN kredit k ON b.kode_kredit = k.kode_kredit
            JOIN pembeli p ON k.ktp = p.ktp
            WHERE YEAR(b.tanggal_cicilan) = '$tanggal'
            ORDER BY b.tanggal_cicilan DESC";
} else {
    $sql = "SELECT b.kode_cicilan, b.kode_kredit, p.nama_pembeli, b.tanggal_cicilan, b.jumlah_cicilan
            FROM bayar_cicilan b
            JOIN kredit k ON b.kode_kredit = k.kode_kredit
            JOIN pembeli p ON k.ktp = p.ktp
            WHERE DATE_FORMAT(b.tanggal_cicilan, '%Y-%m') = '$tanggal'
            ORDER BY b.tanggal_cicilan DESC";
}

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>
