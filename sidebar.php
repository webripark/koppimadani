<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include 'koneksi.php';
$user_id = $_SESSION['user_id'] ?? 0;
$user = null;
if ($user_id) {
    $q = mysqli_query($conn, "SELECT nama_lengkap, foto, username FROM users WHERE id = $user_id");
    if ($q && mysqli_num_rows($q)) $user = mysqli_fetch_assoc($q);
}
$nama = $user['nama_lengkap'] ?? 'Pengguna';
$foto = $user['foto'] ?? null;
$foto_src = (!empty($foto) && file_exists('uploads/'.$foto)) ? 'uploads/'.$foto : 'assets/no-image.png';
?>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.sidebar { width:240px; position:fixed; left:0; top:0; bottom:0; background:linear-gradient(180deg,#4b6cb7,#182848); color:#fff; padding:22px; box-sizing:border-box; overflow-y:auto; }
.sidebar img{width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #ffdd57;display:block;margin:0 auto 10px;}
.sidebar h3{font-size:16px;text-align:center;margin:6px 0;}
.sidebar p{font-size:12px;text-align:center;margin:0 0 12px;color:#e6e6e6;}
.sidebar a{color:#fff;text-decoration:none;display:flex;align-items:center;gap:10px;padding:10px;border-radius:8px;}
.sidebar a.active{background:rgba(255,255,255,0.08);}
.sidebar .menu{margin-top:12px;}
.sidebar i{width:22px;text-align:center}
</style>
<div class="sidebar">
    <a href="profil.php"><img src="<?=htmlspecialchars($foto_src)?>" alt="foto"></a>
    <h3><?=htmlspecialchars($nama)?></h3>
    <p>@<?=htmlspecialchars($user['username'] ?? 'user')?></p>
    <div class="menu">
        <a href="dashboard.php" class="<?=basename($_SERVER['PHP_SELF'])=='dashboard.php'?'active':''?>"><i class="fa fa-home"></i> <span>Dashboard</span></a>
        <a href="stok_barang.php" class="<?=basename($_SERVER['PHP_SELF'])=='stok_barang.php'?'active':''?>"><i class="fa fa-boxes"></i> <span>Stok Barang</span></a>
        <a href="tambah_barang.php"><i class="fa fa-plus-circle"></i> <span>Tambah Barang</span></a>
        <a href="barang_masuk.php" class="<?=basename($_SERVER['PHP_SELF'])=='barang_masuk.php'?'active':''?>"><i class="fa fa-download"></i> <span>Barang Masuk</span></a>
        <a href="barang_keluar.php" class="<?=basename($_SERVER['PHP_SELF'])=='barang_keluar.php'?'active':''?>"><i class="fa fa-upload"></i> <span>Barang Keluar</span></a>
        <a href="barang_rijek.php" class="<?=basename($_SERVER['PHP_SELF'])=='barang_rijek.php'?'active':''?>"><i class="fa fa-times-circle"></i> <span>Barang Rijek</span></a>
        <a href="data_user.php" class="<?=basename($_SERVER['PHP_SELF'])=='data_user.php'?'active':''?>"><i class="fa fa-users"></i> <span>Data User</span></a>
        <a href="profil.php" class="<?=basename($_SERVER['PHP_SELF'])=='profil.php'?'active':''?>"><i class="fa fa-user"></i> <span>Profil</span></a>
        <a href="logout.php"><i class="fa fa-sign-out-alt"></i> <span>Logout</span></a>
    </div>
</div>
