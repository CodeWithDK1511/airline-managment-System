<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO crew_assignments (assignment_id, flight_id, crew_id)
             VALUES (:aid, :fid, :cid)"
        );
        $stmt->execute([
            ':aid' => (int)$_POST['assignment_id'],
            ':fid' => (int)$_POST['flight_id'],
            ':cid' => (int)$_POST['crew_id'],
        ]);
        $msg = 'Crew assignment added successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Crew Assignment</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Assign Crew to Flight</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Assignment ID</label>
        <input type="number" name="assignment_id" required>
        <label>Flight ID</label>
        <input type="number" name="flight_id" required>
        <label>Crew ID</label>
        <input type="number" name="crew_id" required>
        <input type="submit" value="Assign Crew">
    </form>
    <a href="list_assighnments.php" class="back-btn">List Assignments</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
