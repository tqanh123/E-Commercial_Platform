<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <div class="container">
        <h3 class="mt-4">Categories</h3>
        <div class="list-group mt-3">
            <?php
           require_once '../includes/connect.php';

            // Query to fetch all categories
            $category_query = "SELECT Category_Name FROM Category";
            $category_result = $conn->query($category_query);

            // Display fetched categories as links
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<a href='viewcategoryproducts.php?category=" . urlencode($row['Category_Name']) . "' class='list-group-item list-group-item-action'>" . $row['Category_Name'] . "</a>";
                }
            } else {
                echo "No categories found.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>
    
</body>
</html>


