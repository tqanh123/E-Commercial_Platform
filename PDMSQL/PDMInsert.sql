/*INSERT INTO [Account].[Account] (Account_ID, Username, BankName, BankAccountNumber, Password, Address, Gender, Phone_Number, Email, Profile_Picture)
VALUES
 (1, 'Thanh Khiem', 'BIDV', '123456', 'password1', '123 Le Loi', 'Male', '0901998998', 'thanhkhiem14@gmail.com', 'profile_pic1.jpg'),
 (2, 'Quang Anh', 'VIETCOMBANK', '654321', 'password2', '45 Tan Lap', 'Male', '0913474747', 'anhden123@gmail.com', 'profile_pic2.jpg'),
 (3, 'Huu Khanh', 'MBBANK', '399999', 'password3', '67 Hung Vuong', 'Female', '0982123456', 'khanhdaklak1@gmail.com', 'profile_pic3.jpg'),
 (4, 'Anh Khoa', 'TECHCOMBANK', '141414', 'password4', '89 Ly Thuong Kiet', 'Female', '0979999999', 'anhkhoacute123@gmail.com', 'profile_pic4.jpg'),
 (5, 'Minh Tri', 'AGRIBANK', '277777', 'password5', '10 Tran Phu', 'Male', '0911311313', 'minhtrivippro1@gmail.com', 'profile_pic5.jpg'),
 (6, 'Hai Quang', 'BIDV', '456789', 'password6', '13 Quang Trung', 'Male', '0901777666', 'haiquangtkqn@gmail.com', 'profile_pic6.jpg'),
 (7, 'Thanh Vu', 'TPBANK', '678910', 'password7', '4 Song Hanh', 'Male', '0987456321', 'thanhvudeptrai@gmail.com', 'profile_pic7.jpg'),
 (8, 'Nguyen Vi', 'MBBANK', '488888', 'password8', '100 Tran Phu', 'Female', '0899883775', 'nguyenvi123@gmail.com', 'profile_pic8.jpg'),
 (9, 'Ngoc Trinh', 'VIETCOMBANK', '111111', 'password9', '99 Le Loi', 'Female', '0988343434', 'ngoctrinh3@gmail.com', 'profile_pic9.jpg'),
 (10, 'Thuy Tien', 'AGRIBANK', '345345', 'password10', '1 Le Van Viet', 'Female', '0913567567', 'hhthuytien@gmail.com', 'profile_pic10.jpg');


INSERT INTO [Cart].[Cart] (Cart_ID, Customer_ID, Create_at, Update_at)
VALUES 
   (1, 1, '2023-11-10 14:00:00', '2023-11-10 14:30:00'),
   (2, 2, '2023-11-11 15:00:00', '2023-11-11 15:30:00'),
   (3, 3, '2023-11-12 16:00:00', '2023-11-12 16:30:00'),
   (4, 4, '2023-11-13 17:00:00', '2023-11-13 17:30:00'),
   (5, 5, '2023-11-14 18:00:00', '2023-11-14 18:30:00');

INSERT INTO [Product].[Category] (Category_ID, Category_Name)
VALUES
   (1, 'Electronics'),
   (2, 'Clothing'),
   (3, 'Books'),
   (4, 'Home & Garden'),
   (5, 'Sports & Outdoors'); 

INSERT INTO [Product].[Product] (Product_ID, Category_ID, Product_Name, Product_Description, Price, Product_Category, Product_Quantity, Product_Sold, Product_Status, Product_Ratings)
VALUES
   (1, 1, 'Smartphone', 'High-end smartphone with advanced features', 799.99, 'Electronics', 50, 20, 'In Stock', 4.5),
   (2, 2, 'Denim Jeans', 'Classic blue denim jeans for everyday wear', 49.99, 'Clothing', 100, 50, 'In Stock', 4.0),
   (3, 3, 'The Great Gatsby', 'Classic novel by F. Scott Fitzgerald', 12.99, 'Books', 75, 30, 'In Stock', 4.8),
   (4, 4, 'Home Decor Set', 'Decorative items for home interior', 149.99, 'Home & Garden', 30, 10, 'In Stock', 4.2),
   (5, 5, 'Outdoor Camping Tent', 'Spacious tent for outdoor camping adventures', 199.99, 'Sports & Outdoors', 20, 5, 'In Stock', 4.6); 

INSERT INTO [Account].[Seller] (Seller_ID, Account_ID, Product_ID, Category_ID, Seller_Description, Seller_Product_Categories, Seller_Ratings, Transaction_History)
VALUES
   (1, 6, 1, 1, 'Experienced seller specializing in smartphones', 'Electronics', 4.7, 'Sold a smartphone'),
   (2, 7, 2, 2, 'Fashion store with a focus on denim jeans', 'Clothing', 4.5, 'Sole a Denim Jean '),
   (3, 8, 3, 3, 'Bookstore offering a wide range of literary works', 'Books', 4.8, 'Sole a novel named The Great Gatsby'),
   (4, 9, 4, 4, 'Home and decor shop providing quality products', 'Home & Garden', 4.2, 'Sole a Home Decor Set'),
   (5, 10, 5, 5, 'Outdoor equipment supplier for camping enthusiasts', 'Sports & Outdoors', 4.6, 'Sold an Outdoor Camping Tent');

INSERT INTO [Account].[Customer] (Customer_ID, Account_ID, Product_ID, Reward_Points)
VALUES
   (1, 1, 1, 50),
   (2, 2, 2, 30),
   (3, 3, 3, 20),
   (4, 4, 4, 40),
   (5, 5, 5, 25); 

INSERT INTO [Cart].[CartItem] (Cart_Item_ID, Cart_ID, Product_ID, Cart_Item_Quantity, Cart_Item_Price, Create_at, Update_at)
VALUES
   (1, 1, 1, 1, 799.99, '2023-11-10 14:00:00', '2023-11-10 14:30:00'),
   (2, 2, 2, 2, 99.98, '2023-11-11 15:00:00', '2023-11-11 15:30:00'),
   (3, 3, 3, 3, 38.97, '2023-11-12 16:00:00', '2023-11-12 16:30:00'),
   (4, 4, 4, 2, 299.98, '2023-11-13 17:00:00', '2023-11-13 17:30:00'),
   (5, 5, 5, 4, 799.96, '2023-11-14 18:00:00', '2023-11-14 18:30:00'); 

INSERT INTO [OrderManagement].[Order] (Order_ID, Customer_ID, Total_Order_Value, Order_Date, Order_Status, Shipping_Fee, Payment_ID, Order_Purchase_TimeStamp, Order_Canceled, Order_Delivered_Carrier_Date, Order_Delivered_Customer_Date, Order_Estimated_Customer_Date)
VALUES
   (1, 1, 799.99, '2023-11-10', 'Processing', 5.00, 1, '2023-11-10 12:30:00', Null, '2023-11-11 11:30:00', '2023-11-13 12:30:00', '2023-11-13 12:30:00'),
   (2, 2, 99.98, '2023-11-11', 'Shipped', 7.50, 2, '2023-11-11 13:30:00', Null, '2023-11-12 14:00:00', '2023-11-13 14:15:00', '2023-11-13 11:30:00'),
   (3, 3, 38.97, '2023-11-12', 'Delivered', 10.00, 3, '2023-11-12 14:30:00', Null, '2023-11-13 15:00:00', '2023-11-16 15:15:00', '2023-11-16 15:30:00'),
   (4, 4, 299.98, '2023-11-13', 'Processing', 15.00, 4, '2023-11-13 15:30:00', Null, '2023-11-14 16:00:00', '2023-11-17 16:15:00', '2023-11-17 16:30:00'),
   (5, 5, 799.96, '2023-11-14', 'Delivered', 8.00, 5, '2023-11-14 16:30:00', Null, '2023-11-15 17:00:00', '2023-11-17 17:15:00', '2023-11-19 17:30:00');

INSERT INTO [OrderManagement].[Order_Items] (Order_ID, Order_Item_ID, ProductId, Product_Name, Price, Product_Quantity, Cart_ID)
VALUES
   (1, 1, 1, 'Smartphone', 799.99, 1, 1),
   (2, 2, 2, 'Denim Jeans', 49.99, 2, 2),
   (3, 3, 3, 'The Great Gatsby', 12.99, 3, 3),
   (4, 4, 4, 'Home Decor Set', 149.99, 2, 4),
   (5, 5, 5, 'Outdoor Camping Tent', 199.99, 4, 5);

INSERT INTO [OrderManagement].[Payments] (PaymentID, OrderID, Payment_Sequential, Payment_Type, Payment_Installments, Payment_Value)
VALUES
   (1, 1, 1, 'Banking', 3, 799.99),
   (2, 2, 1, 'Cash', 1, 99.98),
   (3, 3, 1, 'Banking', 2, 38.97),
   (4, 4, 1, 'Banking', 4, 299.98),
   (5, 5, 1, 'Banking', 2, 799.96);

INSERT INTO [OrderManagement].[Order_Review] (Review_ID, OrderID, Review_Score, Review_Comment_Title, Review_Comment_Message, Review_Creation_Date, Review_Answer_Timestamp)
VALUES
   (1, 1, 4, 'Great Experience', 'The order was processed quickly, and the product is fantastic!', '2023-11-14 12:45:00', '2023-11-14 13:00:00'),
   (2, 2, 5, 'Excellent Service', 'Smooth transaction and fast shipping. Highly recommended!', '2023-11-15 13:15:00', '2023-11-15 13:30:00'),
   (3, 3, 4, 'Good Bookstore', 'The bookstore has a great selection of books. I am satisfied with my purchase.', '2023-11-17 14:00:00', '2023-11-17 14:15:00'),
   (4, 4, 3, 'Product Quality Concerns', 'The product received did not meet my expectations. Quality needs improvement.', '2023-11-18 15:00:00', '2023-11-18 18:00:00'),
   (5, 5, 5, 'Awesome Outdoor Gear', 'I love the camping gear! It arrived on time, and the quality is outstanding.', '2023-11-18 15:30:00', '2023-11-18 15:45:00');

INSERT INTO [HistoryManagement].[History] (History_ID, Customer_ID, Seller_ID, Order_ID, TimeStamp, Product_Name)
VALUES
   (1, 1, 1, 1, '2023-11-10 14:30:00', 'Smartphone'),
   (2, 2, 2, 2, '2023-11-11 15:30:00', 'Denim Jeans'),
   (3, 3, 3, 3, '2023-11-12 16:30:00', 'The Great Gatsby'),
   (4, 4, 4, 4, '2023-11-13 17:30:00', 'Home Decor Set'),
   (5, 5, 5, 5, '2023-11-14 18:30:00', 'Outdoor Camping Tent'); */








