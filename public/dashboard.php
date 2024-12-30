<?php
// File: dashboard.php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kelas Buana</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <img src="../public/img/logo_KB.png" alt="Logo MyApp" width="150">
            </div>
            <ul class="nav-links">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="src/views/user_list.php">Users List</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Dashboard Content -->
    <section class="dashboard-content">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>You are now logged in to the Kelas Buana dashboard.</p>
        <div class="dashboard-actions">
            <a href="profile.php" class="btn-primary">View Profile</a>
            <a href="src/views/user_list.php" class="btn-secondary">Manage Users</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <p>&copy; 2024 Kelas Buana. All rights reserved.</p>
    </footer>
</body>
</html>
