<?php
require_once 'php_action/db_connect.php';

session_start();

if (isset($_SESSION['userId'])) {
	header('location: https://nerissas-grocery.store/dashboard.php');
}

if (!$_GET['branch']) {
	header('Location: https://nerissas-grocery.store/index.php');
}

$errors = array();
$branchID = trim($_GET['branch']);

$branchQuery = "SELECT street FROM branch WHERE id = '$branchID' LIMIT 1";
$branchResult = $connect->query($branchQuery);
$branch = mysqli_fetch_assoc($branchResult);

$selectedBranch = trim($branch['street']);

if ($_POST) {
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (empty($username) || empty($password)) {
			if ($username == "") {
				$errors[] = "Username is required.";
			}

			if ($password == "") {
				$errors[] = "Password is required.";
			}
		} else {
			$password = md5($password);
			$sql = "SELECT * FROM users WHERE  username = '$username' AND password = '$password' AND (TRIM(branch_name) = '$selectedBranch' OR role = 'admin')";
			echo $sql;
			$result = mysqli_query($connect, $sql);
			mysqli_error($connect);

			if ($result->num_rows == 1) {
				$value = mysqli_fetch_assoc($result);
				$user_id = $value['user_id'];

				// set session
				$_SESSION['userId'] = $user_id;
				$_SESSION['branch'] = $selectedBranch;
				$_SESSION['full_name'] = $value['full_name'];
				$_SESSION['role_type'] = $value['role'];

				header('location: https://nerissas-grocery.store/dashboard.php?branch=' . $value['branch_name']);
			} else {

				$errors[] = "Incorrect username/password combination. Please try again.";
			}
		}
		// /else not empty username // password
	} elseif (isset($_POST['createUser'])) {
		$full_name = $_POST['full_name'];
		$reg_username = $_POST['regUsername'];
		$reg_password = md5($_POST['regPassword']);
		$branch_name = $_POST['branch_name'];

		$sql_reg = "INSERT INTO users (username, password, full_name, branch_name) VALUES ('$reg_username', '$reg_password', '$full_name', '$branch_name')";

		if ($connect->query($sql_reg) != TRUE) {
			$errors[] = "Registration unsuccessful.";
		}
		header('location: https://nerissas-grocery.store/login.php?branch=' . $_GET['branch']);
	}

	$connect->close();
} // /if $_POST
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
	<img src="./assests/images/logo.png" alt="logo">
	<div class="container">
		<div class="row vertical">
			<div class="col-md-5 col-md-offset-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h1 class="panel-title text-center">Welcome to Nerissa's Grocery Store Inventory System <br> (<?= $selectedBranch ?>)</h1>
					</div>
					<div class="panel-body">

						<div class="messages">
							<?php if ($errors) {
								foreach ($errors as $key => $value) {
									echo '<div class="alert alert-warning" role="alert">
									<i class="glyphicon glyphicon-exclamation-sign"></i>
									' . $value . '</div>';
								}
							} ?>
						</div>

						<form class="form-horizontal" method="post" id="loginForm">
							<fieldset>
								<div class="form-group">
									<label for="username" class="col-sm-2 control-label">Username:</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" required />
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-2 control-label">Password:</label>
									<div class="col-sm-10">
										<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required />
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-6">
										<button type="submit" name="login" id="login" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i> Login</button>
									</div>
									<!-- <div class="col-sm-3">
										<a href="" data-toggle="modal" id="addProductModalBtn" class="btn btn-default btn-primary" data-target="#addProductModal">Sign-Up</a>
									</div> -->

								</div>
							</fieldset>
						</form>
						<div>
							<a href="./index.php">
								< Back to Portal</a>
									<a class="pull-right" href="./reviews.php?branchId=<?php echo $branchID; ?>">Post Reviews ></a>
						</div>
					</div>
					<!-- panel-body -->
				</div>
				<!-- /panel -->
			</div>
			<!-- /col-md-4 -->
		</div>
		<!-- /row -->

		<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">

					<form class="form-horizontal" id="submitUser" method="POST">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Sign-Up</h4>
						</div>

						<div class="modal-body" style="max-height:450px; overflow:auto;">

							<div id="add-product-messages"></div>

							<fieldset>
								<div class="form-group">
									<label for="full_name" class="col-sm-3 control-label">Full Name:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="full_name" name="full_name" placeholder="ex. Juan Dela Cruz" autocomplete="off" required />
									</div>
								</div>
								<div class="form-group">
									<label for="regUsername" class="col-sm-3 control-label">Username:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="regUsername" name="regUsername" placeholder="Username" autocomplete="off" required />
									</div>
								</div>
								<div class="form-group">
									<label for="regPassword" class="col-sm-3 control-label">Password:</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Password" autocomplete="off" required />
									</div>
								</div>
								<div class="form-group">
									<label for="regConfPassword" class="col-sm-3 control-label">Confirm Password:</label>
									<div class="col-sm-9">
										<input type="password" class="form-control" id="regConfPassword" name="regConfPassword" placeholder="Password" autocomplete="off" required />
										<small class="text-danger" hidden id="notMatch"><i><strong>Password did not match.</strong></i></small>
										<small class="text-success" hidden id="match"><i><strong>Password matched.</strong></i></small>
									</div>
								</div>
								<div class="form-group">
									<label for="branch_name" class="col-sm-3 control-label">Branch Name:</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="branch_name" name="branch_name" value="<?= $selectedBranch ?>" placeholder="Username" autocomplete="off" readonly />
									</div>
								</div>
							</fieldset>

							<div class="qr_section">
								<div class="row">
									<div class="col-sm-3">
										<button disabled id="qrBTN" type="button" class="btn btn-default" onclick="revealQR()">Generate QR Code</button>
									</div>
									<div class="col-sm-9" id="qr_field" hidden>
										<img id="qr_image" src="" alt="QR Code"><br>
										<a id="qr_exporter" href="" download class="btn btn-primary glyphicon glyphicon-download-alt" style="text-decoration:none; color: white;"> Download</a>
									</div>
								</div>
							</div>

						</div> <!-- /modal-body -->

						<div class="modal-footer">
							<button type="button" id="modalClose" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

							<button type="submit" name="createUser" class="btn btn-primary" id="createUser" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
						</div> <!-- /modal-footer -->
					</form> <!-- /.form -->
				</div> <!-- /modal-content -->
			</div> <!-- /modal-dailog -->
		</div>
		<!-- /add categories -->
	</div>

	<!-- container -->
	<script src="custom/js/login.js"></script>
	<script src="custom/js/generate.js"></script>
</body>

</html>