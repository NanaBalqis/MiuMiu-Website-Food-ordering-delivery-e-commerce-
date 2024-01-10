
<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>sign in Admin</title>
	<link rel="icon" href="logodonut.png" type="image/x-icon">
	<link rel="stylesheet" href="style.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

	<header class="header">
		<div class="brand">
            <a href="#" class="MiuMiu">Miu Miu min.</a>
            <img src="logo.png" alt="Logo" class="logo">
        </div>
	</header>
	<div class="wrapper">
		<form action="loginAdmin.script.php" method="post" enctype="multipart/form-data">
			<h1>Sign In Admin</h1>
			<div class="input-box">
				<input type="text" name="aduser" placeholder="username" required>
				<i class='bx bxs-user'></i>
			</div>
			<div class="input-box">
				<input type="password" name="adpass" placeholder="Password" required>
				<i class='bx bxs-lock-alt'></i>
			</div>
			
			<div class="remember-forgot">
				<label><input type="checkbox"> Remember me</label>
			<a href="http://localhost/miumiu/Admin/ForgotPasswordAdmin/forgotPassAdmin.html">Forgot password?</a>
			</div>
			
			<button type="submit" value="login" name="login" class="btn">Login</button>

			<div class="register-link">
				<p>Don't have an account? <a href="http://localhost/miumiu/Admin/Registration%20Admin/RegistrationAdmin.html">Register</a></p>
			</div>
			<div class="login-as-customer">
				<p>If you are an customer? <a href="http://localhost/miumiu/sign%20in/signIn.php">Login as customer</a></p>
			</div>
		</form>
	</div>
</body>
</html>
