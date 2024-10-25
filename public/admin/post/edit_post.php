<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Postingan Blog</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- TinyMCE Integration -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#konten',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });

        // Validate that the content is not empty
        function validateForm() {
            tinymce.triggerSave();
            var content = tinymce.get('konten').getContent();
            if (content.trim() === '') {
                alert('Konten tidak boleh kosong!');
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container mt-4">
        <h1>Edit Postingan Blog</h1>

        <?php
        // Database connection
        $host = 'localhost';
        $db = 'kelambim_yacinta';
        $user = 'kelambim_yacinta';
        $pass = 'KelambimYacinta';

        $conn = new mysqli($host, $user, $pass, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch the post data using the post ID from the URL
        if (isset($_GET['id'])) {
            $post_id = $_GET['id'];

            // Fetch post data from database
            $query = "SELECT * FROM articles WHERE id = $post_id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $post = mysqli_fetch_assoc($result);
            } else {
                die("Error fetching post data: " . mysqli_error($conn));
            }
        }
        ?>

        <!-- Form with pre-filled values -->
        <form action="update_post.php?id=<?= $post_id ?>" method="POST" enctype="multipart/form-data"
            onsubmit="return validateForm()">
            <div class="form-group">
                <label for="thumbnail">Thumbnail Saat Ini:</label><br>
                <!-- Display the existing thumbnail -->
                <img src="<?= $post['thumbnail'] ?>" alt="Thumbnail" width="150"><br><br>

                <!-- File input to upload a new thumbnail if desired -->
                <label for="thumbnail">Ganti Thumbnail (Opsional):</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control">
            </div>

            <div class="form-group">
                <label for="judul">Judul:</label>
                <!-- Pre-fill the title input -->
                <input type="text" name="judul" id="judul" class="form-control" value="<?= $post['judul'] ?>" required>
            </div>

            <div class="form-group">
                <label for="konten">Konten:</label>
                <!-- Pre-fill the TinyMCE content -->
                <textarea name="konten" id="konten" class="form-control" required><?= $post['konten'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="admin.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>