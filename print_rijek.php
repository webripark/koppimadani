<?php
include 'koneksi.php';

$q = mysqli_query($conn, "
    SELECT r.*, b.kode_barang, b.nama_barang
    FROM barang_rijek r
    LEFT JOIN barang b ON r.id_barang = b.id
    ORDER BY r.id DESC
");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Print Barang Rijek</title>
<style>
    body { font-family: Arial; padding: 18px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #333; padding: 8px; font-size: 14px; }
</style>
</head>
<body>

<h2>Laporan Barang Rijek</h2>

<table>
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Nama Barang</th>
    <th>Jumlah</th>
    <th>Keterangan</th>
    <th>Tanggal</th>
</tr>

<?php 
$no = 1; 
while($r = mysqli_fetch_assoc($q)) { ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($r['kode_barang']) ?></td>
    <td><?= htmlspecialchars($r['nama_barang']) ?></td>
    <td><?= htmlspecialchars($r['jumlah']) ?></td>
    <td><?= htmlspecialchars($r['keterangan']) ?></td>
    <td><?= htmlspecialchars($r['created_at']) ?></td>
</tr>
<?php } ?>

</table>

<script> window.print(); </script>

</body>
</html>
