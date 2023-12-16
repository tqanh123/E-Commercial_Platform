<?php
require_once '../includes/connect.php'; // Include the file containing database connection

$sql = "SELECT * FROM Product";
$result = $conn->query($sql);

echo "<div class='container-fluid list_product'>";
if ($result !== false && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['Product_Name'];
        $price = $row['Price'];
        $description = $row['Product_Description'];
        $product_ID = $row['Product_ID'];

        echo "<div class='card'>
                <div class='caption'>
                    <p class='product Name'> $name </p>
                    <p class='price'>Rate: <b>4</b></p>
                    <p class='price'>Price: <b>$ $price </b></p>
                    <p class='description'>Description: $description</p>
                    <button class='add' data-id='$product_ID'> add to cart </button>
                </div>
            </div>";
    }
}
echo "</div>";

// You can close the connection after use if needed
// $conn->close();
?>

<script> 
    var product_id = document.getElementsByClassName("add");
    for (var i = 0; i < product_id.length; i++) {
        product_id[i].addEventListener("click", function(event){
            var target  = event.target;
            var id = target.getAttribute("data-id");

            alert(id);
            // You can add your AJAX request here using the product ID
        })
    }
</script>
