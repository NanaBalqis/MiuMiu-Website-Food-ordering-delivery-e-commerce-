<?php

include "miumiuconn.php";

$email = $_POST["ademail"];
$code = $_POST["adcode"];

// Check email and admin code from registration admin
$sql = "SELECT ademail FROM `registration admin` WHERE ademail = '$email' AND adcode = '$code'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $validEmail = $row["ademail"];
    $resetLink = "http:example";

    // Insert data into the "forget password" table
    $insertSql = "INSERT INTO `forgotpasswordadmin` (ademail,adcode, resetlink) VALUES ('$validEmail','$code', '$resetLink')";
    if ($conn->query($insertSql) === TRUE) {
        echo "<script>alert('Reset link has been sent to your email!'); window.location.href = 'http://localhost/miumiu/Admin/sign%20in%20admin/sign%20In%20Admin.php';</script>";
        exit();
    } else {
        echo "<script>alert('Data insertion error. ')" . $conn->error;
    }
} else {
    echo "<script>alert('Invalid email or admin code!'); window.location.href = 'http://localhost/miumiu/Admin/ForgotPasswordAdmin/forgotPassAdmin.html';</script>";
    exit();
}

$conn->close();
?>
