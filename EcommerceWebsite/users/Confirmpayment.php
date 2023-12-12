<?php
include ('../includes/connect.php');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT c.Customer_ID, a.Username AS Buyer_Name 
                            FROM Customer c
                            INNER JOIN Account a ON c.Account_ID = a.Account_ID");
    $stmt->execute();
    $buyers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
