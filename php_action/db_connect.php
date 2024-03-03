<?php 	

$localhost = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "stock";
$port = "3307";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname, $port);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}
echo mysqli_error($connect);
?>