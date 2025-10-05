<?php
session_start();

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Proses pendaftaran
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';
    $role = $_POST['new-role'] ?? 'user';
    
    // Validasi
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Dalam praktik nyata, simpan ke database
        // Di sini kita langsung login setelah registrasi
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        
        // Redirect ke dashboard dengan pesan sukses
        header('Location: dashboard.php?message=Pendaftaran berhasil! Selamat datang.');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Pendaftaran</title>
    <link rel="icon" type="image/png" sizes="16x16" href="media/Logo.png" />
    <link rel="stylesheet" href="styles2.css" />
</head>
<body>
    <form method="POST" action="signup.php">
        <?php if ($error): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div style="color: green; margin-bottom: 10px;"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        
        <label for="rolebaru">Daftar Sebagai:</label><br />
        <select id="rolebaru" name="new-role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br /><br />

        <label for="username">Username:</label><br />
        <input type="text" id="username" name="username" required /><br /><br />

        <label for="email">Email:</label><br />
        <input type="email" id="email" name="email" required /><br /><br />

        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <label for="confirm-password">Konfirmasi Password:</label><br />
        <input type="password" id="confirm-password" name="confirm-password" required /><br /><br />

        <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>