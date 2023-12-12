<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    include('../includes/connect.php');
    session_start();
    $username = $_SESSION['username'];
    // $username = 'Anh Khoa';
    $get_user = "SELECT * FROM account JOIN customer WHERE Username='$username' AND account.Account_ID = customer.Account_ID";
    $result = mysqli_query($conn, $get_user);
    $row_fetch = mysqli_fetch_assoc($result);
    $user_id = $row_fetch['Customer_ID'];
    ?>

    <h3 class="text-success">All My Orders</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info">
            <tr>
                <th>Sr. No</th>
                <th>Amount Value</th>
                <!-- <th>Total Products</th> -->
                <!-- <th>Invoice Number</th> -->
                <th>Date</th>
                <!-- <th>Complete/Incomplete</th> -->
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light">
            <?php
            $get_order_details = "SELECT * FROM `order` WHERE Customer_ID='$user_id'";
            $result_orders = mysqli_query($conn, $get_order_details);
            $number = 1;

            while ($row_data = mysqli_fetch_assoc($result_orders)) {
                $order_id = $row_data['Order_ID'];
                $amount_value = $row_data['Total_Order_Value'];
                // $total_products = $row_data['total_products'];
                // $invoice_number = $row_data['invoice_number'];
                $order_status = ($row_data['Order_Status'] == 'Processing') ? 'Shipped' : 'Delivered';
                $order_date = $row_data['Order_Purchase_TimeStamp'];

                echo "<tr>
                        <td>$number</td>
                        <td>$amount_value</td>
                        <td>$order_date</td>
                        <td>$order_status</td>
                        <td><a href='ShowConfirmpayment.php?order_id=$order_id' class='text-light'>confirm</a></td>
                    </tr>";
                $number++;
            }
            ?>
        </tbody>
    </table>
</body>
</html>





    