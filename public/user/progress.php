<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include the database connection file
require_once '../config/config.php';

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch course progress data
$query = "SELECT c.name AS course_name, uc.progress_percentage, uc.last_accessed
          FROM user_courses uc
          JOIN courses c ON uc.course_id = c.id
          WHERE uc.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$progress_data = [];
while ($row = $result->fetch_assoc()) {
    $progress_data[] = $row;
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <nav>
            <a href="dashboard_user.php">Home</a>
            <a href="courses.php">Courses</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Your Course Progress</h2>
        <?php if (count($progress_data) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Progress</th>
                        <th>Last Accessed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($progress_data as $progress): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($progress['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($progress['progress_percentage']); ?>%</td>
                            <td><?php echo htmlspecialchars($progress['last_accessed']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not enrolled in any courses yet.</p>
        <?php endif; ?>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
        <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
</body>
</html>
