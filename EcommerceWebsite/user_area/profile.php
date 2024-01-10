<?php 
include ('../includes/connect.php');
session_start();

$sql = "select * from `Product`";
$result = $conn->query($sql);

$cart_id = $_SESSION['Cart_ID'];
$sql_cart = "SELECT * FROM `cartitem` WHERE Cart_ID = '$cart_id'";
$res_cart = mysqli_query($conn, $sql_cart);
$num_row = mysqli_num_rows($res_cart);

if (isset($_POST['update_client_account'])) {
    //update client
    $name = $_POST['name'];
    $bankname = $_POST['bankname'];
    $account_id = $_POST['id'];
    $bankid = $_POST['bankid'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    //$password = sha1(md5($_POST['password']));
    $address  = $_POST['address'];

    $profile_pic  = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "../image/user/" . $_FILES["profile_pic"]["name"]);

    //Insert Captured information to a database table
    $query = "UPDATE `Account` SET username=?, bankname=?, Phone_Number=?, email=?, address=?, BankAccountNumber=?,  profile_picture=? WHERE account_id = ?";
    $stmt = $conn->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('sssssisi', $name, $bankname, $phone, $email,  $address, $bankid, $profile_pic, $account_id);
    $stmt->execute();

    //declare a varible which will be passed to alert function
    if ($stmt) {
        echo "<script> alert('User Account Updated') </script>";
        echo "<script>window.open('profile.php','_self')</script>";
    } else {
        echo "<script> alert('Please Try Again Or Try Later') </script>";
        echo "<script>window.open('profile.php','_self')</script>";
    }
}
//change password
if (isset($_POST['change_client_password'])) {
    $password = $_POST['password'];
    $hasPass = password_hash($password, PASSWORD_DEFAULT);
    $account_id = $_SESSION['account_id'];
    $old = $_POST['old'];
    $confirm = $_POST['confirm'];

    $select_query = "Select * from `account` where account_id='$account_id' ";
    $result = mysqli_query($conn, $select_query);
    $row_data = mysqli_fetch_assoc($result);

    if (!password_verify($old, $row_data['Password'])) {
        echo "<script> alert('Wrong Password') </script>";
        echo "<script>window.open('profile.php','_self')</script>";
    }
    else if ($password != $confirm) {
        echo "<script> alert('Wrong confirm Password ') </script>";
        echo "<script>window.open('profile.php','_self')</script>";
    }
    else {
        //insert unto certain table in database
        $query = "UPDATE `Account` SET Password = '$hasPass' WHERE account_id=$account_id";
        $stmt = mysqli_query($conn, $query);
        //declare a varible which will be passed to alert function
        if ($stmt) {
            echo "<script> alert('User Password Updated') </script>";
            echo "<script>window.open('profile.php','_self')</script>";
        } else {
            echo "<script> alert('Please Try Again Or Try Later') </script>";
            echo "<script>window.open('profile.php','_self')</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <!-- bootstrap CSS link -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- font awesome link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
     integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
     <!--CSS file-->
     <link rel="stylesheet" href="../style.css">
    </head>
<body>
<!--navbar-->
<div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="container-fluid">
    <img src="../image/ghost_logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="home.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../cart.php"><i class="fa-solid fa-cart-shopping"></i><span id ="badge"><?php echo "$num_row" ?> </span></a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
   
<!-- Second child-->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <ul class="navbar-nav me-auto">
  <?php
  // echo session_id(); 
  // echo $_SESSION['username'];
          if (!isset($_SESSION['username'])) {
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcom Guest</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcom $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='logout.php'>Logout</a></li>";
          }
      ?>
  </ul>
</nav>
<!-- Third child-->
<div class="bg-light">
    <h3 class="text-center">Hidden Store</h3>
    <p class="text-center">Communication is at the heart of e-commerce and community</p>
    
<div class="content-wrapper">
        <!-- Content Header with logged in user details (Page header) -->
        <?php
        $Customer_ID = $_SESSION['Cart_ID'];
        $ret = "SELECT c.account_id, username, bankName, address, Phone_number, BankAccountNumber, email, profile_picture FROM  Customer c, Account a  WHERE c.Customer_id = $Customer_ID AND c.account_id = a.account_id";
        $res = mysqli_query($conn, $ret);
        while ($row = $res->fetch_assoc()) {
            //set automatically logged in user default image if they have not updated their pics
            $img = $row['profile_picture']; 
            if ($img == '') {
                $profile_picture = " <img class='img-fluid' src='../image/user/user_icon.png' alt='User profile picture'> ";
            } else {
                $profile_picture = " <img class=' img-fluid' src='../image/user/$img' alt='User profile picture'>";
            }
        ?>
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="card card-purple card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <?php echo $profile_picture; ?>
                                    </div>
                                    <h3 class="profile-username text-center"><?php echo $row['username']; ?></h3>
                                    <p class="text-muted text-center">Client @iBanking </p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>ID no: </b> <a class="float-right" style="color: black; text-decoration: none;"><?php echo $row['account_id']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Bank: </b> <a class="float-right" style="color: black; text-decoration: none;"><?php echo $row['bankName']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>ID Bank: </b> <a class="float-right" style="color: black; text-decoration: none;"><?php echo $row['BankAccountNumber']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Email: </b> <a class="float-right" style="color: black; text-decoration: none;"><?php echo $row['email']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Phone: </b> <a class="float-right" style="color: black; text-decoration: none;"><?php echo $row['Phone_number']; ?></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Address: </b> <a class="float-right" style="color: black; text-decoration: none;"><?php echo $row['address']; ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card" style="width: 90%;">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#update_Profile" data-toggle="tab">Update Profile</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#Change_Password" data-toggle="tab">Change Password</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <!-- / Update Profile -->
                                        <div class="tab-pane active" id="update_Profile">
                                            <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Customer ID</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" required readonly name="id" value="<?php echo $row['account_id']; ?>" id="inputName2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="name" required class="form-control" value="<?php echo $row['username']; ?>" id="inputName">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" name="email" required value="<?php echo $row['email']; ?>" class="form-control" id="inputEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Contact</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" required name="phone" value="<?php echo $row['Phone_number']; ?>" id="inputName2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Bank Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" required readonly name="bankname" value="<?php echo $row['bankName']; ?>" id="inputName2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Bank ID</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" required readonly name="bankid" value="<?php echo $row['BankAccountNumber']; ?>" id="inputName2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" required name="address" value="<?php echo $row['address']; ?>" id="inputName2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Profile Picture</label>
                                                    <div class="input-group col-sm-8">
                                                        <div class="custom-file">
                                                            <input type="file" name="profile_pic" class=" form-control custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label col-form-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button name="update_client_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                    </div>
                                                </div>
                                            </form> 
                                        </div>
                                        <!-- /Change Password -->
                                        <div class="tab-pane" id="Change_Password">
                                            <form method="post" class="form-horizontal">
                                        
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="old" class="form-control" required id="inputName">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="password" class="form-control" required id="inputEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputName2" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" name="confirm" class="form-control" required id="inputName2">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" name="change_client_password" class="btn btn-outline-success">Change Password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.nav-tabs-custom -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        <?php } ?>
</div>
<!--last child-->
<div class="bg-info p-3 text-center footer">
  <p>Together we make differences in 20 years || 2003-2023<p>
      </div>
<!-- bootstrap js link-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>
</html>

<script>
    // Select all nav items
    var navItems = document.querySelectorAll('.nav-item .nav-link');

    // Add click event listener to each nav item
    navItems.forEach(function(navItem) {
        navItem.addEventListener('click', function(event) {
            // Remove active class from all nav items
            navItems.forEach(function(navItem) {
                navItem.classList.remove('active');
            });

            // Add active class to clicked nav item
            event.target.classList.add('active');
        });
    });

    window.addEventListener( 'popstate', function(event) {
        var tabPanes = document.querySelectorAll('.tab-pane');

        // Remove active class from all nav items
        tabPanes.forEach(function(tab) {
            tab.classList.remove('active');
        });

        // select element with id
        if (window.location.hash === '#update_Profile') {
            var specificTab = document.getElementById('update_Profile');
        }
        if (window.location.hash === '#Change_Password') {
            var specificTab = document.getElementById('Change_Password');
        }

        // add active class for specific element
        specificTab.classList.add('active');
    });                                         
</script>