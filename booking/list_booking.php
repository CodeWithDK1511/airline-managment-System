<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';

try {
    $bookings = $conn->query("
        SELECT b.booking_id, b.booking_status, b.seat_number, b.booking_date,
               p.first_name, p.last_name,
               f.flight_id, f.origin, f.destination, f.departure_time, f.arrival_time,
               pl.model AS aircraft_model
        FROM bookings_table b
        LEFT JOIN passengers p     ON b.passenger_id = p.passenger_id
        LEFT JOIN flights_table f  ON b.flight_id    = f.flight_id
        LEFT JOIN planes_table pl  ON f.plain_id     = pl.plane_id
        ORDER BY b.booking_date DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Booking List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>All Bookings</h2>
    <a href="create_booking.php" class="add-btn">+ New Booking</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($bookings): ?>
    <table>
        <thead>
            <tr>
                <th>Booking ID</th><th>Passenger</th><th>Flight ID</th>
                <th>Origin</th><th>Destination</th><th>Departure</th>
                <th>Aircraft</th><th>Seat</th><th>Status</th><th>Date</th><th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($bookings as $b): ?>
        <tr>
            <td><?= htmlspecialchars($b['booking_id']) ?></td>
            <td><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?></td>
            <td><?= htmlspecialchars($b['flight_id']) ?></td>
            <td><?= htmlspecialchars($b['origin'] ?? '—') ?></td>
            <td><?= htmlspecialchars($b['destination'] ?? '—') ?></td>
            <td><?= htmlspecialchars($b['departure_time'] ?? '—') ?></td>
            <td><?= htmlspecialchars($b['aircraft_model'] ?? '—') ?></td>
            <td><?= htmlspecialchars($b['seat_number']) ?></td>
            <td><?= htmlspecialchars($b['booking_status']) ?></td>
            <td><?= htmlspecialchars($b['booking_date']) ?></td>
            <td><a href="edit_booking.php">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No bookings found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
