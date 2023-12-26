<?php
include('../includes/connect.php');
session_start();

$username = mysqli_real_escape_string($conn, $_SESSION['username']);

$sql_sellerid = "SELECT Seller.Seller_ID
                FROM Seller
                JOIN Account ON Seller.Account_ID = Account.Account_ID
                WHERE Account.Username = '$username'";

$result_sellerid = mysqli_query($conn, $sql_sellerid);

if ($result_sellerid && $row = mysqli_fetch_assoc($result_sellerid)) {

    $seller_id = $row['Seller_ID'];

    $sql_statistics = "SELECT COUNT(oi.Product_ID) AS Total_Products_Bought, SUM(oi.Price) AS Total_Price_Sold
                        FROM `Order_Items` oi
                        JOIN `Product` p ON oi.Product_ID = p.Product_ID
                        JOIN `Order` o ON oi.Order_ID = o.Order_ID
                        WHERE p.Seller_ID = $seller_id";

    $result_statistics = mysqli_query($conn, $sql_statistics);

    if ($result_statistics && $row = mysqli_fetch_assoc($result_statistics)) {
        $total_products_bought = $row['Total_Products_Bought'];
        $total_price_sold = $row['Total_Price_Sold'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    $sql_product_statistics = "SELECT p.Product_ID, p.Product_Name, COUNT(oi.Product_ID) AS Total_Sold, SUM(oi.Price) AS Total_Price_Sold
                                FROM `Order_Items` oi
                                JOIN `Product` p ON oi.Product_ID = p.Product_ID
                                JOIN `Order` o ON oi.Order_ID = o.Order_ID
                                WHERE p.Seller_ID = $seller_id
                                GROUP BY p.Product_ID, p.Product_Name";

    $result_product_statistics = mysqli_query($conn, $sql_product_statistics);

//     if ($result_product_statistics) {
//         echo "<h2>Statistics for Products Sold by the Seller:</h2>";
//         echo "<table border='1'>
//                 <tr>
//                     <th>Product ID</th>
//                     <th>Product Name</th>
//                     <th>Total Sold</th>
//                     <th>Total Price Sold</th>
//                 </tr>";

//         while ($row = mysqli_fetch_assoc($result_product_statistics)) {
//             echo "<tr>";
//             echo "<td>" . $row['Product_ID'] . "</td>";
//             echo "<td>" . $row['Product_Name'] . "</td>";
//             echo "<td>" . $row['Total_Sold'] . "</td>";
//             echo "<td>" . $row['Total_Price_Sold'] . "</td>";
//             echo "</tr>";
//         }

//         echo "</table>";
//     } else {
//         echo "Error: " . mysqli_error($conn);
//     }
// } else {
//     echo "Query failed or no result found: " . mysqli_error($conn);
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
     integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
     <!--CSS file-->
     <link rel="stylesheet" href="../style.css">
    </head>
<body>
<!--navbar-->
<div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
    <img src="../image/ghost_logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Contact</a>
        </li>
        <li class="nav-item">
          
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
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
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='../user_area/login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='logout.php'>Logout</a></li>";
          }
      ?>
  </ul>
</nav>
<!-- Third child-->
<div class="bg-light">
    <h3 class="text-center">Hidden Store</h3>
    <p class="text-center">Communication is at the heart of e-commerce and community</p>
    <div>
            <?php
                echo "<h2>Total products bought from this seller: $total_products_bought</h2>";
                echo "<h2>Total price of products sold by this seller: $total_price_sold</h2>";
            ?>
        </div>

        <!-- Displaying product statistics in a table -->
        <div>
            <?php

            if ($result_product_statistics) {
                echo "<h2>Statistics for Products Sold by the Seller:</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Total Sold</th>
                            <th>Total Price Sold</th>
                        </tr>";

                while ($row = mysqli_fetch_assoc($result_product_statistics)) {
                    echo "<tr>";
                    echo "<td>" . $row['Product_ID'] . "</td>";
                    echo "<td>" . $row['Product_Name'] . "</td>";
                    echo "<td>" . $row['Total_Sold'] . "</td>";
                    echo "<td>" . $row['Total_Price_Sold'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "Error fetching product statistics: " . mysqli_error($conn);
            }
            ?>
        </div>
<!--last child-->
<div class="bg-info p-3 text-center footer">
  <p>Together we make differences in 20 years || 2003-2023<p>
      </div>
<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>
</html>
