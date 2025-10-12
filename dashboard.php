<?php
session_start();
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil data dari session
$username = $_SESSION['username'];
$role = $_SESSION['role'] ?? 'user';
$email = $_SESSION['email'] ?? '';
$login_time = $_SESSION['login_time'] ?? 'Unknown';

// Ambil parameter dari query string
$action = $_GET['action'] ?? '';
$message = $_GET['message'] ?? '';

// Hitung statistik dari database
$query_total_pasien = "SELECT COUNT(*) as total FROM pasien";
$result_pasien = mysqli_query($conn, $query_total_pasien);
$total_pasien = mysqli_fetch_assoc($result_pasien)['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Klinik Sehat Utama</title>
    <link rel="icon" type="image/png" sizes="16x16" href="media/Logo.png" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .dashboard-header {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .dashboard-header h1 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .user-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .user-info h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .info-item {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 10px;
        }
        
        .info-item strong {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        
        .info-item span {
            font-size: 18px;
            font-weight: bold;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .menu-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .menu-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .menu-card h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .menu-card p {
            color: #666;
            font-size: 14px;
        }
        
        .logout-btn {
            background: #f44336;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: background 0.3s ease;
            cursor: pointer;
        }
        
        .logout-btn:hover {
            background: #d32f2f;
        }
        
        .home-btn {
            background: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: background 0.3s ease;
            cursor: pointer;
            margin-right: 10px;
        }
        
        .home-btn:hover {
            background: #45a049;
        }
        
        .message {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .stat-label {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1>🏥 Dashboard Klinik Sehat Utama</h1>
            <p>Sistem Manajemen Klinik - Panel Administrasi</p>
        </div>

        <!-- Success Message -->
        <?php if ($message): ?>
            <div class="message">
                ✓ <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- User Info -->
        <div class="user-info">
            <h2>👤 Informasi Pengguna</h2>
            <div class="info-grid">
                <div class="info-item">
                    <strong>Username</strong>
                    <span><?php echo htmlspecialchars($username); ?></span>
                </div>
                <div class="info-item">
                    <strong>Email</strong>
                    <span><?php echo htmlspecialchars($email); ?></span>
                </div>
                <div class="info-item">
                    <strong>Role</strong>
                    <span><?php echo strtoupper(htmlspecialchars($role)); ?></span>
                </div>
                <div class="info-item">
                    <strong>Waktu Login</strong>
                    <span><?php echo htmlspecialchars($login_time); ?></span>
                </div>
                <div class="info-item">
                    <strong>Status</strong>
                    <span>🟢 Online</span>
                </div>
            </div>
            <div>
                <a href="index.php" class="home-btn">🏠 Ke Halaman Utama</a>
                <a href="logout.php" class="logout-btn">🚪 Logout</a>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="menu-grid">
            <a href="dashboard.php?action=jadwal" class="menu-card">
                <div class="menu-icon">📅</div>
                <h3>Jadwal Dokter</h3>
                <p>Lihat dan kelola jadwal praktek dokter</p>
            </a>

            <a href="pasien.php" class="menu-card" style="border: 3px solid #4CAF50;">
                <div class="menu-icon">👥</div>
                <h3>Data Pasien</h3>
                <p>Manajemen data dan rekam medis pasien (CRUD)</p>
            </a>

            <a href="dashboard.php?action=appointment" class="menu-card">
                <div class="menu-icon">🗓️</div>
                <h3>Appointment</h3>
                <p>Kelola janji temu dan reservasi</p>
            </a>

            <a href="dashboard.php?action=layanan" class="menu-card">
                <div class="menu-icon">🏥</div>
                <h3>Layanan</h3>
                <p>Daftar layanan klinik dan fasilitas</p>
            </a>

            <a href="dashboard.php?action=laporan" class="menu-card">
                <div class="menu-icon">📊</div>
                <h3>Laporan</h3>
                <p>Laporan statistik dan keuangan</p>
            </a>

            <a href="dashboard.php?action=settings" class="menu-card">
                <div class="menu-icon">⚙️</div>
                <h3>Pengaturan</h3>
                <p>Konfigurasi sistem dan profil</p>
            </a>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_pasien; ?></div>
                <div class="stat-label">Total Pasien Terdaftar</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Dokter Aktif</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">89</div>
                <div class="stat-label">Appointment Minggu Ini</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">98%</div>
                <div class="stat-label">Tingkat Kepuasan</div>
            </div>
        </div>

        <?php if ($action): ?>
            <div style="background: white; border-radius: 15px; padding: 30px; margin-top: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <h2 style="color: #667eea; margin-bottom: 20px;">
                    📌 Halaman: <?php echo htmlspecialchars(ucfirst($action)); ?>
                </h2>
                <p style="color: #666;">
                    Anda mengakses menu <strong><?php echo htmlspecialchars($action); ?></strong> 
                    menggunakan query string parameter <code>?action=<?php echo htmlspecialchars($action); ?></code>
                </p>
                <p style="color: #666; margin-top: 15px;">
                    Fitur ini mendemonstrasikan penggunaan <code>$_GET</code> untuk menangani navigasi berbasis URL.
                </p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>