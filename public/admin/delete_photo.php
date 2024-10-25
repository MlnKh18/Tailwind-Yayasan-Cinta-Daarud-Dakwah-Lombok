<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$photo_id = $_GET['id'] ?? null;
$program_id = $_GET['program_id'] ?? null;

if ($photo_id) {
    $stmt = $pdo->prepare("SELECT image_path FROM program_images WHERE id = ?");
    $stmt->execute([$photo_id]);
    $photo = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("DELETE FROM program_images WHERE id = ?");
    $stmt->execute([$photo_id]);

    if ($photo) {
        unlink($photo['image_path']);
    }

    header('Location: list_photos.php?program_id=' . $program_id . '&success=Photo deleted successfully');
    exit;
}

header('Location: list_programs.php');
exit;
