<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';
$plane = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $stmt = $conn->prepare("SELECT * FROM planes_table WHERE plane_id = :pid");
    $stmt->execute([':pid' => (int)$_POST['plane_id']]);
    $plane = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$plane) { $msg = 'Plane not found.'; $msgType = 'error'; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare(
            "UPDATE planes_table SET model=:model, capacity=:cap, manufacturer=:mfr WHERE plane_id=:pid"
        );
        $stmt->execute([
            ':pid'   => (int)$_POST['plane_id'],
            ':model' => trim($_POST['model']),
            ':cap'   => (int)$_POST['capacity'],
            ':mfr'   => trim($_POST['manufacturer']),
        ]);
        $msg = 'Plane updated successfully!'; $msgType = 'success';
        $stmt2 = $conn->prepare("SELECT * FROM planes_table WHERE plane_id = :pid");
        $stmt2->execute([':pid' => (int)$_POST['plane_id']]);
        $plane = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Edit Plane</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Edit Plane</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Plane ID to search</label>
        <input type="number" name="plane_id" value="<?= htmlspecialchars($_POST['plane_id'] ?? '') ?>" required>
        <button type="submit" name="search" class="btn">Search</button>
    </form>
    <?php if ($plane): ?>
    <hr style="margin:20px 0;">
    <form method="post">
        <input type="hidden" name="plane_id" value="<?= htmlspecialchars($plane['plane_id']) ?>">
        <label>Model</label>
        <input type="text" name="model" value="<?= htmlspecialchars($plane['model']) ?>" required>
        <label>Capacity</label>
        <input type="number" name="capacity" value="<?= htmlspecialchars($plane['capacity']) ?>" required>
        <label>Manufacturer</label>
        <input type="text" name="manufacturer" value="<?= htmlspecialchars($plane['manufacturer']) ?>" required>
        <button type="submit" name="update" class="btn">Update Plane</button>
    </form>
    <?php endif; ?>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
