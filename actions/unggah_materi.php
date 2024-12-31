<?php
session_start();
include('../database/db_connection.php'); // Koneksi ke database

// Cek apakah pengguna sudah login dan memiliki role pemateri
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
    header("Location: login.php");
    exit();
}

// Ambil daftar kursus dari database
$query_kursus = "SELECT id, nama_kursus FROM kursus";
$result_kursus = mysqli_query($conn, $query_kursus);

// Proses form saat tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_kursus = mysqli_real_escape_string($conn, $_POST['nama_kursus']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $file_materi = $_FILES['file_materi']['name'];
    $file_tmp = $_FILES['file_materi']['tmp_name'];
    $folder_upload = '../uploads/materi/';
    $target_file = $folder_upload . basename($file_materi);
    $diunggah_oleh = $_SESSION['user_id']; // ID pemateri diambil dari session

    // Validasi input
    if (empty($nama_kursus) || empty($judul) || empty($deskripsi)) {
        echo "<script>alert('Semua kolom wajib diisi!'); window.location.href='unggah_materi.php';</script>";
        exit();
    }

    // Dapatkan kursus_id berdasarkan nama_kursus
    $query_get_id = "SELECT id FROM kursus WHERE nama_kursus = '$nama_kursus'";
    $result_get_id = mysqli_query($conn, $query_get_id);
    if ($result_get_id && mysqli_num_rows($result_get_id) > 0) {
        $row = mysqli_fetch_assoc($result_get_id);
        $kursus_id = $row['id'];
    } else {
        echo "<script>alert('Kursus tidak ditemukan.'); window.location.href='unggah_materi.php';</script>";
        exit();
    }

    // Proses unggah file
    if (move_uploaded_file($file_tmp, $target_file)) {
        // Query untuk menyimpan data ke tabel materi
        $query = "INSERT INTO materi (judul, deskripsi, file_path, kursus_id, diunggah_oleh, tanggal_diunggah) 
                  VALUES ('$judul', '$deskripsi', '$file_materi', '$kursus_id', '$diunggah_oleh', NOW())";

        // Eksekusi query
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Materi berhasil diunggah!'); window.location.href='../public/dashboard_pemateri.php';</script>";
        } else {
            echo "Error saat menyimpan data ke database: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Gagal mengunggah file.'); window.location.href='../public/dashboard_pemateri.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Materi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Unggah Materi</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_kursus" class="form-label">Nama Kursus</label>
                <select class="form-select" id="nama_kursus" name="nama_kursus" required>
                    <option value="" disabled selected>Pilih Kursus</option>
                    <?php while ($kursus = mysqli_fetch_assoc($result_kursus)): ?>
                        <option value="<?php echo htmlspecialchars($kursus['nama_kursus']); ?>">
                            <?php echo htmlspecialchars($kursus['nama_kursus']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Materi</label>
                <input type="text" class="form-control" id="judul" name="judul" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="file_materi" class="form-label">File Materi</label>
                <input type="file" class="form-control" id="file_materi" name="file_materi" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
