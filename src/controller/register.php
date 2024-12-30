<?php
session_start();
include('../../database/db_connection.php'); // Pastikan path benar

// Tampilkan error untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input kosong
    if (empty($full_name) || empty($phone_number) || empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field wajib diisi!');</script>";
        exit();
    }

    try {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Role default adalah 'user'
        $role = 'user';

        // Query untuk menyimpan ke database
        $sql = "INSERT INTO users (full_name, phone_number, username, email, password, role) 
                VALUES (:full_name, :phone_number, :username, :email, :password, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href = '../../public/login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal. Coba lagi!');</script>";
        }
    } catch (PDOException $e) {
        // Tampilkan pesan kesalahan
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
