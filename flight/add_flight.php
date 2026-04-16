<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO flights_table (flight_id, flight_number, departure_time, arrival_time, origin, destination, plain_id, status)
             VALUES (:fid, :fnum, :dep, :arr, :origin, :dest, :pid, :status)"
        );
        $stmt->execute([
            ':fid'    => (int)$_POST['flight_id'],
            ':fnum'   => trim($_POST['flight_number']),
            ':dep'    => $_POST['departure_time'],
            ':arr'    => $_POST['arrival_time'],
            ':origin' => trim($_POST['origin']),
            ':dest'   => trim($_POST['destination']),
            ':pid'    => $_POST['plain_id'] !== '' ? (int)$_POST['plain_id'] : null,
            ':status' => trim($_POST['status']),
        ]);
        $msg = 'Flight added successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Add Flight</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add Flight</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Flight ID</label>
        <input type="number" name="flight_id" required>
        <label>Flight Number</label>
        <input type="text" name="flight_number" required>
        <label>Departure Time</label>
        <input type="datetime-local" name="departure_time" required>
        <label>Arrival Time</label>
        <input type="datetime-local" name="arrival_time" required>
        <label>Origin</label>
        <input type="text" name="origin" required>
        <label>Destination</label>
        <input type="text" name="destination" required>
        <label>Plane ID (optional)</label>
        <input type="number" name="plain_id">
        <label>Status</label>
        <select name="status">
            <option value="Scheduled">Scheduled</option>
            <option value="Delayed">Delayed</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Completed">Completed</option>
        </select>
        <br><br>
        <input type="submit" value="Add Flight">
    </form>
    <a href="list_flight.php" class="back-btn">List Flights</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
