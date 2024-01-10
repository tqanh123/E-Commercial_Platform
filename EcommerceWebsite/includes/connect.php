
<?php

$servername = "127.0.0.1:3307";
$username = "root";
$password = "1234";
$dbname = "e_commercial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['p_id'])){
    // echo "<script> alert('ok'); </script> ";
    $product_ID = $_GET['p_id'];
    $cart_id = $_GET['c_id'];
    $sql = "SELECT * FROM `cartitem` WHERE cart_ID = '$cart_id' and product_id = '$product_ID'";
    $res = mysqli_query($conn, $sql);
    $sqlcart = "SELECT * FROM `cartitem` WHERE cart_ID = '$cart_id'";
    $total_cart = mysqli_query($conn, $sqlcart);
    $cart_num = mysqli_num_rows($total_cart);
    $sqlP = "SELECT * FROM `Product` 
             WHERE Product_ID = '$product_ID'";
    $resP = mysqli_query($conn, $sqlP);
    $row = mysqli_fetch_assoc($resP);
    if (mysqli_num_rows($res) > 0) {
        $incart = "already in cart";
        echo json_encode(["num_cart" => $cart_num, "in_cart" => $incart]);
    }
    else if ($row['Product_Quantity'] == 0) {
        $incart = "this product is null";
        echo json_encode(["num_cart" => $cart_num, "in_cart" => $incart]);
    }
    else {
        
        $price = $row['Price'];
        $insert = "INSERT INTO `cartitem`(Cart_ID, Product_ID, Cart_Item_Quantity, Cart_Item_Price, Update_At)
                    VALUES('$cart_id', '$product_ID', 1, '$price', NOW())"; 
        $update_product = "UPDATE Product SET Product_Quantity = Product_Quantity - 1
                            WHERE Product_ID = '$product_ID'";
        $update = mysqli_query($conn, $update_product);

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
        $select = "SELECT * FROM `cartitem` WHERE ";
        $num = mysqli_query($conn, $select);
        $row = mysqli_fetch_assoc($num);
        $update_product = "UPDATE Product SET Product_Quantity = Product_Quantity + 1 
                                          WHERE Product_ID = '". $row['Product_ID'] ."'";
        $update = mysqli_query($conn, $update_product);
        $incart = "Remove from cart";
        echo json_encode(["num_cart" => -1, "in_cart" => $incart]);
    }

}

?>