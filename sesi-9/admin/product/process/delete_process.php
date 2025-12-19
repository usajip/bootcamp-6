<?php
include '../../../config/koneksi_pdo.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // First, retrieve the product to get the image filename
        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Delete the product from the database
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(['id' => $id]);

            // Delete the image file from the server
            if (!empty($product['image'])) {
                $uploadFileDir = '../../../uploaded_files/';
                $imagePath = $uploadFileDir . $product['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Redirect back to the product list page after deletion with success message
            header("Location: ../index.php?message=Product+deleted+successfully");
            exit();
        } else {
            die("Produk dengan ID: $id tidak ditemukan.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("ID produk tidak diberikan.");
}
?>