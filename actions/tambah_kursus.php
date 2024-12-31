<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'pemateri') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require_once '../config/config.php';

// Proses tambah kursus
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_kursus = mysqli_real_escape_string($conn, $_POST['nama_kursus']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $pemateri_id = $_SESSION['user_id']; // Ambil ID pemateri dari session

    // Query untuk memasukkan kursus ke dalam database
    $query_insert = "
        INSERT INTO kursus (nama_kursus, deskripsi, kategori, dibuat_oleh)
        VALUES ('$nama_kursus', '$deskripsi', '$kategori', '$pemateri_id')
    ";

    if (mysqli_query($conn, $query_insert)) {
        $success_message = "Kursus berhasil ditambahkan!";
    } else {
        $error_message = "Gagal menambahkan kursus: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kursus</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard_user.css">
</head>
<body>
    <!-- Content -->
    <div class="content">
        <h1 class="text-center mb-4">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
        
        <!-- Profil -->
        <section id="profile" class="mb-4">
            <div class="card p-4">
                <h5 class="card-title">Profil Anda</h5>
                <p><strong>Nama:</strong> <?php echo $_SESSION['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                <a href="edit_profile.php" class="btn btn-primary">Edit Profil</a>
            </div>
        </section>

        <!-- Card Tambah Kursus -->
        <div class="card p-4">
            <h4>Tambah Kursus</h4>
            <p>Buat kursus baru untuk peserta Anda.</p>
            
            <!-- Tampilkan pesan jika berhasil atau gagal -->
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="tambah_kursus.php" method="POST">
                <div class="mb-3">
                    <label for="nama_kursus" class="form-label">Nama Kursus</label>
                    <input type="text" class="form-control" id="nama_kursus" name="nama_kursus" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" class="form-control" id="kategori" name="kategori" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambahkan Kursus</button>
            </form>
        </div>

        <!-- Kursus Aktif -->
        <section id="active-courses" class="mb-4">
        <div class="card p-4">
            <h5 class="card-title">Semua Kursus</h5>
            <ul class="list-group">
            <?php
                // Query to get all courses without subscription check
                $query_all_courses = "
                    SELECT k.id, k.nama_kursus AS nama, k.deskripsi, k.kategori, u.username AS pemateri
                    FROM kursus k
                    JOIN users u ON k.dibuat_oleh = u.id
                ";

                $result_all_courses = mysqli_query($conn, $query_all_courses);

                if ($result_all_courses && mysqli_num_rows($result_all_courses) > 0) {
                    while ($row = mysqli_fetch_assoc($result_all_courses)) {
                        // Display each course with access button
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                {$row['nama']} - Pemateri: {$row['pemateri']} - Kategori: {$row['kategori']}
                                <a href='course.php?id={$row['id']}' class='btn btn-primary btn-sm'>Akses</a>
                            </li>";
                    }
                } else {
                    echo "<li class='list-group-item'>Belum ada kursus tersedia.</li>";
                }
            ?>
            </ul>
        </div>
    </section>

        <!-- Footer -->
        <footer class="main-footer">
            <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
            <img src="img/footer.gif" alt="Footer GIF" width="100">
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
