<?php
// auth/register.php
if (session_status() === PHP_SESSION_NONE) if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';
    $confirm  = $_POST['confirm']       ?? '';

    // Basic validation
    if ($username === '' || $email === '' || $password === '' || $confirm === '') {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        try {
            // Check if username or email already exists
            $check = $conn->prepare("SELECT user_id FROM users WHERE username = :u OR email = :e LIMIT 1");
            $check->execute([':u' => $username, ':e' => $email]);

            if ($check->fetch()) {
                $error = 'Username or email already taken. Please choose another.';
            } else {
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $ins = $conn->prepare(
                    "INSERT INTO users (username, email, password, role) VALUES (:u, :e, :p, 'user')"
                );
                $ins->execute([':u' => $username, ':e' => $email, ':p' => $hashed]);
                $success = 'Account created! You can now <a href="login.php">log in</a>.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register – Airline Management System</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .auth-container {
            max-width: 440px;
            margin: 60px auto;
            background: rgba(255,255,255,0.92);
            padding: 40px 36px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .auth-container h2 { text-align:center; margin-bottom:24px; color:#333; }
        .auth-container label { display:block; margin-bottom:4px; font-weight:bold; color:#444; }
        .auth-container input[type="text"],
        .auth-container input[type="email"],
        .auth-container input[type="password"] {
            width:100%; padding:10px 12px; margin-bottom:16px;
            border:1px solid #ccc; border-radius:5px;
            box-sizing:border-box; font-size:15px;
        }
        .auth-container input[type="submit"] {
            width:100%; padding:11px; background:#444; color:#fff;
            border:none; border-radius:5px; font-size:16px; cursor:pointer;
            transition:background 0.3s;
        }
        .auth-container input[type="submit"]:hover { background:#222; }
        .auth-error   { background:#ffe0e0; color:#c0392b; padding:10px; border-radius:5px; margin-bottom:16px; }
        .auth-success { background:#e0ffe4; color:#1a7a2e; padding:10px; border-radius:5px; margin-bottom:16px; }
        .auth-links   { text-align:center; margin-top:16px; }
        .auth-links a { color:#555; text-decoration:none; }
        .auth-links a:hover { text-decoration:underline; }
        .hint { font-size:12px; color:#888; margin-top:-12px; margin-bottom:12px; }
    </style>
</head>
<body>
    <header><h1>Airline Management System</h1></header>

    <div class="auth-container">
        <h2>&#9992; Create Account</h2>

        <?php if ($error):   ?><div class="auth-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <?php if ($success): ?><div class="auth-success"><?= $success ?></div><?php endif; ?>

        <?php if (!$success): ?>
        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus maxlength="50">

            <label for="email">Email Address</label>
            <input type="email" name="email" id="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required maxlength="100">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required minlength="6">
            <p class="hint">Minimum 6 characters.</p>

            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" required>

            <input type="submit" value="Register">
        </form>
        <?php endif; ?>

        <div class="auth-links">
            <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>

    <footer><p>&copy; 2024 Airline Management System</p></footer>
</body>
</html>
