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

// Fetch program details
$stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->execute([$program_id]);
$program = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];

    // Handle file upload
    $thumbnail = $program['thumbnail']; // Default to existing thumbnail
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
        $fileName = $_FILES['thumbnail']['name'];
        $fileSize = $_FILES['thumbnail']['size'];
        $fileType = $_FILES['thumbnail']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file extension (e.g., jpg, jpeg, png)
        $allowedfileExtensions = ['jpg', 'jpeg', 'png'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Set the destination path
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $thumbnail = $dest_path; // Update thumbnail path
            }
        }
    }

    // Update the program
    $stmt = $pdo->prepare("UPDATE programs SET title = ?, thumbnail = ? WHERE id = ?");
    $stmt->execute([$title, $thumbnail, $program_id]);

    header('Location: list_programs.php?success=Program updated successfully');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Program</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h3>Edit Program</h3>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($program['title']) ?>"
                    required>
            </div>

            <div class="form-group mt-3">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" class="form-control" name="thumbnail">
                <small class="form-text text-muted">Leave blank to keep existing thumbnail.</small>
            </div>

            <div class="mt-3">
                <img src="<?= htmlspecialchars($program['thumbnail']) ?>" alt="Current Thumbnail" width="100">
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>