<?php

session_start();
include 'miumiuconn.php';

$username = isset($_SESSION['cust_ID']) ? $_SESSION['cust_ID'] : 0;

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM registration WHERE cust_ID
        = '$username'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $_SESSION['row'] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>




<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CASH</title>
        <link rel="icon" href="image/logo.png" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="style(1).css">
    </head>
    <body>
        <header class="header">
            <div class="brand">
                <a href="#" class="MiuMiu">Miu Miu.</a>
                <img src="image\MIUMIU.png" alt="Logo" class="logo">
            </div>
        </header>

            <div class="container">
                <div class="center">
                    <h3>BILLING INFO</h3>  
                    <form action="card.php">
                    Full Name
                    <input type="text"  value="<?php echo $_SESSION['row']['name']; ?>" required>

                    Address
                    <input type="text"  value="<?php echo $_SESSION['row']['address']; ?>" required>
                    
                    City
                    <input type="text"  value="<?php echo $_SESSION['row']['city']; ?>" required>
                    
                        
                        <div id="zip">
                            <label>
                                State
                                <select>
                                    <option>Choose State</option>
                                    <option>Perlis</option>
                                    <option>Kedah</option>
                                    <option>Pulau Pinang</option>
                                    <option>Perak</option>
                                    <option>Pahang</option>
                                    <option>Selangor</option>
                                    <option>Kelantan</option>
                                    <option>Terengganu</option>
                                    <option>Melaka</option>
                                    <option>Negeri Sembilan</option>
                                    <option>Johor</option>
                                    <option>Sabah</option>
                                    <option>Sarawak</option>
                                </select>
                            </label>

                            <label>
                            Zip Code
                            <input type="number"  value="<?php echo $_SESSION['row']['zipCode']; ?>" required>
                            </label>
                        </div>
                    
                        <div class="button-group">
                            <button class="return-button" onclick="returnToMenu()">Return to Menu</button>
                        </div> 
                    </form> 
                    <input type="submit" onclick="proceedToCheckout()" value="Proceed to Checkout">
                </div>
            </div>
        <script>
            function returnToMenu() {
                window.location.href = 'http://localhost/miumiu/menu%20success%20login/menu.php';
            }

            function proceedToCheckout() {
                window.location.href = 'http://localhost/miumiu/menu%20success%20login/payment.php';
            }
        </script>
    </body>
</html>