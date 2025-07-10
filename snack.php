<?php
session_start();
require 'db.php';

// Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int) $_POST['product_id'];

    // Fetch product from DB
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if ($product) {
        // Add product to cart session
        $_SESSION['cart'][$productId] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'size' => $product['size'],
            'price' => $product['price']
        ];
    }
}

// Remove from cart
if (isset($_GET['remove'])) {
    $removeId = (int) $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
}

$cartItems = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart | Snack Haven</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="page-header">
        <h1>Your Shopping Cart</h1>
        <a href="products.php" class="btn">Continue Shopping</a>
    </header>

    <section class="cart-items">
        <?php if ($cartItems): ?>
            <ul>
                <?php foreach ($cartItems as $item): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($item['name']); ?> (<?php echo $item['size']; ?>)</strong>
                        - $<?php echo number_format($item['price'], 2); ?>
                        <a href="cart.php?remove=<?php echo $item['id']; ?>" class="btn">Remove</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h2>Total: $<?php echo number_format($total, 2); ?></h2>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </section>
</body>
</html>
