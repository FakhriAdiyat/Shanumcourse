<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki hak akses sebagai pemateri
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pemateri') {
    header('Location: login.php');
    exit();
}

require '../../database/db_connection.php'; // Pastikan file ini terhubung dengan database Anda

// Periksa apakah ID akun tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manajemen_akun.php');
    exit();
}

$id = intval($_GET['id']);

// Ambil data akun berdasarkan ID
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$account = $result->fetch_assoc();

if (!$account) {
    header('Location: manajemen_akun.php');
    exit();
}

// Perbarui data akun jika formulir dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Validasi data
    if (empty($username) || empty($email)) {
        $error = "Semua kolom wajib diisi!";
    } else {
        // Update data ke database
        $updateQuery = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('ssi', $username, $email, $id);

        if ($updateStmt->execute()) {
            header('Location: manajemen_akun.php');
            exit();
        } else {
            $error = "Terjadi kesalahan saat memperbarui data.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun Pemateri</title>
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

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input[type="text"], form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #0056b3;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background-color: #003f80;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Edit Akun Pemateri</h1>
    </header>

    <main>
        <h2>Edit Data Akun</h2>

        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="username">Nama</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($account['username']) ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($account['email']) ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
    </main>
</body>
</html>
