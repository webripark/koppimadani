<?php
session_start();
include 'koneksi.php';
$error = '';
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $q = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if ($q && mysqli_num_rows($q) > 0) {
        $user = mysqli_fetch_assoc($q);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
            exit;
        }
    }
    $error = 'Username atau password salah';
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login - Inventory App</title>
<style>
*{box-sizing:border-box;font-family:Arial,sans-serif}
body{background:linear-gradient(135deg,#4e73df,#1cc88a);height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.card{width:360px;padding:28px;border-radius:12px;background:rgba(255,255,255,0.12);backdrop-filter:blur(6px);color:#fff}
input{width:100%;padding:10px;margin:8px 0;border-radius:8px;border:none}
button{width:100%;padding:10px;border-radius:8px;border:none;background:#fff;color:#333;font-weight:600}
.error{background:#ff6b6b;color:#fff;padding:8px;border-radius:6px;margin-bottom:10px;text-align:center}
a{color:#ffe066}
</style>
</head>
<body>
<div class="card">
<h2 style="text-align:center">Inventory App - Login</h2>
<?php if(!empty($error)): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post">
<input name="username" placeholder="Username" required>
<input name="password" type="password" placeholder="Password" required>
<button type="submit" name="login">Masuk</button>
</form>
<p style="text-align:center;margin-top:10px;color:rgba(255,255,255,0.9)">Belum punya akun? <a href="register.php">Daftar</a></p>
</div>
</body>
</html>
