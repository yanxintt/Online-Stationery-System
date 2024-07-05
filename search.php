<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="mystyle.css">
</head>

<body>
    <?php
    include('header.php');
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
            <li style="float:right"><a href="login.php">Sign in</a></li>
        </ul>
        <div class="clearfix"></div>
    </nav>

    <div class="grid-container">
        <!-- Products will be displayed here -->
    </div>

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
                gridItem.dataset.name = item.name;

                const productSection = document.createElement('div');
                productSection.classList.add('product-section');

                const productBorder = document.createElement('div');
                productBorder.classList.add('product-border');

                const productImgCenter = document.createElement('div');
                productImgCenter.classList.add('product-img-center');

                const productImgLink = document.createElement('a');
                productImgLink.href = `productDetails.php?id=${item.id}`;

                const productImg = document.createElement('img');
                productImg.classList.add('product-img');
                productImg.src = item.image;

                productImgLink.appendChild(productImg);
                productImgCenter.appendChild(productImgLink);
                productBorder.appendChild(productImgCenter);
                productSection.appendChild(productBorder);

                const productName = document.createElement('p');
                productName.classList.add('product-name');

                const productNameLink = document.createElement('a');
                productNameLink.href = `productDetails.php?id=${item.id}`;
                productNameLink.textContent = item.name;

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
</body>

</html>