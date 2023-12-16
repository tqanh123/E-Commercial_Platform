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
    <!-- Head content goes here -->
</head>
<body>
    <!-- Category add form -->
    <h2>Add New Category</h2>
    <form action="" method="POST">
        <label for="category_name">Category Name:</label>
        <input type="text" id="category_name" name="category_name" required><br><br>

        <input type="submit" name="add_category" value="Add Category">
    </form>
    <div class="container">
        <h3 class="mt-4">Select a Category</h3>
        <div class="list-group mt-3">
            <?php
            // Display fetched categories as links
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<div><a href='ViewProducts.php?category=".urlencode($row['Category_Name'])."' class='list-group-item list-group-item-action'>".$row['Category_Name']."</a></div>";
                }
            } else {
                echo "No categories found.";
            }
            ?>
        </div>
    </div>
</body>
</html>
