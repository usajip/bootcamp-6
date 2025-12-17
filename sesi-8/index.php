<?php
// koneksi_pdo.php diasumsikan sudah berisi koneksi PDO ke database
require 'koneksi_pdo.php';

// Ambil daftar category untuk filter
try {
    $categories = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die('Error mengambil category: ' . $e->getMessage());
}

// Ambil filter category dari GET
$filterCategory = $_GET['category'] ?? '';

// Query products (dengan atau tanpa filter)
try {
    if ($filterCategory) {
        $stmt = $pdo->prepare("SELECT id, name, description, price, category, image FROM products WHERE category = :category ORDER BY id DESC");
        $stmt->execute(['category' => $filterCategory]);
    } else {
        $stmt = $pdo->query("SELECT id, name, description, price, category, image FROM products ORDER BY id DESC");
    }
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error mengambil products: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h2 class="mb-4">Daftar Products</h2>
        <!-- Filter Category -->
        <form method="GET" class="row mb-4">
            <div class="col-md-4">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Category --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $filterCategory == $cat ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <!-- Card Products -->
        <div class="row g-4">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="uploaded_files/dummy.jpeg" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height:200px; object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text small text-muted"><?= htmlspecialchars($product['description']) ?></p>
                                <span class="badge bg-secondary mb-2"><?= htmlspecialchars($product['category']) ?></span>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <strong>Rp <?= number_format($product['price'], 0, ',', '.') ?></strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-warning">Data product tidak ditemukan.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
