<?php
    $host = "localhost";
    $username = "root";
    $password = "new_password"; 
    $database = "bootcampb6";

    $koneksi = mysqli_connect($host, $username, $password, $database);
    
    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // echo "Koneksi berhasil";
?>