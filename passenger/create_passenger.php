<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $stmt = $conn->prepare(
            "INSERT INTO passengers (passenger_id, first_name, last_name, email, phone_number, passport_no, DateofBirth)
             VALUES (:pid, :fn, :ln, :email, :phone, :passport, :dob)"
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
        $msg = 'Passenger added successfully!'; $msgType = 'success';
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Add Passenger</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Add Passenger</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Passenger ID</label>
        <input type="number" name="passenger_id" required>
        <label>First Name</label>
        <input type="text" name="first_name" required>
        <label>Last Name</label>
        <input type="text" name="last_name" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Phone Number</label>
        <input type="text" name="phone_number" required>
        <label>Passport Number</label>
        <input type="text" name="passport_no" required>
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" required>
        <input type="submit" value="Add Passenger">
    </form>
    <a href="list_passenger.php" class="back-btn">List Passengers</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
