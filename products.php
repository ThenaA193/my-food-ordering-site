<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Our Snacks | Snack Haven</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('li.png') no-repeat center center / cover;
            color: #ffffff;
        }

        .promo-banner {
            background-color: #ff6f00;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-weight: bold;
        }

        .page-header {
            padding: 30px;
            text-align: center;
            animation: fadeIn 1.2s ease;
        }

        .tagline {
            font-size: 1rem;
            color: #cccccc;
            margin-bottom: 20px;
        }

        .nav-buttons {
            margin-bottom: 30px;
        }

        .nav-buttons a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #ff6f00;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            margin: 0 8px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .nav-buttons a:hover {
            background-color: #ffa000;
            transform: translateY(-2px);
        }

        .filters {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease;
        }

        .filters select {
            padding: 10px;
            border-radius: 8px;
            border: none;
            background-color: #1e1e1e;
            color: #fff;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: auto;
            padding: 0 20px 40px;
            animation: fadeIn 2s ease;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
        }

        .product-card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .rating {
            color: #ffcc00;
            margin-bottom: 10px;
        }

        .order-btn {
            background-color: #ff6f00;
            padding: 10px 15px;
            border-radius: 8px;
            color: #fff;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .order-btn:hover {
            background-color: #ffa000;
            transform: translateY(-2px);
        }

        .badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #ff6f00;
            color: #fff;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .favorite {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.2rem;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="promo-banner">
        🎉 Free Delivery on Orders Over $20!
    </div>

    <header class="page-header">
        <h1>Explore Our Snacks</h1>
        <p class="tagline">Delicious snacks, one bite away!</p>
        <div class="nav-buttons">
            <a href="index.php">Home</a>
            <a href="cart.php">View Cart</a>
        </div>
    </header>

    <div class="filters">
        <select id="filter-select">
            <option value="All">Filter: All</option>
            <option value="Spicy">Spicy</option>
            <option value="Crunchy">Crunchy</option>
            <option value="Popular">Popular</option>
        </select>
    </div>

    <section class="product-grid">
        <?php
        $categories = [
            'Muruku' => 'Spicy',
            'Pagoda' => 'Crunchy',
            'Potato Chips' => 'Crunchy',
            'Banana Chips' => 'Sweet',
            'Corn Sticks' => 'Crunchy',
            'Onion Rings' => 'Popular',
            'Cassava Chips' => 'Crunchy',
            'Cheese Balls' => 'Popular',
            'Spicy Nuts' => 'Spicy',
            'Nacho Bites' => 'Spicy',
            'Veggie Crackers' => 'Healthy',
            'Garlic Twists' => 'Spicy'
        ];

        foreach ($categories as $product => $category):
        ?>
        <div class="product-card" data-category="<?php echo $category; ?>">
            <?php if (in_array($product, ['Muruku', 'Potato Chips', 'Onion Rings'])): ?>
                <div class="badge">Popular</div>
            <?php endif; ?>
            <div class="favorite">❤️</div>
            <img src="images/products/<?php echo strtolower(str_replace(' ', '-', $product)); ?>.png" alt="<?php echo $product; ?>">
            <div class="product-title"><?php echo $product; ?></div>
            <div class="rating">⭐⭐⭐⭐☆</div>
            <a href="order.php?product=<?php echo urlencode($product); ?>" class="order-btn">Order</a>
        </div>
        <?php endforeach; ?>
    </section>

    <script>
        const filterSelect = document.getElementById('filter-select');
        const productCards = document.querySelectorAll('.product-card');

        filterSelect.addEventListener('change', () => {
            const selected = filterSelect.value;
            productCards.forEach(card => {
                const category = card.getAttribute('data-category');
                if (selected === 'All' || selected === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
