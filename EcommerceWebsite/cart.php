<?php
session_start();

// Database connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "e_commercial";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

require_once '../EcommerceWebsite/includes/connect.php';

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
        echo "<td><form method='post' action=''>
                    <input type='hidden' name='product_id' value='" . $row['Product_ID'] . "'>
                    <button type='submit' name='remove_product'>Remove</button>
                </form></td>";
        echo "</tr>";
    $total_price += $row['Price'] * $row['Total_Quantity'];
}
        echo "<a class='buy-button' href='users/ShowPayment.php'>Checkout</a>";
        echo "<br>";
        echo "<a class='buy-button' href='index.php'>Continue Shopping</a>";


    if (isset($_POST['remove_product'])) {
        $product_id_to_remove = $_POST['product_id'];
        removeProductFromCart($specificCartId, $product_id_to_remove);
        header("Location: cart.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $cart_id = 1;
    addProductToCart($cart_id ,$product_id);
    header("Location: cart.php");
    exit();
}

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['increase_quantity'])) {
//         $cart_item_id = $_POST['cart_item_id']; 
//         updateQuantity($cart_item_id, 'increase');
//     }
//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         if (isset($_POST['decrease_quantity'])) {
//             $cart_item_id = $_POST['cart_item_id']; 
//             updateQuantity($cart_item_id, 'decrease');
//         }
//     }
// }

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Perform the corresponding action
    switch ($action) {
        case 'addToCart':
            $cart_id = 1;
            addProductToCart($cart_id ,$product_id);
            break;
        case 'removeFromCart':
            $product_id_to_remove = $_POST['product_id'];
            removeProductFromCart($specificCartId, $product_id_to_remove);
            break;
        // case 'updateQuantity':
        //     updateQuantity($productId, $_POST['quantity']);
        //     break;
    }
}

function addProductToCart($cart_id, $product_id) {
    global $conn;

    $sql = "INSERT INTO cartitem (Cart_ID, Product_ID, Cart_Item_Quantity) 
            VALUES (?, ?, 1)
            ON DUPLICATE KEY UPDATE Cart_Item_Quantity = Cart_Item_Quantity + 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $cart_id, $product_id);
    $stmt->execute();

    $cart_item_id = $stmt->insert_id;

    $stmt->close();

    return $cart_item_id;
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

function updateQuantity($cart_item_id, $action) {
    global $conn;

    $currentQuantity = getProductQuantityByCartItemID($cart_item_id);

    if ($currentQuantity !== null) {
        if ($action === 'increase') {
            $newQuantity = $currentQuantity + 1;
        } elseif ($action === 'decrease' && $currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
        }   

        $updateSql = "UPDATE CartItem SET Cart_Item_Quantity = ? WHERE Cart_item_ID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("is", $newQuantity, $cart_item_id);
        $updateStmt->execute();
        $updateStmt->close();
    }
}

function getProductQuantityByCartItemID($cart_item_id) {
    global $conn;

    $sql = "SELECT Cart_Item_Quantity FROM CartItem WHERE Cart_item_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['Cart_Item_Quantity'];
    }

    return null;
}
?>