<?php

require_once '../EcommerceWebsite/includes/connect.php';

// Function to record history
function recordHistory($customerID, $sellerID, $orderID, $productName) {
    global $conn;
    
    $timestamp = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO history (Customer_ID, Seller_ID, Order_ID, TimeStamp, Product_Name)
    VALUES ('$customerID', '$sellerID', '$orderID', '$timestamp', '$productName')";
    
    if ($conn->query($sql) === TRUE) {
        echo "History recorded successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function displayHistory() {
    global $conn;
    
    $sql = "SELECT * FROM history";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "History ID: " . $row["History_ID"]. "<br>".
                 "Customer ID: " . $row["Customer_ID"]. "<br>".
                 "Seller ID: " . $row["Seller_ID"]. "<br>".
                 "Order ID: " . $row["Order_ID"]. "<br>".
                 "Timestamp: " . $row["TimeStamp"]. "<br>".
                 "Product Name: " . $row["Product_Name"]. "<br><br>";
        }
    } else {
        echo "0 results";
    }
}

$conn->close();
?>
