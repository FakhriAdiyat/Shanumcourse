<?php
require '../../database/db_connection.php';

// Ambil data user berdasarkan ID
$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form action="../views/update_user.php?id=<?php echo $user['id']; ?>" method="POST" class="form-register">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
    
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
    
            <label for="is_subscribed">Subscription Status</label>
            <select id="is_subscribed" name="is_subscribed">
                <option value="1" <?php echo ($user['is_subscribed'] == 1 ? 'selected' : ''); ?>>Subscribed</option>
                <option value="0" <?php echo ($user['is_subscribed'] == 0 ? 'selected' : ''); ?>>Not Subscribed</option>
            </select>
    
            <label for="subscription_expiry">Subscription Expiry</label>
            <input type="date" id="subscription_expiry" name="subscription_expiry" value="<?php echo $user['subscription_expiry']; ?>">

        <button type="submit">Update</button>
    </form>

    </div>
</body>
</html>
