<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';
$ticket = null;

// Search
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $stmt = $conn->prepare("SELECT * FROM tickets WHERE ticket_id = :tid");
    $stmt->execute([':tid' => (int)$_POST['ticket_id']]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$ticket) { $msg = 'Ticket not found.'; $msgType = 'error'; }
}

// Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare(
            "UPDATE tickets SET booking_id=:bid, ticket_number=:tnum, seat_class=:class, seat_number=:seat
             WHERE ticket_id=:tid"
        );
        $stmt->execute([
            ':tid'   => (int)$_POST['ticket_id'],
            ':bid'   => (int)$_POST['booking_id'],
            ':tnum'  => trim($_POST['ticket_number']),
            ':class' => $_POST['seat_class'],
            ':seat'  => trim($_POST['seat_number']),
        ]);
        $msg = 'Ticket updated successfully!'; $msgType = 'success';
        $stmt2 = $conn->prepare("SELECT * FROM tickets WHERE ticket_id = :tid");
        $stmt2->execute([':tid' => (int)$_POST['ticket_id']]);
        $ticket = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Edit Ticket</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Edit Ticket</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Ticket ID to search</label>
        <input type="number" name="ticket_id" value="<?= htmlspecialchars($_POST['ticket_id'] ?? '') ?>" required>
        <button type="submit" name="search" class="btn">Search</button>
    </form>
    <?php if ($ticket): ?>
    <hr style="margin:20px 0;">
    <form method="post">
        <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticket['ticket_id']) ?>">
        <label>Booking ID</label>
        <input type="number" name="booking_id" value="<?= htmlspecialchars($ticket['booking_id']) ?>" required>
        <label>Ticket Number</label>
        <input type="text" name="ticket_number" value="<?= htmlspecialchars($ticket['ticket_number']) ?>" required>
        <label>Seat Class</label>
        <select name="seat_class">
            <?php foreach (['Economy','Business','First'] as $c): ?>
            <option value="<?= $c ?>" <?= $ticket['seat_class'] === $c ? 'selected' : '' ?>><?= $c ?></option>
            <?php endforeach; ?>
        </select>
        <label>Seat Number</label>
        <input type="text" name="seat_number" value="<?= htmlspecialchars($ticket['seat_number']) ?>" required>
        <button type="submit" name="update" class="btn">Update Ticket</button>
    </form>
    <?php endif; ?>
    <a href="list_ticket.php" class="back-btn">Ticket List</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
