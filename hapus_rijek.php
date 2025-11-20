<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
$id=(int)($_GET['id']??0);
$q=mysqli_query($conn,"SELECT id_barang,jumlah,foto FROM barang_rijek WHERE id=$id");
if($q && mysqli_num_rows($q)>0){
    $r=mysqli_fetch_assoc($q);
    // restore stok (opsional) - we'll not restore automatically to avoid mistakes
    if(!empty($r['foto']) && file_exists('uploads/'.$r['foto'])) unlink('uploads/'.$r['foto']);
    mysqli_query($conn,"DELETE FROM barang_rijek WHERE id=$id");
}
header('Location: barang_rijek.php'); exit;
?>