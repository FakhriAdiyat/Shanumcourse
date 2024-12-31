<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
require_once '../config/config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard_user.css">
</head>
<body>
<?php
// Notifikasi status
if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $alert_class = '';
    $message = '';

    switch ($status) {
        case 'success':
            $alert_class = 'alert-success';
            $message = 'Berhasil mendaftar ke kursus!';
            break;
        case 'already_enrolled':
            $alert_class = 'alert-warning';
            $message = 'Anda sudah terdaftar di kursus ini.';
            break;
        case 'invalid_request':
            $alert_class = 'alert-danger';
            $message = 'Permintaan tidak valid.';
            break;
        default:
            $alert_class = 'alert-info';
            $message = 'Status tidak dikenal.';
            break;
    }

    // Menampilkan notifikasi
    echo "<div class='alert $alert_class alert-dismissible fade show text-center' role='alert'>
            $message
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}
?>

    <div class="popup-overlay" id="popup-overlay"></div>
        <div class="popup" id="popup">
            <div class="popup-header">Event</div>
            <div class="popup-body">
                <img src="img/discount.png" alt="Diskon Tahun Baru">
                <h5>Diskon Tahun Baru</h5>
                <p>Akses berlangganan materi dan course.</p>
            </div>
            <div class="popup-close" id="popup-close">&times;</div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a class="sidebar-header" href="dashboard_user.php">
            <img src="img/sc.png" alt="Logo MyApp" width="150">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h3>User Dashboard</h3>
        <a href="../public/user/profile.php"><i class="fas fa-user"></i> Profil</a>
        <!-- <a href="../public/user/tasks-quizzies.php"><i class="fas fa-tasks"></i> Tugas & Kuis</a> -->
        <a href="../public/user/jadwal.php"><i class="fas fa-calendar-alt"></i> Jadwal</a>
        <!-- <a href="../public/user/progress.php"><i class="fas fa-chart-line"></i> Progres Belajar</a> -->
        <a href="../public/user/notifications.php"><i class="fas fa-bell"></i> Notifikasi</a>
        <a href="../public/user/halaman_payment.php"><i class="fas fa-credit-card"></i> Pembayaran</a>
        <a href="../public/user/support.php"><i class="fas fa-headset"></i> Support</a>
        <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Search Form -->
    <!-- <section id="search" class="mb-4">
        <div class="d-flex justify-content-end">
            <form action="search_results.php" method="GET" class="d-flex align-items-center">
                <div class="input-group" style="width: 300px;">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="query" id="search-query" class="form-control" placeholder="Cari kursus...">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </section> -->

    <!-- Content -->
    <div class="content">
        <h1 class="text-center mb-4">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
        
        <!-- Profil -->
        <section id="profile" class="mb-4">
            <div class="card p-4">
                <h5 class="card-title">Profil Anda</h5>
                <p><strong>Nama:</strong> <?php echo $_SESSION['username']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                <a href="../public/user/profile.php" class="btn btn-primary">Edit Profil</a>
            </div>
        </section>

        <!-- Kursus Aktif -->
<section id="active-courses" class="mb-4">
    <div class="card p-4">
        <h5 class="card-title">Semua Kursus</h5>
        <ul class="list-group">
        <?php
            $query_all_courses = "
                SELECT k.id, k.nama_kursus AS nama, k.deskripsi, k.kategori, u.username AS pemateri
                FROM kursus k
                JOIN users u ON k.dibuat_oleh = u.id
            ";

            $result_all_courses = mysqli_query($conn, $query_all_courses);

            if ($result_all_courses && mysqli_num_rows($result_all_courses) > 0) {
                while ($row = mysqli_fetch_assoc($result_all_courses)) {
                    // Cek jika user sudah berlangganan kursus
                    $is_enrolled_query = "
                        SELECT * FROM kursus_user 
                        WHERE id_user = '{$_SESSION['user_id']}' AND id_kursus = '{$row['id']}'
                    ";
                    $is_enrolled_result = mysqli_query($conn, $is_enrolled_query);

                    if ($_SESSION['is_subscribed'] == 0) {
                        // Jika belum berlangganan
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                {$row['nama']} - Pemateri: {$row['pemateri']} - Kategori: {$row['kategori']}
                                <span class='badge bg-warning'>Langganan untuk akses</span>
                              </li>";
                    } else {
                        // Jika sudah berlangganan
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                {$row['nama']} - Pemateri: {$row['pemateri']} - Kategori: {$row['kategori']}
                                <a href='course.php?id={$row['id']}' class='btn btn-primary btn-sm'>Akses</a>
                              </li>";
                    }
                }
            } else {
                echo "<li class='list-group-item'>Belum ada kursus tersedia.</li>";
            }
        ?>
        </ul>
    </div>
</section>


        <!-- Riwayat Kursus -->
        <section id="course-history" class="mb-4">
            <div class="card p-4">
                <h5 class="card-title">Riwayat Kursus</h5>
                <ul class="list-group">
                    <?php
                    $query_history = "
                        SELECT k.id, k.nama_kursus AS nama, u.username AS pemateri
                        FROM kursus_user ku
                        JOIN kursus k ON ku.id_kursus = k.id
                        JOIN users u ON k.dibuat_oleh = u.id
                        WHERE ku.id_user = '{$_SESSION['user_id']}' AND ku.status = 'selesai'
                    ";

                    $result_history = mysqli_query($conn, $query_history);

                    if ($result_history && mysqli_num_rows($result_history) > 0) {
                        while ($row = mysqli_fetch_assoc($result_history)) {
                            echo "<li class='list-group-item'>
                                    {$row['nama']} - Pemateri: {$row['pemateri']}
                                    <a href='certificate.php?id={$row['id']}' class='btn btn-link'>Download Sertifikat</a>
                                  </li>";
                        }
                    } else {
                        echo "<li class='list-group-item'>Belum ada riwayat kursus.</li>";
                    }
                    ?>
                </ul>
            </div>
        </section>

        <!-- Progress -->
        <section id="progress" class="mb-4">
            <div class="card p-4">
                <h5 class="card-title">Progres Belajar</h5>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                         style="width: 70%;">70%</div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="main-footer">
            <p>&copy; 2024 Shanum Course Team. All rights reserved.<br>
            Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
            <img src="img/footer2.gif" alt="Footer GIF" width="100">
        </footer>
        
        <script>
        // Remove preload popup after the page is fully loaded
        window.addEventListener('load', () => {
            const preload = document.getElementById('preload');
            preload.style.display = 'none';
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show the pop-up when the page loads
        window.onload = function () {
            const popup = document.getElementById('popup');
            const overlay = document.getElementById('popup-overlay');
            const closeBtn = document.getElementById('popup-close');

            // Display popup and overlay
            popup.style.display = 'block';
            overlay.style.display = 'block';

            // Close the popup
            closeBtn.addEventListener('click', () => {
                popup.style.display = 'none';
                overlay.style.display = 'none';
            });

            // Close popup when clicking outside of it
            overlay.addEventListener('click', () => {
                popup.style.display = 'none';
                overlay.style.display = 'none';
            });
        };
    </script>

</body>
</html>