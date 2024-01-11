<?php
include('../includes/connect.php');
session_start();

$username = $_SESSION['username'];

if (isset($_GET['order_id'])) {
  $order_id = $_GET['order_id'];
    
  $get_order_items_query = "SELECT * FROM order_items WHERE Order_ID = '$order_id'";

  $order_items_result = mysqli_query($conn, $get_order_items_query);
}
if ($order_items_result) {
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
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <!--navbar-->
  <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container-fluid">
        <img src="../image/ghost_logo.png" alt="" class="logo">
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
              <a class="nav-link active" aria-current="page" href="user_orders.php">Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../cart.php"><i
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
    <div class="bg-light">
      <h3 class="text-center">All my order</h3>
    </div>

    <div class="container cart">
  <table class="table table-bordered mt-5">
    <thead class="bg-info">
      <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
      </tr>
    </thead>
    <tbody class="bg-secondary text-light">
      <?php

        while ($row = mysqli_fetch_assoc($order_items_result)) {
          ?>
          <tr>
          <td><?php echo $row['Product_ID'] ?></td>
          <td><?php echo $row['Product_Name'] ?></td>
          <td><?php echo $row['Product_Quantity'] ?></td>
          <td><?php echo $row['Price'] ?></td>
          </tr>
          <?php
        }
      }
      ?>
    </tbody>
  </table>
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

    