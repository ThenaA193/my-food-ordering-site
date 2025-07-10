<?php
$featuredProducts = ['Muruku', 'Pagoda', 'Potato Chips'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Snack Haven | Home</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('2.png') no-repeat center center/cover;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .hero {
            padding: 10px 20px 50px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.6));
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            text-align: center;
            animation: fadeSlide 1s ease-out;
        }

        .hero h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            color: #fff9f0;
        }

        .hero p {
            font-style: italic;
            margin-bottom: 25px;
            font-size: 1.1rem;
            color: #ffe0b3;
        }

        .hero .btn {
            display: inline-block;
            padding: 14px 30px;
            background-color: #ff6f00;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            margin: 0 12px;
            transition: background 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .hero .btn:hover {
            background-color: #ffa000;
            transform: translateY(-2px);
        }

        .featured {
            padding: 50px 20px;
            text-align: center;
        }

        .featured h2 {
            color:rgb(246, 246, 246);
            margin-bottom: 30px;
            font-size: 2rem;
        }

        .featured-products {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }

        .product {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 20px;
            width: 250px;
            backdrop-filter: blur(10px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
            text-align: center;
        }

        .product img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .product h3 {
            margin-bottom: 10px;
        }

        .product p {
            margin-bottom: 15px;
            font-size: 0.95rem;
            color: #e0e0e0;
        }

        .product a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6f00;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .product a:hover {
            background-color: #ffa000;
            transform: translateY(-2px);
        }

        .info-section {
            display: flex;
            justify-content: space-around;
            background: rgba(0, 0, 0, 0.5);
            padding: 40px 20px;
            flex-wrap: wrap;
            text-align: center;
        }

        .info-box {
            max-width: 280px;
            padding: 15px;
        }

        .info-box h3 {
            color: #ff6f00;
            margin-bottom: 15px;
        }

        .info-box p {
            font-size: 0.95rem;
            color: #ddd;
            line-height: 1.4;
        }

        @keyframes fadeSlide {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            text-align: center;
            padding: 20px;
            font-size: 0.85rem;
            color: #cccccc;
            border-top: 1px solid #333;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .info-section {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <header class="hero">
        <h1>Welcome to Snack Haven</h1>
        <p>"Delicious Snacks, Delivered Fresh Every Day!"</p>
        <a href="products.php" class="btn">🍟 Order Now</a>
        <a href="cart.php" class="btn">🛒 View Cart</a>
    </header>

    <section class="featured">
        <h2>Our Popular Snacks</h2>
        <div class="featured-products">
            <?php foreach ($featuredProducts as $product): ?>
            <div class="product">
                <img src="images/products/<?php echo strtolower(str_replace(' ', '-', $product)); ?>.png" alt="<?php echo $product; ?>">
                <h3><?php echo $product; ?></h3>
                <p>Delicious and popular snack loved by all!</p>
                <a href="order.php?product=<?php echo urlencode($product); ?>">Order Now</a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="info-section">
        <div class="info-box">
            <h3>📍 Our Branches</h3>
            <p>123 Flavor Street, Snack City</p>
            <p>45 Crunch Road, Bite Town</p>
            <p>78 Crispy Lane, Munch Village</p>
        </div>
        <div class="info-box">
            <h3>👨‍🍳 Contact & Owner</h3>
            <p>Owner: Alex Tan</p>
            <p>Email: alex@snackhaven.com</p>
            <p>Phone: +1 234 567 8901</p>
        </div>
        <div class="info-box">
            <h3>🏢 Our Story</h3>
            <p>Founded in 2005, Snack Haven began as a humble stall in Snack City. Over the years, our passion for crispy, delightful snacks made us a household favorite across towns!</p>
        </div>
    </section>

    <footer>
        &copy; <?php echo date('Y'); ?> Snack Haven. All rights reserved.
    </footer>
</body>
</html>