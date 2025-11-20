<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
include 'koneksi.php';
include 'sidebar.php';

$awal  = $_GET['awal'] ?? date('Y-m-01');
$akhir = $_GET['akhir'] ?? date('Y-m-d');

$q_masuk = mysqli_query($conn, "SELECT m.*, b.kode_barang, b.nama_barang 
    FROM pemasukan_barang m 
    LEFT JOIN barang b ON m.barang_id=b.id 
    WHERE m.tanggal_masuk BETWEEN '$awal' AND '$akhir' 
    ORDER BY m.tanggal_masuk DESC");

$q_keluar = mysqli_query($conn, "SELECT p.*, b.kode_barang, b.nama_barang 
    FROM pengeluaran_barang p 
    LEFT JOIN barang b ON p.barang_id=b.id 
    WHERE p.tanggal_keluar BETWEEN '$awal' AND '$akhir' 
    ORDER BY p.tanggal_keluar DESC");

$q_stok = mysqli_query($conn, "SELECT * FROM barang ORDER BY nama_barang ASC");

$q_rijek = mysqli_query($conn, "SELECT r.*, b.kode_barang, b.nama_barang 
    FROM barang_rijek r 
    LEFT JOIN barang b ON r.id_barang=b.id 
    WHERE DATE(r.created_at) BETWEEN '$awal' AND '$akhir' 
    ORDER BY r.created_at DESC");
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Laporan</title>

<!-- STYLING -->
<style>
body {
    font-family: Poppins, Arial, sans-serif;
    margin: 0;
    background: #f4f6f9;
}
.container {
    margin-left: 240px;
    padding: 32px;
}
.card {
    background: #fff;
    padding: 20px;
    margin-top: 22px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.card h3 {
    margin: 0 0 12px 0;
}
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
}
.table th {
    background: #e9ecef;
    padding: 10px;
    border: 1px solid #ddd;
    font-size: 14px;
}
.table td {
    padding: 8px;
    border: 1px solid #ddd;
    background: #fff;
    font-size: 14px;
}
.table tr:nth-child(even) td {
    background: #f7f9fc;
}
.btn-print {
    background: #ff4d4d;
    color: #fff;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}
.filter-box {
    display: flex;
    gap: 16px;
    background: #fff;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 20px;
}
.filter-box input {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
.filter-btn {
    padding: 10px 14px;
    background: #0d6efd;
    border: none;
    color: #fff;
    border-radius: 8px;
    cursor: pointer;
}
.filter-btn:hover {
    background: #0b5ed7;
}
.section-title {
    margin-bottom: 6px;
    font-size: 22px;
    font-weight: 600;
}
</style>
</head>

<body>

<div class="container">

<h1 class="section-title">Laporan Inventori</h1>

<form class="filter-box" method="get">
    <div>
        <label>Dari</label><br>
        <input type="date" name="awal" value="<?=htmlspecialchars($awal)?>">
    </div>

    <div>
        <label>Sampai</label><br>
        <input type="date" name="akhir" value="<?=htmlspecialchars($akhir)?>">
    </div>

    <div style="align-self:flex-end;">
        <button class="filter-btn" type="submit">Filter</button>
    </div>
</form>

<!-- BARANG MASUK -->
<div class="card">
    <h3>Barang Masuk (<?=htmlspecialchars($awal)?> — <?=htmlspecialchars($akhir)?>)</h3>
    <a class="btn-print" target="_blank" 
       href="print_masuk.php?awal=<?=urlencode($awal)?>&akhir=<?=urlencode($akhir)?>">Cetak</a>

    <table class="table">
        <tr>
            <th>No</th><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Supplier</th><th>Tanggal</th>
        </tr>
        <?php $no=1; while($r=mysqli_fetch_assoc($q_masuk)){ ?>
        <tr>
            <td><?=$no++?></td>
            <td><?=htmlspecialchars($r['kode_barang'])?></td>
            <td><?=htmlspecialchars($r['nama_barang'])?></td>
            <td><?=htmlspecialchars($r['jumlah'])?></td>
            <td><?=htmlspecialchars($r['supplier'])?></td>
            <td><?=htmlspecialchars($r['tanggal_masuk'])?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- BARANG KELUAR -->
<div class="card">
    <h3>Barang Keluar (<?=htmlspecialchars($awal)?> — <?=htmlspecialchars($akhir)?>)</h3>
    <a class="btn-print" target="_blank" 
       href="print_keluar.php?awal=<?=urlencode($awal)?>&akhir=<?=urlencode($akhir)?>">Cetak</a>

    <table class="table">
        <tr>
            <th>No</th><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Tujuan</th><th>Tanggal</th>
        </tr>
        <?php $no=1; while($r=mysqli_fetch_assoc($q_keluar)){ ?>
        <tr>
            <td><?=$no++?></td>
            <td><?=htmlspecialchars($r['kode_barang'])?></td>
            <td><?=htmlspecialchars($r['nama_barang'])?></td>
            <td><?=htmlspecialchars($r['jumlah'])?></td>
            <td><?=htmlspecialchars($r['tujuan'])?></td>
            <td><?=htmlspecialchars($r['tanggal_keluar'])?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- STOK BARANG -->
<div class="card">
    <h3>Stok Barang</h3>
    <a class="btn-print" target="_blank" href="print_stok.php">Cetak</a>

    <table class="table">
        <tr>
            <th>No</th><th>Kode</th><th>Nama</th><th>Stok</th><th>Stok Minimum</th>
        </tr>
        <?php $no=1; while($r=mysqli_fetch_assoc($q_stok)){ ?>
        <tr>
            <td><?=$no++?></td>
            <td><?=htmlspecialchars($r['kode_barang'])?></td>
            <td><?=htmlspecialchars($r['nama_barang'])?></td>
            <td><?=htmlspecialchars($r['stok'])?></td>
            <td><?=htmlspecialchars($r['stok_minimum'])?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- BARANG RIJEK -->
<div class="card">
    <h3>Barang Rijek (<?=htmlspecialchars($awal)?> — <?=htmlspecialchars($akhir)?>)</h3>
    <a class="btn-print" target="_blank" 
       href="print_rijek.php?awal=<?=urlencode($awal)?>&akhir=<?=urlencode($akhir)?>">Cetak</a>

    <table class="table">
        <tr>
            <th>No</th><th>Kode</th><th>Nama</th><th>Jumlah</th><th>Keterangan</th><th>Tanggal</th>
        </tr>
        <?php $no=1; while($r=mysqli_fetch_assoc($q_rijek)){ ?>
        <tr>
            <td><?=$no++?></td>
            <td><?=htmlspecialchars($r['kode_barang'])?></td>
            <td><?=htmlspecialchars($r['nama_barang'])?></td>
            <td><?=htmlspecialchars($r['jumlah'])?></td>
            <td><?=htmlspecialchars($r['keterangan'])?></td>
            <td><?=htmlspecialchars(date('Y-m-d', strtotime($r['created_at'])))?></td>
        </tr>
        <?php } ?>
    </table>
</div>

</div>
</body>
</html>
