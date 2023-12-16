<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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


