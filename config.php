<?php
// Konfigurasi Database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Default username untuk XAMPP
define('DB_PASSWORD', ''); // Default password untuk XAMPP adalah kosong
define('DB_NAME', 'dbcv');

// Membuat koneksi ke database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Memulai session
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
