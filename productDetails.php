<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details from the database
$product = null;
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = '$productId'"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name'] ?? 'Product Not Found'); ?> - Stationery Shop</title>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>
    <?php include('header.php'); ?>
    <?php include('navigation.php'); ?>
    
    <div class="product-details">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <br>
        <p class="description"><b>Description: </b><br><?php echo htmlspecialchars($product['description']); ?></p>
        <p class="price"><b>Price: RM</b> <?php echo htmlspecialchars($product['price']); ?></p>
        
        <form action="addtoCart.php?id=<?php echo $productId?>" method="POST">
            <label for="product_quantity">Quantity:</label>
            <input type="number" id="product_quantity" name="product_quantity" value="1" min="1" max="10">
            <br>
            <input type="image" src="images/cart.png" alt="Add to Cart" class="cart-image">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <input type="hidden" name="add_to_cart" value="true">
        </form>

    </div>

    <?php include('footer.php'); ?>
</body>
</html>
