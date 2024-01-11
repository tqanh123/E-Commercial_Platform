<?php

require_once '../includes/connect.php';
session_start(); // Starting the session

// If form is submitted to add a product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    // $seller_id = $_SESSION['seller_id']; 
    $category_id = $_POST['category_id'];
    $name = $_SESSION['username'];
    $select_seller = "Select Seller_ID from `account` a, `seller` s where a.account_id = s.account_id and a.username = '$name'";
    $res = mysqli_query($conn, $select_seller);
    $row = mysqli_fetch_array($res);
    $seller_id = $row['Seller_ID'];
    
    // echo "<script>alert($category_id)</script>";
   $add_product_result = "INSERT INTO `Product` (Seller_ID, Product_name, Product_Description, Price,  Category_ID,Product_Quantity, Product_Sold, Product_Ratings, Product_Status) 
                           VALUES ('$seller_id', '$product_name', '$product_description', '$price', '$category_id', '$quantity', 0, 0, 'available')";
    $done = mysqli_query($conn, $add_product_result);

    if ($done) {
        echo "<script>alert('add succesfully $add_product_result')</script>";
        echo "<script>window.open('shop.php','_self')</script>";
    }
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
            <a class="nav-link active" aria-current="page" href="shop.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="add_product.php">Insert Product</a>
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
</div>
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

  <!-- Seller add product form -->
  <div class="bg-light" style="">
    <div>
        <h3 class="text-center">Insert product form</h3>
    </div>
    <!-- <p class="text-center">Communication is at the heart of e-commerce and community</p> -->

    <div>
        <form action="" method="POST" class="center" style="display:block; width: 70%; margin:auto">
            <div class="form-group">
                <div class="form-group">
                    <label for="inputEmail4">Product Name</label>
                    <input type="text" class="form-control" id="name" name="product_name" autocomplete="off" required placeholder="Iphone 15 promax">
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="inputEmail4">Product Description</label>
                    <input type="text" class="form-control" id="product_description" name="product_description" autocomplete="off" required placeholder="gray 2TB">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="inputEmail4">Price</label>
                    <input type="number" class="form-control" id="price" name="price" autocomplete="off" required placeholder="99">
                </div>
                <div class="form-group">
                    <label for="inputEmail4">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" autocomplete="off" required placeholder="100">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputState">Categories</label>
                <!-- <select id="inputState" class="form-control"> -->
                <select id = "category_id" name="category_id" class="form-control">
                    <option>Select Categories</option>
                    <?php
                    //fetch all categories
                    $category_query = "SELECT Category_Name, Category_ID FROM Category";
                    $res = $conn->query($category_query);
                    while ($row = $res->fetch_object()) {
                    ?>
                        <option class="form-control" value=" <?php echo $row->Category_ID ?> ">;
                            <?php echo $row->Category_Name ?>
                        </option>;
                    <?php } ?>
                </select>
                    <!-- <option selected>Choose...</option>
                    <option>...</option>
                </select> -->
            </div>
            <button type="submit" name="add_product" class="btn btn-primary" style="margin-top: 10px;">Add Product</button>
        </form>
    </div>
  </div>
    <!-- last child -->
    <div class="bg-info p-3 text-center footer" style="position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; text-align: center; padding: 10px;">
    <p>Together we make differences in 20 years || 2003-2023<p>
    </div>
</body>
</html>
