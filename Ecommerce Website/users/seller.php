<?php
session_start(); // Starting the session

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "product";

// Establishing connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php"); // Redirect to login page if not logged in
//     exit();
// }



// Function to add a product for buyers
// function addProduct($product_name, $product_description, $price, $quantity, $seller_id, $category_id)
// {
//     global $conn;

//     $insert_product_query = "INSERT INTO Product.Product (Product_Name, Product_Description, Price, Product_Quantity, Category_ID) 
//     VALUES ('$product_name', '$product_description', $price, $quantity, $category_id)";

//     if ($conn->query($insert_product_query) === TRUE) {
//         return "Product added successfully!";
//     } else {
//         return "Error adding product: " . $conn->error;
//     }
// }

function addProduct($product_name, $product_description, $price, $quantity, $seller_id, $category_id)
{
    global $conn;

    // Generating a unique Product ID
    $product_id = uniqid('prod_', true);

    // Inserting the product into the Product table
    $insert_product_query = "INSERT INTO `Product` (Product_ID, Product_Name, Product_Description, Price, Product_Quantity, Category_ID) 
    VALUES ('$product_id', '$product_name', '$product_description', $price, $quantity, $category_id)";

    if ($conn->query($insert_product_query) === TRUE) {
        // Linking the product to the seller in the Account.Seller table
        $link_product_to_seller_query = "INSERT INTO Account.Seller (Account_ID, Product_ID) 
        VALUES ($seller_id, '$product_id')";

        if ($conn->query($link_product_to_seller_query) === TRUE) {
            return "Product added successfully and linked to the seller!";
        } else {
            // If linking to the seller fails, remove the previously added product to prevent duplicates
            $conn->query("DELETE FROM Product WHERE Product_ID = '$product_id'");
            return "Error linking product to the seller: " . $conn->error;
        }
    } else {
        return "Error adding product: " . $conn->error;
    }
}




// If form is submitted to add a product
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    // $seller_id = $_SESSION['seller_id']; // Get the seller's ID from the session
    $seller_id = 6;
    $category_id = $_POST['category_id'];

    $add_product_result = addProduct($product_name, $product_description, $price, $quantity, $seller_id, $category_id);
    echo "<script>alert('$add_product_result');</script>";
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
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_description">Product Description:</label>
        <textarea id="product_description" name="product_description" required></textarea><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <label for="category_id">Category ID:</label>
        <input type="number" id="category_id" name="category_id" required><br><br>

        <input type="submit" name="add_product" value="Add Product">
    </form>
</body>
</html>
