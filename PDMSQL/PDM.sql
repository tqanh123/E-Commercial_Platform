CREATE TABLE `Account` (
    Account_ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255),
    BankName VARCHAR(255),
    BankAccountNumber VARCHAR(20),
    Password VARCHAR(255),
    Address VARCHAR(255),
    Gender VARCHAR(10),
    Phone_Number VARCHAR(15),
    Email VARCHAR(255),
    Profile_Picture VARCHAR(255)
);  

CREATE TABLE `Category` (
    Category_ID INT AUTO_INCREMENT PRIMARY KEY,
    Category_Name VARCHAR(255)
);
CREATE TABLE `Seller` (
    Seller_ID INT AUTO_INCREMENT PRIMARY KEY,
    Account_ID INT,
    Seller_Description TEXT,
    Seller_Ratings DECIMAL(4, 2),
    FOREIGN KEY (Account_ID) REFERENCES Account(Account_ID)
); 
CREATE TABLE `Product` (
    Product_ID INT AUTO_INCREMENT PRIMARY KEY,
    Category_ID INT,
    Seller_ID INT,
    Product_Name VARCHAR(255),
    Product_Description TEXT,
    Price DECIMAL(10, 2),
    Product_Category VARCHAR(255),
    Product_Quantity INT,
    Product_Sold INT,
    Product_Status VARCHAR(20),
    Product_Ratings DECIMAL(4, 2),
    FOREIGN KEY (Seller_ID) REFERENCES Seller(Seller_ID),
    FOREIGN KEY (Category_ID) REFERENCES Category(Category_ID)
); 

CREATE TABLE `Customer` (
    Customer_ID INT AUTO_INCREMENT PRIMARY KEY,
    Account_ID INT,
    FOREIGN KEY (Account_ID) REFERENCES Account(Account_ID)
);

CREATE TABLE `Cart` (
    Cart_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT,
    Update_at DATETIME,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE `CartItem` (
    Cart_Item_ID INT AUTO_INCREMENT PRIMARY KEY,
    Cart_ID INT,
    Product_ID INT,
    Cart_Item_Quantity INT,
    Cart_Item_Price DECIMAL(10, 2),
    Update_at DATETIME,
    FOREIGN KEY (Cart_ID) REFERENCES Cart(Cart_ID),
    FOREIGN KEY (Product_ID) REFERENCES Product(Product_ID)
);

CREATE TABLE `Order` (
    Order_ID INT AUTO_INCREMENT PRIMARY KEY,
    Customer_ID INT,
    Total_Order_Value DECIMAL(10, 2),
    Order_Date DATE,
    Order_Status VARCHAR(20),
    Shipping_Fee DECIMAL(10, 2),
    Order_Purchase_TimeStamp DATETIME,
    Order_Canceled DATETIME,
    Order_Delivered_Carrier_Date DATETIME,
    Order_Delivered_Customer_Date DATETIME,
    Order_Estimated_Customer_Date DATETIME,
    FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
);

CREATE TABLE `Order_Items` (
    Order_Item_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_ID INT,
    Product_ID INT,
    Product_Name VARCHAR(255),
    Price DECIMAL(10, 2),
    Product_Quantity INT,
    Update_at DATETIME,
    FOREIGN KEY (Order_ID) REFERENCES `Order`(Order_ID),
    FOREIGN KEY (Product_ID) REFERENCES Product(Product_ID)
);

CREATE TABLE `Payments` (
    Payment_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_ID INT,
    Payment_Sequential INT,
    Payment_Type VARCHAR(20),
    Payment_Installments INT,
    Payment_Value DECIMAL(10, 2),
    FOREIGN KEY (Order_ID) REFERENCES `Order`(Order_ID)
);

CREATE TABLE `Order_Review` (
    Review_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_ID INT,
    Review_Score INT,
    Review_Comment_Title VARCHAR(255),
    Review_Comment_Message TEXT,
    Review_Creation_Date DATETIME,
    Review_Answer_Timestamp DATETIME,
    FOREIGN KEY (Order_ID) REFERENCES `Order`(Order_ID)
);