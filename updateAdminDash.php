<?php

session_start();

include 'miumiuconn.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get data from the form
$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : null;
$ademail = isset($_POST['ademail']) ? $conn->real_escape_string($_POST['ademail']) : null;
$adphoneno = isset($_POST['adphoneno']) ? $conn->real_escape_string($_POST['adphoneno']) : null;

// Get the username from the session
$username = isset($_SESSION['aduser']) ? $_SESSION['aduser'] : null;

$setClauses = array();

if (!empty($name)) {
    $setClauses[] = "`name` = '$name'";
}

if (!empty($ademail)) {
    $setClauses[] = "`ademail` = '$ademail'";
}

if (!empty($adphoneno)) {
    $setClauses[] = "`adphoneno` = '$adphoneno'";
}


// Update only the specified fields in the database
if (!empty($setClauses)) {
    $setClause = implode(", ", $setClauses);
    $sql = "UPDATE `registration admin` SET $setClause WHERE aduser = '$username'";
    $result = $conn->query($sql);

    if ($result) {
        echo "User data updated successfully";
    } else {
        echo "Error updating user data: " . $conn->error;
    }
} else {
    echo "No fields to update";
}

$conn->close();
?>
