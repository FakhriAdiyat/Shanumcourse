<?php
session_start();
include('../../database/db_connection.php'); // Pastikan path benar

// Pastikan hanya pemateri yang bisa mengakses
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';
    $dibuat_oleh = $_POST['dibuat_oleh'] ?? '';
    $tanggal_dibuat = $_POST['tanggal_dibuat'] ?? '';

    // Validasi input
    if (empty($nama_kursus) || empty($deskripsi) || empty($kategori)) {
        echo "<script>alert('Semua field harus diisi!'); history.back();</script>";
        exit();
    }

    try {
        // Masukkan data kursus ke database
        $sql = "INSERT INTO kursus (nama_kursus, deskripsi, kategori, dibuat_oleh)
                VALUES (:nama_kursus, :deskripsi, :kategori, :dibuat_oleh)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':tanggal_dibuat', $tanggal_dibuat);
        $stmt->bindParam(':dibuat_oleh', $_SESSION['user_id']); // Ambil ID pemateri dari session

        if ($stmt->execute()) {
            echo "<script>alert('Kursus berhasil ditambahkan!'); window.location.href = 'dashboard_pemateri.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan kursus.'); history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); history.back();</script>";
    }
} else {
    echo "<script>alert('Request tidak valid.'); history.back();</script>";
}
?>
