<?php 
require_once 'php_action/db_connect.php';

session_start();

if(isset($_SESSION['userId'])) {
	header('location: http://localhost/stock/dashboard.php');	
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
<body>
	<div class="container">
		<br><br><br><br>
		<h1 class="text-center">Nerissa's Grocery Store Branches</h1>
		<br>
		<div class="row text-center">
			<?php
				if($result->num_rows > 0) {
					while($row = mysqli_fetch_assoc($result)){
			?>
			<div class="col-md-4">
				<h3><?php echo $row["street"] ?></h3>
				<h5><?php echo $row['city'] ?></h5>
				<h1><a href="./login.php?branch=<?php echo $row['id']?>" class="btn btn-default btn-lg btn-success">Branch <?php echo $row['id'] ?></a></h1>
			</div>
			<?php
					}
				}
				mysqli_close($connect);	
			?>

			<!-- <div class="col-md-4">
				<h3>141 Balatan st.</h3>
				<h5>Western Bicutan Taguig City</h5>
				<h1><a href="./login.php?branch=b2" class="btn btn-default btn-lg btn-warning">Branch 2</a></h1>
			</div>

			<div class="col-md-4">
				<h3>16 Dalandan st.</h3>
				<h5>Western Bicutan Taguig City</h5>
				<h1><a href="./login.php?branch=b3" class="btn btn-default btn-lg btn-primary">Branch 3</a></h1>
			</div> -->
		</div>
	</div>
	<!-- container -->	
</body>
</html>






	