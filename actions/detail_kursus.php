<?php
session_start();
include('../database/db_connection.php');

// Ambil ID kursus dari URL
$id_kursus = $_GET['id'];

// Ambil data kursus berdasarkan ID
$query = "SELECT k.id, k.nama, k.deskripsi, k.kategori, k.harga, p.nama AS pemateri 
          FROM kursus k 
          JOIN users p ON k.dibuat_oleh = p.id 
          WHERE k.id = '$id_kursus'";
$result = mysqli_query($conn, $query);

// Jika kursus tidak ditemukan, redirect
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Kursus tidak ditemukan!'); window.location.href='dashboard_user.php';</script>";
    exit();
}

$kursus = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kursus</title>
</head>
<body>
    <h1>Detail Kursus</h1>
    <h2><?php echo htmlspecialchars($kursus['nama']); ?></h2>
    <p><?php echo htmlspecialchars($kursus['deskripsi']); ?></p>
    <p><strong>Kategori:</strong> <?php echo htmlspecialchars($kursus['kategori']); ?></p>
    <p><strong>Harga:</strong> Rp <?php echo number_format($kursus['harga'], 0, ',', '.'); ?></p>
    <p><strong>Pemateri:</strong> <?php echo htmlspecialchars($kursus['pemateri']); ?></p>
    <a href="dashboard_user.php">Kembali</a>
</body>
</html>
