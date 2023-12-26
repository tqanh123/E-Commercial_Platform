<?php

include ('includes/connect.php');

session_start();
    $username = $_SESSION['username'];
    $get_user = "SELECT * FROM account JOIN customer WHERE Username='$username' AND account.Account_ID = customer.Account_ID";
    $result = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['Customer_ID'];

    $sql = "SELECT * FROM history WHERE Customer_ID = $user_id; ";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
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


function recordHistory($customerID, $sellerID, $orderID, $productName) {
    global $conn;
    
    $timestamp = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO history (Customer_ID, Seller_ID, Order_ID, TimeStamp, Product_Name)
    VALUES ('$customerID', '$sellerID', '$orderID', '$timestamp', '$productName')";
    
    // if ($conn->query($sql) === TRUE) {
    //     echo "History recorded successfully";
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
}

$conn->close();
?>
