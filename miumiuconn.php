<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miumiu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect to mainpage.html
header("Location: http://localhost/miumiu/main%20page/main%20page.html");
exit;
?>
