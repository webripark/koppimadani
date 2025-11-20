<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$q = mysqli_query($conn, "SELECT r.*, b.nama_barang, b.kode_barang FROM barang_rijek r LEFT JOIN barang b ON r.id_barang=b.id ORDER BY r.created_at DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Barang Rijek</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Barang Rijek</h2>
<p><a href="tambah_rijek.php" style="padding:8px 12px;background:#ffb86b;color:#222;border-radius:8px;text-decoration:none">+ Input Rijek</a></p>
<table style="background:#fff;padding:12px;border-radius:8px">
<tr><th>No</th><th>Foto</th><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Keterangan</th><th>Tanggal</th><th>Aksi</th></tr>
<?php $no=1; while($r=mysqli_fetch_assoc($q)){ $foto = (!empty($r['foto']) && file_exists('uploads/'.$r['foto'])) ? 'uploads/'.$r['foto'] : 'assets/no-image.png'; echo '<tr><td>'.$no++.'</td><td><img src="'.htmlspecialchars($foto).'" style="width:70px;height:70px;object-fit:cover;border-radius:6px"></td><td>'.htmlspecialchars($r['kode_barang']).'</td><td>'.htmlspecialchars($r['nama_barang']).'</td><td>'.htmlspecialchars($r['jumlah']).'</td><td>'.htmlspecialchars($r['keterangan']).'</td><td>'.htmlspecialchars($r['created_at']).'</td><td><a href="hapus_rijek.php?id='.$r['id'].'" style="background:#dc3545;color:#fff;padding:6px 10px;border-radius:6px;text-decoration:none" onclick="return confirm(\'Hapus?\')">Hapus</a></td></tr>'; } ?>
</table>
</div></body></html>
