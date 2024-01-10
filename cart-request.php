<?php
session_start();
include 'miumiuconn.php';
// session_destroy();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    $action = $_POST['action'];

    if ($action == 'add') {

        $product_id = $_POST['product_id'];
        $product_qty = $_POST['quantity'];

        $sql_item = "SELECT * FROM `item` WHERE `item_ID`= '$product_id'";
        $result_item = $conn->query($sql_item);

        if ($result_item->num_rows > 0) {
            $row = $result_item->fetch_assoc();
            // check if the item is already in cart
            if (isset($_SESSION['cart'][$product_id])) {
                // if item is already in cart, add the quantity
                $_SESSION['cart'][$product_id]['quantity'] += $product_qty;
            } else {
                // if item is not in cart, add the item to cart
                $_SESSION['cart'][$product_id] = array(
                    'quantity' => $product_qty,
                    'name' => $row['itemName'],
                    'price' => $row['itemPrice'],
                    'image' => $row['image_path']
                );
            }
            echo json_encode(array('message' => "Item added to cart.", 'status' => 'success'));
        } else {
            echo json_encode(array('message' => "Item not found.", 'status' => 'error'));
        }
        die;
    } elseif ($action == 'list') {
        header('Content-Type: text/html; charset=UTF-8');
        include 'cart-request-list.php';
        die;
    } elseif ($action == "count") {
        $count = 0;
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $count += $product['quantity'];
        }
        echo $count;
        die;
    } elseif ($action == "update") {
        $product_id = $_POST['product_id'];
        $product_qty = $_POST['quantity'];
        $product_price = $_POST['price'];
        $method = $_POST['method'];

        if (isset($_SESSION['cart'][$product_id])) {
            if ($method == "plus") {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
                $_SESSION['price'][$product_id]['price'] += $product_price;

            } elseif ($method == "minus") {
                $_SESSION['cart'][$product_id]['quantity'] -= 1;
                $_SESSION['price'][$product_id]['price'] -= $product_price;
                if ($_SESSION['cart'][$product_id]['quantity'] == 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
            }
            echo json_encode(array('message' => "Item updated.", 'status' => 'success'));
        } else {
            echo json_encode(array('message' => "Item not found.", 'status' => 'error'));
        }

    } elseif ($action == "remove") {
        $product_id = $_POST['product_id'];

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            echo json_encode(array('message' => "Item removed from cart.", 'status' => 'success'));
        } else {
            echo json_encode(array('message' => "Item not found.", 'status' => 'error'));
        }
        die;
    }
}
// echo "<pre>" . print_r($_SESSION['cart'], true) . "</pre>";