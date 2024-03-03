<?php require_once 'includes/header.php'; ?>

<?php 
require_once 'php_action/extras.php';

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

if($role != 'admin'){
	$new_sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, categories.categories_name
	FROM releases
	INNER JOIN product ON product.product_id = releases.product_id
	INNER JOIN brands ON brands.brand_id = releases.brand
	INNER JOIN categories ON categories.categories_id = releases.category
	WHERE releases.branch = '$branch'";
}else{
	$new_sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, categories.categories_name
	FROM releases
	INNER JOIN product ON product.product_id = releases.product_id
	INNER JOIN brands ON brands.brand_id = releases.brand
	INNER JOIN categories ON categories.categories_id = releases.category";
}

$second_query = $connect->query($new_sql);


// $lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
// $lowStockQuery = $connect->query($lowStockSql);
// $countLowStock = $lowStockQuery->num_rows;

$connect->close();
?>

<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-check"></i>	Attendance Report
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="php_action/getAttendanceReport.php" method="get" id="getAttendanceReportForm">
				  <div class="form-group">
				    <label for="startDate1" class="col-sm-2 control-label">Start Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="startDate1" name="startDate1" placeholder="Start Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate1" class="col-sm-2 control-label">End Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="endDate1" name="endDate1" placeholder="End Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Generate Report</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<!-- /col-dm-12 -->

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-check"></i>	Products Report
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="php_action/getProductReport.php" method="get" id="getProductReportForm">
				  <div class="form-group">
				    <label for="startDate2" class="col-sm-2 control-label">Start Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="startDate2" name="startDate2" placeholder="Start Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate2" class="col-sm-2 control-label">End Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="endDate2" name="endDate2" placeholder="End Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Generate Report</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<!-- /col-dm-12 -->

	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-check"></i>	Releases Report
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="php_action/getReleaseReport.php" method="get" id="getReleaseReportForm">
				  <div class="form-group">
				    <label for="startDate3" class="col-sm-2 control-label">Start Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="startDate3" name="startDate3" placeholder="Start Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate3" class="col-sm-2 control-label">End Date</label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="endDate3" name="endDate3" placeholder="End Date" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success" id="generateReportBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Generate Report</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<!-- /col-dm-12 -->
</div>
<!-- /row -->


<div class="row" id="attendanceTable" hidden>
	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Attendance Report</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull-left">
					<label for="employeeSearch">Search : </label>
					<input type="search" name="employeeSearch" id="employeeSearch" placeholder="All">
				</div>
				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" id="exportAttendance"> <i class="glyphicon glyphicon-plus-sign"></i> Export Report </button>
				</div> <!-- /div-action -->	
							
				
				<table class="table" id="manageAttendanceTable1">
					<thead>
						<tr>						
							<th>Date</th>
							<th>Employee Name</th>							
							<th>Time-In</th>
							<th>Time-Out</th>
							<th>Branch</th>
							<th>Work Hours</th>
						</tr>
					</thead>
					<tbody id="attendanceList">
					</tbody>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
	</div> <!-- /panel -->	
</div>

<div class="row" id="productTable" hidden> 
	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Product Report</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" id="exportProduct"> <i class="glyphicon glyphicon-plus-sign"></i> Export Report </button>
				</div> <!-- /div-action -->	
							
				
				<table class="table" id="manageProductTable2">
					<thead>
						<tr>						
							<th>Product Name</th>
							<th>Price</th>							
							<th>Quantity</th>
							<th>Brand</th>
							<th>Category</th>
							<th>Manufactured Date</th>
							<th>Expiry Date</th>
							<th>Status</th>		
							<th>Branch</th>
						</tr>
					</thead>
					<tbody id="productList">
					</tbody>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	
</div>

<div class="row" id="releaseTable" hidden>
	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Release Report</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" id="exportReleases"> <i class="glyphicon glyphicon-plus-sign"></i> Export Report </button>
				</div> <!-- /div-action -->	
							
				
				<table class="table" id="manageProductTable3">
					<thead>
						<tr>
							<th>Product Name</th>
							<th>Number of Items Released</th>
							<th>Brand</th>
							<th>Category</th>
							<th>Date</th>
							<th>Branch</th>
							<th>Accumulated Price</th>
						</tr>
					</thead>
					<tbody id="releaseList">
						<?php
							echo "<tr>
									<td colspan='6' class='text-center' style='font-weight: bold; font-size: 18px;'>Total</td>
									<td>&#8369; ".revenueCount($second_query)."</td>
								</tr>"
						?>
					</tbody>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	
</div>



<script src="custom/js/report.js"></script>
<script src="assests/plugins/datatables/jquery.table2excel.js"></script>

<?php require_once 'includes/footer.php'; ?>