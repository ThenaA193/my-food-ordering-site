<?php
session_start();
include('db.php');  // Include the database connection using PDO

$cart = $_SESSION['cart'] ?? [];
$shippingFee = 4.90;
$shippingMethods = ['Standard' => $shippingFee];
$paymentMethods = [
    'Cash by Hand' => 'icons/cash.png',
    'Touch n Go eWallet' => 'icons/tng.png'
];

// Handle Order when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $paymentMethod = $_POST['payment_method'] ?? '';

    // Validate required fields
    if ($name && $phone && $address && $paymentMethod) {
        // Insert each cart item into the orders table using PDO
        $grandTotal = 0;
        foreach ($cart as $item) {
            $total = $item['price'] * $item['quantity'];
            $grandTotal += $total;

            $sql = "INSERT INTO orders (product_name, size, quantity, price, total, customer_name, phone, shipping_address, payment_method, status, created_at)
                    VALUES (:product_name, :size, :quantity, :price, :total, :customer_name, :phone, :shipping_address, :payment_method, 'Pending', NOW())";

            // Prepare the statement
            if ($stmt = $pdo->prepare($sql)) {
                // Bind parameters
                $stmt->bindParam(':product_name', $item['product']);
                $stmt->bindParam(':size', $item['size']);
                $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':price', $item['price'], PDO::PARAM_STR);
                $stmt->bindParam(':total', $total, PDO::PARAM_STR);
                $stmt->bindParam(':customer_name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':shipping_address', $address);
                $stmt->bindParam(':payment_method', $paymentMethod);

                // Execute the query
                $stmt->execute();
            }
        }

        // Add the grand total (including shipping) to the session
        $finalTotal = $grandTotal + $shippingFee;
        $_SESSION['order_total'] = $finalTotal; // Store the total in session

        $_SESSION['cart'] = []; // Clear the cart after successful order
        header("Location: payment_qr.php?payment_method=" . urlencode($paymentMethod)); // Redirect to QR page
        exit;
    } else {
        // Redirect if validation fails
        header("Location: checkout.php?error=Missing fields");
        exit;
    }
}

// Calculating the grand total in case the form is not yet submitted
$grandTotal = 0;
foreach ($cart as $item) {
    $grandTotal += $item['price'] * $item['quantity'];
}
$finalTotal = $grandTotal + $shippingFee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Snack Haven</title>
    <style>
        body {
            background-color: #121212;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 30px;
            color: #fff;
        }
        h1 {
            text-align: center;
            color: #ff6f00;
        }
        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: auto;
            background-color: #1c1c1c;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        .checkout-left, .checkout-right {
            padding: 30px;
            flex: 1;
            min-width: 300px;
        }
        .section-title {
            color: #ff6f00;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            background: #2c2c2c;
            border: 1px solid #444;
            color: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .option-box {
            background: #2c2c2c;
            border: 2px solid #444;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #444;
            border-radius: 10px;
            margin-bottom: 15px;
            background-color: #2c2c2c;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
            position: relative;
        }
        .payment-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        .payment-option img {
            width: 35px;
            height: 35px;
            margin-right: 15px;
        }
        .payment-option .details {
            flex-grow: 1;
        }
        .payment-option .details strong {
            font-size: 1rem;
            color: #fff;
        }
        .payment-option .details span {
            display: block;
            font-size: 0.85rem;
            color: #aaa;
            margin-top: 5px;
        }
        .payment-option.active {
            border-color: #ff6f00;
            background-color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color: #ccc;
        }
        th, td {
            padding: 12px 8px;
            border-bottom: 1px solid #444;
            text-align: center;
        }
        .order-summary {
            margin-top: 20px;
        }
        .order-totals {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #444;
            text-align: right;
        }
        .order-totals div {
            margin-bottom: 8px;
            font-size: 1rem;
            color: #ccc;
        }
        .order-totals strong {
            font-size: 1.2rem;
            color: #fff;
        }
        .btn {
            background-color: #ff6f00;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #ffa040;
        }
    </style>
</head>
<body>
<h1>Checkout</h1>

<form method="post" class="checkout-container">
    <div class="checkout-left">
        <div class="section-title">Shipping Details</div>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <textarea name="address" placeholder="Full Shipping Address" required></textarea>

        <div class="section-title">Delivery Options</div>
        <?php foreach ($shippingMethods as $method => $fee): ?>
            <div class="option-box">
                <strong><?php echo htmlspecialchars($method); ?></strong><br>
                RM<?php echo number_format($fee, 2); ?> — Estimated delivery in 2-5 days
            </div>
        <?php endforeach; ?>

        <div class="section-title">Payment Method</div>
        <?php foreach ($paymentMethods as $method => $icon): ?>
            <label class="payment-option">
                <input type="radio" name="payment_method" value="<?php echo htmlspecialchars($method); ?>" required>
                <img src="<?php echo $icon; ?>" alt="<?php echo htmlspecialchars($method); ?>">
                <div class="details">
                    <strong><?php echo htmlspecialchars($method); ?></strong>
                    <span>
                        <?php 
                        if ($method === 'Cash by Hand') {
                            echo 'Pay when you receive your order.';
                        } else {
                            echo 'Link your TNG eWallet to complete the payment.';
                        }
                        ?>
                    </span>
                </div>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="checkout-right">
        <div class="section-title">Order Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product']); ?></td>
                        <td><?php echo (int)$item['quantity']; ?></td>
                        <td>RM<?php echo number_format($item['price'], 2); ?></td>
                        <td>RM<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="order-summary">
            <div class="order-totals">
                <div>Subtotal: RM<?php echo number_format($grandTotal, 2); ?></div>
                <div>Shipping: RM<?php echo number_format($shippingFee, 2); ?></div>
                <div><strong>Total: RM<?php echo number_format($finalTotal, 2); ?></strong></div>
            </div>
        </div>
        <button class="btn" type="submit">Place Order</button>
    </div>
</form>

<script>
    const paymentOptions = document.querySelectorAll('.payment-option');
    paymentOptions.forEach(option => {
        option.addEventListener('click', () => {
            paymentOptions.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            option.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>
</body>
</html>
