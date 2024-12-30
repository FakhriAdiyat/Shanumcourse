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
        <!-- <li class="nav-item"><a href="../actions/tambah_kursus.php" class="nav-link"><i class="fas fa-book"></i> Tambah/Atur Kursus</a></li>
        <li class="nav-item"><a href="../actions/form_unggah_materi.php" class="nav-link"><i class="fas fa-upload"></i> Unggah Materi</a></li> -->
        <li class="nav-item"><a href="../public/pemateri/jadwal.php" class="nav-link"><i class="fas fa-calendar-alt"></i> Jadwal</a></li>
        <!-- <li class="nav-item"><a href="../public/pemateri/statistik.php" class="nav-link"><i class="fas fa-chart-bar"></i> Statistik</a></li>
        <li class="nav-item"><a href="../public/pemateri/peserta.php" class="nav-link"><i class="fas fa-users"></i> Peserta</a></li> -->
        <!-- <li class="nav-item"><a href="../public/pemateri/kuis_ujian.php" class="nav-link"><i class="fas fa-question-circle"></i> Kuis/Ujian</a></li> -->
        <li class="nav-item"><a href="../public/pemateri/manajemen_akun.php" class="nav-link"><i class="fas fa-user-cog"></i> Manajemen Akun</a></li>
        <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>
   
    
    <!-- Konten Utama -->
    <div class="main content">
        <h1 class="text-center mb-4">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?> (Pemateri)</h1>
    </div>
    
    <div class="content-wrapper">
        <!-- Bar Pencarian -->
        <!-- <div class="search-bar">
            <input type="text" placeholder="Cari kursus, materi, atau peserta...">
            <button>Cari</button>
        </div> -->

        <!-- Grid Cards -->
        <div class="cards-grid">
            <!-- Card Tambah Kursus -->
            <div class="card">
                <h4>Tambah Kursus</h4>
                <p>Buat kursus baru untuk peserta Anda.</p>
                <form action="../actions/tambah_kursus.php" method="POST">
                    <div class="mb-3">
                        <label for="nama_kursus" class="form-label">Nama Kursus</label>
                        <input type="text" class="form-control" id="nama_kursus" name="nama_kursus" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambahkan Kursus</button>
                </form>
            </div>


            <!-- Card Unggah Materi -->
            <div class="card">
                <h4>Unggah Materi</h4>
                <p>Tambahkan materi baru untuk peserta kursus.</p>
                <form action="../actions/unggah_materi.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="kursus_id" class="form-label">ID Kursus</label>
                        <input type="text" class="form-control" id="kursus_id" name="kursus_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Materi</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file_materi" class="form-label">Unggah File</label>
                        <input type="file" class="form-control" id="file_materi" name="file_materi" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Unggah Materi</button>
                </form>
 

            </div>

            <!-- Card Jadwal -->
            <div class="card">
                <h4>Jadwal</h4>
                <p>jadwal</p>
                <a href="../public/pemateri/jadwal.php" class="btn-warning">Atur Jadwal</a>
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
