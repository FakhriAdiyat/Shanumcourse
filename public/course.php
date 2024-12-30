<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Periksa status langganan
if ($_SESSION['is_subscribed'] == 0) {
    header("Location: subscribe.php?message=Anda perlu berlangganan untuk mengakses kursus.");
    exit();
}

// Koneksi ke database
require_once '../config/config.php';

// Logika untuk menampilkan detail kursus
$id_kursus = $_GET['id']; // Ambil ID kursus dari URL

// Ambil detail kursus
$query_kursus = "SELECT * FROM kursus WHERE id = '$id_kursus'";
$result_kursus = mysqli_query($conn, $query_kursus);

if ($result_kursus && mysqli_num_rows($result_kursus) > 0) {
    $course = mysqli_fetch_assoc($result_kursus);
    $nama_kursus = htmlspecialchars($course['nama_kursus']);
    $deskripsi_kursus = htmlspecialchars($course['deskripsi']);
} else {
    echo "Kursus tidak ditemukan.";
    exit();
}

// Ambil materi terkait kursus berdasarkan kursus_id
$query_materi = "SELECT * FROM materi WHERE kursus_id = '$id_kursus'";
$result_materi = mysqli_query($conn, $query_materi);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Kursus</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Tambahkan file CSS Anda -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center"><?php echo $nama_kursus; ?></h1>
        <p class="text-center"><?php echo $deskripsi_kursus; ?></p>

        <h2 class="mt-4">Daftar Materi</h2>
        <div class="mt-4">
            <?php if ($result_materi && mysqli_num_rows($result_materi) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Materi</th>
                            <th>Deskripsi</th>
                            <th>File</th>
                            <th>Tanggal Unggah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($materi = mysqli_fetch_assoc($result_materi)): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($materi['judul']); ?></td>
                                <td><?php echo htmlspecialchars($materi['deskripsi']); ?></td>
                                <td>
                                    <?php if (!empty($materi['file_path'])): ?>
                                        <a class="btn btn-info" href="uploads/<?php echo htmlspecialchars($materi['file_path']); ?>" download>
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download
                                        </a>
                                    <?php else: ?>
                                        Tidak ada file
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($materi['tanggal_diunggah']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Tidak ada materi untuk kursus ini.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
