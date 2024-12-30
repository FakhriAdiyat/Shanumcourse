<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
    header("Location: login.php");
    exit();
}

require_once '../config/config.php'; // Pastikan konfigurasi database sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_kursus = mysqli_real_escape_string($conn, $_POST['nama_kursus']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $pemateri_id = $_SESSION['user_id']; // Ambil ID pemateri yang sedang login

    // Insert data ke tabel kursus
    $query = "INSERT INTO kursus (nama_kursus, deskripsi, kategori, dibuat_oleh, tanggal_dibuat)
              VALUES ('$nama_kursus', '$deskripsi', '$kategori', '$pemateri_id', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "Kursus berhasil ditambahkan.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
