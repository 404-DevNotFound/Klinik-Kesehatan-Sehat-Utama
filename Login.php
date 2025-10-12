<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Proses login
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];
    $role = clean_input($_POST['role']);
    
    if (!empty($username) && !empty($password)) {
        // Query untuk cek user
        $password_md5 = md5($password);
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password_md5' AND role = '$role' LIMIT 1";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            
            // Simpan data ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_time'] = date('Y-m-d H:i:s');
            
            // Redirect ke dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Username, password, atau role tidak sesuai!';
        }
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
        <h2 style="text-align: center; margin-bottom: 20px; color: #4CAF50;">🏥 Login Klinik</h2>
        
        <?php if ($error): ?>
            <div style="color: red; background: #ffebee; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <label for="role">Login Sebagai:</label><br />
        <select id="role" name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br /><br />

        <label for="username">Username:</label><br />
        <input type="text" id="username" name="username" required /><br /><br />

        <label for="password">Password:</label><br />
        <input type="password" id="password" name="password" required /><br /><br />

        <button type="submit">Login</button>
        
        <div style="margin-top: 15px; padding: 10px; background: #e3f2fd; border-radius: 5px; font-size: 12px;">
            <strong>Demo Login:</strong><br>
            Admin: username: <code>admin</code> | password: <code>admin123</code><br>
            User: username: <code>user1</code> | password: <code>user123</code>
        </div>
    </form>
    <p>Belum punya akun? <a href="Signup.php">Sign Up di sini</a></p>
</body>
</html>