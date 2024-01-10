<?php

include ('miumiuconn.php');

$id = isset($_GET['item_ID'])? $_GET['item_ID']: null;

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

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" href="image/logo.png" type="image/x-icon">
   <link rel="stylesheet" href="style1.css">
   <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

    :root{
    --green:#27ae60;
    --black:#333;
    --white:#fff;
    --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
    --border:.1rem solid var(--black);
    --background-image: url('newbg.jpg') no-repeat;
    }

    *{
    font-family: 'Poppins', sans-serif;
    margin:0; 
    padding:0;
    box-sizing: border-box;
    outline: none;
    border:none;
    text-decoration: none;
    text-transform: capitalize;
    background: var(--background-image);
    }

    html{
    font-size: 62.5%;
    overflow-x: hidden;
    }

    .btn{
    display: block;
    width: 100%;
    cursor: pointer;
    border-radius: .5rem;
    margin-top: 1rem;
    font-size: 1.7rem;
    padding:1rem 3rem;
    background: var(--green);
    color:var(--white);
    text-align: center;
    }

    .btn:hover{
    background: var(--black);
    }

    .message{
    display: block;
    background: var(--bg-color);
    padding:1.5rem 1rem;
    font-size: 2rem;
    color:var(--black);
    margin-bottom: 2rem;
    text-align: center;
    }

    .container{
    max-width: 1200px;
    padding:2rem;
    margin:0 auto;
    }

    .admin-product-form-container.centered{
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    
    }

    .admin-product-form-container form{
    max-width: 50rem;
    margin:0 auto;
    padding:2rem;
    border-radius: .5rem;
    background: var(--bg-color);
    }

    .admin-product-form-container form h3{
    text-transform: uppercase;
    color:var(--black);
    margin-bottom: 1rem;
    text-align: center;
    font-size: 2.5rem;
    }

    .admin-product-form-container form .box{
    width: 100%;
    border-radius: .5rem;
    padding:1.2rem 1.5rem;
    font-size: 1.7rem;
    margin:1rem 0;
    background: var(--white);
    text-transform: none;
    }

    .product-display{
    margin:2rem 0;
    }

    .product-display .product-display-table{
    width: 100%;
    text-align: center;
    }

    .product-display .product-display-table thead{
    background: var(--bg-color);
    }

    .product-display .product-display-table th{
    padding:1rem;
    font-size: 2rem;
    }


    .product-display .product-display-table td{
    padding:1rem;
    font-size: 2rem;
    border-bottom: var(--border);
    }

    .product-display .product-display-table .btn:first-child{
    margin-top: 0;
    }

    .product-display .product-display-table .btn:last-child{
    background: crimson;
    }

    .product-display .product-display-table .btn:last-child:hover{
    background: var(--black);
    }

    @media (max-width:991px){

    html{
        font-size: 55%;
    }

    }

    @media (max-width:768px){

    .product-display{
        overflow-y:scroll;
    }

    .product-display .product-display-table{
        width: 80rem;
    }

    }

    @media (max-width:450px){

    html{
        font-size: 50%;
    }

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
      
      $select = mysqli_query($conn, "SELECT * FROM item WHERE item_ID = '$item_ID'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form method="POST" action="update_item.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
      <h3 class="title">update the product</h3>
      <input type="text" class="box" name="item_ID" value="<?php echo $row['item_ID']; ?>" placeholder="Enter the item ID">
      <input type="text" class="box" name="itemName" value="<?php echo $row['itemName']; ?>" placeholder="Enter the item name">
      <input type="number" min="0" class="box" name="itemPrice" step="0.01" value="<?php echo $row['itemPrice']; ?>" placeholder="Enter the new item price">
      <input type="number" min="0"class="box" name="quantity" value= "<?php echo $row['quantity'];?>" placeholder="Enter quantity" >
      <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">

      <input type="submit" value="update product" name="update_product" class="btn">
      <a href="admin_page.php" class="btn">go back!</a>
   </form>


   <?php }; ?>

   

</div>

</div>

</body>
</html>