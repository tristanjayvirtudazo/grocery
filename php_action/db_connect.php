<?php

$localhost = "128.199.248.115";
$username = "developer";
$password = "adminP@ssw0rd";
$dbname = "stock";
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
