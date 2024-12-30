<?php
require '../../database/db_connection.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute(['id' => $id]);
    header('Location: ../../src/views/user_list.php?delete=success');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
