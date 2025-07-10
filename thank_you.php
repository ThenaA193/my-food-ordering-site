<?php
session_start();
$message = $_SESSION['order_success'] ?? '';
unset($_SESSION['order_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You | Snack Haven</title>
    <style>
        body {
            background: #121212;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 30px;
            text-align: center;
        }

        h1 {
            color: #ff6f00;
        }

        .btn {
            background-color: #ff6f00;
            color: #fff;
            padding: 14px 25px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #ffa000;
        }
    </style>
</head>
<body>
    <h1>Thank You!</h1>
    <p><?php echo $message ?: 'Order received successfully!'; ?></p>
    <a href="products.php" class="btn">Order More Snacks</a>
</body>
</html>
