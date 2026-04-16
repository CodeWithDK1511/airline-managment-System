<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$crew = $conn->query("SELECT * FROM cew_table ORDER BY crew_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Crew List</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Crew List</h2>
    <a href="add_crew.php" class="add-btn">+ Add Crew Member</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($crew): ?>
    <table>
        <thead><tr><th>Crew ID</th><th>First Name</th><th>Last Name</th><th>Role</th><th>Flight ID</th><th>Action</th></tr></thead>
        <tbody>
        <?php foreach ($crew as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['crew_id']) ?></td>
            <td><?= htmlspecialchars($c['first_name']) ?></td>
            <td><?= htmlspecialchars($c['last_name']) ?></td>
            <td><?= htmlspecialchars($c['role']) ?></td>
            <td><?= htmlspecialchars($c['flight_id'] ?? '—') ?></td>
            <td><a href="edit_crew.php">Edit</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No crew members found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
