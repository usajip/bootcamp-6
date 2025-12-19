<?php
// koneksi database
include '../../config/koneksi_pdo.php';
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = $_POST['product_id'] ?? null;

    if (!$productId) {
        die("ID produk tidak diberikan.");
    }

    if ($action === 'update') {
        $quantity = intval($_POST['quantity'] ?? 1);
        if ($quantity < 1) $quantity = 1;
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    } elseif ($action === 'delete') {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    } else {
        // Default: tambah item ke cart (lama)
        // Periksa apakah produk sudah ada di keranjang
        if (isset($_SESSION['cart'][$productId])) {
            // Jika sudah ada, tingkatkan jumlahnya
            $_SESSION['cart'][$productId]['quantity'] += 1;
        } else {
            // Jika belum ada, ambil data produk dari database
            try {
                $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
                $stmt->execute(['id' => $productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($product) {
                    // Tambahkan produk ke keranjang dengan jumlah 1
                    $_SESSION['cart'][$productId] = [
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => 1
                    ];
                } else {
                    die("Produk dengan ID: $productId tidak ditemukan.");
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
    }
    // Redirect ke halaman keranjang
    header("Location: ../cart.php");
    exit();
} else {
    die("Metode request tidak valid.");
}
?>