<?php
session_start();
include('db.php');

$product = $_POST['product'] ?? '';
$size = $_POST['selected_size'] ?? '';
$quantity = (int) ($_POST['quantity'] ?? 1);
$price = (float) ($_POST['price'] ?? 0);

// Validate fields
if ($product && $size && $quantity > 0 && $price > 0) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = [
        'product' => $product,
        'size' => $size,
        'quantity' => $quantity,
        'price' => $price
    ];

    header("Location: cart.php");
    exit;
} else {
    header("Location: products.php?error=Invalid data");
    exit;
}
?>
