<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO planes_table (plane_id, model, capacity, manufacturer)
             VALUES (:pid, :model, :cap, :mfr)"
        );
        $stmt->execute([
            ':pid'   => (int)$_POST['plane_id'],
            ':model' => trim($_POST['model']),
            ':cap'   => (int)$_POST['capacity'],
            ':mfr'   => trim($_POST['manufacturer']),
        ]);
        $msg = 'Plane added successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Add Plane</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add Plane</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Plane ID</label>
        <input type="number" name="plane_id" required>
        <label>Model</label>
        <input type="text" name="model" placeholder="e.g. Boeing 737" required>
        <label>Capacity</label>
        <input type="number" name="capacity" min="1" required>
        <label>Manufacturer</label>
        <input type="text" name="manufacturer" required>
        <input type="submit" value="Add Plane">
    </form>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
