<?php
require_once "../config.php";

// Cek jika user tidak login, redirect ke halaman login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

$title = $content = "";
$title_err = $content_err = $image_err = "";
$page_title = "Tambah Artikel Baru";
$is_edit = false;
$article_id = null;
$existing_image = "";

// Cek jika ini adalah mode edit (ada ID di URL)
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $is_edit = true;
    $article_id = $_GET["id"];
    $page_title = "Edit Artikel";

    $sql = "SELECT title, content, image FROM articles WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $article_id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $title = $row["title"];
                $content = $row["content"];
                $existing_image = $row["image"];
            } else { echo "Artikel tidak ditemukan."; exit(); }
        } else { echo "Oops! Something went wrong."; exit(); }
    }
    mysqli_stmt_close($stmt);
}

// Proses form saat disubmit
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validasi judul dan konten
    if(empty(trim($_POST["title"]))) { $title_err = "Judul tidak boleh kosong."; }
    else { $title = trim($_POST["title"]); }

    if(empty(trim($_POST["content"]))) { $content_err = "Konten tidak boleh kosong."; }
    else { $content = $_POST["content"]; } // Konten dari TinyMCE tidak perlu di-trim

    $image_name = $existing_image;
    // Logika upload gambar
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowed_ext = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif"];
        $file_name = $_FILES["image"]["name"];
        $file_type = $_FILES["image"]["type"];
        $file_size = $_FILES["image"]["size"];

        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed_ext)){
            $image_err = "Format file tidak valid. Gunakan JPG, PNG, atau GIF.";
        }

        $max_size = 5 * 1024 * 1024; // 5MB
        if($file_size > $max_size) {
            $image_err = "Ukuran file terlalu besar. Maksimal 5MB.";
        }

        if(in_array($file_type, $allowed_ext)){
            $new_filename = uniqid() . "." . $ext;
            if(move_uploaded_file($_FILES["image"]["tmp_name"], "../uploads/" . $new_filename)){
                // Hapus gambar lama jika ada (saat edit)
                if($is_edit && !empty($existing_image) && file_exists("../uploads/" . $existing_image)){
                    unlink("../uploads/" . $existing_image);
                }
                $image_name = $new_filename;
            } else {
                $image_err = "Gagal mengupload file.";
            }
        }
    }

    if(empty($title_err) && empty($content_err) && empty($image_err)){
        if($is_edit){
            $sql = "UPDATE articles SET title = ?, content = ?, image = ? WHERE id = ?";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $image_name, $article_id);
            }
        } else {
            $sql = "INSERT INTO articles (title, content, image) VALUES (?, ?, ?)";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "sss", $title, $content, $image_name);
            }
        }

        if(mysqli_stmt_execute($stmt)){
            header("location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../style.css">
    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/xsum6jyhnblwe43holuzb3rvq6x3pcr2psl6902f2bsq8eil/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#content_editor',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <style>
        .wrapper { max-width: 900px; margin: 2rem auto; }
        .page-section { padding: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-control { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd; box-sizing: border-box; }
        .btn { padding: 10px 15px; border-radius: 5px; text-decoration: none; color: white; border: none; cursor: pointer; }
        .btn-primary { background-color: #007bff; }
        .btn-secondary { background-color: #6c757d; }
        .invalid-feedback { color: red; }
        .current-img { max-width: 200px; margin-top: 10px; display: block; }
    </style>
</head>
<body>
    <div class="background-container"></div>
    <div class="wrapper">
        <div class="page-section">
            <h2><?php echo $page_title; ?></h2>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>">
                    <span class="invalid-feedback"><?php echo $title_err;?></span>
                </div>
                <div class="form-group">
                    <label>Gambar Utama</label>
                    <input type="file" name="image" class="form-control">
                    <?php if($is_edit && $existing_image): ?>
                        <p>Gambar saat ini: <br><img src="../uploads/<?php echo $existing_image; ?>" alt="Current Image" class="current-img"></p>
                    <?php endif; ?>
                    <span class="invalid-feedback"><?php echo $image_err;?></span>
                </div>
                <div class="form-group">
                    <label>Konten</label>
                    <textarea name="content" id="content_editor" class="form-control"><?php echo $content; ?></textarea>
                    <span class="invalid-feedback"><?php echo $content_err;?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Simpan">
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>