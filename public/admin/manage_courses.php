<?php
// Include file koneksi ke database
include('../../database/db_connection.php');

// Mengecek apakah admin sudah login
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Menangani aksi tambah, edit, dan hapus kursus
if (isset($_POST['add_course'])) {
    // Menambahkan kursus baru
    $course_name = $_POST['nama_kursus'];
    $course_description = $_POST['deskripsi'];
    $course_category = $_POST['kategori'];
    $created_by = $_SESSION['user_id'];  // Mengambil ID pengguna yang sedang login
    $created_at = date('Y-m-d H:i:s');  // Tanggal dan waktu saat kursus dibuat

    $query = "INSERT INTO courses (nama_kursus, deskripsi, kategori, dibuat_oleh, tanggal_dibuat) 
              VALUES ('$course_name', '$course_description', '$course_category', '$created_by', '$created_at')";
    mysqli_query($conn, $query);
}

if (isset($_POST['edit_course'])) {
    // Mengedit kursus yang ada
    $course_id = $_POST['kursus_id'];
    $course_name = $_POST['nama_kursus'];
    $course_description = $_POST['deskripsi'];
    $course_category = $_POST['kategori'];

    $query = "UPDATE courses 
              SET nama_kursus='$course_name', deskripsi='$course_description', kategori='$course_category' 
              WHERE id='$course_id'";
    mysqli_query($conn, $query);
}

if (isset($_GET['delete_course'])) {
    // Menghapus kursus berdasarkan ID
    $course_id = $_GET['delete_course'];
    $query = "DELETE FROM kursus WHERE id='$course_id'";
    mysqli_query($conn, $query);
}

// Mengambil data kursus dari database
$query = "SELECT * FROM kursus";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses - Dashboard Admin</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your styles -->
</head>
<style>
    /* Reset untuk margin dan padding default */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body halaman */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        color: #333;
        padding: 20px;
    }

    /* Container utama */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        background-color: white;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Judul halaman */
    h1 {
        font-size: 28px;
        color: #4b6a9d;
        margin-bottom: 20px;
    }

    /* Form untuk menambah kursus */
    form {
        background-color: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    form h2 {
        font-size: 22px;
        color: #4b6a9d;
        margin-bottom: 15px;
    }

    label {
        font-size: 14px;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    textarea:focus {
        border-color: #4b6a9d;
        outline: none;
    }

    button[type="submit"] {
        background-color: #4b6a9d;
        color: white;
        padding: 12px 25px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #3a5578;
    }

    /* Tabel kursus */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: #f0f4f8;
        color: #4b6a9d;
        font-size: 16px;
    }

    table td {
        font-size: 14px;
    }

    table tr:hover {
        background-color: #f7f9fc;
    }

    /* Tombol edit dan hapus */
    button, a {
        padding: 6px 12px;
        background-color: #4b6a9d;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover, a:hover {
        background-color: #3a5578;
    }

    a {
        margin-left: 10px;
    }

    /* Modal untuk edit kursus */
    #editCourseModal {
        background-color: rgba(0, 0, 0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        justify-content: center;
        align-items: center;
    }

    #editCourseModal form {
        background-color: white;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 400px;
        max-width: 90%;
    }

    #editCourseModal input[type="text"],
    #editCourseModal textarea {
        width: 100%;
    }

    #editCourseModal button[type="submit"] {
        width: 100%;
        background-color: #4b6a9d;
        padding: 12px;
        font-size: 16px;
    }

    #editCourseModal button[type="button"] {
        width: 100%;
        background-color: #f44336;
        padding: 12px;
        font-size: 16px;
    }

    #editCourseModal button[type="button"]:hover {
        background-color: #e31c1c;
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
<body>
    <header class="text-white">
        <nav>
            <a href="./../dashboard_admin.php" class="btn-home"><i class="fas fa-home"></i> Home</a>
        </nav>
    </header>
    <div class="container">
        <h1>Manage Courses</h1>

        <!-- Form untuk menambahkan kursus baru -->
        <form action="manage_courses.php" method="POST">
            <h2>Add New Course</h2>
            <label for="course_name">Course Name:</label>
            <input type="text" name="course_name" id="course_name" required>
            <label for="course_description">Course Description:</label>
            <textarea name="course_description" id="course_description" required></textarea>
            <label for="course_category">Course Category:</label>
            <input type="text" name="course_category" id="course_category" required>
            <button type="submit" name="add_course">Add Course</button>
        </form>

        <hr>

        <h2>List of Courses</h2>
        <table>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $course['id']; ?></td>
                        <td><?php echo $course['nama_kursus']; ?></td>
                        <td><?php echo $course['deskripsi']; ?></td>
                        <td><?php echo $course['kategori']; ?></td>
                        <td>
                            <!-- Button untuk mengedit kursus -->
                            <button onclick="editCourse(<?php echo $course['id']; ?>, '<?php echo $course['nama_kursus']; ?>', '<?php echo $course['deskripsi']; ?>', '<?php echo $course['kategori']; ?>')">Edit</button>
                            
                            <!-- Link untuk menghapus kursus -->
                            <a href="manage_courses.php?delete_course=<?php echo $course['id']; ?>" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Form untuk mengedit kursus (Hidden) -->
        <div id="editCourseModal" style="display:none;">
            <h2>Edit Course</h2>
            <form action="manage_courses.php" method="POST">
                <input type="hidden" name="course_id" id="edit_course_id">
                <label for="course_name">Course Name:</label>
                <input type="text" name="course_name" id="edit_course_name" required>
                <label for="course_description">Course Description:</label>
                <textarea name="course_description" id="edit_course_description" required></textarea>
                <label for="course_category">Course Category:</label>
                <input type="text" name="course_category" id="edit_course_category" required>
                <button type="submit" name="edit_course">Save Changes</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // Function to populate and show the edit course modal
        function editCourse(courseId, courseName, courseDescription, courseCategory) {
            document.getElementById('editCourseModal').style.display = 'block';
            document.getElementById('edit_course_id').value = courseId;
            document.getElementById('edit_course_name').value = courseName;
            document.getElementById('edit_course_description').value = courseDescription;
            document.getElementById('edit_course_category').value = courseCategory;
        }

        // Function to close the edit course modal
        function closeEditModal() {
            document.getElementById('editCourseModal').style.display = 'none';
        }
    </script>
</body>
</html>
