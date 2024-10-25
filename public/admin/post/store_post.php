<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
$host = 'localhost';
$user = 'kelambim_yacinta';
$pass = 'KelambimYacinta';
$db = 'kelambim_yacinta';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handler
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $conn->real_escape_string($_POST['judul']);
    $konten = $conn->real_escape_string($_POST['konten']);

    // Check if file is uploaded
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        // Set upload path
        $upload_dir = '../uploads/';
        $upload_file = $upload_dir . basename($_FILES['thumbnail']['name']);

        // Move uploaded file
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $upload_file)) {
            // Prepare SQL query
            $sql = "INSERT INTO articles (thumbnail, judul, konten) VALUES ('$upload_file', '$judul', '$konten')";

            // Execute the query
            if ($conn->query($sql) === TRUE) {
                // Redirect to admin page
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Error: No file uploaded or file upload error.";
    }
}

$conn->close();
