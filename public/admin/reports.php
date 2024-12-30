<?php
// Include koneksi database
include('db_connection.php');

// Mengambil data statistik dari database
$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_courses_query = "SELECT COUNT(*) AS total_courses FROM courses";
$total_enrollments_query = "SELECT COUNT(*) AS total_enrollments FROM enrollments";

$total_users_result = mysqli_query($conn, $total_users_query);
$total_courses_result = mysqli_query($conn, $total_courses_query);
$total_enrollments_result = mysqli_query($conn, $total_enrollments_query);

$total_users = mysqli_fetch_assoc($total_users_result)['total_users'];
$total_courses = mysqli_fetch_assoc($total_courses_result)['total_courses'];
$total_enrollments = mysqli_fetch_assoc($total_enrollments_result)['total_enrollments'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Laporan Kursus Online</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom CSS for styling -->
</head>
<body>
    <div class="dashboard-container">
        <header class="dashboard-header">
            <h1>Dashboard Admin</h1>
            <nav>
                <a href="index.php">Beranda</a>
                <a href="courses.php">Kursus</a>
                <a href="users.php">Pengguna</a>
                <a href="reports.php" class="active">Laporan</a>
            </nav>
        </header>
        
        <section class="report-summary">
            <h2>Statistik Laporan</h2>
            <div class="report-card">
                <h3>Total Pengguna Terdaftar</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="report-card">
                <h3>Total Kursus</h3>
                <p><?php echo $total_courses; ?></p>
            </div>
            <div class="report-card">
                <h3>Total Pendaftar Kursus</h3>
                <p><?php echo $total_enrollments; ?></p>
            </div>
        </section>
        
        <section class="course-enrollment-stats">
            <h2>Statistik Pendaftaran Kursus</h2>
            <table>
                <thead>
                    <tr>
                        <th>Kursus</th>
                        <th>Jumlah Pendaftar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil statistik pendaftaran kursus
                    $course_enrollment_query = "SELECT c.course_name, COUNT(e.user_id) AS enrollments
                                                FROM courses c
                                                LEFT JOIN enrollments e ON c.course_id = e.course_id
                                                GROUP BY c.course_name";
                    $course_enrollment_result = mysqli_query($conn, $course_enrollment_query);
                    
                    while ($row = mysqli_fetch_assoc($course_enrollment_result)) {
                        echo "<tr>
                                <td>" . $row['course_name'] . "</td>
                                <td>" . $row['enrollments'] . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>

<?php
// Menutup koneksi database
mysqli_close($conn);
?>
