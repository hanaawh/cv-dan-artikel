<?php
require_once "config.php";

if(!isset($_GET["id"]) || empty($_GET["id"])){
    header("location: artikel.php");
    exit;
}

$article_id = $_GET["id"];
$title = $content = $created_at = $image = "";

$sql = "SELECT title, content, image, created_at FROM articles WHERE id = ?";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $article_id);
    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_assoc($result);
            $title = $row["title"];
            $content = $row["content"]; // Konten dari TinyMCE adalah HTML
            $image = $row["image"];
            $created_at = date("d F Y", strtotime($row["created_at"]));
        } else { echo "Artikel tidak ditemukan."; exit(); }
    } else { echo "Oops! Something went wrong."; exit(); }
}
mysqli_stmt_close($stmt);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Hana Adilia Rifaie</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .article-content { line-height: 1.8; }
        .article-image { width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; margin-bottom: 2rem; }
    </style>
</head>
<body>
    <div class="background-container"></div>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Tentang Saya</a></li>
                <li><a href="proyek.php">Proyek</a></li>
                <li><a href="pendidikan.php">Pendidikan</a></li>
                <li><a href="pengalaman.php">Pengalaman</a></li>
                <li><a href="keahlian.php">Keahlian</a></li>
                <li><a href="artikel.php" class="active">Artikel</a></li>
            </ul>
        </nav>
        <div class="hamburger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </header>

    <div class="container">
        <section class="page-section">
            <h1><?php echo $title; ?></h1>
            <p><em>Dipublikasikan pada: <?php echo $created_at; ?></em></p>
            
            <?php if(!empty($image) && file_exists("uploads/" . $image)): ?>
                <img src="uploads/<?php echo $image; ?>" alt="<?php echo $title; ?>" class="article-image">
            <?php endif; ?>

            <hr>
            <div class="article-content">
                <?php echo $content; // Langsung echo HTML dari TinyMCE ?>
            </div>
            <br>
            <a href="artikel.php"> &laquo; Kembali ke daftar artikel</a>
        </section>
    </div>

    <footer>
        <div class="contact-info">
            <p>Email dan Kontak:</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>