<?php
include 'koneksi.php';

$q = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Print Stok Barang</title>
<style>
    body { font-family: Arial; padding: 18px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #333; padding: 8px; font-size: 14px; }
</style>
</head>
<body>

<h2>Laporan Stok Barang</h2>

<table>
<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Nama Barang</th>
    <th>Kategori</th>
    <th>Stok</th>
    <th>Stok Minimum</th>
</tr>

<?php 
$no=1; 
while($r = mysqli_fetch_assoc($q)) { ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($r['kode_barang']) ?></td>
    <td><?= htmlspecialchars($r['nama_barang']) ?></td>
    <td><?= htmlspecialchars($r['kategori']) ?></td>
    <td><?= htmlspecialchars($r['stok']) ?></td>
    <td><?= htmlspecialchars($r['stok_minimum']) ?></td>
</tr>
<?php } ?>

</table>

<script> window.print(); </script>

</body>
</html>
