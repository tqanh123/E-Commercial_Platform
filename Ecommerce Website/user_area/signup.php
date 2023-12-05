<?php
    session_start();

    include("../includes/connect.php");

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $Username = $_POST['name'];
        $BankName = $_POST['bank'];
        $BankAccountNumber = $_POST['accNum'];
        $Address = $_POST['address'];
        $Gender = $_POST['gender'];
        $Phone_Number = $_POST['number'];
        $Email = $_POST['mail'];
        $password = $_POST['pass'];
        $repassword = $_POST['confirm'];

        if(!empty($Email) && !empty($password) && !is_numeric($Email) && !empty($repassword))
        {
            $select_query="Select * from `account` where email='$Email'";
            $result=$con -> mysqli_query($con,$select_query);
            $rows_count=mysqli_num_rows($result);
            $ID = "Select max(Account_ID) from `account`";

            if($rows_count>0){
                echo "<script>alert('Username already exist')</script>";
            }
            $query = "insert into `account` form(Account_ID, Username, BankName, BankAccountNumber, Password, Address, Gender, Phone_Number, Email, Profile_Picture) 
            values('$ID', '$Username', '$BankName', '$BankAccountNumber', '$password', '$Address', '$Gender', '$Phone_Number', '$Email', NULL)";

            mysqli_query($con, $query);
            if ($password === $repassword) {
               
                echo"<script type='text/javascript'> alert('Password Matched!Successfully Register')</script>";
    
            } else {
                echo "<script type='text/javascript'> alert('Password do not match! Please try again!')</script>";
                
            }
        }
        else
        {
            echo"<script type='text/javascript'> alert('Please enter some Valid Information')</script>";
        }
        // selecting cart items
        $select_cart_items="Select * from `cart` where addrees='$address'";
        $result_cart=mysqli_query($con,$select_cart_items);
        $rows_count=mysqli_num_rows($result_cart);


        if($rows_count>0){

            $_SESSION['gmail']=$Email;
            echo "<script>alert('You have itmes in your cart')</script>";
            echo "<script>window.open('checkout.php','_self')</script>";
        }
        else{
            echo "<script>window.open('../index.php','_self')</script>";
        }

    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form login and register</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="signup">
    <h1>Sign up</h1>
    <h4>Welcome to our E-Commerce Website</h4>
    <form method="POST">
        <label>User name</label>
        <input type="text" 
        placeholder="Enter your user name" autocomplete="off" 
        name="name" required>
        <label>Gender</label>
        <input type="text"
        placeholder="Choose between Male or Female" autocomplete="off"  
        name="gender" required>
        <label>Contact</label>
        <input type="tel" 
        placeholder="Enter your mobile number" autocomplete="off" 
        name="number" required>
        <label>Address</label>
        <input type="text"
        placeholder="Enter your Email" autocomplete="off" name="add" required>
        <label>Bank</label>
        <input type="text"
        placeholder="Enter your Bank" autocomplete="off" name="bank" required>
        <label>Account number</label>
        <input type="text"
        placeholder="Enter your Bank account number" autocomplete="off" name="accNum" required>
        <label>Email</label>
        <input type="email" 
        placeholder="Enter your password" autocomplete="off" 
        name="mail" required>
        <label>Password</label>
        <input type="password"
        placeholder="Enter your password" autocomplete="off" 
        name="pass" required>
        <label>Confirm Password</label>
        <input type="confirm"
        placeholder="Confirm Password" autocomplete="off" 
        name="confirm" required>
        <input type="submit" name="" value="Submit">
    </form>
    <p>By clicking the Submit button, you argee to our<br>
        <a href="">Terms and Condition</a> and <a href="#">Policy Privacy</a>
    </p>
    <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>
</body>
</html>