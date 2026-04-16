<?php
require '../auth_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';
$msg = ''; $msgType = '';
$payment = null;

// Search for payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $stmt = $conn->prepare("SELECT * FROM payments_table WHERE payement_id = :pid");
    $stmt->execute([':pid' => (int)$_POST['payment_id']]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$payment) { $msg = 'Payment record not found.'; $msgType = 'error'; }
}

// Update payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    try {
        $stmt = $conn->prepare(
            "UPDATE payments_table SET payment_method=:method, amount=:amount WHERE payement_id=:pid"
        );
        $stmt->execute([
            ':pid'    => (int)$_POST['payment_id'],
            ':method' => trim($_POST['payment_method']),
            ':amount' => (float)$_POST['amount'],
        ]);
        $msg = 'Payment updated successfully!'; $msgType = 'success';
        $stmt2 = $conn->prepare("SELECT * FROM payments_table WHERE payement_id = :pid");
        $stmt2->execute([':pid' => (int)$_POST['payment_id']]);
        $payment = $stmt2->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $msg = 'Database error: ' . $e->getMessage(); $msgType = 'error';
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">
<title>Edit Payment</title>
<link rel="stylesheet" href="../style.css"></head><body>
<header><h1>Airline Management System</h1></header>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/nav.php'; ?>
<div class="form-wrap">
    <h2>Edit Payment</h2>
    <?php if ($msg) echo "<div class='msg-$msgType'>".htmlspecialchars($msg)."</div>"; ?>
    <form method="post">
        <label>Payment ID to search</label>
        <input type="number" name="payment_id" value="<?= htmlspecialchars($_POST['payment_id'] ?? '') ?>" required>
        <button type="submit" name="search" class="btn">Search</button>
    </form>
    <?php if ($payment): ?>
    <hr style="margin:20px 0;">
    <form method="post">
        <input type="hidden" name="payment_id" value="<?= htmlspecialchars($payment['payement_id']) ?>">
        <label>Payment Method</label>
        <select name="payment_method">
            <?php foreach (['Credit Card','Debit Card','UPI','Net Banking','Cash'] as $m): ?>
            <option value="<?= $m ?>" <?= $payment['payment_method'] === $m ? 'selected' : '' ?>><?= $m ?></option>
            <?php endforeach; ?>
        </select>
        <label>Amount (₹)</label>
        <input type="number" name="amount" value="<?= htmlspecialchars($payment['amount']) ?>" min="1" step="0.01" required>
        <button type="submit" name="update" class="btn">Update Payment</button>
    </form>
    <?php endif; ?>
    <a href="list_payments.php" class="back-btn">Payment List</a>
    <a href="../index.php" class="back-btn">Home</a>
</div>
<footer><p>&copy; 2024 Airline Management System</p></footer>
</body></html>
