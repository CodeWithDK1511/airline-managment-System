<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$assignments = $conn->query("SELECT * FROM crew_assignments ORDER BY assignment_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Crew Assignments</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="container">
    <h2>Crew Assignment List</h2>
    <a href="crew_assignment.php" class="add-btn">+ New Assignment</a>
    <a href="../index.php" class="back-btn">Home</a>
    <?php if ($assignments): ?>
    <table>
        <thead><tr><th>Assignment ID</th><th>Flight ID</th><th>Crew ID</th></tr></thead>
        <tbody>
        <?php foreach ($assignments as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['assignment_id']) ?></td>
            <td><?= htmlspecialchars($a['flight_id']) ?></td>
            <td><?= htmlspecialchars($a['crew_id']) ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?><p>No assignments found.</p><?php endif; ?>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
