<?php
$title = "Home";

ob_start(); // ⬅️ mirip @section('content')
?>
<?php
// Koneksi database
require __DIR__ . '/../config/koneksi_pdo.php';
// Ambil ID produk dari query string
if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}
$productId = $_GET['id'];
// Ambil data produk berdasarkan ID
try {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        die("Produk dengan ID: $productId tidak ditemukan.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <img src="../uploaded_files/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4"><?= htmlspecialchars($product['name']) ?></h2>
            <h4>Harga: Rp <?= number_format($product['price'], 0, ',', '.') ?></h4>
            <p class="mt-3"><?= htmlspecialchars($product['description']) ?></p>
            <span class="badge bg-secondary"><?= htmlspecialchars($product['category']) ?></span>
            <div class="mt-4">
                <a href="javascript:history.back()" class="btn btn-primary">Kembali</a>
                <!-- button for add to cart -->
                 <form action="process/cart_process.php" method="post" class="d-inline">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                    <button type="submit" class="btn btn-success">Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php
$content = ob_get_clean(); // ⬅️ simpan konten
require __DIR__ . '/../template/main.php';
?>