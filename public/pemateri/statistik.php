<?php
// statistik.php

session_start();

// Cek apakah pemateri sudah login
if (!isset($_SESSION['pemateri_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Koneksi ke database
require_once 'config.php';

// Ambil data statistik
$pemateri_id = $_SESSION['pemateri_id'];

// Total kursus yang dibuat oleh pemateri
$query_total_courses = "SELECT COUNT(*) AS total_courses FROM courses WHERE pemateri_id = ?";
$stmt = $conn->prepare($query_total_courses);
$stmt->bind_param('i', $pemateri_id);
$stmt->execute();
$result_total_courses = $stmt->get_result();
$total_courses = $result_total_courses->fetch_assoc()['total_courses'];

// Total peserta dalam kursus pemateri
$query_total_students = "SELECT COUNT(DISTINCT enrollments.user_id) AS total_students FROM enrollments 
                         INNER JOIN courses ON enrollments.course_id = courses.id 
                         WHERE courses.pemateri_id = ?";
$stmt = $conn->prepare($query_total_students);
$stmt->bind_param('i', $pemateri_id);
$stmt->execute();
$result_total_students = $stmt->get_result();
$total_students = $result_total_students->fetch_assoc()['total_students'];

// Total pendapatan pemateri (dari enrollments)
$query_total_income = "SELECT SUM(enrollments.price) AS total_income FROM enrollments 
                       INNER JOIN courses ON enrollments.course_id = courses.id 
                       WHERE courses.pemateri_id = ?";
$stmt = $conn->prepare($query_total_income);
$stmt->bind_param('i', $pemateri_id);
$stmt->execute();
$result_total_income = $stmt->get_result();
$total_income = $result_total_income->fetch_assoc()['total_income'];

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Statistik Pemateri</title>
    <link rel="stylesheet" href="css/dashboard_pemateri.css">
</head>
<body>
    <header>
        <h1>Dashboard Pemateri</h1>
        <nav>
            <a href="dashboard_pemateri.php">Home</a>
            <a href="create_course.php">Buat Kursus</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <section class="statistics">
            <h2>Statistik Anda</h2>
            <div class="stat-card">
                <h3>Total Kursus</h3>
                <p><?php echo $total_courses; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Peserta</h3>
                <p><?php echo $total_students; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Pendapatan</h3>
                <p>Rp <?php echo number_format($total_income, 0, ',', '.'); ?></p>
            </div>
        </section>
    </main>
    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
        <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
</body>
</html>
