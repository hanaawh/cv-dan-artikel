<?php
require_once "../config.php";

// Cek jika user tidak login, redirect ke halaman login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

if(isset($_GET["id"]) && !empty($_GET["id"])){
    $article_id = $_GET["id"];

    // 1. Dapatkan nama file gambar sebelum menghapus record
    $sql_select = "SELECT image FROM articles WHERE id = ?";
    if($stmt_select = mysqli_prepare($link, $sql_select)){
        mysqli_stmt_bind_param($stmt_select, "i", $article_id);
        mysqli_stmt_execute($stmt_select);
        $result = mysqli_stmt_get_result($stmt_select);
        if($row = mysqli_fetch_assoc($result)){
            $image_to_delete = $row['image'];
        }
        mysqli_stmt_close($stmt_select);
    }

    // 2. Hapus record dari database
    $sql_delete = "DELETE FROM articles WHERE id = ?";
    if($stmt_delete = mysqli_prepare($link, $sql_delete)){
        mysqli_stmt_bind_param($stmt_delete, "i", $article_id);
        if(mysqli_stmt_execute($stmt_delete)){
            // 3. Hapus file gambar dari folder uploads jika ada
            if(!empty($image_to_delete) && file_exists("../uploads/" . $image_to_delete)){
                unlink("../uploads/" . $image_to_delete);
            }
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt_delete);
    mysqli_close($link);
} else{
    header("location: index.php");
    exit();
}
?>