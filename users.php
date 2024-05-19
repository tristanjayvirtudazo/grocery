<?php

require_once 'includes/header.php';

$current_userId = $_SESSION['userId'];

if (isset($_POST['createUser'])) {
	$full_name = $_POST['full_name'];
	$reg_username = $_POST['regUsername'];
	$reg_password = md5($_POST['regPassword']);
	$branch_name = $_POST['branch_name'];
	$role = $_POST['role_type'];

	$sql_reg = "INSERT INTO users (username, password, full_name, branch_name, role) VALUES ('$reg_username', '$reg_password', '$full_name', '$branch_name', '$role')";

	if ($connect->query($sql_reg) != TRUE) {
		$errors[] = "Registration unsuccessful.";
	}
}

?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
			<li><a href="dashboard.php">Home</a></li>
			<li class="active">Users</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading" style="background:#ed1c23; color: white;">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Users</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-warning button1" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add User </button>
				</div> <!-- /div-action -->

				<table class="table" id="manageCategoriesTable">
					<thead>
						<tr>
							<th>Full Name</th>
							<th>Username</th>
							<th>Branch</th>
							<th>Role</th>
							<th style="width:15%;">Options</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$fetchUsers = "SELECT * FROM users WHERE user_id != '$current_userId'";
						$results = $connect->query($fetchUsers);

						if ($results->num_rows > 0) {
							while ($row = $results->fetch_assoc()) {
						?>
								<tr>
									<td><?php echo $row['full_name']; ?></td>
									<td><?php echo $row['username']; ?></td>
									<td><?php echo $row['branch_name']; ?></td>
									<td><?php echo $row['role']; ?></td>
									<td>
										<a href="php_action/removeUser.php?user=<?php echo $row['user_id'] ?>" class="btn-sm btn-danger" name="removeBtn"><i class="glyphicon glyphicon-trash"></i> Remove</a>
									</td>
								</tr>
							<?php
							}
						} else {
							?>
							<tr>
								<td colspan="6" class="text-center">No Data</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


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
								<select class="form-control" name="branch_name" id="branch_name" disabled>
									<option value="SSB Brigade Branch" selected>SSB Brigade Branch</option>
									<option value="Balatan Branch">Balatan Branch</option>
									<option value="Dalandan Branch">Dalandan Branch</option>
								</select>
								<!-- <input type="text" class="form-control" id="branch_name" name="branch_name" value="" placeholder="Username" autocomplete="off" readonly /> -->
							</div>
						</div>
						<div class="form-group">
							<label for="role_type" class="col-sm-3 control-label">Role Type:</label>
							<div class="col-sm-9">
								<select class="form-control" name="role_type" id="role_type">
									<option value="admin">Admin</option>
									<option value="user">User</option>
								</select>
								<!-- <input type="text" class="form-control" id="branch_name" name="branch_name" value="" placeholder="Username" autocomplete="off" readonly /> -->
							</div>
						</div>

					</fieldset>

					<div class="qr_section hidden">
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
<script src="custom/js/generate.js"></script>

<?php require_once 'includes/footer.php'; ?>