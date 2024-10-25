<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $site_title = $_POST['site_title'];
    $jumlah_pengajar = $_POST['jumlah_pengajar'];
    $jumlah_santriwan = $_POST['jumlah_santriwan'];
    $jumlah_santriwati = $_POST['jumlah_santriwati'];
    $hero_image = $_FILES['hero_image'];

    // Initialize an array to hold error messages
    $errors = [];

    // Handle image upload if a new file is uploaded
    if (!empty($hero_image['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($hero_image["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($hero_image["tmp_name"]);
        if ($check === false) {
            $errors[] = "File is not an image.";
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }

        // Attempt to upload the file
        if (empty($errors) && move_uploaded_file($hero_image["tmp_name"], $target_file)) {
            $hero_image_name = basename($hero_image["name"]);
        } else {
            $errors[] = "Error uploading the image.";
        }
    } else {
        // If no new image is uploaded, keep the existing one
        $stmt = $pdo->prepare('SELECT hero_image FROM site_settings LIMIT 1');
        $stmt->execute();
        $existing_settings = $stmt->fetch(PDO::FETCH_ASSOC);
        $hero_image_name = $existing_settings['hero_image'];
    }

    // Update the database
    if (empty($errors)) {
        $stmt = $pdo->prepare('UPDATE site_settings SET site_title = ?, hero_image = ?, jumlah_pengajar = ?, jumlah_santriwan = ?, jumlah_santriwati = ? WHERE id = 1');
        $stmt->execute([$site_title, $hero_image_name, $jumlah_pengajar, $jumlah_santriwan, $jumlah_santriwati]);

        // Redirect back to the dashboard with a success message
        header('Location: index.php?success=Settings updated successfully');
        exit;
    } else {
        // Handle errors by storing them in the session or displaying them
        $_SESSION['errors'] = $errors;
        header('Location: index.php');
        exit;
    }
}
