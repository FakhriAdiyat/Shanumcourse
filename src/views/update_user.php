<?php
require '../../database/db_connection.php';

$id = $_GET['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$is_subscribed = $_POST['is_subscribed'];
$subscription_expiry = $_POST['subscription_expiry'];

try {
    $sql = "UPDATE users 
            SET username = :username, 
                email = :email, 
                is_subscribed = :is_subscribed, 
                subscription_expiry = :subscription_expiry
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'is_subscribed' => $is_subscribed,
        'subscription_expiry' => $subscription_expiry,
        'id' => $id
    ]);
    header("Location: ../view/user_list.php?status=success");
} catch (PDOException $e) {
    header("Location: ../view/user_list.php?status=error");
}
