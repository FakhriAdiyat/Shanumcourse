<?php
session_start();
session_unset();
session_destroy();
header('Location: ../../public/login.php'); // Redirect ke halaman login
exit();
?>
