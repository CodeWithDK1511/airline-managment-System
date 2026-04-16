<?php
// auth/manage_users.php  (Admin only)
require '../admin_check.php';
include $_SERVER['DOCUMENT_ROOT'] . '/airlineManagmentSystem2/db_connect.php';

$message = '';
$msgType = '';

// Handle role change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $target_id = (int)($_POST['target_id'] ?? 0);

    if ($_POST['action'] === 'change_role' && $target_id !== (int)$_SESSION['user_id']) {
        $new_role = ($_POST['new_role'] === 'admin') ? 'admin' : 'user';
        $stmt = $conn->prepare("UPDATE users SET role = :r WHERE user_id = :id");
        $stmt->execute([':r' => $new_role, ':id' => $target_id]);
        $message = 'Role updated successfully.';
        $msgType = 'success';
    }

    if ($_POST['action'] === 'delete' && $target_id !== (int)$_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute([':id' => $target_id]);
        $message = 'User deleted.';
        $msgType = 'success';
    }
}

// Fetch all users
$users = $conn->query("SELECT user_id, username, email, role, created_at FROM users ORDER BY user_id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users – Airline Management System</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .container { max-width:900px; margin:30px auto; background:rgba(255,255,255,0.93); padding:30px; border-radius:10px; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        th, td { padding:10px 14px; border:1px solid #ccc; text-align:left; }
        th { background:#444; color:#fff; }
        tr:nth-child(even) { background:#f7f7f7; }
        .badge-admin { background:#c0392b; color:#fff; padding:3px 9px; border-radius:12px; font-size:12px; }
        .badge-user  { background:#27ae60; color:#fff; padding:3px 9px; border-radius:12px; font-size:12px; }
        .msg-success { background:#e0ffe4; color:#1a7a2e; padding:10px; border-radius:5px; margin-bottom:12px; }
        .msg-error   { background:#ffe0e0; color:#c0392b; padding:10px; border-radius:5px; margin-bottom:12px; }
        select, button { padding:5px 10px; border-radius:4px; border:1px solid #aaa; cursor:pointer; }
        button.del-btn { background:#c0392b; color:#fff; border:none; }
        button.del-btn:hover { background:#922b21; }
        .actions form { display:inline; }
        h2 { color:#333; }
    </style>
</head>
<body>
    <header><h1>Airline Management System</h1></header>
    <nav>
        <ul>
            <li><a href="../index.php">&#8962; Home</a></li>
            <li><a href="../auth/logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>&#128100; Manage Users</h2>

        <?php if ($message): ?>
            <div class="msg-<?= $msgType ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <a href="register.php" style="display:inline-block;margin-bottom:16px;padding:9px 18px;background:#444;color:#fff;border-radius:5px;text-decoration:none;">+ Add New User</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u['user_id'] ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <span class="badge-<?= $u['role'] ?>"><?= $u['role'] ?></span>
                    </td>
                    <td><?= $u['created_at'] ?></td>
                    <td class="actions">
                        <?php if ($u['user_id'] != $_SESSION['user_id']): ?>
                            <!-- Change Role -->
                            <form method="post">
                                <input type="hidden" name="action"    value="change_role">
                                <input type="hidden" name="target_id" value="<?= $u['user_id'] ?>">
                                <select name="new_role">
                                    <option value="user"  <?= $u['role']==='user'  ? 'selected':'' ?>>user</option>
                                    <option value="admin" <?= $u['role']==='admin' ? 'selected':'' ?>>admin</option>
                                </select>
                                <button type="submit">Set Role</button>
                            </form>
                            <!-- Delete -->
                            <form method="post" onsubmit="return confirm('Delete this user?')">
                                <input type="hidden" name="action"    value="delete">
                                <input type="hidden" name="target_id" value="<?= $u['user_id'] ?>">
                                <button type="submit" class="del-btn">Delete</button>
                            </form>
                        <?php else: ?>
                            <em>(you)</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer><p>&copy; 2024 Airline Management System</p></footer>
</body>
</html>
