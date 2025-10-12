-- Database: klinik_sehat
CREATE DATABASE IF NOT EXISTS klinik_sehat;
USE klinik_sehat;

-- Tabel Users untuk autentikasi
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Pasien untuk CRUD (Versi Sederhana tanpa golongan darah)
CREATE TABLE pasien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    nik VARCHAR(16) NOT NULL UNIQUE,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    alamat TEXT NOT NULL,
    no_telepon VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data contoh users
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@kliniksehat.id', MD5('admin123'), 'admin'),
('user1', 'user1@kliniksehat.id', MD5('user123'), 'user');

-- Insert data contoh pasien
INSERT INTO pasien (nama_lengkap, nik, tanggal_lahir, jenis_kelamin, alamat, no_telepon, email) VALUES
('Ahmad Ridwan', '6401012345670001', '1990-05-15', 'Laki-laki', 'Jl. Merdeka No. 123, Samarinda', '081234567890', 'ahmad@email.com'),
('Siti Nurhaliza', '6401012345670002', '1985-08-20', 'Perempuan', 'Jl. Sudirman No. 45, Samarinda', '081234567891', 'siti@email.com'),
('Budi Santoso', '6401012345670003', '1995-03-10', 'Laki-laki', 'Jl. Ahmad Yani No. 78, Samarinda', '081234567892', 'budi@email.com'),
('Dewi Lestari', '6401012345670004', '1992-11-25', 'Perempuan', 'Jl. Pahlawan No. 90, Samarinda', '081234567893', 'dewi@email.com');