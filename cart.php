<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart | Snack Haven</title>
    <style>
        body {
            background: #121212;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #ff6f00;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.05);
            margin-top: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #ff6f00;
            color: #fff;
        }

        td {
            color: #ddd;
        }

        .total {
            font-weight: bold;
            font-size: 1.3rem;
            text-align: right;
            padding: 20px 0;
        }

        .btn {
            background-color: #ff6f00;
            color: #fff;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 15px 10px 0;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #ffa000;
            transform: translateY(-2px);
        }

        .center {
            text-align: center;
        }

        .empty-cart {
            padding: 50px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            max-width: 600px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <h1>Your Shopping Cart</h1>

    <?php if (empty($cart)): ?>
        <div class="empty-cart center">
            <p>Your cart is empty.</p>
            <a href="products.php" class="btn">Continue Shopping</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Price per Pack</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($cart as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $grandTotal += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['product']); ?></td>
                    <td><?php echo htmlspecialchars($item['size']); ?></td>
                    <td><?php echo (int) $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            Total: $<?php echo number_format($grandTotal, 2); ?>
        </div>

        <div class="center">
            <a href="products.php" class="btn">Add More Snacks</a>
            <a href="checkout.php" class="btn">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</body>
</html>
