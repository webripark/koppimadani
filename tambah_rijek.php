<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$err='';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $id_barang = (int)$_POST['id_barang'];
    $jumlah = (int)$_POST['jumlah'];
    $keterangan = mysqli_real_escape_string($conn,$_POST['keterangan']);
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $dir='uploads/'; if(!is_dir($dir)) mkdir($dir,0777,true);
        $name=time().'_'.basename($_FILES['foto']['name']);
        $target=$dir.$name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$target);
        $foto=$name;
    }
    $ins = mysqli_query($conn, "INSERT INTO barang_rijek (id_barang,jumlah,keterangan,foto,created_at) VALUES ($id_barang,$jumlah,'$keterangan',".($foto?"'".$foto."'":"NULL").",NOW())");
    if ($ins) {
        mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id=$id_barang");
        header('Location: barang_rijek.php'); exit;
    } else $err='Gagal simpan';
}
$barang = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Input Rijek</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Input Barang Rijek</h2>
<?php if(!empty($err)) echo '<p style="color:red">'.htmlspecialchars($err).'</p>'; ?>
<form method="post" enctype="multipart/form-data" style="background:#fff;padding:12px;border-radius:8px;width:420px">
<label>Pilih Barang</label>
<select name="id_barang" required style="width:100%;padding:8px;margin:6px 0">
<option value="">-- Pilih --</option>
<?php while($r=mysqli_fetch_assoc($barang)) echo '<option value="'.$r['id'].'">'.htmlspecialchars($r['kode_barang'].' - '.$r['nama_barang'].' (Stok: '.$r['stok'].')').'</option>'; ?>
</select>
<label>Jumlah Rusak</label><input type="number" name="jumlah" value="1" style="width:100%;padding:8px;margin:6px 0">
<label>Keterangan</label><input name="keterangan" style="width:100%;padding:8px;margin:6px 0">
<label>Foto (opsional)</label><input type="file" name="foto" accept="image/*"><br><br>
<button type="submit" style="padding:8px 12px;background:#ffb86b;color:#222;border-radius:6px;border:none">Simpan</button>
</form>
</div></body></html>
