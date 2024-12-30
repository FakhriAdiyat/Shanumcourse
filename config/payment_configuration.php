<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $transaction_id = $_POST['transaction_id'];
    $user_id = $_SESSION['user_id'];

    // Upload bukti pembayaran
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
    move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file);

    // Simpan data ke database
    $query = "INSERT INTO payments (user_id, transaction_id, payment_proof, status, created_at) VALUES (?, ?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $transaction_id, $target_file);

    if ($stmt->execute()) {
        echo "<script>alert('Konfirmasi pembayaran berhasil dikirim. Menunggu verifikasi.'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim konfirmasi pembayaran.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
