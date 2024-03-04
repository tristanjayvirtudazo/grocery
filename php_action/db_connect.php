<?php

$localhost = "nerissas-grocery.store";
$username = "u293422315_stock";
$password = "1k!Uh=rT";
$dbname = "u293422315_stock";
$port = "3306";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname, $port);
// check connection
if ($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}
echo mysqli_error($connect);
