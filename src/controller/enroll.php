<?php
session_start();
require_once '../config/config.php';

// Periksa apakah pengguna sudah login dan memiliki role 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Periksa apakah ID kursus diterima melalui GET
if (isset($_GET['id'])) {
    $id_kursus = mysqli_real_escape_string($conn, $_GET['id']);
    $id_user = $_SESSION['user_id'];

    // Cek apakah pengguna sudah terdaftar di kursus ini
    $query_check = "SELECT COUNT(*) AS total FROM kursus_user WHERE id_user = '$id_user' AND id_kursus = '$id_kursus'";
    $result_check = mysqli_query($conn, $query_check);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check['total'] > 0) {
        // Jika pengguna sudah terdaftar, arahkan kembali ke dashboard
        header("Location: dashboard_user.php?status=already_enrolled");
        exit();
    }

    // Jika belum terdaftar, tambahkan data ke tabel kursus_user
    $query_enroll = "INSERT INTO kursus_user (id_user, id_kursus, status) VALUES ('$id_user', '$id_kursus', 'aktif')";
    if (mysqli_query($conn, $query_enroll)) {
        // Berhasil mendaftar, arahkan kembali ke dashboard
        header("Location: dashboard_user.php?status=success");
    } else {
        // Gagal mendaftar, tampilkan pesan error
        echo "Terjadi kesalahan saat mendaftar ke kursus.";
    }
} else {
    // Jika ID kursus tidak diterima, arahkan kembali ke dashboard
    header("Location: dashboard_user.php?status=invalid_request");
    exit();
}
?>
