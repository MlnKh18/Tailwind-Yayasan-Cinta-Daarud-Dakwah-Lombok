<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
$host = 'localhost';
$db = 'kelambim_yacinta';
$user = 'kelambim_yacinta';
$pass = 'KelambimYacinta';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    // Get the post ID from the URL
    $post_id = $_GET['id'];

    // Sanitize form inputs
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $konten = mysqli_real_escape_string($conn, $_POST['konten']);
    $thumbnail = $_FILES['thumbnail'];

    // Check if a new thumbnail has been uploaded
    if ($thumbnail['name']) {
        // Handle the new thumbnail upload
        $target_dir = "../uploads/thumbnails/";
        $target_file = $target_dir . basename($thumbnail['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($thumbnail['tmp_name']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size (optional limit, e.g., 5MB)
        if ($thumbnail['size'] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($thumbnail['tmp_name'], $target_file)) {
                // Update the database with the new thumbnail
                $query = "UPDATE articles SET judul='$judul', konten='$konten', thumbnail='$target_file' WHERE id=$post_id";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        // If no new thumbnail is uploaded, update without changing the thumbnail
        $query = "UPDATE articles SET judul='$judul', konten='$konten' WHERE id=$post_id";
    }

    // Execute the update query
    if (mysqli_query($conn, $query)) {
        echo "Post updated successfully.";
        header("Location: index.php"); // Redirect to admin page after updating
        exit();
    } else {
        echo "Error updating post: " . mysqli_error($conn);
    }
}
