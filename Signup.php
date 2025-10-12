<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $role = clean_input($_POST['new-role']);
    
    // Validasi
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Cek apakah username sudah ada
        $check_query = "SELECT id FROM users WHERE username = '$username' LIMIT 1";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = 'Username sudah digunakan!';
        } else {
            // Insert user baru
            $password_md5 = md5($password);
            $insert_query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password_md5', '$role')";
            
            if (mysqli_query($conn, $insert_query)) {
                // Ambil ID user yang baru dibuat
                $user_id = mysqli_insert_id($conn);
                
                // Langsung login setelah registrasi
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                
                // Redirect ke dashboard
                header('Location: dashboard.php?message=Pendaftaran berhasil! Selamat datang.');
                exit();
            } else {
                $error = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
            }
        }
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
        <h2 style="text-align: center; margin-bottom: 20px; color: #4CAF50;">🏥 Daftar Akun</h2>
        
        <?php if ($error): ?>
            <div style="color: red; background: #ffebee; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div style="color: green; background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <label for="rolebaru">Daftar Sebagai:</label><br />
        <select id="rolebaru" name="new-role" required>
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