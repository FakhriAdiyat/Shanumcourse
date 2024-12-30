<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Periksa apakah pengguna sudah login dan memiliki peran admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require '../../database/db_connection.php'; // Pastikan file koneksi database sudah benar

// Debugging: Cek koneksi database
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data pembayaran dari database
$query = "SELECT id, email, province, dana_phone, dana_account_number, payment_proof, created_at FROM payments";
$result = $conn->query($query);

// Debugging: Cek apakah query berhasil
if (!$result) {
    die("Error retrieving data: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Payments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar img {
            max-width: 80px;
        }

        .navbar-menu {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 25px;
        }

        .navbar-menu li {
            display: inline;
        }

        .navbar-menu li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .navbar-menu li a:hover {
            background-color: #34495e;
            padding-left: 10px;
            border-radius: 5px;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px; /* Add space for navbar */
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payment-table th, .payment-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .payment-table th {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-header">
            <img src="../../public/img/sc.png" alt="Logo">
            <h2 class="text-white">Admin Panel</h2>
        </div>
        <ul class="navbar-menu">
            <li><a href="../dashboard_admin.php">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h3>Payment Records</h3>

        <table class="payment-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Province</th>
                    <th>Dana Phone</th>
                    <th>Dana Account Number</th>
                    <th>Payment Proof</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['province']; ?></td>
                        <td><?php echo $row['dana_phone']; ?></td>
                        <td><?php echo $row['dana_account_number']; ?></td>
                        <td><a href="../user/<?php echo $row['payment_proof']; ?>" target="_blank">View Proof</a></td>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($row['created_at'])); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
