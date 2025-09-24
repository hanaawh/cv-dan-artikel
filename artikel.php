<?php require_once "config.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel - Hana Adilia Rifaie</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style khusus untuk gambar di daftar artikel */
        .article-list-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .project-card {
            display: flex;
            flex-direction: column;
        }
        .card-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .card-content p {
            flex-grow: 1;
        }
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
        <section id="articles" class="page-section">
            <h1>📝 Artikel Saya</h1>
            <p>Kumpulan tulisan saya mengenai teknologi, pengembangan web, dan topik lainnya.</p>
            <div class="project-grid"> 
                <?php
                // Ambil data artikel termasuk gambar
                $sql = "SELECT id, title, content, image, created_at FROM articles ORDER BY created_at DESC";
                if($result = mysqli_query($link, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_array($result)){
                            echo '<div class="project-card">';
                                // Tampilkan gambar jika ada
                                if(!empty($row['image']) && file_exists("uploads/" . $row['image'])){
                                    echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['title'] . '" class="article-list-image">';
                                } else {
                                    // Fallback jika tidak ada gambar
                                    echo '<img src="https://via.placeholder.com/300x200.png?text=No+Image" alt="' . $row['title'] . '" class="article-list-image">';
                                }
                                
                                echo '<div class="card-content">';
                                    echo '<h3>' . $row['title'] . '</h3>';
                                    // Batasi konten menjadi 100 karakter
                                    $content_preview = substr(strip_tags($row['content']), 0, 100);
                                    echo '<p>' . $content_preview . '...</p>';
                                    echo '<a href="baca-artikel.php?id=' . $row['id'] . '">Baca Selengkapnya</a>';
                                echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Belum ada artikel yang dipublikasikan.</p>';
                    }
                }
                ?>
            </div>
        </section>
    </div>

    <script src="script.js"></script>
</body>
</html>