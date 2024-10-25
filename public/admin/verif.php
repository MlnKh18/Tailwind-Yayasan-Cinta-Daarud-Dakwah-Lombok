<?php
require 'config.php';

// Hash the password using bcrypt
$newPassword = 'yacinta@@';
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the admin's password in the database
$stmt = $pdo->prepare('UPDATE admins SET password = ? WHERE username = ?');
$stmt->execute([$hashedPassword, 'admin']);

echo 'Password updated successfully!';
