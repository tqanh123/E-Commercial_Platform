<?php 
require_once '../History.php';
include ('../includes/connect.php');
session_start();

    $name = $_SESSION['username'];
    $cart_id = $_SESSION['Cart_ID'];
    $total_price = 0;

    $total_price_per_item = 0;
    $select_data =" SELECT ci.Cart_Item_Price, ci.Cart_Item_Quantity, c.Customer_ID 
                                FROM `cartitem` ci
                                JOIN `cart` c ON ci.cart_id = c.cart_id
                                WHERE ci.cart_id = $cart_id";
    $result= mysqli_query($conn,$select_data);
    while($row_fetch = mysqli_fetch_assoc($result)) {
        $item_price = $row_fetch['Cart_Item_Price'];
        $quantity = $row_fetch['Cart_Item_Quantity'];
        $customer_id = $row_fetch['Customer_ID'];
        $total_price_per_item += $item_price * $quantity;

        $total_price += $total_price_per_item;
        
        $product_name = $row_fetch['Product_Name'];
        $seller_id = $row_fetch['Seller_ID'];
    }

if(isset ($_POST['confirm_payment'])){
    $payment_type = $_POST ['payment_type'];

    $update_orders="INSERT INTO `order` (Customer_ID, Total_Order_Value, Order_Date, Order_Status)
    VALUES ('$customer_id', '$total_price_per_item', NOW(), 'shipping')";

    $result_orders= mysqli_query($conn, $update_orders);
    $order_id = mysqli_insert_id($conn);

    $insert_query="INSERT INTO `payments` (Order_ID, Payment_Type, Payment_Value)
                                VALUES  ($order_id, '$payment_type', $total_price_per_item)";
    $result= mysqli_query($conn, $insert_query);
    if ($result) {
        echo "<h3 class=' text-center text-light'>Successfully completed the payment </h3>";
        FinishPayment($cart_id, $order_id);
        
    }
}

    Function FinishPayment($cart_id, $order_id) {
        global $conn;
        $select_cart_items_query = "SELECT * FROM `cartitem` WHERE cart_id = $cart_id";
        $cart_items_result = mysqli_query($conn, $select_cart_items_query);

        if ($cart_items_result && mysqli_num_rows($cart_items_result) > 0) {
        
            mysqli_begin_transaction($conn);
    
            try {
                // Insert cart items into order_item table
                while ($row = mysqli_fetch_assoc($cart_items_result)) {
                    $product_id = $row['Product_ID'];
                    $quantity = $row['Cart_Item_Quantity'];
                    $price = $row['Cart_Item_Price'];
    
                    // Insert into order_item table
                    $insert_order_item_query = "INSERT INTO `order_items` (Order_ID, Product_ID, Product_Quantity, Price)
                                               VALUES ($order_id, $product_id, $quantity, $price)";
                    $insert_result = mysqli_query($conn, $insert_order_item_query);
    
                    if (!$insert_result) {
                        throw new Exception("Error inserting into order_item table");
                    }
                }
    
                $delete_cart_items_query = "DELETE FROM `cartitem` WHERE cart_id = $cart_id";
                $delete_result = mysqli_query($conn, $delete_cart_items_query);
    
                if (!$delete_result) {
                    throw new Exception("Error deleting cart items");
                }
                mysqli_commit($conn);

                recordHistory($customer_id, $seller_id, $order_id, $product_name);
            }
            catch (Exception $e) {
                // Rollback transaction on any error
                mysqli_rollback($conn);
                echo "Transaction failed: " . $e->getMessage();
            }
        } else {
            echo "No cart items found for cart ID: $cart_id";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom styles */

        .price-box {
            border: 1px solid #ccc;
            padding: 10px;
            width: 150px;
            /* Adjust the width as needed */
            text-align: center;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 50%;
            margin: 0 auto;
        }

        .form-group label {
            color: #fff;
        }

        .btn-confirm {
            margin-top: 1rem;
        }
    </style>
</head>

<body class="bg-secondary">
    <h1 class="text-center text-light">Confirm Payment</h1>
    <div class="container my-5">
        <form action="" method="post">
            <div class="form-group my-4">
                Customer Name: <?php echo $name; ?>
            </div>
            <div class="form-group my-4">
                Total Price: <?php echo $total_price; ?>
            </div>
            <div class="form-group my-4">
                <select name="payment_type" class="form-select">
                    <option>Select Payment Mode</option>
                    <option>UPI</option>
                    <option>Netbanking</option>
                    <option>MOMO</option>
                    <option>Cash on Delivery</option>
                    <option>Pay Offline</option>
                </select>
            </div>
            <div class="form-group my-4">
                <input type="submit" class="btn btn-info btn-confirm" value="Confirm" name="confirm_payment">
            </div>
        </form>
    </div>
    <?php
    // require_once 'Confirmpayment.php';
    // foreach ($buyers as $buyer) {
    //     echo "<tr>";
    //     // echo "<td>" . $buyer['Customer_ID'] . "</td>";
    //     echo "<td>" . $buyer['Buyer_Name'] . "</td>";
    //     echo "</tr>";
    // }
    // echo "</table>";
    ?>
</body>

</html>
