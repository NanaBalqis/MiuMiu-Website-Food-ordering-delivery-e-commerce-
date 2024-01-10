<?php
include('./miumiuconn.php');

// Retrieve item ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id === null) {
    die("item ID is not specified.");
}

// Check if the form is submitted
    $itemName = $_POST['itemName'];
    $itemPrice = $_POST['itemPrice'];
    $quantity = $_POST['quantity'];

    // Check if a new image is uploaded
    if ($_FILES['image_path']['name']) {
        // Handle the file upload logic
        $newImagePath = 'image/' . $_FILES['image_path']['name'];
        move_uploaded_file($_FILES['image_path']['tmp_name'], $newImagePath);
    } else {
        // If no new image is uploaded, use the existing image path
        $newImagePath = $_POST['oldImagePath'];
    }

    mysqli_query($conn, "UPDATE `item` SET itemName='$itemName', itemPrice='$itemPrice' , quantity='$quantity', image_path= '$newImagePath' WHERE item_ID='$id'");

    echo '<script>alert("Item updated successfully!");</script>';
    echo '<script>window.location.href = "admin_page.php";</script>';
    exit;
?>
