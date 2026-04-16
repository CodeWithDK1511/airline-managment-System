<?php
// auth_check.php – Include at the TOP of every protected page
if (session_status() === PHP_SESSION_NONE) {
    if (session_status() == PHP_SESSION_NONE) { session_start(); }
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /airlineManagmentSystem2/auth/login.php");
    exit;
}
?>
