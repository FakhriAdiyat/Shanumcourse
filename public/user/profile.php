<?php
session_start();
include('../../database/db_connection.php'); // Pastikan path benar

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database
try {
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Jika user tidak ditemukan, redirect ke login
        header("Location: ../../public/login.php");
        exit();
    }
} catch (PDOException $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    exit();
}

// Proses pembaruan profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    try {
        // Update data pengguna di database
        $update_query = "UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id";
        $stmt = $pdo->prepare($update_query);
        $stmt->bindParam(':username', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect ke halaman profil dengan data terbaru
        header("Location: profile.php");
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            color: #333;
        }

        header {
            background: #6200ea;
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        section {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            margin-bottom: 20px;
            font-size: 20px;
            color: #6200ea;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #6200ea;
            box-shadow: 0 0 4px rgba(98, 0, 234, 0.2);
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background: #6200ea;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background: #5300d2;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 10px;
            }

            section {
                margin: 20px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Selamat datang di Dashboard Kursus Online, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="./../dashboard_user.php">Dashboard</a></li>
                <li><a href="courses.php">Kursus</a></li>
                <li><a href="profile.php">Profil</a></li>
                <li><a href="./../logout.php">Keluar</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Informasi Profil</h2>
        <form method="post" action="profile.php">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor Telepon:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Perbarui Profil</button>
            </div>
        </form>
    </section>

</body>
</html>
