<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$q = mysqli_query($conn, "SELECT p.*, b.nama_barang, b.kode_barang FROM pengeluaran_barang p LEFT JOIN barang b ON p.barang_id=b.id ORDER BY p.created_at DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Barang Keluar</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Barang Keluar</h2>
<p><a href="tambah_keluar.php" style="padding:8px 12px;background:#ff6b6b;color:#fff;border-radius:8px;text-decoration:none">+ Input Keluar</a></p>
<table style="background:#fff;padding:12px;border-radius:8px">
<tr><th>No</th><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Tujuan</th><th>Tanggal</th></tr>
<?php $no=1; while($r=mysqli_fetch_assoc($q)){ echo '<tr><td>'.$no++.'</td><td>'.htmlspecialchars($r['kode_barang']).'</td><td>'.htmlspecialchars($r['nama_barang']).'</td><td>'.htmlspecialchars($r['jumlah']).'</td><td>'.htmlspecialchars($r['tujuan']).'</td><td>'.htmlspecialchars($r['tanggal_keluar']).'</td></tr>'; } ?>
</table>
</div></body></html>
