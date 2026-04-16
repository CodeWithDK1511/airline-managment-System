<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';
$booking = null;

// Search
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $bid = (int)$_POST['booking_id'];
    $stmt = $conn->prepare("SELECT * FROM bookings_table WHERE booking_id = :bid");
    $stmt->execute([':bid' => $bid]);
    $booking = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$booking) { $msg = 'Booking not found.'; $msgType = 'error'; }
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare(
            "UPDATE bookings_table SET booking_status=:status, seat_number=:seat WHERE booking_id=:bid"
        );
        $stmt->execute([
            ':bid'    => (int)$_POST['booking_id'],
            ':status' => $_POST['booking_status'],
            ':seat'   => trim($_POST['seat_number']),
        ]);
        $msg = 'Booking updated successfully!'; $msgType = 'success';
        $stmt2 = $conn->prepare("SELECT * FROM bookings_table WHERE booking_id = :bid");
        $stmt2->execute([':bid' => (int)$_POST['booking_id']]);
        $booking = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Edit Booking</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Edit Booking</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>

    <form method="post">
        <label>Booking ID</label>
        <input type="number" name="booking_id" value="<?= htmlspecialchars($_POST['booking_id'] ?? '') ?>" required>
        <button type="submit" name="search" class="btn">Search</button>
    </form>

    <?php if ($booking): ?>
    <hr style="margin:20px 0;">
    <form method="post">
        <input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking['booking_id']) ?>">
        <label>Seat Number</label>
        <input type="text" name="seat_number" value="<?= htmlspecialchars($booking['seat_number']) ?>" required>
        <label>Booking Status</label>
        <select name="booking_status">
            <?php foreach (['Booked','Cancelled','Completed'] as $s): ?>
            <option value="<?= $s ?>" <?= $booking['booking_status'] === $s ? 'selected' : '' ?>><?= $s ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit" name="update" class="btn">Update Booking</button>
    </form>
    <?php endif; ?>

    <a href="list_booking.php" class="back-btn">List Bookings</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
