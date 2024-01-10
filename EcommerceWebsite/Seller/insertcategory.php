<?php
require_once '../includes/connect.php';

// Function to add a new category
function addCategory($category_name)
{
    global $conn;

    // Inserting the category into the Category table
    $insert_category_query = "INSERT INTO `Category` (Category_Name) VALUES ('$category_name')";

    if ($conn->query($insert_category_query) === TRUE) {
        return "Category added successfully!";
    } else {
        return "Error adding category: " . $conn->error;
    }
}

// If form is submitted to add a category
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    $add_category_result = addCategory($category_name);
    echo "<script>alert('$add_category_result');</script>";
}
$category_query = "SELECT Category_Name FROM Category";
$category_result = $conn->query($category_query);
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
        <h3 class="text-center">Insert Category form</h3>
    </div>
    <!-- <p class="text-center">Communication is at the heart of e-commerce and community</p> -->

    <div>
        <form action="" method="POST" class="center" style="display:block; width: 70%; margin:auto">
            <div class="form-group">
                <div class="form-group">
                    <label for="inputEmail4">Product Name</label>
                    <input type="text" id="category_name" name="category_name" required><br><br>
                </div>
            <button type="submit" name="add_category" class="btn btn-primary" style="margin-top: 10px;">Add Product</button>
        </form>
    </div>
  </div>
    <!-- last child -->
    <div class="bg-info p-3 text-center footer" style="position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; text-align: center; padding: 10px;">
    <p>Together we make differences in 20 years || 2003-2023<p>
    </div>
</body>
</html>