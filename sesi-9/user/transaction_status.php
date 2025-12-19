<?php
$title = "Home";

ob_start(); // ⬅️ mirip @section('content')
?>

<?php
// Display transaction data from database using id passed via GET
require __DIR__ . '/../config/koneksi_pdo.php';
if (!isset($_GET['message'])) {
    die("Message not found.");
}
$message = $_GET['message'];

if(!isset($_GET['transaction_id'])) {
    die("Transaction ID not found.");
}
$transactionId = $_GET['transaction_id'];
try {
    $stmt = $pdo->prepare("SELECT t.id, t.status, t.total, u.name, u.email, u.phone, u.address 
                           FROM transactions t 
                           JOIN users u ON t.user_id = u.id 
                           WHERE t.id = :id");
    $stmt->execute(['id' => $transactionId]);
    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$transaction) {
        die("Transaction with ID: $transactionId not found.");
    }
    
    // Fetch transaction items
    $stmtItems = $pdo->prepare("SELECT ti.*, p.name as product_name, p.price as product_price 
                                FROM transaction_items ti 
                                JOIN products p ON ti.product_id = p.id 
                                WHERE ti.transaction_id = :id");
    $stmtItems->execute(['id' => $transactionId]);
    $transactionItems = $stmtItems->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<div class="container py-4">
    <div class="alert alert-success" role="alert">
        <?= htmlspecialchars($message) ?>
    </div>
    <h2>Transaction Details</h2>
    <p><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction['id']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($transaction['status']) ?></p>
    <p><strong>Total Amount:</strong> Rp <?= number_format($transaction['total'], 0, ',', '.') ?></p>
    <h3>Items:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactionItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>Rp <?= number_format($item['product_price'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td>Rp <?= number_format($item['total_price'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h3>User Information</h3>
    <p><strong>Name:</strong> <?= htmlspecialchars($transaction['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($transaction['email']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($transaction['phone']) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($transaction['address']) ?></p>
    <!-- Button for Transaction Confirmation via Whatsapp -->
    <div class="mt-4">
        <?php
        $whatsappMessage = "Hello, I would like to confirm my transaction with the following details:%0A%0A" .
                           "Transaction ID: " . $transaction['id'] . "%0A" .
                           "Name: " . $transaction['name'] . "%0A" .
                           "Email: " . $transaction['email'] . "%0A" .
                           "Phone: " . $transaction['phone'] . "%0A" .
                           "Address: " . $transaction['address'] . "%0A" .
                           "Total Amount: Rp " . number_format($transaction['total'], 0, ',', '.') . "%0A%0A" .
                           "Please let me know the next steps.";
        $whatsappUrl = "https://wa.me/1234567890?text=" . $whatsappMessage; // Ganti 1234567890 dengan nomor tujuan
        ?>
        <a href="<?= $whatsappUrl ?>" class="btn btn-success" target="_blank">Confirm via WhatsApp</a>
    </div>
</div>

<?php
$content = ob_get_clean(); // ⬅️ simpan konten
require __DIR__ . '/../template/main.php';
?>