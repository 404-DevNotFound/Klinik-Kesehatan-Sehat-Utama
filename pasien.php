<?php
session_start();
require_once 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$message = '';
$message_type = '';

// Proses DELETE
if (isset($_GET['delete'])) {
    $id = clean_input($_GET['delete']);
    $delete_query = "DELETE FROM pasien WHERE id = '$id'";
    if (mysqli_query($conn, $delete_query)) {
        $message = 'Data pasien berhasil dihapus!';
        $message_type = 'success';
    } else {
        $message = 'Gagal menghapus data pasien!';
        $message_type = 'error';
    }
}

// Proses CREATE & UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? clean_input($_POST['id']) : '';
    $nama = clean_input($_POST['nama_lengkap']);
    $nik = clean_input($_POST['nik']);
    $tanggal_lahir = clean_input($_POST['tanggal_lahir']);
    $jenis_kelamin = clean_input($_POST['jenis_kelamin']);
    $alamat = clean_input($_POST['alamat']);
    $no_telepon = clean_input($_POST['no_telepon']);
    $email = clean_input($_POST['email']);
    
    if (empty($id)) {
        // CREATE - Insert data baru
        $query = "INSERT INTO pasien (nama_lengkap, nik, tanggal_lahir, jenis_kelamin, alamat, no_telepon, email) 
                  VALUES ('$nama', '$nik', '$tanggal_lahir', '$jenis_kelamin', '$alamat', '$no_telepon', '$email')";
        
        if (mysqli_query($conn, $query)) {
            $message = 'Data pasien berhasil ditambahkan!';
            $message_type = 'success';
        } else {
            $message = 'Gagal menambahkan data: ' . mysqli_error($conn);
            $message_type = 'error';
        }
    } else {
        // UPDATE - Edit data (Perbaikan: hapus koma sebelum WHERE)
        $query = "UPDATE pasien SET 
                  nama_lengkap = '$nama',
                  nik = '$nik',
                  tanggal_lahir = '$tanggal_lahir',
                  jenis_kelamin = '$jenis_kelamin',
                  alamat = '$alamat',
                  no_telepon = '$no_telepon',
                  email = '$email'
                  WHERE id = '$id'";
        
        if (mysqli_query($conn, $query)) {
            $message = 'Data pasien berhasil diupdate!';
            $message_type = 'success';
        } else {
            $message = 'Gagal mengupdate data: ' . mysqli_error($conn);
            $message_type = 'error';
        }
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = clean_input($_GET['edit']);
    $edit_query = "SELECT * FROM pasien WHERE id = '$edit_id' LIMIT 1";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_data = mysqli_fetch_assoc($edit_result);
}

// READ - Ambil semua data pasien
$query = "SELECT * FROM pasien ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Klinik Sehat Utama</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 24px;
        }
        
        .back-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }
        
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        .message.success {
            background: #4CAF50;
            color: white;
        }
        
        .message.error {
            background: #f44336;
            color: white;
        }
        
        .form-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .form-section h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 20px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        
        .btn-primary:hover {
            background: #45a049;
        }
        
        .btn-secondary {
            background: #757575;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #616161;
        }
        
        .table-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        tr:hover {
            background: #f5f5f5;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit {
            background: #2196F3;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
        }
        
        .btn-delete {
            background: #f44336;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
        }
        
        .btn-edit:hover {
            background: #1976D2;
        }
        
        .btn-delete:hover {
            background: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👥 Data Pasien</h1>
            <a href="dashboard.php" class="back-btn">← Kembali ke Dashboard</a>
        </div>
        
        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Form Tambah/Edit -->
        <div class="form-section">
            <h2><?php echo $edit_data ? '✏️ Edit Data Pasien' : '➕ Tambah Data Pasien'; ?></h2>
            <form method="POST" action="pasien.php">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" value="<?php echo $edit_data['nama_lengkap'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>NIK (No. KTP) *</label>
                        <input type="text" name="nik" value="<?php echo $edit_data['nik'] ?? ''; ?>" maxlength="16" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" value="<?php echo $edit_data['tanggal_lahir'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" <?php echo ($edit_data['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo ($edit_data['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>No. Telepon *</label>
                        <input type="text" name="no_telepon" value="<?php echo $edit_data['no_telepon'] ?? ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $edit_data['email'] ?? ''; ?>">
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 20px;">
                    <label>Alamat *</label>
                    <textarea name="alamat" required><?php echo $edit_data['alamat'] ?? ''; ?></textarea>
                </div>
                
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">
                        <?php echo $edit_data ? '💾 Update Data' : '➕ Tambah Data'; ?>
                    </button>
                    <?php if ($edit_data): ?>
                        <a href="pasien.php" class="btn btn-secondary">Batal</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Tabel Data -->
        <div class="table-section">
            <h2 style="color: #667eea; margin-bottom: 10px;">📋 Daftar Pasien</h2>
            <p style="color: #666; margin-bottom: 20px;">Total: <strong><?php echo mysqli_num_rows($result); ?></strong> pasien</p>
            
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NIK</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($row['nik']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_lahir'])); ?></td>
                        <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_telepon']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="pasien.php?edit=<?php echo $row['id']; ?>" class="btn-edit">✏️ Edit</a>
                                <a href="pasien.php?delete=<?php echo $row['id']; ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('Yakin ingin menghapus data <?php echo htmlspecialchars($row['nama_lengkap']); ?>?')">
                                   🗑️ Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if (mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #999; padding: 30px;">
                            Belum ada data pasien
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>