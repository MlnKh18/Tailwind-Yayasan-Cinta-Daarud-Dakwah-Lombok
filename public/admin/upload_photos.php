<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$program_id = $_GET['program_id'] ?? null;
if (!$program_id) {
    header('Location: list_programs.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $images_paths = [];
    if (isset($_FILES['images'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['images']['error'][$key] == 0) {
                // Generate a random name for the image
                $image_extension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                $image_name = uniqid('img_', true) . '.' . $image_extension; // Randomized name
                $image_path = 'uploads/images/' . $image_name;

                move_uploaded_file($tmp_name, $image_path);
                $images_paths[] = $image_path;

                // Insert image path into the database
                $stmt = $pdo->prepare("INSERT INTO program_images (program_id, image_path) VALUES (?, ?)");
                $stmt->execute([$program_id, $image_path]);
            }
        }
    }

    header('Location: list_programs.php?success=Photos added successfully');
    exit;
}
