<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$payments = $conn->query("SELECT * FROM payments_table ORDER BY payment_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Payment List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Payment List</h2>
    <a href="create_payment.php" class="add-btn">+ Add Payment</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($payments): ?>
    <table>
        <thead>
            <tr><th>Payment ID</th><th>Booking ID</th><th>Date</th><th>Method</th><th>Amount (₹)</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($payments as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['payement_id']) ?></td>
            <td><?= htmlspecialchars($p['booking_id']) ?></td>
            <td><?= htmlspecialchars($p['payment_date']) ?></td>
            <td><?= htmlspecialchars($p['payment_method']) ?></td>
            <td><?= htmlspecialchars(number_format($p['amount'], 2)) ?></td>
            <td><a href="edit_payment.php">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No payments found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
