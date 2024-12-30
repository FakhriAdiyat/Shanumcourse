<?php
session_start();
include('../../database/db_connection.php'); // Pastikan path benar

class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        // Validasi input kosong
        if (empty($email) || empty($password)) {
            throw new Exception('Email dan Password harus diisi!');
        }

        // Query untuk mengambil user berdasarkan email
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validasi user dan password
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data jika valid
        }

        throw new Exception('Email atau Password salah!');
    }
}

class SessionManager {
    public static function setUserSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['is_subscribed'] = $user['is_subscribed'];
    }

    public static function getRedirectUrlByRole($role) {
        $roleRedirects = [
            'user' => '../public/dashboard_user.php',
            'pemateri' => '../public/dashboard_pemateri.php',
            'admin' => '../public/dashboard_admin.php',
        ];

        return $roleRedirects[$role] ?? null;
    }
}

class Redirector {
    public static function redirectToLoginPage($redirectUrl) {
        echo "<script>
            localStorage.setItem('loginSuccess', 'true');
            localStorage.setItem('redirectUrl', '$redirectUrl');
            window.location.href = '../../public/login.php';
        </script>";
    }
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Buat objek Auth untuk proses login
        $auth = new Auth($pdo);
        $user = $auth->login($email, $password);

        // Set session pengguna
        SessionManager::setUserSession($user);

        // Redirect berdasarkan role
        $redirectUrl = SessionManager::getRedirectUrlByRole($user['role']);
        if ($redirectUrl) {
            Redirector::redirectToLoginPage($redirectUrl);
        } else {
            throw new Exception('Role tidak valid!');
        }
    }
} catch (Exception $e) {
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
}
?>