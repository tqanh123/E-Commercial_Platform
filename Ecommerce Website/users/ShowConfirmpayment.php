<?php 
include ('../includes/connect.php');


if(isset ($_Get ['oder_id'])){
    $order_id=$_GET  ['oder_id'];
    $selecct_data = "select * from `user_orders` where order_id=$order_id";
    $result= mysqli_query($con,$select_data);
    $row_fetch=mysqli_fetch_assoc ($result);
    $invoice_number=$row_fetch ['invoice_number'];
    $amount_due=$row_fetch['amount_due'];

} 

if(isset ($_POST['Show_Confirm_payment'])){
    $invoice_number = $_POST ['invoice_number'];
    $amount = $_POST ['amount'];
    $payment_mode = $_POST ['payment_mode'];
    $insert_querry="insert into `user_payments` (order_id,invoice_number,amount,payment_mode)
    values  ($order_id,$invoice_number, $amount,'$payment_mode')";
    $result= mysqli_query($con,$$insert_query);
    if ($result) {
        echo "<h3 class=' text-center text-light'>Succesfully completed the payment </h3>";
        echo "<scripted> window.open ('profile.php?my_orders','_self')</script>";

    }
    $update_orders="update `user_odrders` set_order_status= 'complete' where order_id = $order_id";
    $result_orders= mysqli_query($con,$$insert_query);

}
?>















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Custom styles */
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 50%;
            margin: 0 auto;
        }

        .form-group label {
            color: #fff;
        }

        .btn-confirm {
            margin-top: 1rem;
        }
    </style>
</head>
<body class="bg-secondary">
    <h1 class="text-center text-light">Confirm Payment</h1>
    <div class="container my-5">
        <form action="" method="post">
            <div class="form-group my-4">
                <input type="text" class="form-control" name="invoice_number" placeholder="Invoice Number">
            </div>
            <div class="form-group my-4">
                <label for="" class="text-light">Amount</label>
                <input type="text" class="form-control" name="amount">
            </div>
            <div class="form-group my-4">
                <select name="payment_mode" class="form-select">
                    <option>Select Payment Mode</option>
                    <option>UPI</option>
                    <option>Netbanking</option>
                    <option>MOMO</option>
                    <option>Cash on Delivery</option>
                    <option>Pay Offline</option>
                </select>
            </div>
            <div class="form-group my-4">
                <input type="text" class="form-control" name="voucher_code" placeholder="Enter voucher code">
            </div>
            <div class="form-group my-4">
                <input type="submit" class="btn btn-info btn-confirm" value="Confirm" name="confirm_payment">
            </div>
        </form>
    </div>
    <?php
    require_once 'Confirmpayment.php';
    foreach ($buyers as $buyer) {
        echo "<tr>";
        // echo "<td>" . $buyer['Customer_ID'] . "</td>";
        echo "<td>" . $buyer['Buyer_Name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
</body>
</html>




