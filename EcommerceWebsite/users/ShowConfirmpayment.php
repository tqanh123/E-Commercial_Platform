<?php 
include ('../includes/connect.php');
session_start();

    $name = $_SESSION['username'];
    $cart_id = $_SESSION['Cart_ID'];
    $total_price = 0;
    $shipping_fee = 10;

    $total_price_per_item = 0;
    $select_data = "SELECT ci.Cart_Item_Price, ci.Cart_Item_Quantity, c.Customer_ID, p.Product_Name, p.Seller_ID
                                FROM `cartitem` ci
                                JOIN `cart` c ON ci.cart_id = c.cart_id
                                JOIN `product` p ON p.Product_ID = ci.Product_ID
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

    $update_orders="INSERT INTO `order` (Customer_ID, Total_Order_Value, Order_Status, Shipping_Fee, Update_at)
    VALUES ('$customer_id', '$total_price_per_item', 'Paid', '10' ,NOW())";

    $result_orders= mysqli_query($conn, $update_orders);
    $order_id = mysqli_insert_id($conn);

    $insert_query="INSERT INTO `payments` (Order_ID, Payment_Type, Payment_Value)
                                VALUES  ($order_id, '$payment_type', $total_price_per_item)";
    $result= mysqli_query($conn, $insert_query);
    if ($result) {
        echo "<div class='alert alert-success text-center' role='alert'>Successfully completed the payment</div>";
        FinishPayment($cart_id, $order_id);
        
    }
}

    Function FinishPayment($cart_id, $order_id) {
        global $conn;
        $select_cart_items_query = "SELECT * FROM cartitem c JOIN product p ON c.Product_ID = p.Product_ID WHERE cart_id = $cart_id";
        $cart_items_result = mysqli_query($conn, $select_cart_items_query);

        if ($cart_items_result && mysqli_num_rows($cart_items_result) > 0) {
        
            mysqli_begin_transaction($conn);
    
            try {
                // Insert cart items into order_item table
                while ($row = mysqli_fetch_assoc($cart_items_result)) {
                    $product_id = $row['Product_ID'];
                    $quantity = $row['Cart_Item_Quantity'];
                    $price = $row['Cart_Item_Price'];
                    $name = $row['Product_Name'];
    
                    $insert_order_item_query = "INSERT INTO `order_items` (Order_ID, Product_ID, Product_Name, Product_Quantity, Price)
                                               VALUES ($order_id, $product_id, '$name' ,$quantity, $price)";
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

            }
            catch (Exception $e) {
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ecommerce Website</title>
  <!-- bootstrap CSS link -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- font awesome link-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!--CSS file-->
  <link rel="stylesheet" href="../style.css">
</head>

<body>
  <!--navbar-->
  <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container-fluid">
        <img src="../image/ghost_logo.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../user_area/home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../cart.php"><i
                  class="fa-solid fa-cart-shopping"></i></a>
            </li>

          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>

    <!-- Second child-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
      <ul class="navbar-nav me-auto">
        <?php
          if (!isset($_SESSION['username'])) {
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome Guest</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/logout.php'>Logout</a></li>";
          }
      ?>
      </ul>
    </nav>
    <div class="bg-light">
      <h3 class="text-center">Payment</h3>
    </div>

    <div class="container my-5">
        <form action="" method="post">
            <div class="form-group my-4">
                Customer Name: <?php echo $name; ?>
            </div>
            <div class="form-group my-4">
                Total Product Price: <?php echo $total_price; ?>
            </div>
            <div class="form-group my-4">
                Shipping Fee: <?php echo $shipping_fee; ?>
            </div>
            <div class="form-group my-4">
                Total Price: <?php echo $total_price + $shipping_fee; ?>
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
          
    </div>

    <!--last child-->
    <div class="bg-info p-3 text-center footer" style="position: fixed; bottom: 0; width: 100%; background-color: #f8f9fa; text-align: center; padding: 10px;">
    <p>Together we make differences in 20 years || 2003-2023<p>
    </div>
    <!-- bootstrap js link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


</body>

</html>