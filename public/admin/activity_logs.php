<?php
// activity_logs.php
include('config.php');  // untuk menghubungkan dengan database

// Pastikan admin sudah login
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Arahkan jika admin belum login
    exit;
}

// Query untuk mengambil log aktivitas
$query = "SELECT * FROM activity_logs ORDER BY timestamp DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs - Dashboard Admin</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link ke file CSS -->
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="courses.php">Kursus</a></li>
            <li><a href="students.php">Siswa</a></li>
            <li><a href="activity_logs.php" class="active">Log Aktivitas</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h1>Activity Logs</h1>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['action']; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($row['timestamp'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($conn);
?>
