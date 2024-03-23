<?php require_once 'includes/header.php'; ?>

<?php
require_once 'php_action/extras.php';

date_default_timezone_set("Asia/Manila");
echo date_default_timezone_get();

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

if ($role != 'admin') {
	$new_sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, categories.categories_name
	FROM releases
	INNER JOIN product ON product.product_id = releases.product_id
	INNER JOIN brands ON brands.brand_id = releases.brand
	INNER JOIN categories ON categories.categories_id = releases.category
	WHERE releases.branch = '$branch'";
} else {
	$new_sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, categories.categories_name
	FROM releases
	INNER JOIN product ON product.product_id = releases.product_id
	INNER JOIN brands ON brands.brand_id = releases.brand
	INNER JOIN categories ON categories.categories_id = releases.category";
}


$new_query = $connect->query($new_sql);
$second_query = $connect->query($new_sql);


// $lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
// $lowStockQuery = $connect->query($lowStockSql);
// $countLowStock = $lowStockQuery->num_rows;

$connect->close();

?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">

<div class="row" style="margin-bottom: 30px;">
	<div class="col-md-12">
		<div class="card">
			<div class="cardHeader">
				<h3>Scan for Attendance</h3>
			</div>

			<div class="cardContainer">
				<div id="scannerContainer" hidden>
					<video id="preview" width="500px" height="500px"></video><br>
					<form class="form-horizontal" id="attendanceTypeForm">
						<div class="form-group">
							<label for="attendance_type" class="col-sm-3 control-label">Time-In / Time-Out: </label>
							<label class="col-sm-1 control-label">: </label>
							<div class="col-sm-4">
								<select type="text" class="form-control" id="attendance_type" name="attendance_type">
									<option value="">~~SELECT~~</option>
									<option value="Time-in">Time-in</option>
									<option value="Time-out">Time-out</option>
								</select>
							</div>
						</div>
					</form>
				</div>
				<button id="openCamera" class="btn btn-primary">Click to Scan QR Code</button>
			</div>
		</div>
	</div>
</div>

<div class="row">

	<div class="col-md-4">
		<div class="card">
			<div class="cardHeader" style="background-color:#245580;">
				<h1><?php echo $countProduct; ?></h1>
			</div>

			<div class="cardContainer">
				<p>Total Products</p>
			</div>
		</div>
	</div>

	<!-- <div class="col-md-4">
			<div class="panel panel-info">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Total Orders
					<span class="badge pull pull-right"></span>
				</a>
					
			</div> 
		</div> 
		</div>  -->

	<!-- <div class="col-md-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="product.php" style="text-decoration:none;color:black;">
					Low Stock
					<span class="badge pull pull-right"><></span>	
				</a>
				
			</div> 
		</div>
	</div> -->

	<div class="col-md-4 align-self-center">
		<div class="card">
			<div class="cardHeader">
				<h1><?php echo date('d'); ?></h1>
			</div>

			<div class="cardContainer">
				<p><?php echo date('l jS \of F Y'); ?></p>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="cardHeader" style="background-color:#245580;">
				<h1>&#8369; <?= revenueCount($second_query) ?></h1>
			</div>

			<div class="cardContainer">
				<p> <i class="glyphicon glyphicon-peso"></i> Total Revenue</p>
			</div>
		</div>
	</div>



</div> <!--/row-->

<div class="row" style="margin-top: 50px;">
	<div class="panel panel-default">
		<div class="panel-heading">Item Release Logs</div>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Product Name</th>
					<th>Number of Items Released</th>
					<th>Brand</th>
					<th>Accumulated Price</th>
					<th>Category</th>
					<th>Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$row_count = 1;
				while ($row = $new_query->fetch_array()) {
				?>
					<tr>
						<th scope="row"><?= $row_count; ?></th>
						<td><?= $row[0] ?></td>
						<td><?= $row[1] ?></td>
						<td><?= $row[4] ?></td>
						<td><?= $row[2] ?></td>
						<td><?= $row[5] ?></td>
						<td><?= $row[3] ?></td>
					</tr>
				<?php
					$row_count++;
				}
				?>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="codeValidation" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<form class="form-horizontal" id="submitValidation" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Validate Code</h4>
				</div>

				<div class="modal-body" style="max-height:450px; overflow:auto;">

					<div id="add-product-messages"></div>

					<fieldset>
						<div class="form-group">
							<label for="password" class="col-sm-3 control-label">Password:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required />
							</div>
						</div>
					</fieldset>
				</div> <!-- /modal-body -->

				<div class="modal-footer">
					<button type="button" id="modalClose" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

					<button type="submit" name="validate" class="btn btn-primary" id="validate" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
				</div> <!-- /modal-footer -->
			</form> <!-- /.form -->
		</div> <!-- /modal-content -->
	</div> <!-- /modal-dailog -->
</div>

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function() {
		// top bar active
		$('#navDashboard').addClass('active');

		//Date for the calendar events (dummy data)
		var date = new Date();
		var d = date.getDate(),
			m = date.getMonth(),
			y = date.getFullYear();

		$('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'title'
			},
			buttonText: {
				today: 'today',
				month: 'month'
			}
		});


	});
</script>

<script src="custom/js/dashboard.js"></script>
<?php require_once 'includes/footer.php'; ?>
