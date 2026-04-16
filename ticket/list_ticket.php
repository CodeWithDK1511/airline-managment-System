<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$tickets = $conn->query("SELECT * FROM tickets ORDER BY issued_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Ticket List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Ticket List</h2>
    <a href="new_ticket.php" class="add-btn">+ New Ticket</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($tickets): ?>
    <table>
        <thead>
            <tr><th>Ticket ID</th><th>Booking ID</th><th>Ticket Number</th><th>Seat Class</th><th>Seat Number</th><th>Issued Date</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $t): ?>
        <tr>
            <td><?= htmlspecialchars($t['ticket_id']) ?></td>
            <td><?= htmlspecialchars($t['booking_id']) ?></td>
            <td><?= htmlspecialchars($t['ticket_number']) ?></td>
            <td><?= htmlspecialchars($t['seat_class']) ?></td>
            <td><?= htmlspecialchars($t['seat_number']) ?></td>
            <td><?= htmlspecialchars($t['issued_date']) ?></td>
            <td><a href="edit_ticket.php">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No tickets found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
