<?php

// $con = mysqli_connect('localhost', 'root', '', 'e_commercial');
// if (!$con) {
//     die(mysqli_error($con));
// }
$servername = "127.0.0.1:3307";
$username = "root";
$password = "1234";
$dbname = "e_commercial";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>