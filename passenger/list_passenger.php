<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$passengers = $conn->query("SELECT * FROM passengers ORDER BY passenger_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Passenger List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Passenger List</h2>
    <a href="create_passenger.php" class="add-btn">+ Add Passenger</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($passengers): ?>
    <table>
        <thead>
            <tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Passport No</th><th>DOB</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php foreach ($passengers as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['passenger_id']) ?></td>
            <td><?= htmlspecialchars($p['first_name']) ?></td>
            <td><?= htmlspecialchars($p['last_name']) ?></td>
            <td><?= htmlspecialchars($p['email']) ?></td>
            <td><?= htmlspecialchars($p['phone_number']) ?></td>
            <td><?= htmlspecialchars($p['passport_no']) ?></td>
            <td><?= htmlspecialchars($p['DateofBirth']) ?></td>
            <td>
                <a href="edit_passenger.php">Edit</a> |
                <a href="delete_passenger.php?passenger_id=<?= $p['passenger_id'] ?>"
                   onclick="return confirm('Delete this passenger?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No passengers found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
