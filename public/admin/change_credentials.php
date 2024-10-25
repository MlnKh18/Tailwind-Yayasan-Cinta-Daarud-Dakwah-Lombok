<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current admin data
    $stmt = $pdo->prepare('SELECT * FROM admins WHERE id = 1'); // Assuming admin ID is 1
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$admin || !password_verify($current_password, $admin['password'])) {
        $error = 'Current password is incorrect.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match.';
    } else {
        // Update password
        $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('UPDATE admins SET password = ? WHERE id = 1');
        $stmt->execute([$new_password_hashed]);

        $success = 'Password updated successfully.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h3>Change Password</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group mt-3">
                <label for="current_password">Current Password</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>

            <div class="form-group mt-3">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>

            <div class="form-group mt-3">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Change Password</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>