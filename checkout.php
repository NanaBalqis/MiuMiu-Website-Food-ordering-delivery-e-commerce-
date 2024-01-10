<?php
session_start();
include 'miumiuconn.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['cust_ID']) && isset($_POST['checkout'])) {
    $username = $_SESSION['cust_ID'];

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        $cartItems = $_SESSION['cart'];

        $sqlMaxOrderID = "SELECT MAX(SUBSTRING(order_ID, 6)) as maxOrderNumber FROM cart";
        $resultMaxOrderID = mysqli_query($conn, $sqlMaxOrderID);

        $maxOrderNumber = 0;

        if ($resultMaxOrderID && mysqli_num_rows($resultMaxOrderID) > 0) {
            $rowMaxOrderID = mysqli_fetch_assoc($resultMaxOrderID);
            $maxOrderNumber = (int)$rowMaxOrderID['maxOrderNumber'];
        }

        $newOrderNumber = $maxOrderNumber + 1;

        $newOrderID = 'order' . $newOrderNumber;

        foreach ($cartItems as $cartItemId => $cartItem) {
            if (
                isset($cartItem['quantity']) &&
                isset($cartItem['name']) &&
                isset($cartItem['price'])
            ) {
                $quantity = $cartItem['quantity'];
                $itemName = $cartItem['name'];
                $price = $cartItem['price'];

                $sqlItem = "SELECT * FROM item WHERE itemName = ? AND itemPrice = ? AND item_ID = ?";
                $stmtItem = mysqli_prepare($conn, $sqlItem);

                mysqli_stmt_bind_param($stmtItem, "sdi", $itemName, $price, $cartItemId);

                mysqli_stmt_execute($stmtItem);

                $resultItem = mysqli_stmt_get_result($stmtItem);

                if ($resultItem && mysqli_num_rows($resultItem) > 0) {
                    $itemData = mysqli_fetch_assoc($resultItem);

                    $category = $itemData['category_ID'];
                    $itemId = $itemData['item_ID'];

                    $total = $quantity * $price;

                    $sql = "INSERT INTO cart (order_ID, cust_ID, category_ID, item_ID, itemName, itemPrice, quantity, amount)
                            VALUES ('$newOrderID', '$username', '$category', '$cartItemId', '$itemName', '$price', '$quantity', '$total')";

                    $result = mysqli_query($conn, $sql);

                    if (!$result) {
                        echo "<script>alert('Order Failed!')</script>";
                        exit; // Exit if there's an issue with the database insertion
                    }
                } else {
                    echo "<script>alert('Item not found!')</script>";
                    exit;
                }
            } else {
                // Handle missing keys, log or alert a message
                echo "<script>alert('Missing key(s) in cart item!')</script>";
                exit;
            }
        }

        // Check if success insert into cart table
        if ($result) {
            $_SESSION['cust_ID'] = $username;
            $_SESSION['order_ID'] = $newOrderID;

            echo "<script>alert('Order Successful!')</script>";
            echo "<script>window.location.href = 'http://localhost/miumiu/menu%20success%20login/method.php';</script>";

            // clear cart lepas checkout
            unset($_SESSION['cart']);
        } else {
            echo "<script>alert('Order Failed!')</script>";
            echo "<script>window.location.href = 'menu.php';</script>";
        }
    } else {
        echo "<script>alert('Shopping cart is empty!')</script>";
        echo "<script>window.location.href = 'cart-request-list.php';</script>";
    }
}
?>
