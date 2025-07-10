<?php
session_start();

// Include the database connection
include('db.php');

// Get the product name from the query string (e.g., order.php?product=SomeProduct)
$productName = $_GET['product'] ?? '';  // If no product is passed, set as empty

if (!$productName) {
    // Redirect to the products page if no product name is provided
    header("Location: products.php");
    exit;
}

// Fetch product details from the database
$query = "SELECT small_price, medium_price, large_price, description, image FROM products WHERE name = :productName";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
$stmt->execute();

$product = $stmt->fetch();

if (!$product) {
    // If no product found in the database, redirect to the products page
    header("Location: products.php");
    exit;
}

// Set the product details for use in the HTML
$prices = [
    'Small' => $product['small_price'],
    'Medium' => $product['medium_price'],
    'Large' => $product['large_price']
];
$description = $product['description'];
$productImage = 'images/products/' . strtolower(str_replace(' ', '-', $productName)) . '.png';

// Set ingredients information (you can modify this part to be dynamic from the database)
$ingredientsList = [
    'Muruku' => '🍚 Rice Flour, Urad Dal, Sesame Seeds, Spices, Oil',
    'Pagoda' => '🌿 Chickpea Flour, Rice Flour, Spices, Curry Leaves, Oil',
    'Potato Chips' => '🥔 Potatoes, Salt, Oil',
    'Banana Chips' => '🍌 Banana, Salt, Sugar, Oil',
    'Corn Sticks' => '🌽 Corn Flour, Salt, Oil',
    'Onion Rings' => '🧅 Wheat Flour, Onion Powder, Salt, Spices, Oil',
    'Cassava Chips' => '🌱 Cassava Root, Salt, Oil',
    'Cheese Balls' => '🧀 Corn Meal, Cheese Powder, Salt, Oil',
    'Spicy Nuts' => '🌶️ Peanuts, Chili Powder, Salt, Oil',
    'Nacho Bites' => '🌮 Corn Masa Flour, Cheese Powder, Salt, Oil',
    'Veggie Crackers' => '🥦 Wheat Flour, Vegetable Powder, Salt, Spices, Oil',
    'Garlic Twists' => '🧄 Wheat Flour, Garlic, Spices, Salt, Oil'
];

$ingredients = $ingredientsList[$productName] ?? 'Ingredients info not available.';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order <?php echo htmlspecialchars($productName); ?> | Snack Haven</title>
    <style>
       body {
           margin: 0;
           font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           background: radial-gradient(circle at top left, rgba(68, 68, 68, 0.7) 0%, rgba(34, 34, 34, 0.9) 100%),
                       url('b1.png') no-repeat center center/cover;
           background-blend-mode: overlay;
           color: #ffffff;
       }
       header.page-header { padding: 20px; text-align: center; background: rgba(0,0,0,0.5); position: sticky; top: 0; z-index: 999; backdrop-filter: blur(8px); box-shadow: 0 3px 10px rgba(0,0,0,0.4); }
       header h1 { margin: 0; font-size: 1.8rem; }
       .btn { display: inline-block; padding: 10px 20px; background-color: #ff6f00; color: #fff; border-radius: 8px; text-decoration: none; margin-top: 15px; transition: background 0.3s ease, transform 0.2s ease; }
       .btn:hover { background-color: #ffa000; transform: translateY(-2px); }
       .order-card { background: rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 35px; max-width: 700px; margin: 40px auto; text-align: center; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5); backdrop-filter: blur(15px); animation: floatCard 3s ease-in-out infinite alternate; }
       .order-card img { width: 100%; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4); }
       @keyframes floatCard { 0% { transform: translateY(0); } 100% { transform: translateY(-10px); } }
       .stars { color: #ffcc00; font-size: 1.3rem; margin-bottom: 15px; }
       .description { margin-bottom: 20px; font-size: 1rem; color: #dddddd; }
       .section-title { font-weight: bold; color: #ffcc80; margin: 20px 0 10px; font-size: 1.1rem; }
       .ingredients { background: rgba(255,255,255,0.08); padding: 12px; border-radius: 8px; margin-bottom: 20px; }
       .size-options { display: flex; justify-content: center; gap: 20px; margin-bottom: 20px; }
       .size-options label { cursor: pointer; }
       .order-card input[type="number"] { width: 150px; padding: 10px; background-color: #1e1e1e; border: none; border-radius: 8px; color: #fff; font-size: 1rem; margin-bottom: 20px; }
       .price-display { font-size: 1.8rem; color: #ff6f00; font-weight: bold; margin-bottom: 20px; }
       .action-button { background-color: #ff6f00; padding: 14px 28px; border-radius: 10px; color: #fff; text-decoration: none; font-weight: 600; transition: background 0.3s ease, transform 0.2s ease; }
       .action-button:hover { background-color: #ffa000; transform: translateY(-2px); }
       .extra-info { margin-top: 25px; font-size: 0.95rem; color: #ccc; }
       @media (max-width: 600px) { .order-card { padding: 25px; } .size-options { flex-direction: column; } .order-card input[type="number"] { width: 100%; } }
    </style>
    <script>
        function updateTotal() {
            const prices = <?php echo json_encode($prices); ?>;
            const qty = parseInt(document.getElementById('quantity').value);
            const size = document.querySelector('input[name="size"]:checked').value;
            const total = prices[size] * qty;
            document.getElementById('total').innerText = '$' + total.toFixed(2);
            document.getElementById('sizeInput').value = size;
            document.getElementById('priceInput').value = prices[size];
        }
    </script>
</head>
<body>
    <header class="page-header">
        <h1>Order <?php echo htmlspecialchars($productName); ?></h1>
        <a href="products.php" class="btn">Back to Snacks</a>
    </header>

    <section class="order-card">
        <img src="<?php echo $productImage; ?>" alt="Product Image">
        <div class="stars">⭐⭐⭐⭐⭐</div>
        <p class="description"><?php echo $description; ?></p>

        <div class="section-title">🍴 Ingredients</div>
        <div class="ingredients"><?php echo $ingredients; ?></div>

        <div class="section-title">📏 Select Your Size</div>
        <form method="post" action="add_to_cart.php" oninput="updateTotal()">
            <div class="size-options">
                <?php foreach ($prices as $size => $price): ?>
                    <label>
                        <input type="radio" name="size" value="<?php echo $size; ?>" <?php echo ($size === 'Small') ? 'checked' : ''; ?>>
                        <?php echo $size; ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="section-title">📦 How Many Packs Would You Like?</div>
            <input type="number" id="quantity" name="quantity" min="1" value="1">

            <div class="price-display">
                Your Total: <span id="total">$0.00</span>
            </div>

            <!-- Hidden fields to pass product details -->
            <input type="hidden" name="product" value="<?php echo $productName; ?>">
            <input type="hidden" name="price" id="priceInput" value="">
            <input type="hidden" name="selected_size" id="sizeInput" value="">

            <button type="submit" class="action-button">Add to Cart</button>
        </form>

        <div class="extra-info">
            🍃 <em>Fun Fact:</em> This snack is high in crunch, low in boredom!<br>
            🚚 <em>Fast Delivery:</em> Usually arrives within 20-30 minutes.
        </div>
    </section>

    <script>updateTotal();</script>
</body>
</html>
