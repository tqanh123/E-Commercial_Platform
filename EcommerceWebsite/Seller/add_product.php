<?php

require_once '../includes/connect.php';
session_start(); // Starting the session

// If form is submitted to add a product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    // $seller_id = $_SESSION['seller_id']; // Get the seller's ID from the session
    $category_id = $_POST['category_id'];
    $name = $_SESSION['username'];
    $select_seller = "Select Seller_ID from `account` a, `seller` s where a.account_id = s.account_id and a.username = '$name'";
    $res = mysqli_query($conn, $select_seller);
    $row = mysqli_fetch_assoc($res);
    $seller_id = $row['Seller_ID'];

    echo "<script>alert($category_id)</script>";
    $add_product_result = "INSERT INTO `Product` (Seller_Id, Product_name, Product_Description, Price,  Category_ID,Product_Quantity, Product_Sold, Product_Ratings, Product_Status) 
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
    <!-- Head content goes here -->
</head>
<body>
    <h1>Welcome, 
        <!-- <?php 
    echo $_SESSION['username']; 
    ?> -->
    </h1>
    <!-- Seller add product form -->
    <form action="" method="POST">
        <label for="product_name">Product Name:</label>
        <input type="text"  id="product_name" name="product_name" autocomplete="off" required><br><br>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" autocomplete="off" required></textarea><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" autocomplete="off" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" autocomplete="off" required><br><br>

        <label for="category_id">Category ID:</label>
        <input type="number" id="category_id" name="category_id" autocomplete="off" required><br><br>

        <input type="submit" name="add_product" value="Add Product">
    </form>
</body>
</html>
