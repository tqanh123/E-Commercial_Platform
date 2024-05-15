-- SQL Query to check the username --
SELECT * FROM `account` WHERE username='$username'

-- SQL Query to check user information after verifying the password --
SELECT * FROM `customer` c, `account` a 
WHERE c.account_id = a.account_id
AND a.username = '$username'

-- Check if the username, email, or phone number already exists --
SELECT * FROM `account`
WHERE email='$Email' OR userName='$Username' OR Phone_Number='$Phone_Number'

-- Insert new user information into the account table --
INSERT INTO `account` (Username, BankName, BankAccountNumber, Password, Address, Gender, Phone_Number, Email, Profile_Picture)
VALUES ('$Username', 'BIDV', 12, '$hash_pass', 'ktx', 'male', '$Phone_Number', '$Email', NULL)

-- Retrieve the Account_ID of the newly inserted user --
SELECT Account_ID FROM account WHERE Username='$Username'

-- Insert a new record into the customer table --
INSERT INTO `customer` (Account_ID) VALUES ('$ID')

-- Insert a new record into the customer table --
SELECT Customer_ID FROM customer WHERE Account_ID='$ID'

-- Insert a new record into the cart table --
INSERT INTO cart (Customer_ID, Create_at, update_at) 
VALUES ('$cus_ID', NOW(), NOW())

-- User’s Password Change --
$select_query = "Select * from `account` where account_id='$account_id'";
$result = mysqli_query($conn, $select_query);
$row_data = mysqli_fetch_assoc($result);

--  Query to retrieve Seller_ID from the username --
SELECT Seller.Seller_ID
FROM Seller
JOIN Account ON Seller.Account_ID = Account.Account_ID
WHERE Account.Username = '$username'

-- Query to get the total number of products bought and the total price sold by the seller --
SELECT COUNT(oi.Product_ID) AS Total_Products_Bought, SUM(oi.Price) AS Total_Price_Sold
FROM `Order_Items` oi
JOIN `Product` p ON oi.Product_ID = p.Product_ID
JOIN `Order` o ON oi.Order_ID = o.Order_ID
WHERE p.Seller_ID = $seller_id

-- Query to retrieve detailed statistics for each product sold by the seller --
SELECT p.Product_ID, p.Product_Name, COUNT(oi.Product_ID) AS Total_Sold, SUM(oi.Price) AS Total_Price_Sold
FROM `Order_Items` oi
JOIN `Product` p ON oi.Product_ID = p.Product_ID
JOIN `Order` o ON oi.Order_ID = o.Order_ID
WHERE p.Seller_ID = $seller_id
GROUP BY p.Product_ID, p.Product_Name

-- Query to fetch products based on the selected category --
SELECT Product_ID, Product_Name, Price,  Product_Category FROM Product 
WHERE Product_Category = '$category';

-- Retrieve Cart Items with Product Details --
SELECT * FROM cartitem 
NATURAL JOIN Product
WHERE Cart_ID = '$cart_id';

-- Create a subtable to calculate total sales quantity and value by category --
WITH CategorySales AS (
    SELECT c.Category_Name, SUM(oi.Product_Quantity) AS Total_Quantity_Sold, SUM(oi.Price * oi.Product_Quantity) AS Total_Sales_Value
    FROM Category c
    JOIN Product p ON c.Category_ID = p.Category_ID
    JOIN Order_Items oi ON p.Product_ID = oi.Product_ID
    GROUP BY c.Category_Name
)
SELECT * FROM CategorySales;

-- Query to get products that have been sold at least once, sorted by number of sales from high to low --
SELECT p.Product_ID, p.Product_Name, SUM(oi.Product_Quantity) AS Total_Sold
FROM Product p
JOIN Order_Items oi ON p.Product_ID = oi.Product_ID
GROUP BY p.Product_ID, p.Product_Name
HAVING Total_Sold > 0
ORDER BY Total_Sold DESC;

-- Query to get top-rated products, along with seller name and category --
SELECT p.Product_ID, p.Product_Name, p.Price, p.Product_Ratings, s.Seller_Description, c.Category_Name
FROM Product p
JOIN Seller s ON p.Seller_ID = s.Seller_ID
JOIN Category c ON p.Category_ID = c.Category_ID
ORDER BY p.Product_Ratings DESC
LIMIT 10;

-- 
