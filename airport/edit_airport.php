<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "UPDATE airports_table SET Airport_name=:n, city=:c, country=:co WHERE airport_code=:code"
        );
        $stmt->execute([
            ':code' => trim($_POST['airport_code']),
            ':n'    => trim($_POST['Airport_name']),
            ':c'    => trim($_POST['city']),
            ':co'   => trim($_POST['country']),
        ]);
        $msg = 'Airport updated successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Edit Airport</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Edit Airport</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>$msg</div>"; ?>
    <form method="post">
        <label>Airport Code (existing)</label>
        <input type="text" name="airport_code" required>
        <label>New Airport Name</label>
        <input type="text" name="Airport_name" required>
        <label>City</label>
        <input type="text" name="city" required>
        <label>Country</label>
        <input type="text" name="country" required>
        <input type="submit" value="Update Airport">
    </form>
    <a href="list_airport.php" class="back-btn">View All Airports</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
