<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'peserta') {
    header('Location: login.php');
    exit();
}

// Dapatkan informasi pengguna dari sesi
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Sambungkan ke database
require 'db_connection.php';

// Ambil daftar kursus yang diikuti peserta
$query = "SELECT courses.id, courses.title, courses.description, enrollments.enroll_date 
          FROM courses
          INNER JOIN enrollments ON courses.id = enrollments.course_id
          WHERE enrollments.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profil</a>
            <a href="logout.php">Keluar</a>
        </nav>
    </header>

    <main>
        <h2>Kursus yang Diikuti</h2>

        <?php if (empty($courses)): ?>
            <p>Anda belum terdaftar dalam kursus apa pun. <a href="courses.php">Daftar sekarang</a>.</p>
        <?php else: ?>
            <ul class="course-list">
                <?php foreach ($courses as $course): ?>
                    <li>
                        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p><?php echo htmlspecialchars($course['description']); ?></p>
                        <small>Terdaftar pada: <?php echo date('d M Y', strtotime($course['enroll_date'])); ?></small>
                        <a href="course_detail.php?id=<?php echo $course['id']; ?>">Lihat Kursus</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
        <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
</body>
</html>
