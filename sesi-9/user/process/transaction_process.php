<?php
include '../../config/koneksi_pdo.php';
session_start();
// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Keranjang belanja Anda kosong.");
}

$cartItems = $_SESSION['cart'];

// Save the user data to database users table (name, email, phone, address) and Process the transaction and save to database (transactions table (status, total, user_id) and transaction_items table (transaction_id, product_id, quantity, total_price))

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Insert user data
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, address) VALUES (:name, :email, :phone, :address)");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ]);
        $userId = $pdo->lastInsertId();

        // Calculate total amount
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Insert transaction data
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, status, total) VALUES (:user_id, :status, :total)");
        $stmt->execute([
            'user_id' => $userId,
            'status' => 'pending',
            'total' => $totalAmount
        ]);
        $transactionId = $pdo->lastInsertId();

        // Insert transaction items
        $stmt = $pdo->prepare("INSERT INTO transaction_items (transaction_id, product_id, quantity, total_price) VALUES (:transaction_id, :product_id, :quantity, :total_price)");
        foreach ($cartItems as $productId => $item) {
            $stmt->execute([
                'transaction_id' => $transactionId,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity']
            ]);
        }

        // Commit transaction
        $pdo->commit();

        // Clear the cart
        unset($_SESSION['cart']);

        // Redirect to a success page or display a success message
        header("Location: ../transaction_status.php?message=Transaction+successful&transaction_id=$transactionId");
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
} else {
    die("Metode request tidak valid.");
}
?>