<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$id=(int)($_GET['id']??0);
$q=mysqli_query($conn,"SELECT * FROM barang WHERE id=$id");
if(!$q||mysqli_num_rows($q)==0) die('Barang tidak ditemukan');
$b=mysqli_fetch_assoc($q);
$err='';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nama = mysqli_real_escape_string($conn,$_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn,$_POST['kategori']);
    $satuan = mysqli_real_escape_string($conn,$_POST['satuan']);
    $stok = (int)$_POST['stok'];
    $stok_min = (int)$_POST['stok_minimum'];
    $foto = $b['foto'];
    if(!empty($_FILES['foto']['name'])){
        $dir='uploads/'; if(!is_dir($dir)) mkdir($dir,0777,true);
        $name=time().'_'.basename($_FILES['foto']['name']);
        $target=$dir.$name;
        $ext=strtolower(pathinfo($target,PATHINFO_EXTENSION));
        $allow=['jpg','jpeg','png','gif'];
        if(in_array($ext,$allow)){
            move_uploaded_file($_FILES['foto']['tmp_name'],$target);
            if(!empty($foto) && file_exists('uploads/'.$foto)) unlink('uploads/'.$foto);
            $foto=$name;
        } else $err='Format foto tidak didukung';
    }
    if(empty($err)){
        $up = mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', kategori='$kategori', satuan='$satuan', stok=$stok, stok_minimum=$stok_min, foto=".($foto?"'".$foto."'":"NULL")." WHERE id=$id");
        if($up) { header('Location: stok_barang.php'); exit; } else $err='Gagal update';
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Edit Barang</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Edit Barang</h2>
<?php if(!empty($err)) echo '<p style="color:red">'.htmlspecialchars($err).'</p>'; ?>
<form method="post" enctype="multipart/form-data" style="background:#fff;padding:16px;border-radius:8px;width:420px;">
<label>Nama Barang</label><input name="nama_barang" value="<?=htmlspecialchars($b['nama_barang'])?>" required style="width:100%;padding:8px;margin:6px 0"><br>
<label>Kategori</label><input name="kategori" value="<?=htmlspecialchars($b['kategori'])?>" style="width:100%;padding:8px;margin:6px 0"><br>
<label>Satuan</label>
<select name="satuan" style="width:100%;padding:8px;margin:6px 0">
  <option value="Unit" <?= $b['satuan']=='Unit'?'selected':''?>>Unit</option>
  <option value="Kg" <?= $b['satuan']=='Kg'?'selected':''?>>Kg</option>
  <option value="Box" <?= $b['satuan']=='Box'?'selected':''?>>Box</option>
  <option value="Liter" <?= $b['satuan']=='Liter'?'selected':''?>>Liter</option>
  <option value="Pcs" <?= $b['satuan']=='Pcs'?'selected':''?>>Pcs</option>
</select><br>
<label>Stok</label><input name="stok" type="number" value="<?=htmlspecialchars($b['stok'])?>" style="width:100%;padding:8px;margin:6px 0"><br>
<label>Stok Minimum</label><input name="stok_minimum" type="number" value="<?=htmlspecialchars($b['stok_minimum'])?>" style="width:100%;padding:8px;margin:6px 0"><br>
<label>Foto Barang</label><br>
<?php if(!empty($b['foto']) && file_exists('uploads/'.$b['foto'])): ?>
<img src="uploads/<?=htmlspecialchars($b['foto'])?>" style="width:120px;border-radius:8px"><br>
<?php endif; ?>
<input type="file" name="foto" accept="image/*"><br><br>
<button type="submit" style="padding:10px 14px;background:#007bff;color:#fff;border:none;border-radius:6px">Simpan</button>
</form>
</div>
</body></html>
