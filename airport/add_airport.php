<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO airports_table (airport_code, Airport_name, city, country)
             VALUES (:airport_code, :Airport_name, :city, :country)"
        );
        $stmt->execute([
            ':airport_code' => trim($_POST['airport_code']),
            ':Airport_name' => trim($_POST['Airport_name']),
            ':city'         => trim($_POST['city']),
            ':country'      => trim($_POST['country']),
        ]);
        $msg = 'Airport added successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Add Airport</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add Airport</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>$msg</div>"; ?>
    <form method="post">
        <label>Airport Code</label>
        <input type="text" name="airport_code" maxlength="10" required>
        <label>Airport Name</label>
        <input type="text" name="Airport_name" required>
        <label>City</label>
        <input type="text" name="city" required>
        <label>Country</label>
        <input type="text" name="country" required>
        <input type="submit" value="Add Airport">
    </form>
    <a href="list_airport.php" class="back-btn">View All Airports</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
