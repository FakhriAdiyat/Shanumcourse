<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan pengguna ke halaman login (atau halaman lain)
header("Location: ../index.php");
exit();
?>
