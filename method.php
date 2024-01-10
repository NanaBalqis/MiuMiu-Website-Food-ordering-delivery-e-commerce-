<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width,initial-scale=1.0">
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	    <title>PAYMENT</title>
		<link rel="icon" href="image/logo.png" type="image/x-icon">
	    <link rel="stylesheet" href="style2.css">
    </head>
<body>
    <header class="header">
		<div class="brand">
            <a href="#" class="MiuMiu">Miu Miu.</a>
            <img src="image\MIUMIU.png" alt="Logo" class="logo">
        </div>
	</header>

    <div class="container">
        <div class="title">
            <h4>Select a <span style="color: rgb(217, 72, 132)">Payment</span> method</h4>
        </div>
        
        <form action="#">
            <input type="radio" name="payment" id="visa" onclick="redirectToCardPage('visa')">
			<input type="radio" name="payment" id="mastercard" onclick="redirectToCardPage('mastercard')">
			<input type="radio" name="payment" id="paypal" onclick="redirectToCardPage('paypal')">
			<input type="radio" name="payment" id="cod" onclick="redirectToCardPage('cod')">

						<div class="category">
							<label for="visa" class="visaMethod">
								<div class="imgName">
									<div class="imgContainer visa">
										<img src="image\VISA.png" alt="">
									</div>
									<span class="name">VISA</span>
                                </div>
									<span class="check"><i class="fa-solid fa-circle-check" style="color: #d94884;"></i></span>
                                </label>

							<label for="mastercard" class="mastercardMethod">
								<div class="imgName">
									<div class="imgContainer mastercard">
										<img src="image\MASTERCARD.jpg" alt="">
									</div>
									<span class="name">MASTERCARD</span>
                                </div>
									<span class="check"><i class="fa-solid fa-circle-check" style="color: #d94884;"></i></span>	
							</label>

							<label for="paypal" class="paypalMethod">
								<div class="imgName paypal">
									<div class="imgContainer">
										<img src="image\PP.jpeg" alt="">
									</div>
									<span class="name">PAYPAL</span>
                                </div>
									<span class="check"><i class="fa-solid fa-circle-check" style="color: #d94884;"></i></span>	
							</label>

							<label for="cod" class="codMethod">
								<div class="imgName cod">
									<div class="imgContainer">
										<img src="image\COD.jpg" alt="">
									</div>
									<span class="name">CASH ON DELIVERY</span>
                                </div>
									<span class="check"><i class="fa-solid fa-circle-check" style="color: #d94884;"></i></span>	
							</label>
						</div>
        </form>
    </div>
    <script>
        function redirectToCardPage(selectedPayment) {
            if (selectedPayment === 'visa' || selectedPayment === 'mastercard') {
                window.location.href = 'http://localhost/miumiu/menu%20success%20login/card.php'; 
            }
            if (selectedPayment === 'paypal'){
                window.location.href = 'http://localhost/miumiu/menu%20success%20login/online.php?'
            }
            if (selectedPayment === 'cod'){
                window.location.href = 'http://localhost/miumiu/menu%20success%20login/cash.php'
            }
        }
    </script>    
</body>
</html>