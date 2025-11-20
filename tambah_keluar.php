<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';
$err='';
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $barang_id = (int)$_POST['barang_id'];
    $jumlah = (int)$_POST['jumlah'];
    $tanggal = mysqli_real_escape_string($conn,$_POST['tanggal']);
    $tujuan = mysqli_real_escape_string($conn,$_POST['tujuan']);
    $user_id = $_SESSION['user_id'];
    // check stok
    $stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM barang WHERE id=$barang_id"))['stok'] ?? 0;
    if ($jumlah > $stok) $err='Jumlah melebihi stok.';
    else {
        $ins = mysqli_query($conn, "INSERT INTO pengeluaran_barang (barang_id,jumlah,tanggal_keluar,tujuan,user_id,created_at) VALUES ($barang_id,$jumlah,'$tanggal','$tujuan',$user_id,NOW())");
        if ($ins) {
            mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id=$barang_id");
            header('Location: barang_keluar.php'); exit;
        } else $err='Gagal menyimpan';
    }
}
$barang = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Input Barang Keluar</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Input Barang Keluar</h2>
<?php if(!empty($err)) echo '<p style="color:red">'.htmlspecialchars($err).'</p>'; ?>
<form method="post" style="background:#fff;padding:12px;border-radius:8px;width:420px">
<label>Pilih Barang</label>
<select name="barang_id" required style="width:100%;padding:8px;margin:6px 0">
<option value="">-- Pilih --</option>
<?php while($r=mysqli_fetch_assoc($barang)) echo '<option value="'.$r['id'].'">'.htmlspecialchars($r['kode_barang'].' - '.$r['nama_barang'].' (Stok: '.$r['stok'].')').'</option>'; ?>
</select>
<label>Jumlah</label><input type="number" name="jumlah" value="1" style="width:100%;padding:8px;margin:6px 0">
<label>Tanggal</label><input type="date" name="tanggal" value="<?=date('Y-m-d')?>" style="width:100%;padding:8px;margin:6px 0">
<label>Tujuan</label><input name="tujuan" style="width:100%;padding:8px;margin:6px 0">
<button type="submit" style="padding:8px 12px;background:#ff6b6b;color:#fff;border-radius:6px;border:none">Simpan</button>
</form>
</div></body></html>
