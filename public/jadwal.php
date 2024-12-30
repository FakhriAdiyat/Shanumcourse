<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
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
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Jadwal Pemateri</h1>

    <!-- Form Tambah Jadwal -->
    <!-- <div class="card mb-4">
        <div class="card-body">
            <h3 class="card-title">Tambah Jadwal</h3>
            <form action="tambah_jadwal.php" method="POST">
                <div class="mb-3">
                    <label for="nama_kursus" class="form-label">Nama Kursus</label>
                    <input type="text" class="form-control" id="nama_kursus" name="nama_kursus" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                </div>
                <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="time" class="form-control" id="waktu" name="waktu" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
            </form>
        </div>
    </div> -->

    <!-- Tabel Jadwal -->
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Daftar Jadwal</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kursus</th>
                        <th>Pemateri</th>
                        <th>hari</th>
                        <th>Waktu</th>
                        <th>Tanggal</th>
                        <!-- <th>Aksi</th> -->
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
                                    <a href="edit_jadwal.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="hapus_jadwal.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
