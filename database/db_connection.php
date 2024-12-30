<?php
$host = 'localhost'; // Nama host
$user = 'root'; // Username database
$password = ''; // Password database
$database = 'db_connection'; // Nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_connection', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
