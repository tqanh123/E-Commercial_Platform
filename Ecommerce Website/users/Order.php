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

function addProductToOrder($order_id, $product_id) {
    global $conn;

    $sql = "INSERT INTO order_items (Order_Item_ID, Order_ID, Product_ID, Product_Name, Price,Product_Quantity) 
            VALUES (?, ?, ?, ?, ?, 1)
            ON DUPLICATE KEY UPDATE Product_Quantity = Product_Quantity + 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $order_id, $product_id);
    $stmt->execute();
    $stmt->close();
}

function removeProductFromOrder($order_id, $product_id) {
    global $conn;

    $sql = "DELETE FROM order_items WHERE Order_ID = ? AND Product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $order_id, $product_id);
    $stmt->execute();
    $stmt->close();
}