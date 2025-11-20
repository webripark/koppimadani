<?php
session_start();
include 'koneksi.php';
include 'sidebar.php';
$q = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Data User</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Data User</h2>
<div style="background:#fff;padding:16px;border-radius:8px;box-shadow:0 3px 10px rgba(0,0,0,0.06)">
<table style="width:100%;border-collapse:collapse">
<tr><th>No</th><th>Foto</th><th>Nama</th><th>Username</th><th>Dibuat</th></tr>
<?php $no=1; while($r=mysqli_fetch_assoc($q)){ $foto = (!empty($r['foto']) && file_exists('uploads/'.$r['foto'])) ? 'uploads/'.$r['foto'] : 'assets/no-image.png'; echo '<tr><td>'.$no++.'</td><td><img src="'.htmlspecialchars($foto).'" style="width:48px;height:48px;object-fit:cover;border-radius:6px"></td><td>'.htmlspecialchars($r['nama_lengkap']).'</td><td>'.htmlspecialchars($r['username']).'</td><td>'.htmlspecialchars($r['created_at']).'</td></tr>'; } ?>
</table>
</div>
</div></body></html>
