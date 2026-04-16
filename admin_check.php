<?php
// admin_check.php – Include on pages only admins can access
if (session_status() === PHP_SESSION_NONE) {
    if (session_status() == PHP_SESSION_NONE) { session_start(); }
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /airlineManagmentSystem2/auth/login.php");
    exit;
}
if ($_SESSION['role'] !== 'admin') {
    header("Location: /airlineManagmentSystem2/index.php");
    exit;
}
?>
