<?php

session_start();

include 'miumiuconn.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = isset($_SESSION['aduser']) ? $_SESSION['aduser'] : null;

$username = $conn->real_escape_string($username);

$sql = "SELECT * FROM `registration admin` WHERE aduser = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $_SESSION['row'] = array(
        'name' => $row['name'],
        'ademail' => $row['ademail'],
        'adphoneno' => $row['adphoneno'],        
    );
} else {
    echo "Admin not found";
}

$sqlMonthlySales = "SELECT MONTH(dateTime) AS month, SUM(totalAmount) AS totalSales
                   FROM payment
                   GROUP BY MONTH(dateTime)";

$resultMonthlySales = $conn->query($sqlMonthlySales);

if ($resultMonthlySales->num_rows > 0) {
    $monthlySales = array();
    while ($rowSales = $resultMonthlySales->fetch_assoc()) {
        $monthlySales[$rowSales['month']] = $rowSales['totalSales'];
    }

    // Define an array of month names
    $months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
} else {
    echo "No sales data available";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="logodonut.png" type="image/x-icon">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                    <img src="foxy.png" alt="">
                    <div>
                        <h3>Admin</h3>
                        <form action="adminDasboard.php">
                        <span class="las la-envelope"></span>
                        <span><?php echo $_SESSION['row']['ademail']; ?> </span>
                    </div>
                    <div>
                        <span class="las la-phone"></span>
                        <span>0<?php echo $_SESSION['row']['adphoneno']; ?></span>
                    </div>
                </div>
                </form>
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
                                Monthly Sales
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
                    Home / Admin Profile
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

                                    <form id="updateForm" action='./updateAdminDash.php' method= "post">
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
                                        <?php echo $_SESSION['row']['ademail']; ?>
                                            <span class="editemail">
                                                <input type="text" name="ademail" id="email" placeholder="Enter new email.">
                                            </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h4 class="mb-0">Phone</h4>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                    0<?php echo $_SESSION['row']['adphoneno']; ?>

                                        <span class="editphone">
                                            <input type="text" name="adphoneno" id="phone" placeholder="Enter new phoneNum.">
                                        </span>
                                    </div>
                                </div>
                                </form> 
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12"><br>
                                        <button type="button" class="custom-button">Edit</button>
                                        <button type="button" class="submit-button custom-button">Submit</button>
                                    
                                    </div>
                                </div>  
                                                            
                            </div>
                        </div>
                    </div>
                </section>

                <div class="chart-container">
                    <h1>Monthly Sales</h1>
                    <div class="bar-chart">
                        <?php
                        if (!empty($monthlySales)) {
                            $maxSales = max($monthlySales);
                            foreach ($monthlySales as $sales) {
                                // Calculate the height of the bar relative to the maximum sales
                                $height = ($sales / $maxSales) * 300; // Adjust the scaling factor as needed
                        ?>
                                <div class="bar" style="height: <?php echo $height; ?>px;"></div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="labels">
                        <?php
                        // Assuming $months is an array of month names
                        foreach ($months as $month) {
                        ?>
                            <label><?php echo $month; ?></label>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
        <script>
            $(document).ready(function () {
                $('.editname').hide();
                $('.editemail').hide();
                $('.editphone').hide();

                $('.custom-button').click(function () {
                    $('.editname').show();
                    $('.editemail').show();
                    $('.editphone').show();
                });

                $('.submit-button').click(function () {
                    
                    // Collect data from the input fields
                    var data = {
                        name: $('#name').val(),
                        ademail: $('#email').val(),
                        adphoneno: $('#phone').val(),
                    };

                    // Send an Ajax request to adminUpdate
                    $.ajax({
                        type: 'Post',
                        url: $('#updateForm').attr('action'),
                        data: data,
                        success: function (response) {
                            alert(response);
                            window.location.reload();
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });

                    $('.editname').hide();
                    $('.editemail').hide();
                    $('.editphone').hide();
                });
            });
        </script>
        <?php if (!empty($monthlySales)) { ?>
            <script>
                $(document).ready(function () {
                    var maxSales = Math.max.apply(null, <?php echo json_encode(array_values($monthlySales)); ?>);
                    $('.bar').each(function(index) {
                        var sales = <?php echo isset($monthlySales[$index + 1]) ? $monthlySales[$index + 1] : 0; ?>;
                        var height = (sales / maxSales) * 300; // Adjust the scaling factor as needed
                        $(this).css('height', height + 'px');
                    });
                });
            </script>
        <?php } ?>
    </body>
</html>

