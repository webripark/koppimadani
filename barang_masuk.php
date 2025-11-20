<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$q = mysqli_query($conn, "SELECT p.*, b.nama_barang, b.kode_barang FROM pemasukan_barang p LEFT JOIN barang b ON p.barang_id=b.id ORDER BY p.created_at DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Barang Masuk</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Barang Masuk</h2>
<p><a href="tambah_masuk.php" style="padding:8px 12px;background:#0d6efd;color:#fff;border-radius:8px;text-decoration:none">+ Input Masuk</a></p>
<table style="background:#fff;padding:12px;border-radius:8px">
<tr><th>No</th><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Supplier</th><th>Tanggal</th></tr>
<?php $no=1; while($r=mysqli_fetch_assoc($q)){ echo '<tr><td>'.$no++.'</td><td>'.htmlspecialchars($r['kode_barang']).'</td><td>'.htmlspecialchars($r['nama_barang']).'</td><td>'.htmlspecialchars($r['jumlah']).'</td><td>'.htmlspecialchars($r['supplier']).'</td><td>'.htmlspecialchars($r['tanggal_masuk']).'</td></tr>'; } ?>
</table>
</div></body></html>
