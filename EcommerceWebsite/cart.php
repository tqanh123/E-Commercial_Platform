<?php

// Database connection
include('./includes/connect.php');
session_start();

    $name = $_SESSION['username'];
    $cart_id = $_SESSION['Cart_ID'];

    $sql = "SELECT * FROM cartitem NATURAL JOIN Product WHERE Cart_ID = '$cart_id'";
    $res = mysqli_query($conn, $sql);

    $num_item = mysqli_num_rows($res);
    $total = 0;
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
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!--CSS file-->
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <!--navbar-->
  <div class="container-fluid p-0">
    <!-- first child -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container-fluid">
        <img src="./image/ghost_logo.png" alt="" class="logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../EcommerceWebsite/user_area/home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="../EcommerceWebsite/cart.php"><i
                  class="fa-solid fa-cart-shopping"></i><span id="badge"><?php echo "$num_item" ?> </span></a>
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
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome Guest</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/login.php'>Login</a></li>";
          }
          else {
            $name = $_SESSION['username'];
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='#'>Welcome $name</a></li>";
            echo "<li class='nav-item'> <a class='nav-link active' aria-current='page' href='./user_area/logout.php'>Logout</a></li>";
          }
      ?>
      </ul>
    </nav>
    <div class="bg-light">
      <h3 class="text-center">Cart</h3>
    </div>

    <div class="container cart">
      <?php
        if ($num_item === 0) {
            ?>
      <div class="bg-light">
        <h3 class="text-center">There is no item here!!</h3>
      </div>
      <?php
        } 
        else {
            while ($row = $res -> fetch_assoc()) {
              $quantity = $row["Cart_Item_Quantity"];
              $price = $row["Price"];
              $total += $quantity * $price;
    ?>
      <div class="card">
        <div class="caption">
          <p class="product Name"> <?php echo $row["Product_Name"]; ?></p>
          <p class="price">Price: <b>$<?php echo $price ?></b></p>
          <p>Description: <?php echo $row["Product_Description"]; ?></p>
          <!-- <button class="quantity " data="-1"citem=" <?php echo $row["Cart_Item_ID"]; ?> ">-</button> -->
          <p class="description quantity" data = "0"citem=" <?php echo $row["Cart_Item_ID"]; ?> "> quantity: <?php echo $quantity ?></p>
          <!-- <button class="quantity" data="1"citem=" <?php echo $row["Cart_Item_ID"]; ?> ">+</button> -->
          <button class="remove" data-citem=" <?php echo $row["Cart_Item_ID"]; ?> "
            data-price="<?php echo ($quantity * $price) ?>"> Remove from cart </button>
        </div>
      </div>
      <?php } ?>
      <div>

        <form method="GET" action="../EcommerceWebsite/users/ShowConfirmpayment.php">
          <!-- <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>"> -->
          <input type="hidden" name="cart_id" value="<?php echo htmlspecialchars($cart_id); ?>">
          <!-- <p name="total" id="total">Total Price: <?php echo $total ?></p> -->
          <button type="submit">Checkout</button>
        </form>
      </div>
      <?php } ?>
    </div>

    <!--last child-->
    <div class="bg-info p-3 text-center footer">
      <p>Together we make differences in 20 years || 2003-2023<p>
    </div>
    <!-- bootstrap js link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>


</body>

</html>

<script>
  var cartitem_id = document.getElementsByClassName("remove");
  for (var i = 0; i < cartitem_id.length; i++) {
    cartitem_id[i].addEventListener("click", function (event) {
      var target = event.target;
      var citem = target.getAttribute('data-citem');
      var iprice = target.getAttribute('data-price');
      // const  = int.Parse(i);

      var xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var data = JSON.parse(this.responseText);
          target.style.opacity = .3;
          target.innerHTML = data.in_cart;
          document.getElementById('badge').innerHTML--;
        }
      }

      xml.open("GET", "includes/connect.php?ci_id=" + citem, true);
      xml.send();
    })
  }

</script>