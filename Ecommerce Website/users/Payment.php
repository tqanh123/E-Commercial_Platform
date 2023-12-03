<?php
// Function to handle payment process
function makePayment($customerID, $orderID, $paymentType, $paymentInstallments, $paymentValue) {
    // Database connection parameters
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "cart";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute INSERT query for Payments table
    $insertPaymentQuery = "INSERT INTO OrderManagement.Payments (Order_ID, Payment_Type, Payment_Installments, Payment_Value)
                           VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertPaymentQuery);
    $stmt->bind_param("isid", $orderID, $paymentType, $paymentInstallments, $paymentValue);
    $stmt->execute();

    // Update Order status to reflect payment completion
    $updateOrderStatusQuery = "UPDATE OrderManagement.Order SET Order_Status = 'Paid' WHERE Order_ID = ?";
    $stmt = $conn->prepare($updateOrderStatusQuery);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
