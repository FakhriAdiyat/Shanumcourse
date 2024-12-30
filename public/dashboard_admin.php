<?php
// File: dashboard.php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Role-Based Access Control (RBAC)
$role = $_SESSION['role']; // Ambil role dari sesi pengguna

// Tentukan akses berdasarkan role
$canManageUsers = $role === 'admin' || $role === 'pemateri';
$canViewReports = $role === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard Admin</title>
        <link rel="stylesheet" href="../public/css/dashboard_admin.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    
<body>
    <!-- Header Section -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="img/logo_sc.png" alt="Logo MyApp" width="150">
            <h2>Shanum Course</h2>
        </div>
        <ul class="sidebar-menu">
            <?php if ($canManageUsers): ?>
                <li><a href="../src/views/user_list.php"><i class="fas fa-users"></i> Manage Users</a></li>
                <li><a href="../public/admin/manage_instructors.php"><i class="fas fa-chalkboard-teacher"></i> Manage Instructors</a></li>
            <?php endif; ?>
            <li><a href="../public/admin/manage_courses.php"><i class="fas fa-book"></i> Manage Courses</a></li>
             <!-- Tambahan menu baru untuk Tambahkan Jadwal -->
            <li><a href="../public/admin/tambah_jadwal.php"><i class="fas fa-calendar-alt"></i> Tambahkan Jadwal</a></li>
            <?php if ($canViewReports): ?>
                <!-- <li><a href="../public/admin/reports.php"><i class="fas fa-chart-line"></i> Reports</a></li> -->
            <?php endif; ?>
            <!-- <li><a href="../public/admin/participant_stats.php"><i class="fas fa-chart-pie"></i> Participant Stats</a></li> -->
           
            <!-- Tambahan menu baru untuk memeriksa pembayaran -->
            <?php if ($role === 'admin'): ?>
                <li><a href="../public/admin/check_payments.php"><i class="fas fa-money-check-alt"></i> Check Payments</a></li>
            <?php endif; ?>

            <!-- <li><a href="logout.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li> -->
            <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </ul>
    </aside>

    <main class="main-content">
        <div class="welcome-section">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <p>You are now logged in to the Shanum Course Admin dashboard.</p>
        </div>
        <section class="dashboard-overview">
            <h2>Dashboard Features</h2>
            <div class="dashboard-features">
                <div class="dashboard-feature-card">
                    <h3>Manajemen Pemateri</h3>
                    <p>Kelola daftar pengajar untuk kursus online.</p>
                    <a href="../public/admin/manage_instructors.php">View</a>
                </div>
                <!-- <div class="dashboard-feature-card">
                    <h3>Statistik Peserta</h3>
                    <p>Lihat perkembangan peserta.</p>
                    <a href="../public/admin/participant_stats.php">View</a>
                </div> -->
                <div class="dashboard-feature-card">
                    <h3>Pemeriksaan Pembayaran</h3>
                    <p>Validasi pembayaran dari pengguna.</p>
                    <a href="../public/admin/check_payments.php">View</a>
                </div>
            </div>
        </section>
    
    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.<br>
        Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
</body>
</html>
