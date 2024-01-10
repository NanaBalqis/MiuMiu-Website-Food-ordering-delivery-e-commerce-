<?php
session_start();

include 'miumiuconn.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Get data from the form
$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : null;
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : null;
$phoneno = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : null;
$address = isset($_POST['address']) ? $conn->real_escape_string($_POST['address']) : null;

// Get the username from the session
$username = isset($_SESSION['cust_ID']) ? $_SESSION['cust_ID'] : null;

$setClauses = array();

if (!empty($name)) {
    $setClauses[] = "`name` = '$name'";
}

if (!empty($email)) {
    $setClauses[] = "`email` = '$email'";
}

if (!empty($phoneno)) {
    $setClauses[] = "`phoneno` = '$phoneno'";
}

if (!empty($address)) {
    $setClauses[] = "`address` = '$address'";
}

if (!empty($setClauses)) {
    $setClause = implode(", ", $setClauses);
    $sql = "UPDATE `registration` SET $setClause WHERE cust_ID = '$username'";
    $result = $conn->query($sql);
    
    if ($result) {
        echo "User data updated successfully";
    } else {
        $error_message = "Error updating user data: " . $conn->error;
        error_log($error_message, 0);
        echo "Oops! Something went wrong. Please try again later.";
    }
} else {
    echo "No fields to update";
}

$conn->close();
?>