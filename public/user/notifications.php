<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - User Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./../css/dashboard_user.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a class="sidebar-header" href="./../dashboard_user.php">
            <img src="./../img/sc.png" alt="Logo MyApp" width="150">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h3>User Dashboard</h3>
        <a href="profile.php"><i class="fas fa-user"></i> Profil</a>
        <a href="tasks-quizzies.php"><i class="fas fa-tasks"></i> Tugas & Kuis</a>
        <!-- <a href="progress.php"><i class="fas fa-chart-line"></i> Progres Belajar</a> -->
        <a href="notifications.php"><i class="fas fa-bell"></i> Notifikasi</a>
        <a href="payment.php"><i class="fas fa-credit-card"></i> Pembayaran</a>
        <a href="support.php"><i class="fas fa-headset"></i> Support</a>
        <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <h1 class="text-center mb-4">Notifikasi</h1>

        <!-- Notifikasi Section -->
        <section id="notifications" class="mb-4">
            <div class="card p-4">
                <h5 class="card-title">Pesan & Notifikasi</h5>
                <ul class="list-group">
                    <!-- Contoh Notifikasi -->
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pemberitahuan Baru:</strong> Diskon 50% untuk kursus tertentu hingga akhir bulan ini!
                        </div>
                        <a href="details.php?id=discount" class="btn btn-info btn-sm">Detail</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Pemberitahuan:</strong> Tugas baru tersedia untuk kursus Anda.
                        </div>
                        <a href="tasks.php" class="btn btn-warning btn-sm">Lihat Tugas</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Informasi:</strong> Webinar mendatang tentang "Teknik Belajar Efektif".
                        </div>
                        <a href="webinar.php" class="btn btn-success btn-sm">Ikuti Webinar</a>
                    </li>
                </ul>
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.<br>
        Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="./../img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
