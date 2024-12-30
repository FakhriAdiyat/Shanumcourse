<?php

/**
 * Fungsi untuk membersihkan input dari pengguna
 *
 * @param string $data Input dari pengguna
 * @return string Data yang telah dibersihkan
 */
function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Fungsi untuk memformat tanggal ke format yang lebih mudah dibaca
 *
 * @param string $date Tanggal dalam format asli
 * @return string Tanggal dalam format "d M Y"
 */
function formatTanggal($date) {
    return date('d M Y', strtotime($date));
}

/**
 * Fungsi untuk menampilkan pesan alert
 *
 * @param string $message Pesan yang akan ditampilkan
 */
function showAlert($message) {
    echo "<script>alert('$message');</script>";
}

/**
 * Fungsi untuk redirect ke halaman lain
 *
 * @param string $url URL tujuan
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Fungsi untuk mengecek apakah pengguna memiliki role tertentu
 *
 * @param string $role Role yang akan dicek
 * @return bool True jika sesuai, False jika tidak
 */
function checkUserRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

?>
