<?php 

session_start();

require_once 'db_connect.php';

// echo $_SESSION['userId'];

if(!$_SESSION['userId']) {
	header('location: http://128.199.248.115/grocery/stock/index.php');	
} 



?>