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
    <title>Buat Postingan Blog</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- TinyMCE Integration -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#konten',
            plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            toolbar_mode: 'floating',
        });

        // Custom validation for TinyMCE
        function validateForm() {
            // Trigger TinyMCE to save the content to the textarea
            tinymce.triggerSave();

            // Get the content of the editor
            var content = tinymce.get('konten').getContent();

            // Check if content is empty
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
        <h1>Buat Postingan Blog</h1>
        <!-- Add onsubmit event to ensure TinyMCE content is saved and validated -->
        <form action="store_post.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="thumbnail">Thumbnail:</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" id="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="konten">Konten:</label>
                <!-- Removed required attribute from the textarea -->
                <textarea name="konten" id="konten" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="admin.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>