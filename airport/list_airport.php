<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$airports = $conn->query("SELECT * FROM airports_table")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Airport List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Airport List</h2>
    <a href="add_airport.php" class="add-btn">+ Add Airport</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($airports): ?>
    <table>
        <thead><tr><th>Code</th><th>Name</th><th>City</th><th>Country</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($airports as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['airport_code']) ?></td>
            <td><?= htmlspecialchars($a['Airport_name']) ?></td>
            <td><?= htmlspecialchars($a['city']) ?></td>
            <td><?= htmlspecialchars($a['country']) ?></td>
            <td><a href="edit_airport.php">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No airports found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
