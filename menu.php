<?php
session_start();
include 'miumiuconn.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT item.*, category.categoryName FROM item
        JOIN category ON item.category_ID = category.category_ID";
$result = $conn->query($sql);

$conn->close();

// Assuming you have a session variable for the customer's username
if (isset($_SESSION['cust_ID'])) {
    $username = $_SESSION['cust_ID'];

    if (isset($_POST["action"]) && $_POST["action"] == "add") {
        $product_id = $_POST["item_ID"];
        $quantity = $_POST["quantity"];

        // Check if the product is already in the cart
        if (!isset($_SESSION["shopping_cart"])) {
            $_SESSION["shopping_cart"] = array();
        }

        $cart_item_key = $product_id;
        if (array_key_exists($cart_item_key, $_SESSION["shopping_cart"])) {
            // Product already exists in the cart, update quantity
            $_SESSION["shopping_cart"][$cart_item_key]["quantity"] += $quantity;
        } else {
            // Product doesn't exist in the cart, add it
            $sql = "SELECT * FROM item WHERE item_ID = '$product_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $item = array(
                    "item_ID" => $row['item_ID'],
                    "itemName" => $row['itemName'],
                    "itemPrice" => $row['itemPrice'],
                    "category_ID" => $row['category_ID'],
                    "quantity" => $quantity,
                );

                $_SESSION["shopping_cart"][$cart_item_key] = $item;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Menu</title>
    <link rel="icon" href="image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="brand">
                <a href="#" class="MiuMiu">Miu Miu.</a>
                <img src="image/logo.png" alt="Miu Miu Logo" class="logo">
            </div>
            <div class="uProfile">
                <a href="http://localhost/miumiu/dashboard/custDashboard.php">
                    <i class='bx bxs-user-circle' ></i>
                </a>
            </div>
            <div class="favourite">
                <a href="http://localhost/miumiu/menu%20success%20login/favorite.php">
                    <i class='bx bxs-heart'></i>
                </a>
            </div>
            <div class="icon-cart">
                <i class='bx bxs-cart'></i>
                <span>0</span>
            </div>
            <div class="log-out">
                <a href="http://localhost/miumiu/main%20page/main%20page.html">
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
        </header>

        <section class="banner">
            <div class="slider-wrapper">
                <div class="slider">
                    <img id="slide-1" src="image/banner1.jpg" alt="banner1" />
                    <img id="slide-2" src="image/banner2.jpg" alt="banner2" />
                    <img id="slide-3" src="image/banner3.jpg" alt="banner3" />
                </div>
                <div class="slider-nav">
                    <a href="#slide-1"></a>
                    <a href="#slide-2"></a>
                    <a href="#slide-3"></a>
                </div>
            </div>
        </section>

        <div id="menu">
            <h1 id="section">Menu</h1>
            <section class="filters">
                <h2>Filters</h2>
                <div class="filter-container">
                    <div class="filter-group">
                        <label for="categoryFilter">Category:</label>
                        <select id="categoryFilter" name="selectedCategory">
                            <option value="all">All</option>
                            <option value="C">Cakes</option>
                            <option value="CR">Croffle</option>
                            <option value="PS">Pastries</option>
                            <option value="DF">Deep Fried</option>
                            <option value="NC">Non-Coffee</option>
                            <option value="CF">Coffee</option>
                        </select>
                        <div class="offer" id="offerToggle">
                            <label>Show Offers:</label>
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <div id="menu_row">
                <?php
                $currentCategory = null;

                while ($row = $result->fetch_assoc()) {

                    if ($row['categoryName'] !== $currentCategory) {

                        if ($currentCategory !== null) {
                            ?>
                        </div>
                        <?php
                        }
                        ?>
                    <div id="menu_col">
                        <h2>
                            <?php echo $row['categoryName']; ?>
                        </h2>
                        <?php
                        $currentCategory = $row['categoryName'];
                    }
                    ?>
                    <div class="menu-box" data-item-id="<?php echo $row['item_ID']; ?>"
                        data-item-name="<?php echo $row['itemName']; ?>" data-item-price="<?php echo $row['itemPrice']; ?>"
                        data-item-category="<?php echo $row['category_ID']; ?>">
                        <div class="menu-image">
                            <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['itemName']; ?>">
                        </div>
                        <div class="menu-details">
                            <h3>
                                <?php echo $row['itemName']; ?>
                            </h3>
                            <h4>RM
                                <?php echo $row['itemPrice']; ?>
                            </h4>
                            <div class="menuBtn">
                                <i id="addCart" class="bx bxs-cart-add"
                                    onclick="tambahCart('<?php echo $row['item_ID']; ?>')"></i>
                                <i id="addFav" class="bx bxs-heart"
                                    onclick="addfavorite('<?php echo $row['item_ID']; ?>')"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="cartTab">
        <h1>Shopping Cart</h1>
        <div class="listCart">
        </div>
        <div class="total">
            <h3>Total: RM <span id="cartTotal">0.00</span></h3>
        </div>
        <div class="btn">
            <button class="close">CLOSE</button>
            <form action="checkout.php" method="post">
                <button class="checkout" name="checkout">CHECK OUT</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryFilter = document.getElementById('categoryFilter');
            const offerToggle = document.getElementById('offerToggle');
            const listProductPHP = document.querySelector('.menu_row');
            const iconCart = document.querySelector('.icon-cart');
            const closeCart = document.querySelector('.close');
            const body = document.querySelector('body');
            const listCartPHP = document.querySelector('.listCart');
            const iconCartSpan = document.querySelector('.icon-cart span');
            const menuBoxes = document.querySelectorAll('.menu-box');
            let carts = [];

            if (menuBoxes === null || menuBoxes === undefined) {
                console.error("Error: menuBoxes is null or undefined.");
                return;
            }

            menuBoxes.forEach(menuBox => {
                const itemID = menuBox.getAttribute('data-item-id');
                const itemName = menuBox.getAttribute('data-item-name');
                const itemPrice = menuBox.getAttribute('data-item-price');
                const categoryID = menuBox.getAttribute('data-item-category');

                console.log(`item_ID: ${itemID}, itemName: ${itemName}, itemPrice: ${itemPrice}, category_ID: ${categoryID}`);
            });

            // change filter
            function applyFilters() {
                const selectedCategory = categoryFilter.value;
                const showOffers = offerToggle.checked;

                menuBoxes.forEach(function (item) {
                    const category = item.getAttribute('data-item-category');
                    const hasOffer = item.classList.contains('offer');

                    const categoryMatch = selectedCategory === 'all' || selectedCategory === category;
                    const offerMatch = !showOffers || (showOffers && hasOffer);

                    if (categoryMatch && offerMatch) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }

            categoryFilter.addEventListener('change', applyFilters);
            offerToggle.addEventListener('change', applyFilters);

            iconCart.addEventListener('click', () => {
                body.classList.toggle('showCart');
            });

            closeCart.addEventListener('click', () => {
                body.classList.toggle('showCart');
            });

        });
    </script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    function tambahCart(product_id) {
        $.ajax({
            url: "cart-request.php",
            type: "POST",
            data: {
                product_id: product_id,
                quantity: 1,
                action: 'add',
            },
            datatype: "json",
            success: function (response) {
                if (response.status == "success") {
                    alert(response.message);
                    listCart();
                } else {
                    alert(response.message);
                }
            }
        })
    }

    function addfavorite(product_id) {
        $.ajax({
            url: "fav-request.php",
            type: "POST",
            data: {
                product_id: product_id,
                action: 'add',
            },
            datatype: "json",
            success: function (response) {
                if (response.status == "success") {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            }
        })
    }

    // ready 
    $(document).ready(function () {
        listCart();
        updateCartTotal();
    });

    function listCart() {
        $.ajax({
            url: "cart-request.php",
            type: "POST",
            data: {
                action: 'list',
            },
            datatype: "html",
            success: function (response) {
                $(".listCart").html(response);
                updateCartTotal();
                count();
            }, error: function (response) {
                console.log(response);
            }
        })
        count();
    }

    // Update total when cart items change
    function updateCartTotal(){
        var total = 0;
        $('.item').each(function(){
            var price = $(this).find('.priceTotal').text();
            total += parseFloat(price);
        });
        $('#cartTotal').text(total.toFixed(2));
    }


    function count() {
        $.ajax({
            url: "cart-request.php",
            type: "POST",
            data: {
                action: 'count',
            },
            datatype: "html",
            success: function (response) {
                $(".icon-cart span").html(response);
                updateCartTotal();
            }, error: function (response) {
                console.log(response);
            }
        });
    }

</script>

</html>