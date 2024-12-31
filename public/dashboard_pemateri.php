<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemateri</title>
    <link rel="stylesheet" href="css/dashboard_pemateri.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
<!-- Sidebar -->
<div class="sidebar">
    <a class="sidebar-header" href="dashboard_pemateri.php">
        <img src="img/sc.png" alt="Logo MyApp" width="150">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <h3>Dashboard Pemateri</h3>
    <ul>
        <li class="nav-item"><a href="dashboard_pemateri.php" class="nav-link"><i class="fas fa-home"></i> Beranda</a></li>
        <li class="nav-item"><a href="../public/pemateri/jadwal.php" class="nav-link"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
        <li class="nav-item"><a href="../public/pemateri/manajemen_akun.php" class="nav-link"><i class="fas fa-user-cog"></i> Manajemen Akun</a></li>
        <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>
   
<!-- Konten Utama -->
<div class="main content">
    <h1 class="text-center mb-4">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?> (Pemateri)</h1>
</div>
    
<div class="content-wrapper">
    <!-- Grid Cards -->
    <div class="cards-grid">
        <!-- Card Tambah Kursus -->
        <div class="card">
            <h4>Tambah Kursus</h4>
            <p>Buat kursus baru untuk peserta Anda.</p>
            <!-- Tombol untuk mengalihkan ke halaman tambah kursus -->
            <a href="../actions/tambah_kursus.php" class="btn btn-primary">Buka Halaman Tambah Kursus</a>
        </div>

        <!-- Card Unggah Materi -->
        <div class="card">
            <h4>Unggah Materi</h4>
            <p>Tambahkan materi baru untuk peserta kursus Anda.</p>
            <!-- Tombol untuk mengalihkan ke halaman unggah materi -->
            <a href="../actions/unggah_materi.php" class="btn btn-primary">Buka Halaman Unggah Materi</a>
        </div>

        <!-- Card Jadwal -->
        <div class="card">
            <h4>Jadwal</h4>
            <p>Jadwal kursus Anda.</p>
            <a href="../public/pemateri/jadwal.php" class="btn btn-warning">Lihat Jadwal</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="main-footer">
    <p>&copy; 2024 Shanum Course Team. All rights reserved.<br>
    Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
    <img src="img/footer2.gif" alt="Footer GIF" width="100">
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
