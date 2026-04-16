<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';
$passenger = null;

// Step 1: Search for passenger
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $pid = (int)$_POST['passenger_id'];
    $stmt = $conn->prepare("SELECT * FROM passengers WHERE passenger_id = :pid");
    $stmt->execute([':pid' => $pid]);
    $passenger = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$passenger) { $msg = 'Passenger not found.'; $msgType = 'error'; }
}

// Step 2: Update passenger
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare(
            "UPDATE passengers SET first_name=:fn, last_name=:ln, email=:email,
             phone_number=:phone, passport_no=:passport, DateofBirth=:dob
             WHERE passenger_id=:pid"
        );
        $stmt->execute([
            ':pid'      => (int)$_POST['passenger_id'],
            ':fn'       => trim($_POST['first_name']),
            ':ln'       => trim($_POST['last_name']),
            ':email'    => trim($_POST['email']),
            ':phone'    => trim($_POST['phone_number']),
            ':passport' => trim($_POST['passport_no']),
            ':dob'      => $_POST['date_of_birth'],
        ]);
        $msg = 'Passenger updated successfully!'; $msgType = 'success';
        // Re-fetch updated record
        $stmt2 = $conn->prepare("SELECT * FROM passengers WHERE passenger_id = :pid");
        $stmt2->execute([':pid' => (int)$_POST['passenger_id']]);
        $passenger = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Edit Passenger</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Edit Passenger</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>

    <!-- Search form -->
    <form method="post">
        <label>Enter Passenger ID to search</label>
        <input type="number" name="passenger_id" value="<?= htmlspecialchars($_POST['passenger_id'] ?? '') ?>" required>
        <button type="submit" name="search" class="btn">Search</button>
    </form>

    <?php if ($passenger): ?>
    <hr style="margin:20px 0;">
    <h3>Update Details</h3>
    <form method="post">
        <input type="hidden" name="passenger_id" value="<?= htmlspecialchars($passenger['passenger_id']) ?>">
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($passenger['first_name']) ?>" required>
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($passenger['last_name']) ?>" required>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($passenger['email']) ?>" required>
        <label>Phone Number</label>
        <input type="text" name="phone_number" value="<?= htmlspecialchars($passenger['phone_number']) ?>" required>
        <label>Passport Number</label>
        <input type="text" name="passport_no" value="<?= htmlspecialchars($passenger['passport_no']) ?>" required>
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" value="<?= htmlspecialchars($passenger['DateofBirth']) ?>" required>
        <button type="submit" name="update" class="btn">Update Passenger</button>
    </form>
    <?php endif; ?>

    <a href="list_passenger.php" class="back-btn">List Passengers</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
