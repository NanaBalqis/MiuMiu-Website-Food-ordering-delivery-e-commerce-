<?php

include 'miumiuconn.php';

if(isset($_POST['add_product'])){
   
   $category = $_POST['category_ID'];
   $item_ID = $_POST['item_ID'];
   $itemName = $_POST['itemName'];
   $price = $_POST['itemPrice'];
   $quantity = $_POST['quantity'];
   $product_image = 'image/'.$_FILES['image_path']['name'];
   $product_image_tmp_name = 'image/'.$_FILES['image_path']['tmp_name'];
   $product_image_folder = 'image/'.$product_image;

   if (empty($category)||empty($item_ID) || empty($itemName) || empty($price) || empty($quantity)||  empty($product_image)){
      $message[] = 'Please fill out all fields ';

   }else{
      $insert = "INSERT INTO item (category_ID, item_ID, itemName, itemPrice, quantity, image_path) VALUES('$category' ,'$item_ID', '$itemName', '$price', '$quantity', '$product_image')";
      $upload = mysqli_query($conn,$insert);

      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         
         $message[] = 'New product added successfully';
         header('Location: admin_page.php'); // Redirect to the admin page
         exit();
      }else{
         $message[] = 'Could not add the product' . mysqli_error($conn);
      }
   }

};

if(isset($_GET['delete'])){
   $item_ID = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM item WHERE item_ID = '$item_ID'");
   
   $message[] = 'Item were deleted successfully';
   header('Location: admin_page.php');

   exit(); 
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>
   <link rel="icon" href="image/logo.png" type="image/x-icon">
   <!-- font awesome cdn link  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">-->

   <!-- custom css file link  -->
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

   <div class="admin-product-form-container">

      <form action="admin_page.php" method="post" enctype="multipart/form-data">
         <h3>add a new product</h3>
         <input type="text" placeholder="Enter category ID" name="category_ID" class="box">
         <input type="text" placeholder="Enter item ID" name="item_ID" class="box">
         <input type="text" placeholder="Enter item name" name="itemName" class="box">
         <input type="number" placeholder="Enter item price" name="itemPrice" step="0.01" class="box">
         <input type="number" placeholder="Enter quantity" name="quantity" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="image_path" class="box">
         <input type="submit" class="btn" name="add_product" value="add product">
      </form>

   </div>

   <?php 

   $select = mysqli_query($conn, "SELECT * FROM `item`");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Item image</th>
            <th>Item name</th>
            <th>Item price</th>
            <th>Quantity</th>
            <th>Action</th>
         </tr>
         </thead> 
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="<?php echo $row['image_path']; ?>" height="100" alt=""></td>
            <td><?php echo $row['itemName']; ?></td>
            <td>RM<?php echo $row['itemPrice']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td> 
               <a href="admin_edit.php?id=<?php echo $row['item_ID']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="admin_page.php?delete=<?php echo $row['item_ID']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr> 
      <?php } ?>
      </table>
   </div>

</div>


</body>
</html>