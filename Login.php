<?php
session_start();

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}

// Proses login
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';
    
    // Validasi sederhana (dalam praktik nyata, gunakan database dan hash password)
    if (!empty($username) && !empty($password)) {
        // Simpan data ke session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        
        // Redirect ke dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Username dan password harus diisi!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Login</title>
    <link rel="icon" type="image/png" sizes="16x16" href="media/Logo.png" />
    <link rel="stylesheet" href="styles2.css" />
</head>
<body>
    <form method="POST" action="login.php">
        <?php if ($error): ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <label for="role">Login Sebagai:</label><br />
        <select id="role" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br /><br />

        <label for="username">Username / Email:</label><br />
        <input type="text" id="username" name="username" required /><br /><br />

        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="Signup.php">Sign Up di sini</a></p>
</body>
</html>