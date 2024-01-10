<?php
include('includes/connect.php');
session_start();

$cart_id = $_SESSION['Cart_ID'];

if (isset($_GET['search_button'])) {
    $searchQuery = $_GET['search_query'];

    $sqlSellers = "SELECT s.Seller_ID, s.Seller_Description AS Description, a.Username  
                            FROM Seller s 
                            JOIN account a ON s.Account_ID = a.Account_ID 
                            WHERE Seller_Description LIKE '%$searchQuery%' OR a.Username LIKE '%$searchQuery%' ";
    
    $sqlProducts = "SELECT p.Product_ID, p.Product_Name, p.Product_Description AS Description, p.Price, a.Username
                                FROM Product p 
                                JOIN seller s ON p.Seller_ID = s.Seller_ID 
                                JOIN account a ON s.Account_ID = a.Account_ID
                                WHERE Product_Name LIKE '%$searchQuery%'";
    $resultSellers = $conn->query($sqlSellers);
    $resultProducts = $conn->query($sqlProducts);

    $sellerResults = [];
    if ($resultSellers->num_rows > 0) {
        while ($row = $resultSellers->fetch_assoc()) {
            $sellerResults[] = $row;
        }
    }

    $productResults = [];
    if ($resultProducts->num_rows > 0) {
        while ($row = $resultProducts->fetch_assoc()) {
            $productResults[] = $row;
        }
    }
    $searchResults = array_merge($sellerResults, $productResults);

    // foreach ($searchResults as $result) {
    //     if (isset($result['Seller_ID'])) {
    //         echo "Seller ID: " . $result['Seller_ID'] . ", Description: " . $result['Description'] . "<br>";
    //     } else {
    //         echo "Product ID: " . $result['Product_ID'] . ", Name: " . $result['Product_Name'] . ", Seller: ". $result['Username']."<br>";
    //     }
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Website</title>
  <!-- bootstrap CSS link -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- font awesome link-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!--CSS file-->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!--navbar-->
  <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container-fluid">
        <img src="image/ghost_logo.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../EcommerceWebsite/user_area/home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../EcommerceWebsite/cart.php"><i
                  class="fa-solid fa-cart-shopping"></i></a>
            </li>

          </ul>
          <form class="d-flex" role="search" method="GET" action="search.php">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_query">
          <button class="btn btn-outline-success" type="submit" name="search_button">Search</button>
      </form>
        </div>
      </div>
    </nav>

    <!-- Second child-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <ul class="navbar-nav me-auto">
        <?php
  // echo session_id(); 
  // echo $_SESSION['username'];
          if (!isset($_SESSION['username'])) {
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome Guest</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/logout.php'>Logout</a></li>";
          }
      ?>
      </ul>
    </nav>
    <div class="container cart">
    <?php
    if ($resultSellers->num_rows === 0 && $resultProducts->num_rows === 0) {
        ?>
        <div class="bg-light">
            <h3 class="text-center">Items not found</h3>
        </div>
        <?php
    } else {
        foreach ($searchResults as $result) {
            if (isset($result['Seller_ID'])) {
                echo "<a href='view_seller_product.php?seller_id=" . $result['Seller_ID'] . "' class='seller-card'>";
                echo "<div class='card'>";
                echo "<div class='caption'>";
                echo "<p class='product Name'>Seller: " . $result['Username'] . "</p>";
                echo "<p class='description'>Description: " . $result['Description'] . "</p>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "<div class='card'>";
                echo "<div class='caption'>";
                echo "<p class='product Name'>" . $result['Product_Name'] . "</p>";
                echo "<p class='price'>Price: <b>$" . $result['Price'] . "</b></p>";
                echo "<p>Description: " . $result['Description'] . "</p>";
                echo "<p>Seller: " . $result['Username'] . "</p>";
                echo "<button class='add' cart-id='" . $_SESSION["Cart_ID"] . "' data-id='" . $result['Product_ID'] . "'>Add to cart</button>";
                echo "</div>";
                echo "</div>";
            }
        }
    }
    ?>
</div>

    <!--last child-->
    <div class="bg-info p-3 text-center footer" style="position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; text-align: center; padding: 10px;">
    <p>Together we make differences in 20 years || 2003-2023<p>
    </div>
    <!-- bootstrap js link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


</body>

</html>


<script> 
    var product_id = document.getElementsByClassName("add");
    for (var i = 0; i < product_id.length; i++) {
      product_id[i].addEventListener("click", function(event){
        var target  = event.target;
        var id = target.getAttribute("data-id");
        var cid = target.getAttribute('cart-id');

        // alert(cid);
            var xml = new XMLHttpRequest();
            xml.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200) { 
                    // alert(this.responseText);
                    var data = JSON.parse(this.responseText);
                    target.innerHTML = data.in_cart;
                    document.getElementById("badge").innerHTML = data.num_cart;
                }
            }

            xml.open("GET", "includes/connect.php?p_id="+id+"&c_id="+cid, true);
            xml.send();
      })
    }
</script>