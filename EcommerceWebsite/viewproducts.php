<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add your CSS styles here for product display */
        .product-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .product-name {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .product-price {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Products</h3>
        <div class="row">
            <?php

            include('../EcommerceWebsite/includes/connect.php');

            // Retrieve the selected category from the URL query parameter
            $category = $_GET['category'] ?? '';

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch products based on the selected category
            $sql = "SELECT Product_ID, Product_Name, Price, Product_Category FROM Product WHERE Product_Category = '$category' ";
            $result = $conn->query($sql);

            // Display products
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-4'>";
                    echo "<div class='product-item'>";
                    echo "<h3 class='product-name'>".$row['Product_Name']."</h3>";
                    echo "<p class='product-price'>Price: ".$row['Price']."</p>";
                    echo "<form method=\"post\" action=\"\">";
                    echo "<input type=\"hidden\" name=\"product_id\" value=\"".$row['Product_ID']."\">";
                    echo "<input type=\"hidden\" name=\"action\" value=\"add_to_cart\">";
                    echo "<input type=\"submit\" name=\"AddToCart\" value=\"add to cart\" class=\"btn btn-primary\">";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No products found for this category.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>


