<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify booking exists
    $check = $conn->prepare("SELECT COUNT(*) FROM bookings_table WHERE booking_id = :bid");
    $check->execute([':bid' => (int)$_POST['booking_id']]);
    if ($check->fetchColumn() == 0) {
        $msg = 'Booking ID does not exist.'; $msgType = 'error';
    } else {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO tickets (booking_id, ticket_number, seat_class, seat_number, issued_date)
                 VALUES (:bid, :tnum, :class, :seat, NOW())"
            );
            $stmt->execute([
                ':bid'   => (int)$_POST['booking_id'],
                ':tnum'  => trim($_POST['ticket_number']),
                ':class' => $_POST['seat_class'],
                ':seat'  => trim($_POST['seat_number']),
            ]);
            $msg = 'Ticket added successfully!'; $msgType = 'success';
        } catch (PDOException $e) {
            $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>New Ticket</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add New Ticket</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Booking ID</label>
        <input type="number" name="booking_id" required>
        <label>Ticket Number</label>
        <input type="text" name="ticket_number" placeholder="e.g. TKT-2024-001" required>
        <label>Seat Class</label>
        <select name="seat_class">
            <option value="Economy">Economy</option>
            <option value="Business">Business</option>
            <option value="First">First</option>
        </select>
        <label>Seat Number</label>
        <input type="text" name="seat_number" placeholder="e.g. 14B" required>
        <input type="submit" value="Issue Ticket">
    </form>
    <a href="list_ticket.php" class="back-btn">Ticket List</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
