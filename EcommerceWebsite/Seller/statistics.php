<?php
include('../includes/connect.php');
session_start();

$username = mysqli_real_escape_string($conn, $_SESSION['username']);

$sql_sellerid = "SELECT Seller.Seller_ID
                FROM Seller
                JOIN Account ON Seller.Account_ID = Account.Account_ID
                WHERE Account.Username = '$username'";

$result_sellerid = mysqli_query($conn, $sql_sellerid);

if ($result_sellerid && $row = mysqli_fetch_assoc($result_sellerid)) {

    $seller_id = $row['Seller_ID'];

    $sql_statistics = "SELECT COUNT(oi.Product_ID) AS Total_Products_Bought, SUM(oi.Price) AS Total_Price_Sold
                        FROM `Order_Items` oi
                        JOIN `Product` p ON oi.Product_ID = p.Product_ID
                        JOIN `Order` o ON oi.Order_ID = o.Order_ID
                        WHERE p.Seller_ID = $seller_id";

    $result_statistics = mysqli_query($conn, $sql_statistics);

    if ($result_statistics && $row = mysqli_fetch_assoc($result_statistics)) {
        $total_products_bought = $row['Total_Products_Bought'];
        $total_price_sold = $row['Total_Price_Sold'];

        echo "Total products bought from this seller: $total_products_bought<br>";
        echo "Total price of products sold by this seller: $total_price_sold";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    $sql_product_statistics = "SELECT p.Product_ID, p.Product_Name, COUNT(oi.Product_ID) AS Total_Sold, SUM(oi.Price) AS Total_Price_Sold
                                FROM `Order_Items` oi
                                JOIN `Product` p ON oi.Product_ID = p.Product_ID
                                JOIN `Order` o ON oi.Order_ID = o.Order_ID
                                WHERE p.Seller_ID = $seller_id
                                GROUP BY p.Product_ID, p.Product_Name";

    $result_product_statistics = mysqli_query($conn, $sql_product_statistics);

    if ($result_product_statistics) {
        echo "<h2>Statistics for Products Sold by the Seller:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Total Sold</th>
                    <th>Total Price Sold</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result_product_statistics)) {
            echo "<tr>";
            echo "<td>" . $row['Product_ID'] . "</td>";
            echo "<td>" . $row['Product_Name'] . "</td>";
            echo "<td>" . $row['Total_Sold'] . "</td>";
            echo "<td>" . $row['Total_Price_Sold'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Query failed or no result found: " . mysqli_error($conn);
}
?>