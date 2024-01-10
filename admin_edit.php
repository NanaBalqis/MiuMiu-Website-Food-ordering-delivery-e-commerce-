<?php
include('miumiuconn.php');

// Retrieve item ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id === null) {
    // Handle the case when item ID is not provided in the URL
    die("Item ID is not specified.");
} 

// Use prepared statement to prevent SQL injection
$stmt = mysqli_prepare($conn, "SELECT * FROM `item` WHERE item_ID=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="icon" href="image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style1.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('image/abstract light.jpg') no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0; /* Add this line to remove default margin */
        }
    </style>
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $message){
        echo '<span class="message">'.$message.'</span>';
    }
}
?>

<div class="container">

   <div class="admin-product-form-container centered">

<?php 
  $select = mysqli_query($conn, "SELECT * FROM item  WHERE item_ID = '$id'");
  while($row = mysqli_fetch_assoc($select)){
?>

<form method="POST" action="update_item.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
      <h3 class="title">edit the product item</h3>
      <input type="text" class="box" name="itemName" value="<?php echo $row['itemName']; ?>" placeholder="Enter the item name">
      <input type="number" min="0" class="box" name="itemPrice" step="0.01" value="<?php echo $row['itemPrice']; ?>" placeholder="Enter the item price">
      <input type="number" min="0" class="box" name="quantity" value="<?php echo $row['quantity']; ?>" placeholder="Enter the quantity">
      <input type="file" accept="image/png, image/jpeg, image/jpg" name="image_path" class="box">
      <input type="hidden" name="oldImagePath" value="<?php echo $row['image_path']; ?>">
      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="admin_page.php" class="btn">go back!</a>
</form>

<?php
}
?>

</div>
</div>

</body>
</html>
