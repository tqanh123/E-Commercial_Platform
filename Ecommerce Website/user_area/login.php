<?php
    session_start();

    include("db.php");
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $gmail = $_POST['mail'];
        $password = $_POST['pass'];

        if(!empty($gmail) && !empty($password) && !is_numeric($gmail))
        {
            $query = "select * from form where email ='$gmail' limit 1";
            $result =mysqli_query($con, $query);

            if($result)
            {
                if($result && mysqli_num_rows($result) >0)
                {
                    $user_data = mysqli_fetch_assoc($result);

                    if($user_data['pass'] == $password)
                    {
                        header("location: index.php");
                        die;

                    }
                }
            }
            echo"<script type='text/javascript'> alert('Wrong username or password! Please try again')</script>";
        }
        else{
            echo"<script type='text/javascript'> alert('Wrong username or password! Please try again')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form login and register</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body{
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <div class="login">
    <h1>Sign up</h1>
    <h4>Welcome to our E-Commerce Website</h4>
    <form method="POST">
        <label>Email</label>
        <input type="email" 
        placeholder="Enter your Email" autocomplete="off" name="mail" required>
        <label>Password</label>
        <input type="password"
        placeholder="Enter your password" autocomplete="off" name="pass" required>
        <input type="submit" name="" value="Submit">
    </form>
    <p>Not have account? <a href="signup.php">Sign up here</a></p>
    </div>
    </body>
    </html>
    <?php
    if(isset($_POST['login'])){
        $gmail =$_POST['mail'];
        $password=$_POST['pass'];
        $select_query="Select * from `register`where gmail='$gmail'";
        $result=mysqli_query($con,$select_query);
        $row_count=mysqli_num_rows($result);
        $row_data=mysqli_fetch_assoc($result);
        $user_ip=getIPAddress();


        // cart item
        $select_query_cart="Select * from `cart_details`where address='$user_ip'";
        $select_cart=mysqli_query($con,$select_query_cart);
        $row_count_cart=mysqli_num_rows($result_count_cart);

        
        if($row_count>0){
            if(passwoed_verify($password,$row_data['pass'])){
                // echo"<script>alert('Login successful!')</scipt>"
                if($row_count==1 and $row_count_cart==0){
                    echo"<script>alert('Login successful!')</scipt>";
                    echo"<script>window.open('profile.php','_self')</script>";
                }else{
                    echo"<script>alert('Login successful!')</scipt>";
                    echo"<script>window.open('payment.php','_self')</script>";
                }
            }else{
                echo"<script>alert('Invalid Credentials')</scipt>";
            }
        }else{
                echo"<script>alert('Invalid Credentials')</scipt>";
        }

    }
?>