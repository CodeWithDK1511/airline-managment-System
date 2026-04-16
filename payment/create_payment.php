<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

// Auto-generate next payment ID
$row = $conn->query("SELECT COALESCE(MAX(payement_id), 0) + 1 AS next_id FROM payments_table")->fetch(PDO::FETCH_ASSOC);
$next_payment_id = $row['next_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = (int)$_POST['booking_id'];
    // Verify booking exists
    $check = $conn->prepare("SELECT COUNT(*) FROM bookings_table WHERE booking_id = :bid");
    $check->execute([':bid' => $booking_id]);
    if ($check->fetchColumn() == 0) {
        $msg = 'Booking ID does not exist. Please check and try again.'; $msgType = 'error';
    } else {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO payments_table (payement_id, booking_id, payment_date, payment_method, amount)
                 VALUES (:pid, :bid, NOW(), :method, :amount)"
            );
            $stmt->execute([
                ':pid'    => (int)$_POST['payment_id'],
                ':bid'    => $booking_id,
                ':method' => trim($_POST['payment_method']),
                ':amount' => (float)$_POST['amount'],
            ]);
            $msg = 'Payment processed successfully!'; $msgType = 'success';
        } catch (PDOException $e) {
            $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
        }
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Add Payment</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add Payment</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Payment ID (auto-generated)</label>
        <input type="number" name="payment_id" value="<?= htmlspecialchars($next_payment_id) ?>" readonly>
        <label>Booking ID</label>
        <input type="number" name="booking_id" required>
        <label>Payment Method</label>
        <select name="payment_method">
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="UPI">UPI</option>
            <option value="Net Banking">Net Banking</option>
            <option value="Cash">Cash</option>
        </select>
        <label>Amount (₹)</label>
        <input type="number" name="amount" min="1" step="0.01" required>
        <input type="submit" value="Process Payment">
    </form>
    <a href="list_payments.php" class="back-btn">Payment List</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
