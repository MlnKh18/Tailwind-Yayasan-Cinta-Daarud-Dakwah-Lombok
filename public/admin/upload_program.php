<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];

    // Handle thumbnail upload
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        // Generate a random name for the thumbnail
        $thumbnail_extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        $thumbnail_name = uniqid('thumb_', true) . '.' . $thumbnail_extension; // Randomized name
        $thumbnail_path = 'uploads/thumbnails/' . $thumbnail_name;

        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnail_path);

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO programs (title, thumbnail) VALUES (?, ?)");
        $stmt->execute([$title, $thumbnail_path]);

        header('Location: list_programs.php?success=Program added successfully');
        exit;
    }
}
