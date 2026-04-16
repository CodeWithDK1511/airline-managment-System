<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO cew_table (crew_id, first_name, last_name, role, flight_id)
             VALUES (:crew_id, :first_name, :last_name, :role, :flight_id)"
        );
        $stmt->execute([
            ':crew_id'    => (int)$_POST['crew_id'],
            ':first_name' => trim($_POST['first_name']),
            ':last_name'  => trim($_POST['last_name']),
            ':role'       => trim($_POST['role']),
            ':flight_id'  => $_POST['flight_id'] !== '' ? (int)$_POST['flight_id'] : null,
        ]);
        $msg = 'Crew member added successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Add Crew</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add Crew Member</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Crew ID</label>
        <input type="number" name="crew_id" required>
        <label>First Name</label>
        <input type="text" name="first_name" required>
        <label>Last Name</label>
        <input type="text" name="last_name" required>
        <label>Role</label>
        <input type="text" name="role" placeholder="e.g. Pilot, Cabin Crew" required>
        <label>Flight ID (optional)</label>
        <input type="number" name="flight_id">
        <input type="submit" value="Add Crew Member">
    </form>
    <a href="list_crew.php" class="back-btn">List Crew</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
