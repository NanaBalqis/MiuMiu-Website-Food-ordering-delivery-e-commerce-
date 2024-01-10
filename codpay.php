<?php
include 'miumiuconn.php';

session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = isset($_SESSION['cust_ID']) ? $_SESSION['cust_ID'] : null;
$order_ID = isset($_SESSION['order_ID']) ? $_SESSION['order_ID'] : null;

// Check if $_SESSION['cart'] is set and not empty
$cartData = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Fetch data from cart
$sql = "SELECT * FROM cart WHERE cust_ID = '$username' AND order_ID = '$order_ID'";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching data: " . $conn->error);
}

$total = 0;

// Process fetched data
while ($row = $result->fetch_assoc()) {
    $itemPrice = $row['itemPrice'];
    $quantity = $row['quantity'];

    $total += $itemPrice * $quantity;
}

//fecth delivery_ID from payment if already submitPayment
$sql = "SELECT delivery_ID FROM payment WHERE order_ID = '$order_ID'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Delivery_ID = $row['delivery_ID'];
} else {
    // Handle the case where Delivery_ID is not found
    $Delivery_ID = "N/A";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CHECKOUT</title>
    <link rel="icon" href="image/logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>
    <header class="header">
        <div class="brand">
            <a href="#" class="MiuMiu">Miu Miu.</a>
            <img src="image\logo.png" alt="Logo" class="logo">
        </div>
    </header>

    <div class="container">
        <div class="center">
            <br><h3>PAYMENT DETAILS</h3><br>
            <form method="POST" action="order.php" autocomplete="off">
                <div class="voucher-section">
                    <div class="voucher-box">
                        <label for="voucherCode">Voucher Code</label>
                        <input type="text" id="voucherCode" placeholder="Enter voucher code">
                        <button onclick="validateVoucher(event)">Apply</button>
                    </div>
                </div>
                <div class="voucher-message">
                    <span id="voucherMessage" style="display: none;"></span>
                </div>  
                <table>
                    <tr>
                        <td>Total Order</td>
                        <td class="align-right" id="totalOrderResult">RM <?php echo number_format($total, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Charge</td>
                        <td class="align-right" id="chargeResult"></td>
                    </tr>
                    <tr>
                        <td>Delivery Charge</td>
                        <td class="align-right" id="deliveryChargeResult">
                            <span id="deliveryCharge"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="align-right" id="discountResult"></td>
                    </tr>
                    <tr>
                        <td><b>Total</b></td>
                        <td class="align-right" id="totalResult">
                            <input type="hidden" name="total" value="<?php echo $total; ?>">
                            <b>RM <span id="totalAllorder"><?php echo number_format($total, 2); ?></span></b>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="order_ID" value="<?php echo $order_ID; ?>">
            </form>
            <div class="btn">
                <form action="order.php" method="post">
                    <button class="PAY" name="payment" onclick="submitPayment(event)">CONFIRM</button>
                </form>
                <button class="EXIT" name="exit" onclick="openPopup()">CHECK DELIVERY ID</button>
            </div>
            <div class="popup" id="popup">
                <img src="image\MIUMIU.png">
                <b><h2>PAYMENT SUCCESSFUL !</h2></b><br>
                <p>Thank you For Your Order!</p><br>
                <p>Your order has been placed; please wait for the delivery.</p><br>
                <p>Your Delivery ID is <b><?php echo $Delivery_ID; ?></b></p><br>
                <input type="button" value="OKAY" onclick="window.location.href='http://localhost/miumiu/main%20page/main%20page.html'">
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>
            
            $(document).ready(function () {
                calculateTotal();
            });

            function validateVoucher(event) {
                event.preventDefault();// Prevent the form from submitting

                var userEnteredCode = document.getElementById("voucherCode").value;
                var validVoucherCode = "MIUMIU623";
                var voucherMessage = document.getElementById("voucherMessage");

                if (userEnteredCode === validVoucherCode) {
                    voucherMessage.textContent = "Voucher code 20% off applied successfully!";
                } else {
                    voucherMessage.textContent = "Invalid voucher code. Please try again.";
                }

                voucherMessage.style.display = "block";

                calculateTotal();
            }

            function calculateTotal() {
                var totalOrder = <?php echo $total; ?>;
                var charge = 0.30;
                var deliveryCharge = 5.00;

                var appliedVoucher = "MIUMIU623";
                var userEnteredCode = document.getElementById("voucherCode").value;
                var discount = userEnteredCode === appliedVoucher ? 0.2 : 0; // Apply a 20% discount if the voucher matches

                var total = (totalOrder + charge + deliveryCharge) * (1 - discount);

                document.getElementById("chargeResult").textContent = "RM " + charge.toFixed(2);
                document.getElementById("deliveryChargeResult").textContent = "RM " + deliveryCharge.toFixed(2);
                document.getElementById("discountResult").textContent = "-RM " + ((totalOrder + charge + deliveryCharge) * discount).toFixed(2);

                var totalAllorderElement = document.getElementById("totalAllorder");
                if (totalAllorderElement) {
                    totalAllorderElement.textContent = total.toFixed(2);
                    updateTotal(total);
                } else {
                    console.error("Element with ID 'totalAllorder' not found.");
                }
            }
            
            function updateTotal(total) {
                console.log("Total Value:", total);

                $.ajax({
                    url: "calculateTotal.php",
                    type: "POST",
                    data: { total: total },
                    success: function (data) {
                        $(".totalAllorder").text(data);
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });

                return false;
            }

            let popup = document.getElementById("popup");

            function openPopup() {
                popup.classList.add("open-popup");
            }

            function closePopup() {
                popup.classList.remove("open-popup");
            }

            function submitPayment(event) {
                event.preventDefault();

                // Extract the necessary data
                var totalAmountElement = document.getElementById("totalAllorder");
                var order_ID = document.getElementsByName("order_ID")[0].value;

                if (totalAmountElement !== null) {
                    var totalAmount = parseFloat(totalAmountElement.textContent.replace("RM ", ""));

                    console.log("Total Amount:", totalAmount);

                    $.ajax({
                        url: "order.php",
                        type: "POST",
                        data: { totalAmount: totalAmount, order_ID: order_ID }, // Include order_ID in the data
                        success: function (response) {
                            alert('order submitted!');
                            console.log("Payment successful:", response);

                            window.location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.log("Error during payment AJAX request:", xhr.responseText);
                        }
                    });

                } else {
                    console.error("Element with ID 'totalAllorder' not found.");
                }
            }

        </script>
    </body>
</html>
