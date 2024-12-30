<?php
// manage_instructors.php

session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
require '../../database/db_connection.php';
require_once '../../config/config.php';

// Handle actions (add, edit, delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $name = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $role = 'pemateri'; // Setting role as 'pemateri' for instructor
            $is_subscribed = 0; // Assuming new instructors are not subscribed initially
            $subscription_expiry = NULL; // Assuming no subscription expiry initially
            $phone_number = $_POST['phone_number']; // Assume phone_number is provided

            // Insert into 'users' table (including phone_number column)
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, is_subscribed, subscription_expiry, phone_number, created_at) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $password, $role, $is_subscribed, $subscription_expiry, $phone_number]);

        } elseif ($action === 'edit') {
            $id = $_POST['id'];
            $name = $_POST['username'];
            $email = $_POST['email'];

            // Update instructor information in 'users' table
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $id]);
        } elseif ($action === 'delete') {
            $id = $_POST['id'];

            // Delete instructor from 'users' table
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
        }
    }
}

// Fetch instructors from 'users' table where role is 'pemateri'
$stmt = $pdo->query("SELECT * FROM users WHERE role = 'pemateri'");
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Instructors</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Global styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        table tr:hover {
            background-color: #f9f9f9;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 40%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 30px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal form {
            display: flex;
            flex-direction: column;
        }

        .modal form input,
        .modal form button {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .modal form button:hover {
            background-color: #45a049;
        }

        /* Styling dasar untuk tombol */
        .btn-home {
            display: inline-block;
            text-decoration: none;
            background-color: #007bff; /* Warna dasar biru */
            color: white; /* Warna teks */
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px; /* Membuat sudut tombol melengkung */
            transition: all 0.3s ease; /* Animasi halus */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Tambahkan efek bayangan */
        }

        /* Efek hover */
        .btn-home:hover {
            background-color: #0056b3; /* Warna biru lebih gelap saat hover */
            transform: translateY(-2px); /* Tombol terlihat seperti terangkat */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Tingkatkan bayangan */
        }

        /* Efek saat tombol ditekan */
        .btn-home:active {
            transform: translateY(0); /* Tombol kembali ke posisi semula */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Kurangi bayangan */
        }

        /* Responsif untuk ukuran layar kecil */
        @media (max-width: 768px) {
            .btn-home {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }

    </style>
</head>
<body>

    <header class="text-white">
        <nav>
            <a href="./../dashboard_admin.php" class="btn-home"><i class="fas fa-home"></i> Home</a>
        </nav>
    </header>
    
    <div class="dashboard-container">
        <h1>Manage Instructors</h1>
        
        <button onclick="document.getElementById('addModal').style.display='block'">Add Instructor</button>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instructors as $instructor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($instructor['id']); ?></td>
                        <td><?php echo htmlspecialchars($instructor['username']); ?></td>
                        <td><?php echo htmlspecialchars($instructor['email']); ?></td>
                        <td><?php echo htmlspecialchars($instructor['phone_number']); ?></td>
                        <td>
                            <button onclick="editInstructor(<?php echo htmlspecialchars(json_encode($instructor)); ?>)">Edit</button>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($instructor['id']); ?>">
                                <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Modal -->
        <div id="addModal" class="modal">
            <form class="modal-content" method="POST">
                <span onclick="document.getElementById('addModal').style.display='none'" class="close">&times;</span>
                <h2>Add Instructor</h2>
                <input type="hidden" name="action" value="add">
                <label for="name">Name</label>
                <input type="text" name="name" required>
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" name="password" required>
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" required>
                <button type="submit">Add</button>
            </form>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="modal">
            <form class="modal-content" method="POST">
                <span onclick="document.getElementById('editModal').style.display='none'" class="close">&times;</span>
                <h2>Edit Instructor</h2>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit-id">
                <label for="name">Name</label>
                <input type="text" name="name" id="edit-name" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="edit-email" required>
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="edit-phone_number" required>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        function editInstructor(instructor) {
            document.getElementById('edit-id').value = instructor.id;
            document.getElementById('edit-name').value = instructor.name;
            document.getElementById('edit-email').value = instructor.email;
            document.getElementById('edit-phone_number').value = instructor.phone_number;
            document.getElementById('editModal').style.display = 'block';
        }
    </script>
</body>
</html>
