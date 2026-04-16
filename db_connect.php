<?php
// db_connect.php – Database connection (shared by all pages)
$host   = 'localhost';
$dbname = 'airlinedatabase';
$username = 'root';
$password = '';   // XAMPP default – change if you set a password

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
