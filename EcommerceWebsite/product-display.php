<?php
include('../EcommerceWebsite/includes/connect.php');

// select all product data from database
$sql = "SELECT Product_ID, Product_Name, Price FROM Product";
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
    echo "<input type=\"hidden\" name=\"action\" value=\"add_to_cart\">";
    echo "<input type=\"submit\" name=\"AddToCart\" value=\"add to cart\">";
    echo "</form>";
    echo "</div>";
    }
}

// close connection
$conn->close();
?>
