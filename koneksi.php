<?php
// Konfigurasi Database
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "klinik_Sehat"; 

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset untuk mendukung karakter Indonesia
mysqli_set_charset($conn, "utf8");

// Fungsi untuk mencegah SQL Injection
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}
?>