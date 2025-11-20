<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$err='';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $kode = mysqli_real_escape_string($conn,$_POST['kode_barang']);
    $nama = mysqli_real_escape_string($conn,$_POST['nama_barang']);
    $kategori = mysqli_real_escape_string($conn,$_POST['kategori']);
    $satuan = mysqli_real_escape_string($conn,$_POST['satuan']);
    $stok = (int)$_POST['stok'];
    $stok_min = (int)$_POST['stok_minimum'];
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $dir='uploads/'; if(!is_dir($dir)) mkdir($dir,0777,true);
        $name=time().'_'.basename($_FILES['foto']['name']);
        $target=$dir.$name;
        $ext=strtolower(pathinfo($target,PATHINFO_EXTENSION));
        $allow=['jpg','jpeg','png','gif'];
        if(in_array($ext,$allow)) {
            move_uploaded_file($_FILES['foto']['tmp_name'],$target);
            $foto=$name;
        } else { $err='Format foto tidak didukung'; }
    }
    if(empty($err)){
      $ins = mysqli_query($conn, "INSERT INTO barang (kode_barang,nama_barang,kategori,satuan,stok,stok_minimum,foto,created_at) VALUES ('$kode','$nama','$kategori','$satuan',$stok,$stok_min,".($foto?"'".$foto."'":"NULL").",NOW())");
      if ($ins) { header('Location: stok_barang.php'); exit; } else { $err='Gagal menyimpan'; }
    }
}
?>
<!doctype html>
<html lang="id"><head><meta charset="utf-8"><title>Tambah Barang</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Tambah Barang</h2>
<?php if(!empty($err)) echo '<p style="color:red">'.htmlspecialchars($err).'</p>'; ?>
<form method="post" enctype="multipart/form-data" style="background:#fff;padding:16px;border-radius:8px;width:420px;">
<label>Kode Barang</label><input name="kode_barang" required style="width:100%;padding:8px;margin:6px 0"><br>
<label>Nama Barang</label><input name="nama_barang" required style="width:100%;padding:8px;margin:6px 0"><br>
<label>Kategori</label><input name="kategori" style="width:100%;padding:8px;margin:6px 0"><br>
<label>Satuan</label>
<select name="satuan" style="width:100%;padding:8px;margin:6px 0">
  <option value="Unit">Unit</option><option value="Kg">Kg</option><option value="Box">Box</option><option value="Liter">Liter</option><option value="Pcs">Pcs</option>
</select><br>
<label>Stok</label><input name="stok" type="number" value="0" style="width:100%;padding:8px;margin:6px 0"><br>
<label>Stok Minimum</label><input name="stok_minimum" type="number" value="0" style="width:100%;padding:8px;margin:6px 0"><br>
<label>Foto Barang</label><input type="file" name="foto" accept="image/*"><br><br>
<button type="submit" style="padding:10px 14px;background:#28a745;color:#fff;border:none;border-radius:6px">Simpan</button>
</form>
</div>
</body></html>
