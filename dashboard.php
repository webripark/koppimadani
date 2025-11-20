<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';

// stats
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang"))['total'] ?? 0;
$total_stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) AS total FROM barang"))['total'] ?? 0;
$total_masuk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pemasukan_barang"))['total'] ?? 0;
$total_keluar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pengeluaran_barang"))['total'] ?? 0;
$stok_minimum = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM barang WHERE stok <= stok_minimum"))['total'] ?? 0;
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>KOPPI MADANI</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    margin:0;
    font-family:Poppins,Arial;
    background:linear-gradient(135deg,#c9d6ff,#e2e2e2);
    display:flex;
}

/* MAIN */
.main{
    margin-left:240px;
    padding:40px;
    width:100%;
}

/* TITLE */
h1{
    font-size:32px;
    font-weight:700;
    margin-bottom:5px;
}

/* CARDS GRID */
.cards{
    margin-top:25px;
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
    gap:22px;
}

/* CARD STYLE */
.card{
    backdrop-filter:blur(10px);
    background:rgba(255,255,255,0.40);
    border-radius:18px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,0.12);
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:0.3s;
}
.card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 35px rgba(0,0,0,0.18);
}
.card h3{
    font-size:15px;
    margin:0;
    color:#444;
}
.card span{
    font-size:32px;
    font-weight:700;
}

/* QUICK BUTTONS */
.quick{
    margin-top:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(190px,1fr));
    gap:15px;
}

.btn{
    padding:14px;
    border-radius:14px;
    color:#fff;
    font-weight:600;
    text-decoration:none;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    transition:0.3s;
}
.btn:hover{
    filter:brightness(1.15);
    transform:translateY(-3px);
}

.add{background:linear-gradient(135deg,#36d1dc,#5b86e5);}
.masuk{background:linear-gradient(135deg,#0d6efd,#0a58ca);}
.keluar{background:linear-gradient(135deg,#ff416c,#ff4b2b);}
.rijek{background:linear-gradient(135deg,#ffb347,#ff7e5f);}
.laporan{background:linear-gradient(135deg,#6a11cb,#2575fc);}

footer{
    margin-top:45px;
    color:#555;
    text-align:center;
    padding-bottom:20px;
}
</style>

</head>
<body>

<div class="main">

<h1>KOPPI MADANI</h1>
<p>Ringkasan stok & aktivitas inventori Koppi Madani</p>

<!-- STATISTICS -->
<div class="cards">
    <div class="card">
        <div>
            <h3>Total Barang</h3>
            <span><?= $total_barang ?></span>
        </div>
        <i class="fa fa-boxes" style="font-size:42px;color:#4b6cb7"></i>
    </div>

    <div class="card">
        <div>
            <h3>Total Stok</h3>
            <span><?= $total_stok ?></span>
        </div>
        <i class="fa fa-cubes" style="font-size:42px;color:#2dce89"></i>
    </div>

    <div class="card">
        <div>
            <h3>Transaksi Masuk</h3>
            <span><?= $total_masuk ?></span>
        </div>
        <i class="fa fa-download" style="font-size:42px;color:#0d6efd"></i>
    </div>

    <div class="card">
        <div>
            <h3>Transaksi Keluar</h3>
            <span><?= $total_keluar ?></span>
        </div>
        <i class="fa fa-upload" style="font-size:42px;color:#ff6b6b"></i>
    </div>

    <div class="card">
        <div>
            <h3>Stok di bawah minimum</h3>
            <span><?= $stok_minimum ?></span>
        </div>
        <i class="fa fa-exclamation-triangle" style="font-size:42px;color:#ffc107"></i>
    </div>
</div>

<!-- QUICK ACTION -->
<div class="quick">
    <a class="btn add" href="tambah_barang.php"><i class="fa fa-plus-circle"></i> Tambah Barang</a>
    <a class="btn masuk" href="barang_masuk.php"><i class="fa fa-download"></i> Barang Masuk</a>
    <a class="btn keluar" href="barang_keluar.php"><i class="fa fa-upload"></i> Barang Keluar</a>
    <a class="btn rijek" href="barang_rijek.php"><i class="fa fa-times-circle"></i> Barang Rijek</a>
    <a class="btn laporan" href="laporan.php"><i class="fa fa-file-alt"></i> Laporan</a>
</div>

<footer>© <?= date('Y') ?> Koppi Madani</footer>

</div>
</body>
</html>
