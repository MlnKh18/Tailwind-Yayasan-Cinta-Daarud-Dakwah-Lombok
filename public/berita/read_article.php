<?php
$host = 'localhost';
$user = 'kelambim_yacinta';
$pass = 'KelambimYacinta';
$db = 'kelambim_yacinta';
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the article based on the ID passed in the URL
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM articles WHERE id = $id";
    $result = $conn->query($sql);

    // Check if an article was found
    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
        $imagePathFromDb = $article['thumbnail'];
        // Adjust the path to the correct location
        $imagePath = str_replace('../uploads/', '../admin/uploads/', $imagePathFromDb);
    } else {
        // Redirect if no article found
        header('Location: index.php'); // Redirect to your articles list page
        exit;
    }
} else {
    // Redirect if no ID is provided
    header('Location: index.php'); // Redirect to your articles list page
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['judul']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container">
        <h1 class="mt-5"><?php echo htmlspecialchars($article['judul']); ?></h1>
        <img style="height: 200px;" src="<?php echo htmlspecialchars($imagePath); ?>"
            alt="<?php echo htmlspecialchars($article['judul']); ?>" class="img-fluid" />
        <div class="mt-3">
            <?php echo $article['konten']; // Directly output content to preserve HTML formatting 
            ?>
        </div>
        <a href="index.php" class="btn btn-primary mt-4">Back to Articles</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>