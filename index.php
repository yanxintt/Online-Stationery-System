<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stationery Stash Online Shop</title>
    <link rel="stylesheet" href="mystyle.css">
</head>

<body>
    <?php
    include('header.php');
    include('navigation.php');

    $conn = new mysqli("localhost", "root", "", "stationery");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT products.id, products.name, products.price, products.image FROM products";
    $result = $conn->query($sql);

    $itemList = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $itemList[] = $row;
        }
    }

    $conn->close();
    ?>

    <br>
    <div class="productpromo-container">
        <div class="productpromo-inner">
            <img class="productpromo-img" src="images/1.png">
            <img class="productpromo-img" src="images/2.png">
            <img class="productpromo-img" src="images/3.png">
            <img class="productpromo-img" src="images/4.png">
            <img class="productpromo-img" src="images/5.png">
        </div>
    </div>
    <div class="contentWrapper">
        <div class="grid-container">
            <?php foreach ($itemList as $item) : ?>
                <div class="grid-item">
                    <div class="product-section">
                        <div class="product-border">
                            <div class="product-img-center">
                                <a href="productDetails.php?id=<?php echo $item['id']; ?>"><img class="product-img" src="<?php echo $item['image']; ?>"></a>
                            </div>
                            <div>
                                <p class="product-name">
                                    <a href="productDetails.php?id=<?php echo $item['id']; ?>"><b><?php echo $item['name']; ?></b></a>
                                </p>
                                <p class="product-price">
                                    <?php echo $item['price']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>