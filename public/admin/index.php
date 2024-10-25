<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

$stmt = $pdo->prepare('SELECT * FROM site_settings LIMIT 1');
$stmt->execute();
$settings = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="list_programs.php">List Program</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="change_credentials.php">Change Password</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="update.php" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label for="site_title">Site Title</label>
                <input type="text" class="form-control" name="site_title"
                    value="<?= htmlspecialchars($settings['site_title']) ?>">
            </div>

            <div class="form-group mt-3">
                <label for="hero_image">Hero Image</label>
                <input type="file" class="form-control" name="hero_image">
                <img height="100px" width="100px" src="uploads/<?= htmlspecialchars($settings['hero_image']) ?>"
                    alt="Hero Image" class="mt-3 img-fluid">
            </div>

            <div class="form-group mt-3">
                <label for="jumlah_pengajar">Jumlah Pengajar</label>
                <input type="number" class="form-control" name="jumlah_pengajar"
                    value="<?= htmlspecialchars($settings['jumlah_pengajar']) ?>">
            </div>

            <div class="form-group mt-3">
                <label for="jumlah_santriwan">Jumlah Santriwan</label>
                <input type="number" class="form-control" name="jumlah_santriwan"
                    value="<?= htmlspecialchars($settings['jumlah_santriwan']) ?>">
            </div>

            <div class="form-group mt-3">
                <label for="jumlah_santriwati">Jumlah Santriwati</label>
                <input type="number" class="form-control" name="jumlah_santriwati"
                    value="<?= htmlspecialchars($settings['jumlah_santriwati']) ?>">
            </div>

            <button type="submit" class="btn btn-primary mt-4">Update</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>