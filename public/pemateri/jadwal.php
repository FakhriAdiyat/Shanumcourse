<?php
session_start();
if (!isset($_SESSION['email']) || !in_array($_SESSION['role'], ['pemateri', 'user'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_connection"); // Sesuaikan dengan konfigurasi database Anda
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil jadwal dari database
$sql = "SELECT * FROM jadwal WHERE email_pemateri = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$jadwal = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pemateri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .nav-menu {
            background-color: #007bff;
            padding: 10px;
        }
        .nav-menu a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .nav-menu a:hover {
            text-decoration: underline;
        }
        .main-footer {
            display: flex; /* Aktifkan Flexbox */
            justify-content: space-between; /* Pisahkan teks dan GIF */
            align-items: center; /* Pusatkan teks secara vertikal */
            background-color: #007bff; /* Warna latar (opsional) */
            padding: 20px;
            font-family: Arial, sans-serif;
            color: white; /* Warna teks */
            height: 100px; /* Pastikan ada tinggi untuk footer */
        }

        .main-footer p {
            margin: 0 auto; /* Pastikan teks berada di tengah secara horizontal */
            text-align: center; /* Pastikan teks rata tengah */
            flex: 1; /* Biarkan teks memenuhi ruang yang tersisa */
        }

        .main-footer img {
            max-width: 50px; /* Atur ukuran maksimal GIF */
            height: auto; /* Pertahankan rasio aspek */
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            border-radius: 50px;
        }
        .btn-warning {
            color: white;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Jadwal Pemateri</h1>
</div>

<div class="nav-menu">
    <a href="./../dashboard_pemateri.php">Home</a>
    <a href="jadwal.php">Jadwal</a>
    <a href="./../logout.php">Logout</a>
</div>

<div class="container mt-4">
    <!-- Tabel Jadwal -->
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Daftar Jadwal</h3>
            <table class="table table-hover table-bordered text-center">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Kursus</th>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($jadwal) > 0): ?>
                        <?php foreach ($jadwal as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama_kursus']); ?></td>
                                <td><?php echo htmlspecialchars($row['hari']); ?></td>
                                <td><?php echo htmlspecialchars($row['waktu']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <a href="edit_jadwal.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="hapus_jadwal.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada jadwal.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.<br>
        Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="./../img/footer2.gif" alt="Footer GIF" width="100">
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
