<?php
// Replace these variables with your actual database credentials
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "cart";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT c.Customer_ID, a.Username AS Buyer_Name 
                            FROM Account.Customer c
                            INNER JOIN Account.Account a ON c.Account_ID = a.Account_ID");
    $stmt->execute();
    $buyers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
