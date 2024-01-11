<?php
// require_once '../includes/connect.php';

// select all product data from database
$sql = "SELECT * FROM Product";
$result = $conn->query($sql);

echo "<div class='container-fluid list_product'>";
// generate HTML code to display products
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['Product_Name'];
        $price = $row['Price'];
        $description = $row['Product_Description'];
        $product_ID = $row['Product_ID'];

        // <form method='post' action='/EcommerceWebsite/cart.php'>
        echo "<div class='card'>
                <div class='caption'>
                    <p class='product Name'> $name </p>
                    <p class='price'>Price: <b>$ $price </b></p>
                    <p class='description'>Description: $description</p>
                    <button class='add' data-id = ' <?php echo $product_ID ?> '> add to cart </button>
                </div>
            </div>";
        // </form>
        //     echo "<div class='product-item'>";
        // // echo "<img src='".$row['image']."' alt='".$row['name']."' class='product-image'>";
        // echo "<h3 class='product-name'>".."</h3>";
        // echo "<p class='product-price'>Price: ".$row['Price']."</p>";
        // echo "<form method=\"post\" action=\"/EcommerceWebsite/cart.php\">";
        // echo "<input type=\"hidden\" name=\"product_id\" value=\"".$row['Product_ID']."\">";
        // echo "<input type=\"hidden\" name=\"action\" value=\"add_to_cart\">";
        // echo "<input type=\"submit\" name=\"AddToCart\" value=\"add to cart\">";
        // echo "</form>";
        // echo "</div>";
    }
}
echo "</div>";
// // close connection
// $conn->close();
?>

<script> 
    var product_id = document.getElementsByClassName("add");
    for (var id = 0; i < product_id.length; i++) {
        product_id[id].addEventListener("click", function(event){
            var target  = event.target;
            var id = target.getAttribute("data-id");

            alert(id);
            // var xml = new XMLHttpRequest();
            // xml.onreadystatechange = function(){
            //     if (this.readyState == 4 && this.status == 200) {
            //         alert(this.responseText);
            //     }
            // }

            // xml.open("GET", "connection.php?p_id="+id, true);
            // xml.send();
        })
    }
</script>