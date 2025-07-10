<?php
session_start();

// Get the payment method from the URL
$paymentMethod = $_GET['payment_method'] ?? '';

// Ensure that the payment method is valid
if ($paymentMethod !== 'Touch n Go eWallet') {
    // If the payment method is not Touch n Go, redirect back to checkout
    header("Location: checkout.php");
    exit;
}

// Assuming order total is stored in the session
$orderTotal = $_SESSION['order_total'] ?? 0;  // Get the total order amount from session
$transactionId = "TXN" . rand(100000, 999999);  // Example Transaction ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Your Payment | Snack Haven</title>
    <style>
        body {
            background-color: #000;  /* Solid black background */
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 30px;
            color: #fff;
        }
        h1 {
            text-align: center;
            color: #ff6f00;
            margin-bottom: 40px;
            font-size: 2.5rem;
            font-weight: 600;
        }
        .payment-container {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.85); /* Slightly transparent black container */
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
            max-width: 800px;
            margin: auto;
            overflow: hidden;
        }
        .payment-details, .payment-instructions, .payment-note {
            margin-top: 20px;
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #fff;
        }
        .amount-to-pay {
            font-size: 2rem;
            color: #ff6f00;
            margin-top: 20px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            background-color: #333;
            display: inline-block;
            border: 2px solid #ff6f00;
        }
        .payment-note {
            font-size: 1.1rem;
            color: #bbb;
            font-style: italic;
        }
        .qr-code-container {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 25px;
            background-color: #222;
            border-radius: 15px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.6);
        }
        .qr-code-container img {
            max-width: 100%;
            width: 250px;
            height: auto;
            margin-bottom: 25px;
            border-radius: 8px;
            border: 2px solid #ff6f00;
        }
        .btn {
            background-color: #ff6f00;
            color: #fff;
            padding: 18px 32px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 40px;
            text-decoration: none;
            transition: background-color 0.3s;
            display: inline-block;
        }
        .btn:hover {
            background-color: #ffa040;
        }
        .info-box {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
            margin-top: 30px;
            font-size: 1.1rem;
        }
        .info-box img {
            max-width: 40px;
            margin-right: 15px;
        }

        /* Add subtle background effects */
        .payment-container {
            background-color: rgba(0, 0, 0, 0.85); /* Slightly transparent black container */
        }
        .qr-code-container {
            animation: fadeIn 2s ease-in-out;
        }

        /* Animations */
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

    </style>
</head>
<body>
<h1>Complete Your Payment</h1>

<div class="payment-container">
    <!-- Order Summary -->
    <div class="payment-details">
        <p><strong>Order Summary:</strong></p>
        <p>Your total amount to pay: <span class="amount-to-pay">RM <?php echo number_format($orderTotal, 2); ?></span></p>
    </div>

    <!-- Instructions for Payment -->
    <div class="payment-instructions">
        <p>To complete the payment via <strong>Touch n Go eWallet</strong>, please scan the following QR code:</p>
    </div>

    <!-- QR Code Section -->
    <div class="qr-code-container">
        <img src="images/payment_qr1.png" alt="QR Code for Touch n Go Payment">
    </div>
    
    <!-- Additional Notes and Information -->
    <div class="payment-note">
        <p><strong>Important:</strong> Once your payment is completed, your order status will be updated automatically. If you encounter any issues during the payment process, please contact our support team.</p>
    </div>

    <!-- Information Box -->
    <div class="info-box">
        <img src="icons/info-icon.png" alt="Info Icon">
        <p>For any inquiries, please refer to our <strong>Help Center</strong> or reach out to our customer support.</p>
    </div>

    <!-- Proceed Button -->
    <a href="order_success.php" class="btn">Proceed to Order Success</a>
</div>

</body>
</html>
