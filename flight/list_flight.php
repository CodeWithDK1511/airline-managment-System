<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$flights = $conn->query("SELECT * FROM flights_table ORDER BY departure_time DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Flight List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Flight List</h2>
    <a href="add_flight.php" class="add-btn">+ Add Flight</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($flights): ?>
    <table>
        <thead>
            <tr><th>Flight ID</th><th>Number</th><th>Departure</th><th>Arrival</th><th>Origin</th><th>Destination</th><th>Plane ID</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
        <?php foreach ($flights as $f): ?>
        <tr>
            <td><?= htmlspecialchars($f['flight_id']) ?></td>
            <td><?= htmlspecialchars($f['flight_number']) ?></td>
            <td><?= htmlspecialchars($f['departure_time']) ?></td>
            <td><?= htmlspecialchars($f['arrival_time']) ?></td>
            <td><?= htmlspecialchars($f['origin']) ?></td>
            <td><?= htmlspecialchars($f['destination']) ?></td>
            <td><?= htmlspecialchars($f['plain_id'] ?? '—') ?></td>
            <td><?= htmlspecialchars($f['status']) ?></td>
            <td><a href="edit_flight.php">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No flights found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
