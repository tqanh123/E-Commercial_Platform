<?php

// Database connection
include('../EcommerceWebsite/includes/connect.php');
session_start();

$name = $_SESSION['username'];
    $select = "select Customer_ID from `customer` c, `account` a
    where c.account_id = a.account_ID and a.Username = '$name'";
    $res = mysqli_query($conn, $select);
    $row_data = mysqli_fetch_assoc($res);
    $specificCartId = $row_data['Customer_ID']; 
$_SESSION['Cart_ID'] = $specificCartId;
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add_to_cart':
            $cart_id = $specificCartId;
            $product_id = $_POST['product_id'];
            addProductToCart($cart_id ,$product_id);
            header("Location: ../cart.php");
            break;
    }
}

function addProductToCart($cart_id, $product_id) {
    global $conn;

    $check_sql = "SELECT Cart_Item_ID FROM cartitem WHERE Cart_ID = ? AND Product_ID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $cart_id, $product_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        
        $update_sql = "UPDATE cartitem SET Cart_Item_Quantity = Cart_Item_Quantity + 1 WHERE Cart_ID = ? AND Product_ID = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ss", $cart_id, $product_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        
        $insert_sql = "INSERT INTO cartitem (Cart_ID, Product_ID, Cart_Item_Quantity) VALUES (?, ?, 1)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ss", $cart_id, $product_id);
        $insert_stmt->execute();

        $cart_item_id = $insert_stmt->insert_id;

        $insert_stmt->close();

        return $cart_item_id;
    }
}

function removeProductFromCart($cart_id, $product_id) {
    global $conn;

    $sql = "DELETE FROM CartItem WHERE Cart_ID = ? AND Product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $cart_id, $product_id);
    $stmt->execute();
    $stmt->close();
}

function getProductsInCart($cart_id) {
    global $conn;

    $sql = "SELECT 
                    cartitem.Cart_Item_ID,
                    cartitem.Product_ID, 
                    product.Product_Name AS Name, 
                    product.Price,
                    SUM(cartitem.Cart_Item_Quantity) as Total_Quantity
                FROM 
                    cartitem
                INNER JOIN 
                    Product 
                ON 
                    Cartitem.Product_ID = Product.Product_ID 
                WHERE 
                    Cartitem.Cart_ID = ?
                GROUP BY cartitem.Product_ID";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}

function updateQuantity($cart_id, $product_id, $action) {
    global $conn;

    $currentQuantity = getProductQuantity($cart_id, $product_id);

    if ($currentQuantity !== null) {
        if ($action === 'increase') {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action === 'decrease' && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        }   

        $updateSql = "UPDATE CartItem SET Cart_Item_Quantity = ? WHERE Cart_ID = ? AND Product_ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("iss", $newQuantity, $cart_id, $product_id);
        $updateStmt->execute();
        $updateStmt->close();
    }
}

function getProductQuantity($cart_id, $product_id) {
    global $conn;

    $sql = "SELECT Cart_Item_Quantity FROM CartItem WHERE Cart_ID = ? AND Product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $cart_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['Cart_Item_Quantity'];
    }

    return null;
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
     integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
     <!--CSS file-->
     <link rel="stylesheet" href="style.css">
    </head>
<body>
<!--navbar-->
<div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
    <img src="./image/ghost_logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../EcommerceWebsite/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
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
  // echo session_id(); 
  // echo $_SESSION['username'];
          if (!isset($_SESSION['username'])) {
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcom Guest</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcom $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/logout.php'>Logout</a></li>";
          }
      ?>
  </ul>
</nav>
<div class="bg-light">
    <h3 class="text-center">Cart</h3>
</div>

<div class="cart">
    <div class="caption">
        <p class="product Name">product name</p>
        <p class="price"><b>10</b></p>
        <p class="description"> white </p>
        <button class="remove"> Remove from cart </button>
    </div>
</div>
<div class="cart">
    <div class="caption">
        <p class="product Name">product name</p>
        <p class="price"><b>10</b></p>
        <p class="description"> white </p>
        <button class="remove"> Remove from cart </button>
    </div>
</div>

<!-- <?php
    

    $productsInCart = getProductsInCart($specificCartId);       

    if ($productsInCart->num_rows === 0) {
        echo "<div class='cart'>";
        echo "<h2>Your cart is empty. Please buy something before checking out.</h2>";
        echo "<br>";
        echo "<a class='buy-button' href='index.php'>Buy Now</a>";
        echo "</div>";
    } else {
        // Display the items in the cart
        echo "<div class='cart'>";
        echo "<h2>Cart</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Price</th></tr>";

        $total_price = 0;

        while ($row = $productsInCart->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Name'] . "</td>";
        echo "<td>$" . $row['Price'] . "</td>";
        echo "<td>" . $row['Total_Quantity'] . "</td>";
        echo "<td>
        <form method='post' action=''>
            <input type='hidden' name='product_id' value='" . $row['Product_ID'] . "'>
            <button type='submit' name='remove_product'>Remove</button>
        </form>
        </td>";
        // Increase quantity button
        echo "<td>
        <form method='post' action=''>
            <input type='hidden' name='product_id' value='" . $row['Product_ID'] . "'>
            <button type='submit' name='increase_quantity'>+</button>
        </form>
        </td>";
        // Decrease quantity button
        echo "<td>
        <form method='post' action=''>
            <input type='hidden' name='product_id' value='" . $row['Product_ID'] . "'>
            <button type='submit' name='decrease_quantity'>-</button>
        </form>
        </td>";
        echo "</tr>";
        $total_price += $row['Price'] * $row['Total_Quantity'];
    }
    echo "</table>"; // Close the table started in the loop

    echo "<div class='cart-options'>";
    echo "<a class='buy-button' href='users/ShowPayment.php'>Checkout</a>";
    echo "</div>";
    echo "<a class='buy-button' href='index.php'>Continue Shopping</a>";
    echo "</div>";
    if (isset($_POST['remove_product'])) {
        $product_id_to_remove = $_POST['product_id'];
        removeProductFromCart($specificCartId, $product_id_to_remove);
        header("Location: cart.php");
        exit();
    }

    if (isset($_POST['increase_quantity'])) {
        $product_id = $_POST['product_id'];
        updateQuantity($specificCartId, $product_id, 'increase');
        header("Location: cart.php");
        exit();
    }

    if (isset($_POST['decrease_quantity'])) {
        $product_id = $_POST['product_id'];
        updateQuantity($specificCartId, $product_id, 'decrease');
        header("Location: cart.php");
        exit();
    }
}
?> -->
<!--last child-->
<div class="bg-info p-3 text-center footer">
  <p>Together we make differences in 20 years || 2003-2023<p>
      </div>
<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>
</html>