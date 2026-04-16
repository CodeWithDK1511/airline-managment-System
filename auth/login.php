<?php
// auth/login.php
if (session_status() === PHP_SESSION_NONE) if (session_status() == PHP_SESSION_NONE) { session_start(); }

// Already logged in → go home
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        try {
            $stmt = $conn->prepare("SELECT user_id, username, password, role FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role']     = $user['role'];
                session_regenerate_id(true); // prevent session fixation
                header("Location: ../index.php");
                exit;
            } else {
                $error = 'Invalid username or password.';
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
    <title>Login – Airline Management System</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .auth-container {
            max-width: 420px;
            margin: 80px auto;
            background: rgba(255,255,255,0.92);
            padding: 40px 36px;
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .auth-container h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }
        .auth-container label { display: block; margin-bottom: 4px; font-weight: bold; color:#444; }
        .auth-container input[type="text"],
        .auth-container input[type="password"] {
            width: 100%; padding: 10px 12px; margin-bottom: 18px;
            border: 1px solid #ccc; border-radius: 5px;
            box-sizing: border-box; font-size: 15px;
        }
        .auth-container input[type="submit"] {
            width: 100%; padding: 11px; background: #444; color: #fff;
            border: none; border-radius: 5px; font-size: 16px; cursor: pointer;
            transition: background 0.3s;
        }
        .auth-container input[type="submit"]:hover { background: #222; }
        .auth-error  { background:#ffe0e0; color:#c0392b; padding:10px; border-radius:5px; margin-bottom:16px; }
        .auth-links  { text-align:center; margin-top:16px; }
        .auth-links a { color:#555; text-decoration:none; }
        .auth-links a:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <header><h1>Airline Management System</h1></header>

    <div class="auth-container">
        <h2>&#9992; Sign In</h2>

        <?php if ($error): ?>
            <div class="auth-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>

        <div class="auth-links">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <footer><p>&copy; 2024 Airline Management System</p></footer>
</body>
</html>
