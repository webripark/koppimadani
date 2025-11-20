<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$id=(int)($_GET['id']??0);
$q=mysqli_query($conn,"SELECT * FROM barang WHERE id=$id");
if(!$q || mysqli_num_rows($q)==0) die('Barang tidak ditemukan');
$b=mysqli_fetch_assoc($q);
$foto = (!empty($b['foto']) && file_exists('uploads/'.$b['foto'])) ? 'uploads/'.$b['foto'] : 'assets/no-image.png';
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Detail Barang</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Detail Barang</h2>
<div style="background:#fff;padding:18px;border-radius:8px;width:700px;box-shadow:0 3px 12px rgba(0,0,0,0.06)">
<img src="<?=htmlspecialchars($foto)?>" style="width:260px;height:260px;object-fit:cover;border-radius:8px;float:right;margin-left:20px">
<table>
<tr><td><strong>Kode:</strong></td><td><?=htmlspecialchars($b['kode_barang'])?></td></tr>
<tr><td><strong>Nama:</strong></td><td><?=htmlspecialchars($b['nama_barang'])?></td></tr>
<tr><td><strong>Kategori:</strong></td><td><?=htmlspecialchars($b['kategori'])?></td></tr>
<tr><td><strong>Satuan:</strong></td><td><?=htmlspecialchars($b['satuan'])?></td></tr>
<tr><td><strong>Stok:</strong></td><td><?=htmlspecialchars($b['stok'])?></td></tr>
<tr><td><strong>Stok Minimum:</strong></td><td><?=htmlspecialchars($b['stok_minimum'])?></td></tr>
<tr><td><strong>Dibuat:</strong></td><td><?=htmlspecialchars($b['created_at'])?></td></tr>
</table>
<div style="clear:both;margin-top:16px"><a href="stok_barang.php">← Kembali</a></div>
</div>
</div>
</body></html>
