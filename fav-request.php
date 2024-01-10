<?php
session_start();

include 'miumiuconn.php';

// Check if the 'fav' array exists in the session
if (!isset($_SESSION['fav'])) {
    $_SESSION['fav'] = array();
}

$cust_ID = $_SESSION['cust_ID'];


// Add item to favorites
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    $action = $_POST['action'];

    if ($action == 'add') {
        $product_id = $_POST['product_id'];
        $cust_ID = $_SESSION['cust_ID'];

        // Check if the 'fav' array for the cust_ID exists in the session
        if (!isset($_SESSION['fav'][$cust_ID])) {
            $_SESSION['fav'][$cust_ID] = array();
        }

        // Check if the item is already in favorites
        if (isset($_SESSION['fav'][$cust_ID][$product_id])) {
            echo json_encode(array('message' => "Item is already in favorites.", 'status' => 'error'));
        } else {
            // Insert the item into the 'favorite' table (use prepared statements)
            $cust_ID = $_SESSION['cust_ID'];

            $sql_insert = "INSERT INTO favorite (cust_ID, item_ID, category_ID, itemName, itemPrice) 
                        SELECT ?, i.item_ID, i.category_ID, i.itemName, i.itemPrice
                        FROM item i 
                        WHERE i.item_ID = ?";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("ss", $cust_ID, $product_id);

            if ($stmt->execute()) {
                // Update the session data
                $sql_item = "SELECT * FROM `item` WHERE `item_ID`= ?";
                $stmt_item = $conn->prepare($sql_item);
                $stmt_item->bind_param("s", $product_id);
                $stmt_item->execute();
                $result_item = $stmt_item->get_result();

                if ($result_item->num_rows > 0) {
                    $row = $result_item->fetch_assoc();
                    $_SESSION['fav'][$cust_ID][$product_id] = array(
                        'quantity' => 1,
                        'name' => $row['itemName'],
                        'price' => $row['itemPrice'],
                        'image' => $row['image_path']
                    );

                    echo json_encode(array('message' => "Item added to favorites.", 'status' => 'success'));
                } else {
                    echo json_encode(array('message' => "Item not found.", 'status' => 'error'));
                }
            } else {
                echo json_encode(array('message' => "Error adding item to favorites. SQL Error: " . $stmt->error, 'status' => 'error'));
            }

            $stmt->close();
            $stmt_item->close();
        }

        // Close the database connection
        $conn->close();
        die;
    } elseif ($action == 'delete') {
        $product_id = $_POST['product_id'];

        // Check if the item is in favorites
        if (!isset($_SESSION['fav'][$cust_ID][$product_id])) {
            echo json_encode(array('message' => "Item not found in favorites.", 'status' => 'error'));
            exit;
        }

        // Delete the item from the 'favorite' table
        $sql_delete = "DELETE FROM favorite WHERE cust_ID = ? AND item_ID = ?";

        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("ss", $cust_ID, $product_id);

        if ($stmt_delete->execute()) {
            // Update the session data
            unset($_SESSION['fav'][$cust_ID][$product_id]);

            echo json_encode(array('message' => "Item removed from favorites.", 'status' => 'success'));
        } else {
            echo json_encode(array('message' => "Error removing item from favorites. SQL Error: " . $stmt_delete->error, 'status' => 'error'));
        }

        $stmt_delete->close();
        $conn->close();
        exit;
    }
}
?>