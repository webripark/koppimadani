<?php
include 'koneksi.php';
$err = '';
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $foto = null;
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $err = 'Username sudah terdaftar';
    } else {
        if (!empty($_FILES['foto']['name'])) {
            $target_dir = 'uploads/';
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $name = time() . '_' . basename($_FILES['foto']['name']);
            $target = $target_dir . $name;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target);
            $foto = $name;
        }
        $ins = mysqli_query($conn, "INSERT INTO users (username,password,nama_lengkap,foto,created_at) VALUES ('$username','$password','$nama_lengkap'," . ($foto?"'".$foto."'":"NULL") . ",NOW())");
        if ($ins) {
            echo "<script>alert('Pendaftaran berhasil, silakan login.');window.location='login.php';</script>";
            exit;
        } else {
            $err = 'Gagal mendaftar';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Register - Inventory App</title>
<style>
*{box-sizing:border-box;font-family:Arial,sans-serif}
body{background:linear-gradient(135deg,#1cc88a,#4e73df);height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.card{width:420px;padding:28px;border-radius:12px;background:rgba(255,255,255,0.12);backdrop-filter:blur(6px);color:#fff}
input{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:none}
button{width:100%;padding:10px;border-radius:8px;border:none;background:#fff;color:#333;font-weight:600}
.error{background:#ff6b6b;color:#fff;padding:8px;border-radius:6px;margin-bottom:10px;text-align:center}
</style>
</head>
<body>
<div class="card">
<h2 style="text-align:center">Daftar Akun</h2>
<?php if(!empty($err)): ?><div class="error"><?=htmlspecialchars($err)?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data">
<input name="username" placeholder="Username" required>
<input name="nama_lengkap" placeholder="Nama Lengkap" required>
<input name="password" type="password" placeholder="Password" required>
<label style="color:#fff;font-size:13px">Foto Profil (opsional)</label>
<input type="file" name="foto" accept="image/*">
<button type="submit" name="register">Daftar</button>
</form>
<p style="text-align:center;margin-top:10px;color:rgba(255,255,255,0.9)"><a href="login.php">Sudah punya akun? Login</a></p>
</div>
</body>
</html>
