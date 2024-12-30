<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki hak akses sebagai pemateri
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pemateri') {
    header('Location: login.php');
    exit();
}

require '../../database/db_connection.php'; // Pastikan file ini terhubung dengan database Anda

// Fetch akun pemateri dari database
$query = "SELECT * FROM users WHERE role = 'pemateri'";
$result = $conn->query($query);
$accounts = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun Pemateri</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #0056b3;
            color: #fff;
            padding: 15px 20px;
        }

        header h1 {
            margin-bottom: 10px;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        header nav ul li a.active,
        header nav ul li a:hover {
            background-color: #003f80;
        }

        main {
            padding: 20px;
        }

        h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        table td a {
            text-decoration: none;
            color: #0056b3;
            margin-right: 10px;
        }

        table td a:hover {
            text-decoration: underline;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #0056b3;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .button:hover {
            background-color: #003f80;
        }
        .main-footer {
            display: flex; /* Aktifkan Flexbox */
            justify-content: space-between; /* Pisahkan teks dan GIF */
            align-items: center; /* Pusatkan teks secara vertikal */
            background-color: #003f80; /* Warna latar (opsional) */
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
    </style>
</head>
<body>
    <header>
        <h1>Dashboard Pemateri</h1>
        <nav>
            <ul>
                <li><a href="./../dashboard_pemateri.php">Home</a></li>
                <li><a href="manajemen_akun.php" class="active">Manajemen Akun</a></li>
                <li><a href="./../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Manajemen Akun Pemateri</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account): ?>
                <tr>
                    <td><?= htmlspecialchars($account['id']) ?></td>
                    <td><?= htmlspecialchars($account['username']) ?></td>
                    <td><?= htmlspecialchars($account['email']) ?></td>
                    <td>
                    <a href="edit_akun.php?id=<?= $account['id'] ?>">Edit</a>
                    <a href="hapus_akun.php?id=<?= $account['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="tambah_akun.php" class="button"><i class="fas fa-plus"></i> Tambah Akun</a>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
        <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="./../img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
</body>
</html>
