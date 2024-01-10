<?php
include "miumiuconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $username = isset($_POST["cust_ID"]) ? $_POST["cust_ID"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $num = isset($_POST["phoneno"]) ? $_POST["phoneno"] : "";
    $password = isset($_POST["pass"]) ? $_POST["pass"] : "";
    $confirmpassword = isset($_POST["confirmpass"]) ? $_POST["confirmpass"] : "";
    $address = isset($_POST["address"]) ? $_POST["address"] : "";
    $city = isset($_POST["city"]) ? $_POST["city"] : "";
    $zipCode = isset($_POST["zipCode"]) ? $_POST["zipCode"] : "";

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $hashPassword = password_hash($confirmpassword, PASSWORD_DEFAULT);

    // Insert data
    $sql = "INSERT INTO registration (name, cust_ID, email, phoneno, pass, confirmpass, address, city, zipCode) 
            VALUES ('$name', '$username', '$email', '$num', '$hashedPassword', '$hashPassword', '$address', '$city', '$zipCode')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully'); window.location.href = 'http://localhost/miumiu/sign%20in/signIn.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: No data submitted.'); window.location.href = 'http://localhost/miumiu/Registration/Registration.html';</script>";
        error_log("Error: " . $sql . "<br>" . $conn->error);
        exit();
    }
}

$conn->close();
?>
