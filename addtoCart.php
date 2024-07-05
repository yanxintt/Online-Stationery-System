<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stationery";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
    // Retrieve user ID from the users table
    if (!isset($_SESSION['email'])) {
        echo '<p style="color: red; text-align: center;">Please <a href="login.php">log in</a> first.</p>';
        exit();
    }
    $email = $_SESSION['email'];

    // Retrieve user ID from the users table based on the email
    $user_query = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (!$user_query) {
        die('User not found.');
    }

    $user_data = mysqli_fetch_assoc($user_query);
    $user_id = $user_data['id'];

    $productID = $_GET['id'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `carts` WHERE item_id = '$productID' AND user_id = '$user_id'") or die('query failed');

    // Check if the product already exists in the cart
    if (mysqli_num_rows($check_cart_numbers) > 0) {
        // Product already exists, so update the quantity
        $existing_cart_item = mysqli_fetch_assoc($check_cart_numbers);
        $new_quantity = $existing_cart_item['quantity'] + $product_quantity;

        // Update the quantity for the existing product in the cart
        mysqli_query($conn, "UPDATE `carts` SET quantity = '$new_quantity' WHERE item_id = '$productID' AND user_id = '$user_id'") or die('query failed');

        $message[] = 'Quantity updated in the cart!';
    } else {
        // Product does not exist, so insert a new record into the cart
        mysqli_query($conn, "INSERT INTO `carts`(user_id, item_id, quantity) VALUES('$user_id', '$productID', '$product_quantity')") or die('query failed');
        $message[] = 'Product added to cart!';
    }

    // Include relevant file after cart manipulation
    include('productDetails.php');
}
?>