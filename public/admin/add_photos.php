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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Photos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="list_programs.php">Programs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3>Add Photos for Program ID: <?= htmlspecialchars($program_id) ?></h3>

        <form action="upload_photos.php?program_id=<?= $program_id ?>" method="POST" enctype="multipart/form-data"
            class="mt-4">
            <div class="form-group">
                <label for="images">Gambar (multiple)</label>
                <input type="file" class="form-control" name="images[]" multiple required>
            </div>

            <button type="submit" class="btn btn-primary mt-4">Add Photos</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>