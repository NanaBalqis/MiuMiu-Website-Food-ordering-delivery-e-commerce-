<?php
session_start();
include 'miumiuconn.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve cust_ID from the session
$cust_ID = $_SESSION['cust_ID'];

// Select items from favorite table for the current customer
$sql = "SELECT f.*, i.image_path 
        FROM favorite f
        JOIN item i ON f.item_ID = i.item_ID
        WHERE f.cust_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $cust_ID);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite</title>
    <link rel="icon" href="image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style4.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        function removeFavorite(cust_ID, product_id) {
            console.log("Removing favorite. Cust_ID:", cust_ID, "Product_ID:", product_id);

            $.ajax({
                url: "fav-request.php",
                type: "POST",
                data: {
                    cust_ID: cust_ID,
                    product_id: product_id,
                    action: 'delete',
                },
                dataType: "json",
                success: function (response) {
                    console.log("Response:", response);

                    if (response.status == "success") {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr, status, error);
                }
            });
        }
    </script>
</head>

<body class="">
    <div class="container">
        <header>
            <div class="title">FAVORITE LIST</div>
        </header>
        <div class="listProduct">
            <?php
                while ($row = $result->fetch_assoc()) {
                    // Display your favorite items here
                    echo '<div class="favorite-item">';
                    echo '<div class="favorite-item-image">';
                    echo '<img src="' . $row['image_path'] . '" alt="' . $row['itemName'] . '">';
                    echo '</div>';
                    echo '<div class="favorite-item-details">';
                    echo '<h3>' . $row['itemName'] . '</h3>';
                    echo '<h4> RM ' . $row['itemPrice'] . '</h4>';
                    echo '<div class="remove-favorite">';
                    echo '<button class="remove-btn" onclick="removeFavorite(\'' . $cust_ID . '\', \'' . $row['item_ID'] . '\')">Remove</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }                

                if ($result->num_rows == 0) {
                    echo '<p>No items in favorites.</p>';
                }
            ?>
        </div>
    </div>
</body>
</html>
