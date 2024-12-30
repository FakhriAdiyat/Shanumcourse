<?php
// tasks-quizzies.php

// Start session and include necessary files
session_start();
require_once '../../config/config.php';
require_once '../../functions/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'];

// Fetch quizzes and tasks from the database
$query = "SELECT * FROM quizzes WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$quizzes = $stmt->fetchAll();

$query = "SELECT * FROM tasks WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Quizzes & Tasks</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?= htmlspecialchars($user_name) ?>!</h1>
        <nav>
            <ul>
                <li><a href="dashboard_user.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="tasks-quizzies.php">Quizzes & Tasks</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="quizzes">
            <h2>Your Quizzes</h2>
            <?php if (count($quizzes) > 0): ?>
                <ul>
                    <?php foreach ($quizzes as $quiz): ?>
                        <li>
                            <h3><?= htmlspecialchars($quiz['title']) ?></h3>
                            <p>Status: <?= htmlspecialchars($quiz['status']) ?></p>
                            <p>Deadline: <?= htmlspecialchars($quiz['deadline']) ?></p>
                            <a href="quiz-details.php?id=<?= $quiz['id'] ?>">View Quiz</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No quizzes available.</p>
            <?php endif; ?>
        </section>

        <section id="tasks">
            <h2>Your Tasks</h2>
            <?php if (count($tasks) > 0): ?>
                <ul>
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <h3><?= htmlspecialchars($task['title']) ?></h3>
                            <p>Status: <?= htmlspecialchars($task['status']) ?></p>
                            <p>Deadline: <?= htmlspecialchars($task['deadline']) ?></p>
                            <a href="task-details.php?id=<?= $task['id'] ?>">View Task</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No tasks available.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 Shanum Course Team. All rights reserved.</p>
        <p>Contact us: support@shanumcourse.com | +62 899-XXX-XXXX</p>
        <img src="img/footer2.gif" alt="Footer GIF" width="100">
    </footer>
</body>
</html>
