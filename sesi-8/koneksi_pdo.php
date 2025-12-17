<?php
$host = "localhost";
$database = "bootcampb6";
$username = "root";
$password = "new_password";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    // echo "Koneksi berhasil";
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
