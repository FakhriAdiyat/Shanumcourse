<?php
session_start();
require_once '../config/config.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil user ID
$user_id = $_SESSION['user_id'];

// Set masa aktif langganan (30 hari dari sekarang)
$expiry_date = date('Y-m-d', strtotime('+30 days'));

// Update status langganan di database
$query = "
    UPDATE users 
    SET is_subscribed = 1, subscription_expiry = '$expiry_date' 
    WHERE id = $user_id
";

if (mysqli_query($conn, $query)) {
    // Redirect ke dashboard dengan notifikasi sukses
    header("Location: dashboard.php?status=payment_success");
} else {
    // Redirect ke dashboard dengan notifikasi error
    header("Location: dashboard.php?status=payment_error");
}
?>
