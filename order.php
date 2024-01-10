<?php
include 'miumiuconn.php';

session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$cust_ID = isset($_SESSION['cust_ID']) ? $_SESSION['cust_ID'] : null;

// Get data totalAllorder from payment.php
$totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : 0;

// Get order_ID from the payment form
$order_ID = isset($_POST['order_ID']) ? $_POST['order_ID'] : null;

// Fetch the maximum payment ID
$sqlMaxPaymentID = "SELECT MAX(CAST(SUBSTRING(payment_ID, 4) AS SIGNED)) as maxPaymentNumber FROM payment";
$resultMaxPaymentID = mysqli_query($conn, $sqlMaxPaymentID);

$maxPaymentNumber = 0;

if ($resultMaxPaymentID && mysqli_num_rows($resultMaxPaymentID) > 0) {
    $rowMaxPaymentID = mysqli_fetch_assoc($resultMaxPaymentID);
    $maxPaymentNumber = (int)$rowMaxPaymentID['maxPaymentNumber'];
}

$newPaymentNumber = $maxPaymentNumber + 1;
$newPaymentID = 'pay' . $newPaymentNumber;

//timestamp
$dateTime = date('Y-m-d H:i:s');

// Fetch the maximum delivery ID
$sqlMaxDeliveryID = "SELECT MAX(CAST(SUBSTRING(delivery_ID, 4) AS SIGNED)) as maxDeliveryNumber FROM payment";
$resultMaxDeliveryID = mysqli_query($conn, $sqlMaxDeliveryID);

$maxDeliveryNumber = 0;

if ($resultMaxDeliveryID && mysqli_num_rows($resultMaxDeliveryID) > 0) {
    $rowMaxDeliveryID = mysqli_fetch_assoc($resultMaxDeliveryID);
    $maxDeliveryNumber = (int)$rowMaxDeliveryID['maxDeliveryNumber'];
}

$newDeliveryNumber = $maxDeliveryNumber + 1;
$newDeliveryID = 'del' . $newDeliveryNumber;

//inser data
$sql = "INSERT INTO payment (payment_ID, cust_ID, order_ID, totalAmount, dateTime, delivery_ID)
        VALUES ('$newPaymentID', '$cust_ID', '$order_ID', '$totalAmount', '$dateTime', '$newDeliveryID')";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "Payment successful!";
} else {
    echo "Error processing payment: " . $conn->error;
}

$conn->close();
?>
