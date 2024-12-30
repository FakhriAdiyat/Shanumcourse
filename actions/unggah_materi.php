<?php
session_start();
include('../database/db_connection.php'); // Koneksi ke database

// Cek apakah pengguna sudah login dan memiliki role pemateri
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
    header("Location: login.php");
    exit();
}

// Proses form saat tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kursus_id = $_POST['kursus_id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $file_materi = $_FILES['file_materi']['name'];
    $file_tmp = $_FILES['file_materi']['tmp_name'];
    $folder_upload = '../uploads/materi/';
    $target_file = $folder_upload . basename($file_materi);
    $diunggah_oleh = $_SESSION['user_id']; // ID pemateri diambil dari session

    // Validasi input
    if (empty($kursus_id) || empty($judul) || empty($deskripsi)) {
        echo "<script>alert('Semua kolom wajib diisi!'); window.location.href='unggah_materi.php';</script>";
        exit();
    }

    // Proses unggah file
    if (move_uploaded_file($file_tmp, $target_file)) {
        // Query untuk menyimpan data ke tabel materi
        $query = "INSERT INTO materi (judul, deskripsi, file_path, kursus_id, diunggah_oleh, tanggal_diunggah) 
                  VALUES ('$judul', '$deskripsi', '$file_materi', '$kursus_id', '$diunggah_oleh', NOW())";

        // Eksekusi query
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Materi berhasil diunggah!'); window.location.href=''../public/dashboard_pemateri.php';</script>";
        } else {
            echo "Error saat menyimpan data ke database: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Gagal mengunggah file.'); window.location.href='../public/dashboard_pemateri.php';</script>";
    }
}
?>
