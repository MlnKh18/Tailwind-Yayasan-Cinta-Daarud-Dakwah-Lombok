<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$host = 'localhost';
$db = 'kelambim_yacinta';
$user = 'kelambim_yacinta';
$pass = 'KelambimYacinta';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the post ID is provided
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Step 1: Get the post information (including the thumbnail path)
    $sql = "SELECT * FROM articles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $thumbnail_path = $row['thumbnail'];

        // Step 2: Delete the post from the database
        $delete_sql = "DELETE FROM articles WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $post_id);

        if ($delete_stmt->execute()) {
            // Step 3: Delete the thumbnail file from the server
            if (file_exists($thumbnail_path)) {
                unlink($thumbnail_path); // Deletes the file from the server
            }
            $_SESSION['success_message'] = "Artikel berhasil dihapus.";
        } else {
            $_SESSION['error_message'] = "Gagal menghapus artikel.";
        }
    } else {
        $_SESSION['error_message'] = "Artikel tidak ditemukan.";
    }
    $stmt->close();
    $conn->close();

    // Redirect back to the admin page
    header('Location: index.php');
    exit;
} else {
    $_SESSION['error_message'] = "ID artikel tidak disediakan.";
    header('Location: index.php');
    exit;
}
