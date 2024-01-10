<?php
session_start();

include 'miumiuconn.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = isset($_SESSION['cust_ID']) ? $_SESSION['cust_ID'] : null;

// Escape the username to prevent SQL injection
$username = $conn->real_escape_string($username);
$sql = "SELECT * FROM `registration` WHERE cust_ID = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $_SESSION['row'] = array(
        'name' => $row['name'],
        'email' => $row['email'],
        'phone' => $row['phoneno'],
        'address' => $row['address'],
        
    );
} else {
    echo "User not found";
}

// Fetch payment data for each month
$sqlMonthlyExpenses = "SELECT MONTH(dateTime) AS month, SUM(totalAmount) AS totalExpense
                      FROM payment
                      WHERE cust_ID = '$username'
                      GROUP BY MONTH(dateTime)";

$resultMonthlyExpenses = $conn->query($sqlMonthlyExpenses);

if ($resultMonthlyExpenses->num_rows > 0) {
    $monthlyExpenses = array();
    while ($rowExpense = $resultMonthlyExpenses->fetch_assoc()) {
        $monthlyExpenses[$rowExpense['month']] = $rowExpense['totalExpense'];
    }
} else {
    echo "No expense data available";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="tstyle.css">
    <link rel="icon" href="logodonut.png" type="image/x-icon">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-flex">
                <img src="logodonut.png" width="50px" alt="">
            </div>
        </div>
        <div class="sidebar-main">
            <div class="sidebar-user">
                <img src="meow.png" alt="">
                     <div>
                        <h3><?php echo $_SESSION['row']['name']; ?></h3>
                        <span class="las la-envelope"></span>
                        <span><?php echo $_SESSION['row']['email']; ?></span>
                        <br>
                        <span class="las la-phone"></span>
                        <span>0<?php echo $_SESSION['row']['phone']; ?></span>
                        <span>
                    </div>
            </div>
            <div class="sidebar-menu">
                <div class="menu-head">
                    <span>Dashboard</span>
                </div>
                <ul>
                    <li>
                        <a href="">
                            <span class="las la-user-circle"></span>
                            My Profile
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="las la-chart-pie"></span>
                            Expenses
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">
        <header>
            <span class="bars">
                <span class="las la-home"></span>
                Home / User Profile
            </span>
        </header>
        <main>
            <section class="profile-dashboard">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4 class="mb-0">Full Name</h4>
                                </div>

                                <form id="updateForm" action='./updateCust.php' method= "post">
                                <div class="col-sm-9 text-secondary">
                                <?php echo $_SESSION['row']['name']; ?>
                                    <span class="editname">
                                        <input type="text" name="name" id="name" placeholder="Enter new name.">
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4 class="mb-0">Email</h4>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                <?php echo $_SESSION['row']['email']; ?>
                                    <span class="editemail">
                                        <input type="text" name="email" id="email" placeholder="Enter new email.">
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4 class="mb-0">Phone</h4>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                0<?php echo $_SESSION['row']['phone']; ?>
                                    <span class="editphone">
                                        <input type="text" name="phone" id="phone" placeholder="Enter new phoneNum.">
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h4 class="mb-0">Address</h4>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                <?php echo $_SESSION['row']['address']; ?>
                                    <span class="editaddress">
                                        <input type="text" name="address" id="address" placeholder="Enter new address.">
                                    </span>
                                </div>
                            </div>
                            </form>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12"><br>
                                    <button type="button" class="custom-button">Edit</button>
                                    <button type="button"  class="submit-button custom-button">Submit</button>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </section>
            
            <div class="container">
                <h2>Monthly Expenses</h2>
                <br><br>
                <div class="pie-row">
                    <?php
                    if (!empty($monthlyExpenses)) {
                        foreach ($monthlyExpenses as $month => $expense) {
                    ?>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

        $(document).ready(function(){

            $('.editname').hide();
            $('.editemail').hide();
            $('.editphone').hide();
            $('.editaddress').hide();

            $('.custom-button').click(function(){
                $('.editname').show();
                $('.editemail').show();
                $('.editphone').show();
                $('.editaddress').show();
            });

            $('.submit-button').click(function(){

                //collect data from fields
                var data ={
                    name: $('#name').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    address: $('#address').val(),
                };

                //send ajax request to updateCust.php
                $.ajax({
                    type: 'Post',
                    url: $('#updateForm').attr('action'),
                    data: data,
                    success: function(response){
                        alert(response); 
                        window.location.reload();
                    },
                    error: function(error){
                        console.log(error);
                    }
                });  

                $('.editname').hide();
                $('.editemail').hide();
                $('.editphone').hide();
                $('.editaddress').hide();
            });

            <?php if (!empty($monthlyExpenses)) { ?>
                <?php foreach ($monthlyExpenses as $month => $expense) { ?>
                    $('.pie-row').append('<div class="chart-container"><div class="pie animate" style="--p:' + <?php echo $expense; ?> + ';--c:#8878C3;">' + <?php echo $expense; ?> + '%</div><div class="label"><?php echo date("F", mktime(0, 0, 0, $month, 1)); ?></div></div>');
                <?php } ?>
            <?php } ?>
        });
    </script>
</body>
</html>