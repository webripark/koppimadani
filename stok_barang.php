<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Stok Barang</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:Arial;margin:0;background:#f4f6f9}
.main{margin-left:240px;padding:22px}
.table-box{background:#fff;padding:16px;border-radius:10px;box-shadow:0 4px 12px rgba(0,0,0,0.04)}
.table-box table{width:100%;border-collapse:collapse}
.table-box th, .table-box td{padding:10px;border-bottom:1px solid #eee;text-align:left}
.thumb{width:70px;height:70px;object-fit:cover;border-radius:8px}
.controls{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.search{padding:8px;border-radius:8px;border:1px solid #ccc}
.btn{padding:8px 12px;border-radius:8px;text-decoration:none;color:#fff}
.add{background:#28a745}
</style>
</head>
<body>
<div class="main">
<h2>Stok Barang KOPPI MADANI</h2>
<div class="table-box">
<div class="controls"><a class="btn add" href="tambah_barang.php"><i class="fa fa-plus"></i> Tambah Barang</a><input class="search" id="search" placeholder="Cari..."></div>
<table>
<thead><tr><th>No</th><th>Foto</th><th>Kode</th><th>Nama</th><th>Kategori</th><th>Satuan</th><th>Stok</th><th>Min</th><th>Aksi</th></tr></thead>
<tbody>
<?php
$q = mysqli_query($conn, "SELECT * FROM barang ORDER BY created_at DESC");
$no=1;
if ($q && mysqli_num_rows($q)>0) {
  while($r=mysqli_fetch_assoc($q)) {
    $foto = (!empty($r['foto']) && file_exists('uploads/'.$r['foto'])) ? 'uploads/'.$r['foto'] : 'assets/no-image.png';
    echo '<tr data-name="'.htmlspecialchars(strtolower($r['nama_barang'].' '.$r['kode_barang'])).'">';
    echo '<td>'.$no++.'</td>';
    echo '<td><img src="'.htmlspecialchars($foto).'" class="thumb"></td>';
    echo '<td>'.htmlspecialchars($r['kode_barang']).'</td>';
    echo '<td>'.htmlspecialchars($r['nama_barang']).'</td>';
    echo '<td>'.htmlspecialchars($r['kategori']).'</td>';
    echo '<td>'.htmlspecialchars($r['satuan']).'</td>';
    echo '<td>'.htmlspecialchars($r['stok']).'</td>';
    echo '<td>'.htmlspecialchars($r['stok_minimum']).'</td>';
    echo '<td><a href="detail_barang.php?id='.$r['id'].'" class="btn" style="background:#0d6efd"><i class="fa fa-eye"></i></a> <a href="edit_barang.php?id='.$r['id'].'" class="btn" style="background:#ffc107;color:#000"><i class="fa fa-edit"></i></a> <a href="hapus_barang.php?id='.$r['id'].'" class="btn" style="background:#dc3545" onclick="return confirm(\'Hapus barang ini?\')"><i class="fa fa-trash"></i></a></td>';
    echo '</tr>';
  }
} else {
  echo '<tr><td colspan="9">Tidak ada data.</td></tr>';
}
?>
</tbody>
</table>
</div>
</div>
<script>
document.getElementById('search').addEventListener('input', function(){
  const v = this.value.toLowerCase();
  document.querySelectorAll('tbody tr').forEach(tr=>{
    tr.style.display = tr.dataset.name.includes(v) ? '' : 'none';
  });
});
</script>
</body>
</html>
