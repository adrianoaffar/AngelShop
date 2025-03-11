<?php
$servername = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'angelshop';

// Aktifkan laporan error untuk debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Buat koneksi ke database
$conn = mysqli_connect($servername, $username, $password, $database) 
    or die("Koneksi gagal: " . mysqli_connect_error());

// Set karakter encoding ke utf8mb4 untuk mendukung karakter khusus
mysqli_set_charset($conn, "utf8mb4");
?>
