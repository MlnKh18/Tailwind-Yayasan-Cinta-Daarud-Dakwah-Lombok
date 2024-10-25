<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$program_id = $_GET['id'] ?? null;
if (!$program_id) {
    header('Location: list_programs.php');
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->execute([$program_id]);
$program = $stmt->fetch(PDO::FETCH_ASSOC);


if ($program) {
    $stmt = $pdo->prepare("SELECT * FROM program_images WHERE program_id = ?");
    $stmt->execute([$program_id]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($images as $image) {
        if (file_exists($image['image_path'])) {
            unlink($image['image_path']);
        }
    }
    $stmt = $pdo->prepare("DELETE FROM programs WHERE id = ?");
    $stmt->execute([$program_id]);

    if (file_exists($program['thumbnail'])) {
        unlink($program['thumbnail']);
    }

    header('Location: list_programs.php?success=Program deleted successfully');
} else {
    header('Location: list_programs.php?error=Program not found');
}
exit;