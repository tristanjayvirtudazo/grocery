<?php
require_once 'php_action/db_connect.php';

session_start();

if (isset($_SESSION['userId'])) {
	header('location: https://nerissas-grocery.store/dashboard.php');
}

$sql = "SELECT * FROM branch";
$result = $connect->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
	<title>Nerissa's Grocery Store</title>

	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

	<!-- custom css -->
	<link rel="stylesheet" href="custom/css/custom.css">

	<!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
	<!-- jquery ui -->
	<link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
	<script src="assests/jquery-ui/jquery-ui.min.js"></script>

	<!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>
</head>

<body style="box-sizing: border-box;">
	<div class="container">
		<br><br><br><br>
		<div style="width: 100%;display: flex; justify-content: center;">
			<img style="text-align:center;" src="./assests/images//banner.png" width="400" alt="banner">
		</div>
		<br>
		<div class="row text-center">
			<div>
				<h3>SSB Brigade Branch</h3>
				<h5>Block 7, Lot 7, SSB Brigade, Western Bicutan Taguig City</h5>
				<h1><a href="./login.php?branch=1" class="btn btn-default btn-lg btn-warning">Branch 1</a></h1>
			</div>

			<!-- <div class="col-md-4">
				<h3>16 Dalandan st.</h3>
				<h5>Western Bicutan Taguig City</h5>
				<h1><a href="./login.php?branch=b3" class="btn btn-default btn-lg btn-primary">Branch 3</a></h1>
			</div> -->
		</div>
	</div>
	<!-- container -->
</body>

</html>