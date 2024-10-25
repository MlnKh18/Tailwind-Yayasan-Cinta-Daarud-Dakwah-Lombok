<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';

// Fetch programs
$stmt = $pdo->query("SELECT * FROM programs");
$programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>List Programs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Admin Dashboard</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="add_program.php">Add Program</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h3>List of Programs</h3>
        <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Thumbnail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($programs as $program): ?>
                <tr>
                    <td><?= htmlspecialchars($program['title']) ?></td>
                    <td><img src="<?= htmlspecialchars($program['thumbnail']) ?>" alt="Thumbnail" width="100"></td>
                    <td>
                        <a href="edit_program.php?id=<?= $program['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_program.php?id=<?= $program['id'] ?>" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this program?');">Hapus</a>
                        <a href="add_photos.php?program_id=<?= $program['id'] ?>" class="btn btn-primary">Tambah
                            Foto</a>
                        <a href="list_photos.php?program_id=<?= $program['id'] ?>" class="btn btn-info">List Foto</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>