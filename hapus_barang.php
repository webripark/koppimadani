<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
$id=(int)($_GET['id']??0);
$q=mysqli_query($conn,"SELECT foto FROM barang WHERE id=$id");
if($q && mysqli_num_rows($q)>0){
    $r=mysqli_fetch_assoc($q);
    if(!empty($r['foto']) && file_exists('uploads/'.$r['foto'])) unlink('uploads/'.$r['foto']);
    mysqli_query($conn,"DELETE FROM barang WHERE id=$id");
}
header('Location: stok_barang.php'); exit;
?>