<?php

include "miumiuconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST["cust_ID"]) ? $_POST["cust_ID"] : "";
    $password = isset($_POST["pass"]) ? $_POST["pass"] : "";

    if (!empty($username) && !empty($password)) {
        $stmt = $conn->prepare("SELECT cust_ID, pass FROM registration WHERE cust_ID = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        if (!$stmt) {
            die("Error executing the query: " . $conn->error);
        }

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($custID, $storedPassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $storedPassword)) {

                session_unset();
                session_destroy();
                session_start();
            
                // Set loggedIn to true
                $_SESSION['loggedIn'] = true;
            
                // Store cust_ID in session
                $_SESSION['cust_ID'] = $custID;

                // Initialize $_SESSION
                $_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
                $_SESSION['fav'] = isset($_SESSION['fav']) ? $_SESSION['fav'] : array();
                $_SESSION['total'] = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
                $_SESSION['checkout'] = isset($_SESSION['checkout']) ? $_SESSION['checkout'] : array();
            
                echo "<script>alert('Successfully Login!'); window.location.href = 'http://localhost/miumiu/menu%20success%20login/menu.php';</script>";
                exit();
            } else {
                echo "<script>alert('Invalid password. Please try again.'); window.location.href = 'http://localhost/miumiu/sign%20in/signIn.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('User not found.'); window.location.href = 'http://localhost/miumiu/sign%20in/signIn.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please provide both username and password.'); window.location.href = 'http://localhost/miumiu/sign%20in/signIn.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>sign in</title>
    <link rel="icon" href="logodonut.png" type="image/x-icon">
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

	<header class="header">
		<div class="brand">
            <a href="#" class="MiuMiu">Miu Miu.</a>
            <img src="logodonut.png" alt="Logo" class="logo">
        </div>
	</header>
	<div class="wrapper">
		<form action="signIn.php" method="post" enctype="multipart/form-data">
			<h1>Sign In</h1>
			<div class="input-box">
				<input type="text" name="cust_ID" placeholder="Username" required>
				<i class='bx bxs-user'></i>
			</div>
			<div class="input-box">
				<input type="password" name="pass" placeholder="Password" required>
				<i class='bx bxs-lock-alt'></i>
			</div>
			
			<div class="remember-forgot">
				<label><input type="checkbox"> Remember me</label>
			<a href="http://localhost/miumiu/ForgotPassword/forgotPass.html">Forgot password?</a>
			</div>
			
			<button type="submit" class="btn">Login</button>
			<div class="register-link">
				<p>Don't have an account? <a href="http://localhost/miumiu/Registration/Registration.html">Register</a></p>
			</div>
			<div class="login-as-admin">
				<p>If you are an admin? <a href="http://localhost/miumiu/Admin/sign%20in%20admin/sign%20in%20admin.php">Login as admin</a></p>
			</div>
		</form>
	</div>
</body>
</html>

