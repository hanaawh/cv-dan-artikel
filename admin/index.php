<?php
require_once "../config.php";

// Cek jika user tidak login, redirect ke halaman login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .wrapper { max-width: 800px; margin: 2rem auto; }
        .page-section { padding: 2rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; color: #333; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; border-radius: 5px; text-decoration: none; color: white; }
        .btn-success { background-color: #28a745; }
        .btn-primary { background-color: #007bff; }
        .btn-danger { background-color: #dc3545; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; }
    </style>
</head>
<body>
    <div class="background-container"></div>
    <div class="wrapper">
        <div class="page-section">
            <div class="admin-header">
                <h2>Manajemen Artikel</h2>
                <div>
                    <a href="manage-artikel.php" class="btn btn-success">Tambah Artikel Baru</a>
                    <a href="../logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil data artikel dari database
                    $sql = "SELECT id, title, created_at FROM articles ORDER BY created_at DESC";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_array($result)){
                                echo "<tr>";
                                    echo "<td>" . $row['title'] . "</td>";
                                    echo "<td>" . date('d M Y', strtotime($row['created_at'])) . "</td>";
                                    echo "<td>";
                                        echo '<a href="manage-artikel.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>';
                                        echo '&nbsp;';
                                        echo '<a href="hapus-artikel.php?id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Anda yakin ingin menghapus artikel ini?\')">Hapus</a>';
                                    echo "</td>";
                                echo "</tr>";
                            }
                            mysqli_free_result($result);
                        } else{
                            echo '<tr><td colspan="3"><em>Belum ada artikel.</em></td></tr>';
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
                    mysqli_close($link);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
