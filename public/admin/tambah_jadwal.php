<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_connection");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $email_pemateri = $_POST['email_pemateri'];
    $nama_kursus = $_POST['nama_kursus'];
    $hari = $_POST['hari'];
    $waktu = $_POST['waktu'];

    // Siapkan query untuk memasukkan data ke tabel jadwal
    $stmt = $conn->prepare("INSERT INTO jadwal (email_pemateri, nama_kursus, hari, waktu, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $email_pemateri, $nama_kursus, $hari, $waktu);

    if ($stmt->execute()) {
        echo "<script>alert('Jadwal berhasil ditambahkan!'); window.location.href='jadwal.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan jadwal!'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pemateri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #6a11cb;
        }
        .form-label {
            font-weight: bold;
        }
        .container {
            margin-top: 10px;
        }
        h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        }
        .navbar a {
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="./../dashboard_admin.php">Shanum Course</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./../dashboard_admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="jadwal.php">Jadwal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1 class="text-center mb-4"><i class="fas fa-calendar-plus"></i> Tambah Jadwal Pemateri</h1>

    <!-- Form Tambah Jadwal -->
    <div class="card mb-4 p-4">
        <div class="card-body">
            <h3 class="card-title text-center"><i class="fas fa-plus-circle"></i> Form Tambah Jadwal</h3>
            <form action="tambah_jadwal.php" method="POST">
                <div class="mb-3">
                    <label for="email_pemateri" class="form-label">Email Pemateri</label>
                    <input type="email" class="form-control" id="email_pemateri" name="email_pemateri" placeholder="contoh: pemateri@kursus.com" required>
                </div>
                <div class="mb-3">
                    <label for="nama_kursus" class="form-label">Nama Kursus</label>
                    <input type="text" class="form-control" id="nama_kursus" name="nama_kursus" placeholder="contoh: Kursus Bahasa Inggris" required>
                </div>
                <div class="mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <select class="form-select" id="hari" name="hari" required>
                        <option value="">Pilih Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="waktu" class="form-label">Waktu</label>
                    <input type="time" class="form-control" id="waktu" name="waktu" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Tambah Jadwal</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
