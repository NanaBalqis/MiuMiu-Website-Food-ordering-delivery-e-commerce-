<?php

include "miumiuconn.php";

$email = $_POST["email"];


//Check email from registration
//ambil emai dari registration table
$sql = "SELECT email FROM registration WHERE email = '$email'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    //Send email to user
    $validEmail = $row["email"];
    $resetLink = "http:resetLink.com";

    //Insert data into forget password table 
    $insertSql = "INSERT INTO `forgotpassword` (email, resetlink) VALUES ('$validEmail', '$resetLink')";
    if ($conn->query($insertSql) === TRUE){
    echo "<script>alert('Reset link has been sent to your email!'); window.location.href = 'http://localhost/miumiu/sign%20in/signIn.php';</script>";
    exit();
} else {
    echo "<script>alert('Request not submitted. ')". $conn->error;
}

} else {
    echo "<script>alert('Email not found!'); window.location.href = 'http://localhost/miumiu/ForgotPassword/forgotPass.html';</script>";
    exit();
}

$conn->close();
?>

