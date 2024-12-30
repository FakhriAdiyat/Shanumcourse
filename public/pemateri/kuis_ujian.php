<?php
// kuis_ujian.php - Halaman dashboard untuk pemateri online course
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pemateri') {
    // Redirect ke halaman login jika belum login atau bukan pemateri
    header('Location: ../../public/login.php');
    exit();
}

require '../../database/db_connection.php'; // File konfigurasi database
require_once '../../config/config.php'; // File konfigurasi tambahan
require_once '../../functions/functions.php'; // File fungsi tambahan

$user_id = $_SESSION['user_id']; // Ambil ID pemateri dari session

// Ambil data kursus yang dikelola oleh pemateri
$query = "SELECT * FROM kursus WHERE dibuat_oleh = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$kursus = $result->fetch_all(MYSQLI_ASSOC);

// Fungsi untuk mengambil kuis dan ujian berdasarkan kursus
function getKuisUjian($conn, $kursus_id) {
    $query = "SELECT * FROM kuis_ujian WHERE kursus_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $kursus_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kuis & Ujian - Shanum Course</title>
    <link rel="stylesheet" href="./../css/dashboard_pemateri.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tambahan CSS untuk mempercantik tampilan */
        body {
            background-color: #f8f9fa;
        }
        header {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
        header nav a {
            color: white;
            margin-right: 15px;
            font-weight: 500;
        }
        header nav a:hover {
            color: #ffc107;
        }
        .kursus-card {
            margin-bottom: 30px;
        }
        .kursus-card .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .kuis-ujian ul {
            list-style: none;
            padding: 0;
        }
        .kuis-ujian li {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .kuis-ujian li:last-child {
            border-bottom: none;
        }
        .kuis-ujian .actions a {
            margin-left: 10px;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        .kuis-ujian .actions a:hover {
            color: #dc3545;
        }
        .btn-tambah {
            margin-top: 15px;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .social-icons i {
            margin: 0 10px;
            color: white;
            transition: color 0.3s ease;
        }
        .social-icons i:hover {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <header class="text-white">
        <nav class="container d-flex justify-content-between align-items-center">
            <h2>Shanum Course</h2>
            <div>
                <a href="./../dashboard_pemateri.php"><i class="fas fa-home"></i> Beranda</a>
                <a href="./../logout.php"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </div>
        </nav>
    </header>
    
    <main class="container my-5">
        <section>
            <h2 class="mb-4">Kursus Anda</h2>
            <?php if (!empty($kursus)) : ?>
                <div class="row">
                    <?php foreach ($kursus as $k) : ?>
                        <div class="col-md-6 kursus-card">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <?= htmlspecialchars($k['nama_kursus']); ?>
                                </div>
                                <div class="card-body">
                                    <p class="card-text"><?= htmlspecialchars($k['deskripsi']); ?></p>
                                    <a href="#" class="btn btn-primary btn-tambah" data-kursus-id="<?= $k['id']; ?>"><i class="fas fa-plus"></i> Tambah Kuis/Ujian</a>
                                    <div class="kuis-ujian mt-3">
                                        <h5>Kuis & Ujian:</h5>
                                        <?php $kuis_ujian = getKuisUjian($conn, $k['id']); ?>
                                        <?php if (!empty($kuis_ujian)) : ?>
                                            <ul class="list-group">
                                                <?php foreach ($kuis_ujian as $ku) : ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <?= htmlspecialchars($ku['judul']); ?>
                                                        <div class="actions">
                                                            <a href="edit_kuis_ujian.php?id=<?= $ku['id']; ?>" class="text-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                            <a href="hapus_kuis_ujian.php?id=<?= $ku['id']; ?>" class="text-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?');"><i class="fas fa-trash-alt"></i></a>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <p class="text-muted">Belum ada kuis atau ujian.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="alert alert-info">
                    Anda belum memiliki kursus. <a href="tambah_kursus.php" class="alert-link">Tambah Kursus</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tambahkan event listener untuk tombol tambah kuis/ujian
        document.querySelectorAll('.btn-tambah').forEach(btn => {
            btn.addEventListener('click', () => {
                const kursusId = btn.dataset.kursusId;
                window.location.href = `tambah_kuis_ujian.php?kursus_id=${kursusId}`;
            });
        });
    </script>
</body>
</html>
