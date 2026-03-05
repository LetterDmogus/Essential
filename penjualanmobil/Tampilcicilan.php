<?php
include 'Koneksi.php';
header('Content-Type: application/json');

$sql = "
SELECT 
    k.kode_kredit,
    p.nama_pembeli,
    b.tanggal_cicilan,
    b.cicilanke,
    b.jumlah_cicilan,
    b.sisa_cicilan
FROM bayar_cicilan b
JOIN kredit k ON b.kode_kredit = k.kode_kredit
JOIN pembeli p ON k.ktp = p.ktp
WHERE (b.kode_kredit, b.cicilanke) IN (
    SELECT kode_kredit, MAX(cicilanke)
    FROM bayar_cicilan
    GROUP BY kode_kredit
)
ORDER BY k.kode_kredit ASC
";

$result = $conn->query($sql);
$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>
