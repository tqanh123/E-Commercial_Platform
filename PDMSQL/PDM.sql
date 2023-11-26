CREATE TABLE [Account].[Account] (
    Account_ID INT PRIMARY KEY,
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

CREATE TABLE [Cart].[Cart] (
    Cart_ID INT PRIMARY KEY,
    Customer_ID INT,
    Create_at DATETIME,
    Update_at DATETIME
    FOREIGN KEY (Customer_ID) REFERENCES [Account].[Customer],
);

CREATE TABLE [Product].[Category] (
    Category_ID INT PRIMARY KEY,
    Category_Name VARCHAR(255),
); 

CREATE TABLE [Product].[Product] (
    Product_ID INT PRIMARY KEY,
    Category_ID INT,
    Product_Name VARCHAR(255),
    Product_Description TEXT,
    Price DECIMAL(10, 2),
    Product_Category VARCHAR(255),
    Product_Quantity INT,
    Product_Sold INT,
    Product_Status VARCHAR(20),
    Product_Ratings DECIMAL(4, 2),
    FOREIGN KEY (Category_ID) REFERENCES [Product].[Category](Category_ID)
); 

CREATE TABLE [Account].[Seller] (
    Seller_ID INT PRIMARY KEY,
    Account_ID INT,
    Product_ID INT,
    Category_ID INT,
    Seller_Description TEXT,
    Seller_Product_Categories TEXT,
    Seller_Ratings DECIMAL(4, 2),
    Transaction_History TEXT,
    FOREIGN KEY (Account_ID) REFERENCES [Account].[Account](Account_ID),
    FOREIGN KEY (Product_ID) REFERENCES [Product].[Product](Product_ID),
    FOREIGN KEY (Category_ID) REFERENCES [Product].[Category](Category_ID)
); 

CREATE TABLE [Account].[Customer] (
    Customer_ID INT PRIMARY KEY,
    Account_ID INT,
    Product_ID INT,
    FOREIGN KEY (Account_ID) REFERENCES [Account].[Account](Account_ID),
    FOREIGN KEY (Product_ID) REFERENCES [Product].[Product](Product_ID)
)

CREATE TABLE [Cart].[CartItem] (
    Cart_Item_ID INT PRIMARY KEY,
    Cart_ID INT,
    Product_ID INT,
    Cart_Item_Quantity INT,
    Cart_Item_Price DECIMAL(10, 2),
    Create_at DATETIME,
    Update_at DATETIME,
    FOREIGN KEY (Cart_ID) REFERENCES [Cart].[Cart](Cart_ID),
    FOREIGN KEY (Product_ID) REFERENCES [Product].[Product](Product_ID)
);


CREATE TABLE [OrderManagement].[Order] (
    Order_ID INT PRIMARY KEY,
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
    FOREIGN KEY (Customer_ID) REFERENCES [Account].[Customer],
);

CREATE TABLE [OrderManagement].[Order_Items] (
    Order_Item_ID INT PRIMARY KEY,
    Order_ID INT,
    ProductId INT,
    Product_Name VARCHAR(255),
    Price DECIMAL(10, 2),
    Product_Quantity INT,
    FOREIGN KEY (Order_ID) REFERENCES [OrderManagement].[Order](Order_ID),
    FOREIGN KEY (Product_ID) REFERENCES [Product].[Product](Product_ID)
);

CREATE TABLE [OrderManagement].[Payments] (
    Payment_ID INT PRIMARY KEY,
    Order_ID INT,
    Payment_Sequential INT,
    Payment_Type VARCHAR(20),
    Payment_Installments INT,
    Payment_Value DECIMAL(10, 2),
    FOREIGN KEY (Order_ID) REFERENCES [OrderManagement].[Order](Order_ID)
);

CREATE TABLE[OrderManagement].[Order_Review] (
    Review_ID INT PRIMARY KEY,
    Order_ID INT,
    Review_Score INT,
    Review_Comment_Title VARCHAR(255),
    Review_Comment_Message TEXT,
    Review_Creation_Date DATETIME,
    Review_Answer_Timestamp DATETIME,
    FOREIGN KEY (Order_ID) REFERENCES [OrderManagement].[Order](Order_ID)
);

CREATE TABLE [HistoryManagement].[History] (
    History_ID INT PRIMARY KEY,
    Customer_ID INT,
    Seller_ID INT,
    Order_ID INT,
    TimeStamp DATETIME,
    Product_Name VARCHAR(255),
    FOREIGN KEY (Customer_ID) REFERENCES [Account].[Customer](Customer_ID),
    FOREIGN KEY (Seller_ID) REFERENCES [Account].[Seller](Seller_ID),
    FOREIGN KEY (Order_ID) REFERENCES [OrderManagement].[Order](Order_ID) 
);

