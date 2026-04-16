<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

// Auto-generate next booking ID
$row = $conn->query("SELECT COALESCE(MAX(booking_id),999) + 1 AS next_id FROM bookings_table")->fetch(PDO::FETCH_ASSOC);
$next_booking_id = $row['next_id'];

$passenger_id = isset($_GET['passenger_id']) ? (int)$_GET['passenger_id'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO bookings_table (booking_id, passenger_id, flight_id, booking_date, seat_number, booking_status)
             VALUES (:bid, :pid, :fid, NOW(), :seat, 'Booked')"
        );
        $stmt->execute([
            ':bid'  => (int)$_POST['booking_id'],
            ':pid'  => (int)$_POST['passenger_id'],
            ':fid'  => (int)$_POST['flight_id'],
            ':seat' => trim($_POST['seat_number']),
        ]);
        $msg = 'Booking created successfully! Booking ID: ' . (int)$_POST['booking_id'];
        $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Create Booking</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Create Booking</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Booking ID (auto-generated)</label>
        <input type="number" name="booking_id" value="<?= htmlspecialchars($next_booking_id) ?>" readonly>
        <label>Passenger ID</label>
        <input type="number" name="passenger_id" value="<?= htmlspecialchars($passenger_id) ?>" required>
        <label>Flight ID</label>
        <input type="number" name="flight_id" required>
        <label>Seat Number</label>
        <input type="text" name="seat_number" placeholder="e.g. 12A" required>
        <input type="submit" value="Create Booking">
    </form>
    <a href="list_booking.php" class="back-btn">List Bookings</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
