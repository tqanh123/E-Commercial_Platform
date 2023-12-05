<?php
session_start();

// Database connection
$servername = "127.0.0.1:3307";
$username = "root";
$password = "1234";
$dbname = "e_commercial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$specificCartId = "1"; 

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
    echo "<h2>Cart Items</h2>";
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

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'add_to_cart':
            $cart_id = 1;
            $product_id = $_POST['product_id'];
            addProductToCart($cart_id ,$product_id);
            header("Location: cart.php");
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