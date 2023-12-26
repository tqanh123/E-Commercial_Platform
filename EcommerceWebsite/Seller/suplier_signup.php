<?php

include("../includes/connect.php");
session_start();

    if(isset($_POST['suplier_register']))
    {
        $Username = $_POST['name'];
        $BankName = $_POST['bank'];
        $BankAccountNumber = $_POST['accNum'];
        $Address = $_POST['address'];
        $Gender = $_POST['gender'];
        $Phone_Number = $_POST['number'];
        $Email = $_POST['mail'];
        $password = $_POST['pass'];
        $hash_pass = password_hash($password, PASSWORD_DEFAULT);
        $repassword = $_POST['confirm'];

        if(!empty($Email) && !empty($password) && !is_numeric($Email) && !empty($repassword))
        {
            $select_query="Select * from `account` where email='$Email' or userName = '$Username' or Phone_Number = '$Phone_Number'";
            $result=mysqli_query($conn,$select_query);
            $rows_count=mysqli_num_rows($result);
            
            if($rows_count>0){
                echo "<script>alert('Shop name, Email or phone number already exist')</script>";
            }
            else if ($password === $repassword) {
                
                $query = "insert into `account` (Username, BankName, BankAccountNumber, Password, Address, Gender, Phone_Number, Email, Profile_Picture)
                values('$Username', '$BankName', '$BankAccountNumber', '$hash_pass', '$Address', NULL, '$Phone_Number', '$Email', NULL)";
                // values('$Username', 'BIDV', 12, '$hash_pass', 'ktx', NULL, '$Phone_Number', '$Email', NULL)";
                
                $insert_acc = mysqli_query($conn, $query);
                if($insert_acc) {

                    $acc = "Select Account_ID from account where Username = '$Username'";
                    $accq = $conn -> query($acc);
                    $ID = $accq -> fetch_array()[0];
                    $cus_query = "insert into `seller` (Account_ID, Seller_Ratings) values('$ID', 0)"; 
                    $insert_cus = mysqli_query($conn, $cus_query);

                    echo"<script type='text/javascript'> alert('Password Matched! Successfully Register!!')</script>";
                    echo "<script>window.open('../user_area/login.php','_self')</script>";
                }
                
            } else {
                echo "<script type='text/javascript'> alert('Password do not match! Please try again!')</script>";
            }
        }
        else
        {
            echo"<script type='text/javascript'> alert('Please enter some Valid Information')</script>";
        }

    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form login and register</title>
    <link rel="stylesheet" href="../user_area/acc.css">
</head>
<body>
    <div class="signup">
    <h1>Suplier sign up</h1>
    <h4>Welcome to our E-Commerce Website</h4>
    <form method="POST" action = "">
        <label>Shop name</label>
        <input type="text" 
        placeholder="Enter your shop name" autocomplete="off" 
        name="name" required>
        <label>Contact</label>
        <input type="tel" 
        placeholder="Enter your mobile number" autocomplete="off" 
        name="number" required>
        <!-- <label>Address</label>
        <input type="text"
        placeholder="Enter your Address" autocomplete="off" name="address" required> -->
        <!-- <label>Bank</label>
        <input type="text"
        placeholder="Enter your Bank" autocomplete="off" name="bank" required>
        <label>Account number</label>
        <input type="text"
        placeholder="Enter your Bank account number" autocomplete="off" name="accNum" required> -->
        <label>Email</label>
        <input type="email" 
        placeholder="Enter your email" autocomplete="off" 
        name="mail" required>
        <label>Password</label>
        <input type="password"
        placeholder="Enter your password" autocomplete="off" 
        name="pass" required>
        <label>Confirm Password</label>
        <input type="password"
        placeholder="Confirm Password" autocomplete="off" 
        name="confirm" required>
        <input type="submit" name="suplier_register" value="Submit">
    </form>
    <p>By clicking the Submit button, you argee to our<br>
        <a href="">Terms and Condition</a> and <a href="#">Policy Privacy</a>
    </p>
    <p>Already have an account? <a href="../user_area/login.php">Login Here</a></p>
    </p>
    <p>You are a customer? <a href="../user_area/signup.php">Click here</a></p>
    </div>
</body>
</html>