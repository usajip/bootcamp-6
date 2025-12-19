<?php
    // Fetch product data based on the provided ID
    if (!isset($_GET['id'])) {
        die("ID produk tidak ditemukan.");
    }
    $productId = $_GET['id'];
    include '../../config/koneksi_pdo.php';
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
<?php
$title = "Edit Produk Admin";

ob_start(); // ⬅️ mirip @section('content')
?>
<div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1>Form Edit Data Produk</h1>
                <form action="process/edit_process.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>
                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori Produk</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" disabled>Pilih Kategori</option>
                            <option value="Elektronik" <?= $product['category'] == 'Elektronik' ? 'selected' : '' ?>>Elektronik</option>
                            <option value="Pakaian" <?= $product['category'] == 'Pakaian' ? 'selected' : '' ?>>Pakaian</option>
                            <option value="Makanan" <?= $product['category'] == 'Makanan' ? 'selected' : '' ?>>Makanan</option>
                            <option value="Minuman" <?= $product['category'] == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
                            <option value="Lainnya" <?= $product['category'] == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk (biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div class="mt-2">
                            <img src="../../uploaded_files/<?= htmlspecialchars($product['image']) ?>" alt="Current Product Image" style="width:150px; height:auto;">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        //form validation
        let form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            let name = document.getElementById('name').value;
            let price = document.getElementById('price').value;
            let description = document.getElementById('description').value;
            let category = document.getElementById('category').value;
            if (!name || !price || !description || !category) {
                event.preventDefault();
                alert('All fields are required.');
            }
        });
    </script>
</div>

<?php
$content = ob_get_clean(); // ⬅️ simpan konten
require __DIR__ . '/../../template/main.php';
?>