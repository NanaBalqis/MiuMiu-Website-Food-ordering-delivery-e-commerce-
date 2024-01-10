<?php
include 'miumiuconn.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT item.*, category.categoryName FROM item
        JOIN category ON item.category_ID = category.category_ID";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Menu</title>
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="icon" href="image/logo.png" type="image/x-icon">
</head>
<body>
  <div class="container">
    <header class="header">
      <div class="brand">
        <a href="#" class="MiuMiu">Miu Miu.</a>
        <img src="image/logo.png" alt="Miu Miu Logo" class="logo">
      </div>
        <div class="LogIn">
          <a href="http://localhost/miumiu/sign%20in/signIn.php">Sign In</a>
        </div>
      <!--<div class="favourite">
        <a href="#">
          <i class='bx bxs-heart'></i>
        </a>
      </div>
      <div class="cart">
        <a href="http://localhost/miumiu/Cart/Cart.html">
          <i class='bx bxs-cart'></i>
        </a>
      </div>
      <div class="log-out">
        <a href="http://localhost/miumiu/main%20page/main%20page.html">
          <i class='bx bx-log-out'></i>
        </a>
      </div>-->
    </header>

    <section class="banner">
      <div class="slider-wrapper">
        <div class="slider">
          <img id="slide-1" src="image/banner1.jpg" alt="banner1" />
          <img id="slide-2" src="image/banner2.jpg" alt="banner2" />
          <img id="slide-3" src="image/banner3.jpg" alt="banner3" />
        </div>
        <div class="slider-nav">
          <a href="#slide-1"></a>
          <a href="#slide-2"></a>
          <a href="#slide-3"></a>
        </div>
      </div>
    </section>

    <div id="menu">
        <h1 id="section">Menu</h1>
        <section class="filters">
            <h2>Filters</h2>
            <div class="filter-container">
                <div class="filter-group">
                    <label for="categoryFilter">Category:</label>
                    <select id="categoryFilter" name="selectedCategory">
                      <option value="all">All</option>
                      <option value="C">Cakes</option>
                      <option value="CR">Croffle</option>
                      <option value="PS">Pastries</option>
                      <option value="DF">Deep Fried</option>
                      <option value="NC">Non-Coffee</option>
                      <option value="CF">Coffee</option>
                    </select>
                    <div class="offer" id="offerToggle">
                      <label>Show Offers:</label>
                      <label class="switch">
                          <input type="checkbox">
                          <span class="slider round"></span>
                      </label>
                    </div>
                </div>
            </div>
        </section>

         <div id="menu_row">
            <?php
                $currentCategory = null;

                while ($row = $result->fetch_assoc()) {
                    
                    if ($row['categoryName'] !== $currentCategory) {
        
                        if ($currentCategory !== null) {
                            echo '</div>';
                        }
                        echo '<div id="menu_col">';
                        echo '<h2>' . $row['categoryName'] . '</h2>';
                        $currentCategory = $row['categoryName'];
                    }

                    echo '<div class="menu-box" data-category="' . $row['category_ID'] . '" data-price="' . $row['itemPrice'] . '">';
                    echo '<div class="menu-image">';
                    echo '<img src="' . $row['image_path'] . '" alt="' . $row['itemName'] . '">';
                    echo '</div>';
                    echo '<div class="menu-details">';
                    echo '<h3>' . $row['itemName'] . '</h3>';
                    echo '<h4>RM' . $row['itemPrice'] . '</h4>';
                    echo '<i class="bx bxs-cart-add"></i>';
                    echo '<i class="bx bxs-heart"></i>';
                    echo '</div>';
                    echo '</div>';
                }

                echo '</div>';
            ?>
        </div>
    </div>
</div>

<form action="item.php" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" id="selectedCategory" name="selectedCategory" value="all">
    <input type="hidden" id="selectedPrice" name="selectedPrice" value="all">
</form>

  <script>
    //redirect to sign-in
    function redirectToSignIn() {
      window.location.href = 'http://localhost/miumiu/sign%20in/signIn.php';
    }
  
    // Attach click
    document.querySelectorAll('.bxs-cart-add, .bxs-heart').forEach(function (button) {
      button.addEventListener('click', redirectToSignIn);
    });
  </script>
  
    
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // refer filter
      const categoryFilter = document.getElementById('categoryFilter');
      const offerToggle = document.getElementById('offerToggle'); 

      // refer menu
      const menuItems = document.querySelectorAll('.menu-box');

      // change filter
      function applyFilters() {
        const selectedCategory = categoryFilter.value;
        const showOffers = offerToggle.checked; 

        menuItems.forEach(function (item) {
          const category = item.getAttribute('data-category');
          const hasOffer = item.classList.contains('offer'); 

          const categoryMatch = selectedCategory === 'all' || selectedCategory === category;

          const offerMatch = !showOffers || (showOffers && hasOffer);

          if (categoryMatch && offerMatch) {
            item.style.display = 'block';
          } else {
            item.style.display = 'none';
          }
        });
      }

      categoryFilter.addEventListener('change', applyFilters);
      offerToggle.addEventListener('change', applyFilters); 
    });
  </script>  
</body>
</html>