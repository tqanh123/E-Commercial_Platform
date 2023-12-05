<?php
// $host_name = "localhost";
// $username = "root";
// $password = "";
// $db_name = "e_commercial";

// // create connection
// $conn = new mysqli($host_name, $username, $password, $db_name);

// // check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
require_once '../EcommerceWebsite/includes/connect.php';

// select all product data from database
$sql = "SELECT Product.Product_ID, Product.Product_Name, Product.Price FROM Product";
$result = $conn->query($sql);

// generate HTML code to display products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-item'>";
    // echo "<img src='".$row['image']."' alt='".$row['name']."' class='product-image'>";
    echo "<h3 class='product-name'>".$row['Product_Name']."</h3>";
    echo "<p class='product-price'>Price: ".$row['Price']."</p>";
    echo "<form method=\"post\" action=\"cart.php\">";
    echo "<input type=\"hidden\" name=\"product_id\" value=\"".$row['Product_ID']."\">";
    echo "<input type=\"submit\" name=\"add_to_cart\" value=\"Add to Cart\">";
    echo "</form>";
    echo "</div>";
    }
}

// close connection
$conn->close();
?>
