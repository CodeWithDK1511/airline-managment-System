<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

// Handle GET delete (from list page link)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['passenger_id'])) {
    $pid = (int)$_GET['passenger_id'];
    try {
        $stmt = $conn->prepare("DELETE FROM passengers WHERE passenger_id = :pid");
        $stmt->execute([':pid' => $pid]);
        $msg = 'Passenger deleted successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}

// Handle POST delete (from form on this page)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pid = (int)$_POST['passenger_id'];
    try {
        $stmt = $conn->prepare("DELETE FROM passengers WHERE passenger_id = :pid");
        $stmt->execute([':pid' => $pid]);
        $msg = 'Passenger deleted successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Delete Passenger</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Delete Passenger</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Passenger ID to Delete</label>
        <input type="number" name="passenger_id" required>
        <input type="submit" value="Delete Passenger"
               style="background:#c0392b;"
               onclick="return confirm('This cannot be undone. Continue?')">
    </form>
    <a href="list_passenger.php" class="back-btn">List Passengers</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
