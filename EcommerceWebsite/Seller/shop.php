<?php 
include ('../includes/connect.php');
session_start();
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
    <img src="./image/ghost_logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="add_product.php">Insert Product</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="viewproduct.php">View Product</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="insertcategory.php">Insert category</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="viewcategory.php">View Category</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="statistics.php">View Statistics</a>
        </li>
    </div>
  </div>
</nav>
   
<!-- Second child-->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <ul class="navbar-nav me-auto">
      <?php
          if (!isset($_SESSION['username'])) {
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome Guest</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='../user_area/login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='../user_area/logout.php'>Logout</a></li>";
          }
      ?>
      
  </ul>
</nav>
<!-- Third child-->
<div class="bg-light">
<h3 class="text-center">Hidden Store</h3>
<p class="text-center">Communication is at the heart of e-commerce and community</p>
</div>

<!-- <?php include '../product-display.php'; ?> -->

<!--last child-->
<div class="bg-info p-3 text-center footer">
  <p>Together we make differences in 20 years || 2003-2023<p>
</div>



<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>
