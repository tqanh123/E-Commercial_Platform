
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e_commercial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['p_id'])){
    $product_ID = $_GET['p_id'];
    $cart_id = $_GET['c_id'];
    $sql = "SELECT * FROM `cartitem` WHERE cart_ID = '$cart_id' and product_id = '$product_ID'";
    $res = mysqli_query($conn, $sql);
    $sqlcart = "SELECT * FROM `cartitem` WHERE cart_ID = '$cart_id'";
    $total_cart = mysqli_query($conn, $sqlcart);
    $cart_num = mysqli_num_rows($total_cart);

    if (mysqli_num_rows($res) > 0) {
        $incart = "already in cart";
        echo json_encode(["num_cart" => $cart_num, "in_cart" => $incart]);
    }
    else {
        $sqlP = "SELECT * FROM `Product` 
                WHERE Product_ID = '$product_ID'";
        $resP = mysqli_query($conn, $sqlP);
        $row = mysqli_fetch_assoc($resP);
        $price = $row['Price'];
        $insert = "INSERT INTO `cartitem`(Cart_ID, Product_ID, Cart_Item_Quantity, Cart_Item_Price, Create_At, Update_At)
                    VALUES('$cart_id', '$product_ID', 1, '$price', NOW(), NOW())"; 

        if ($conn -> query($insert)) {
            $cart_num += 1;
            $incart = "added into cart";
            echo json_encode(["num_cart" => $cart_num, "in_cart" => $incart]);
        }
        else 
            echo "<script> alert(Doesn't insert) </script>";
    } 

}

if (isset($_GET['ci_id']) ){
    $cartitem_id = $_GET['ci_id'];
    $sql = "DELETE FROM `cartitem` WHERE Cart_Item_ID = '$cartitem_id'";
    
    if ($conn -> query($sql) === true) {
        // $select = "SELECT * FROM `cartitem WHERE "
        // $num = mysqli_num_rows($sql);
        $incart = "Remove from cart";
        echo json_encode(["num_cart" => -1, "in_cart" => $incart]);
    }

}

?>