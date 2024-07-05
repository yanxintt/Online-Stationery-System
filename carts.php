<!DOCTYPE html>
<html>
<link rel="stylesheet" href="mystyle.css">
    <?php include('header.php'); ?>
    <?php include('navigation.php'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/trash.css' rel='stylesheet'>
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/add-r.css' rel='stylesheet'>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Comic Sans MS, Comic Sans, cursive;
            background-color: whitesmoke;
        }

        h1 {
            text-align: center;
            color: darkblue;
            vertical-align: middle;
        }

        .shopping-image {
            width: 35px;
        }

        .cart-container {
            padding: 10px;
            margin: auto;
            max-width: 800px;
            display: flex;
            flex-direction: column;
        }

        table {
            width: 100%;
            border-collapse: collapse;

        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: lemonchiffon;
        }

        tr:nth-child(odd) {
            background-color: lightcyan;
        }

        th {
            background-color: pink;
        }

        .product-image {
            width: 20px;
            height: auto;
        }

        .total-price {
            margin-top: 20px;
            position: absolute;
            left: 67%;
        }
        .msg{
            color: lightgreen;
            text-align: center;
            margin-top: 55px;
        }

        .shopping span {
            background-color: red;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            position: absolute;
            top: 16px;
            left: 59%;
            padding: 2px 6px;
            font-size: 12px;
            width: 12px;
            height: 20px;
        }

        .login-message {
            color: red;
            text-align: center;
        }

        .delete-button {
            background-color: #ff5555;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        .add-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        outline: none; 
        }
    </style>
</head>

<body>
    <h1>Shopping Carts
        <img src="images/shopping.png" class="shopping-image">
    </h1>

    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user is logged in
    if (!isset($_SESSION['email'])) {
        echo '<p class="login-message">Please <a href="login.php">log in</a> first.</p>';
        exit();
    }

    // Establish database connection
    $conn = mysqli_connect('localhost', 'root', '', 'stationery');
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    // Retrieve user ID from session
    $user_email = $_SESSION['email'];

    // Fetch user ID from the database based on email
    $query = "SELECT id FROM users WHERE email = '$user_email'";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo 'User not found.';
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];

    $query = "SELECT carts.id, carts.quantity, products.price, products.name, products.image
                FROM carts
                INNER JOIN products ON carts.item_id = products.id
                WHERE carts.user_id = $user_id";
    $cart_result = mysqli_query($conn, $query);

    $total_price = 0;
    $total_quantity = 0;

    if (mysqli_num_rows($cart_result) > 0) {

        echo '<div class="cart-container">'; 
        echo '<table>';
        echo '<tr><th> </th><th>Products</th><th>Quantity</th><th> </th><th>Price</th><th> </th></tr>';
        while ($cart_row = mysqli_fetch_assoc($cart_result)) {
            if ($cart_result) {
                $item_total_price = $cart_row['quantity'] * $cart_row['price'];
                $total_price = $total_price + $item_total_price;
                $total_quantity = $total_quantity + $cart_row['quantity'];
                $image_path = htmlspecialchars($cart_row['image']);
                echo '<tr>';
                echo '<td><img src="' . $image_path . '" style="width: 80px"/></td>';
                echo '<td>' . $cart_row['name'] . '</td>';
                echo '<td>' . $cart_row['quantity'] . '</td>';
                echo '<td>
                    <form method="post" action="">
                        <input type="hidden" name="item_id" value="' . $cart_row['id'] . '">
                        <button type="submit" class="add-button" name="add_item"><i class="gg-add-r"></i></button>
                    </form>
                    </td>';
                echo '<td>RM ' . $cart_row['price'] . '</td>';
                echo '<td><form method="post" action=""><button type="submit" class="delete-button" name="delete_item" value="' 
                . $cart_row['id'] . '"><i class="gg-trash"></i></button></form></td>';
            } else {
                echo "<p>Your Cart Is Empty</p>";
            }
        }
        
        echo '</tr>';
        echo '</table>';
        echo '</div>';
        echo '<p class="total-price">Total Price: RM ' . $total_price . '</p>';

        echo '<div class="shopping">';
        echo '</div>';
    }

    if (isset($_POST['delete_item'])) {
        $cart_item_id = $_POST['delete_item'];
        deleteRow($conn, $cart_item_id);
    }

    if (isset($_POST['add_item'])) {
        $cart_item_id = $_POST['item_id'];
        addQuantity($conn, $cart_item_id);
    }
    
    function deleteRow($conn, $id) {
        $sql = $conn->prepare("DELETE FROM carts WHERE id = ?");
        $sql->bind_param("i", $id);
        if ($sql->execute()) {
            echo '<p class="msg">Product deletion successful. Click on cart to view changes!<br>';
            exit();
        } else {
            echo "Error: " . $sql->error;
        }
    }
    

    function addQuantity($conn, $id) {
        $query = "SELECT quantity FROM carts WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_quantity = $row['quantity'];
            
            $new_quantity = $current_quantity + 1;
            
            $update_query = "UPDATE carts SET quantity = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ii", $new_quantity, $id);
            
            if ($update_stmt->execute()) {
                echo '<p class="msg">Quantity updated successful. Click on cart to view changes!<br>';
            } else {
                echo "Error updating quantity: " . $update_stmt->error;
            }
        } else {
            echo "Record not found for ID: $id";
        }
    }
    
    mysqli_close($conn);
    ?>
    </div>
    <?php include('footer.php'); ?>
</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var addForms = document.querySelectorAll('.add-form');

    addForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); 
            
            var formData = new FormData(form); 
            var itemId = formData.get('item_id'); 

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_quantity.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var cartItem = document.querySelector('.cart-item[data-id="' + itemId + '"]');
                    var quantityCell = cartItem.querySelector('.quantity');
                    var newQuantity = parseInt(quantityCell.textContent) + 1;
                    quantityCell.textContent = newQuantity;
                } else {
                    console.log('Error updating quantity');
                }
            };
            xhr.send('item_id=' + itemId); 
        });
    });
});
</script>
</html>