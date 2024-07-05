<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'stationery');
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

$total_quantity = 0;

if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    $query = "SELECT id FROM users WHERE email = '$user_email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        $cart_query = "SELECT SUM(quantity) as total_quantity FROM carts WHERE user_id = $user_id";
        $cart_result = mysqli_query($conn, $cart_query);

        if ($cart_result) {
            $cart_row = mysqli_fetch_assoc($cart_result);
            $total_quantity = $cart_row['total_quantity'];
        }
    }
}

$itemList = [];

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $search_query = "SELECT * FROM products WHERE name LIKE '%$query%'";
    $search_result = mysqli_query($conn, $search_query);

    while ($row = mysqli_fetch_assoc($search_result)) {
        $itemList[] = $row;
    }
} else {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $itemList[] = $row;
        }
    }
}

mysqli_close($conn);
?>

<nav id="topNavigation">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About Us</a></li>
        <li><a href="contact.php">Contact</a></li>
        <form id="search-form" method="get" action="search.php" style="float:left">
            <input type="text" name="query" id="search-box" onkeyup="renderSearchResults()" placeholder="Search...">
            <button type="submit" id="search-button">
                <img src="images/search.png" class="search" alt="search icon">
            </button>
        </form>
        <li style="float:right">
            <a href="carts.php" class="shopping">
                <img src="images/shopping2.png" alt="cart icon">
                <span class="quantity"><?php echo $total_quantity; ?></span>
            </a>
        </li>
        <li style="float:right"><a href="login.php">Log In</a></li>
    </ul>
    <div class="clearfix"></div>
</nav>

<script>
    const searchResults = <?php echo json_encode($itemList); ?>;

    function renderSearchResults() {
        const gridContainer = document.querySelector('.grid-container');
        gridContainer.innerHTML = '';

        const query = document.getElementById('search-box').value;
        const filteredResults = searchResults.filter(item => item.name.toLowerCase().includes(query.toLowerCase()));

        filteredResults.forEach(item => {
            const gridItem = document.createElement('div');
            gridItem.classList.add('grid-item');
            gridItem.dataset.name = item.product_name;

            const productSection = document.createElement('div');
            productSection.classList.add('product-section');

            const productBorder = document.createElement('div');
            productBorder.classList.add('product-border');

            const productImgCenter = document.createElement('div');
            productImgCenter.classList.add('product-img-center');

            const productImgLink = document.createElement('a');
            productImgLink.href = `productDetails.php?id=${item.item_id}`;

            const productImg = document.createElement('img');
            productImg.classList.add('product-img');
            productImg.src = item.product_img_name;

            productImgLink.appendChild(productImg);
            productImgCenter.appendChild(productImgLink);
            productBorder.appendChild(productImgCenter);
            productSection.appendChild(productBorder);

            const productName = document.createElement('p');
            productName.classList.add('product-name');

            const productNameLink = document.createElement('a');
            productNameLink.href = `productDetails.php?id=${item.item_id}`;
            productNameLink.textContent = item.product_name;

            productName.appendChild(productNameLink);
            productSection.appendChild(productName);

            const productPrice = document.createElement('p');
            productPrice.classList.add('product-price');
            productPrice.textContent = item.price;

            productSection.appendChild(productPrice);
            gridItem.appendChild(productSection);
            gridContainer.appendChild(gridItem);
        });
    }

    renderSearchResults();
</script>