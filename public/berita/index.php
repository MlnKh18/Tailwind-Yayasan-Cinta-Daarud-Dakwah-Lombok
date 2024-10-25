<?php

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

// Pagination settings
$articlesPerPage = 5; // Number of articles to display per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($current_page - 1) * $articlesPerPage; // Calculate the offset

// Search functionality
$search = '';
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
}

// Modify SQL query for pagination
$sql = "SELECT * FROM articles WHERE judul LIKE '%$search%' ORDER BY id DESC LIMIT $articlesPerPage OFFSET $offset";
$result = $conn->query($sql);

// Count total articles for pagination
$countSql = "SELECT COUNT(*) AS total FROM articles WHERE judul LIKE '%$search%'";
$countResult = $conn->query($countSql);
$totalArticles = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalArticles / $articlesPerPage); // Calculate total pages

$conn->close();
?>
<html>

<head>
    <title>Berita</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            border-bottom: 1px solid #e5e5e5;
        }

        .navbar-brand {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .navbar-brand span {
            color: #b30059;
        }

        .main-content {
            padding: 2rem 0;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .section-title span {
            color: #b30059;
        }

        .card {
            border: none;
            margin-bottom: 1.5rem;
            /* Space between cards */
            width: 100%;
            /* Ensure full width */
            max-width: 100%;
            /* Ensure full width */
        }

        .author {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Adjust card body padding */
        .card-body {
            padding: 1rem;
            /* Padding inside the card */
        }

        /* Responsive images */
        .card-img-top {
            object-fit: cover;
            /* Maintain aspect ratio */
            height: 200px;
            /* Fixed height */
            width: 100%;
            /* Full width */
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="#">BERITA<span>.</span></a>

        </div>
    </nav>

    <div class="container main-content">
        <!-- Search Bar -->
        <form method="POST" class="mb-4">
            <input type="text" name="search" class="form-control" placeholder="Search articles..."
                value="<?php echo htmlspecialchars($search); ?>" />
        </form>

        <div class="section-title mt-5">
            Daftar Berita
            <span>.</span>
        </div>

        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()):
                    $imagePathFromDb = $row['thumbnail'];
                    // Adjust the path to the correct location
                    $imagePath = str_replace('../uploads/', '../admin/uploads/', $imagePathFromDb);
                ?>
                    <div class="col-12 mb-3">
                        <!-- Full width for each card on mobile -->
                        <div class="card">
                            <!-- Full width card -->
                            <a href="read_article.php?id=<?php echo $row['id']; ?>">
                                <img alt="<?php echo $row['judul']; ?>" class="card-img-top" src="<?php echo $imagePath ?>" />
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><a style="text-decoration: none;"
                                        href="read_article.php?id=<?php echo $row['id']; ?>"><?php echo $row['judul']; ?></a>
                                </h5>
                                <p class="card-text"><?php echo substr($row['konten'], 0, 100) . '...'; ?></p>
                                <div class="author">
                                    <span>Author: Admin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No articles found.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php if ($current_page <= 1) echo 'disabled'; ?>">
                    <a class="page-link"
                        href="?search=<?php echo urlencode($search); ?>&page=<?php echo $current_page - 1; ?>"
                        tabindex="-1">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                        <a class="page-link"
                            href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php if ($current_page >= $totalPages) echo 'disabled'; ?>">
                    <a class="page-link"
                        href="?search=<?php echo urlencode($search); ?>&page=<?php echo $current_page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-nvxK2QIBjWblg+x7WpqyI/yeWLRmZPUlMn8LoD9GnXlF4jBX5S38Ff1eF1ZMoE/d" crossorigin="anonymous">
    </script>
</body>

</html>