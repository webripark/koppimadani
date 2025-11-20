<?php
session_start();
include 'koneksi.php';
include 'sidebar.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');
$user_id = $_SESSION['user_id'];
$q = mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id");
if (!$q || mysqli_num_rows($q)==0) die('User tidak ditemukan');
$user = mysqli_fetch_assoc($q);
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $nama = mysqli_real_escape_string($conn,$_POST['nama_lengkap']);
    $password = $_POST['password'];
    $foto = $user['foto'];
    if (!empty($_FILES['foto']['name'])) {
        $dir='uploads/'; if(!is_dir($dir)) mkdir($dir,0777,true);
        $name=time().'_'.basename($_FILES['foto']['name']);
        $target=$dir.$name;
        move_uploaded_file($_FILES['foto']['tmp_name'],$target);
        if(!empty($foto) && file_exists('uploads/'.$foto)) unlink('uploads/'.$foto);
        $foto = $name;
    }
    if (!empty($password)) $pw = "password='".password_hash($password,PASSWORD_DEFAULT)."',"; else $pw='';
    mysqli_query($conn, "UPDATE users SET nama_lengkap='$nama',$pw foto=".($foto?"'".$foto."'":"NULL")." WHERE id=$user_id");
    echo "<script>alert('Profil diperbarui');window.location='profil.php'</script>";
    exit;
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><title>Profil</title></head>
<body style="font-family:Arial;margin:0;">
<div style="margin-left:240px;padding:20px;">
<h2>Profil</h2>
<form method="post" enctype="multipart/form-data" style="background:#fff;padding:16px;border-radius:8px;width:420px;">
<label>Nama Lengkap</label><input name="nama_lengkap" value="<?=htmlspecialchars($user['nama_lengkap'])?>" style="width:100%;padding:8px;margin:6px 0;"><br>
<label>Password Baru (kosongkan jika tidak ingin ubah)</label><input name="password" type="password" style="width:100%;padding:8px;margin:6px 0;"><br>
<label>Foto Profil</label><br>
<?php if(!empty($user['foto']) && file_exists('uploads/'.$user['foto'])): ?>
<img src="uploads/<?=htmlspecialchars($user['foto'])?>" style="width:120px;border-radius:8px;"><br>
<?php endif; ?>
<input type="file" name="foto" accept="image/*"><br><br>
<button type="submit" style="padding:10px 14px;background:#007bff;color:#fff;border:none;border-radius:6px;">Simpan</button>
</form>
</div></body></html>
