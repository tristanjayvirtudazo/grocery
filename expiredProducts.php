<?php require_once 'includes/header.php'; ?>

<?php 
// require_once 'php_action/extras.php';

// $branch = $_SESSION['branch'];
// $role = $_SESSION['role_type'];

// $sql = "SELECT * FROM product WHERE status = 1";
// $query = $connect->query($sql);
// $countProduct = $query->num_rows;

// if($role != 'admin'){
// 	$new_sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, categories.categories_name
// 	FROM releases
// 	INNER JOIN product ON product.product_id = releases.product_id
// 	INNER JOIN brands ON brands.brand_id = releases.brand
// 	INNER JOIN categories ON categories.categories_id = releases.category
// 	WHERE releases.branch = '$branch'";
// }else{
// 	$new_sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, categories.categories_name
// 	FROM releases
// 	INNER JOIN product ON product.product_id = releases.product_id
// 	INNER JOIN brands ON brands.brand_id = releases.brand
// 	INNER JOIN categories ON categories.categories_id = releases.category";
// }

// $second_query = $connect->query($new_sql);


// // $lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
// // $lowStockQuery = $connect->query($lowStockSql);
// // $countLowStock = $lowStockQuery->num_rows;

// $connect->close();
?>


<div class="row" id="expiryTable"> 
	<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Expired / Expiring Products</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>
							
				<table class="table" id="expiryProductTable">
					<thead>
						<tr>						
							<th>Product Name</th>
							<th>Price</th>							
							<th>Quantity</th>
							<th>Brand</th>
							<th>Unit</th>
							<th>Category</th>
							<th>Expiry Date</th>
							<th>Status</th>	
                            <th>Action</th>	
						</tr>
					</thead>
					<tbody id="expiryList">
					</tbody>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->	
</div>

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Product</h4>
      </div>
      <div class="modal-body">

      	<div class="removeProductMessages"></div>

        <p>Do you really want to remove?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->

<!-- Edit dialouge -->
<div class="modal fade" id="editDialog" tabindex="-1" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
    	    	
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title dynamic-title"><i class="fa fa-edit"></i></h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">
	      	<div class="text-center">
	      		<h5>Would you like to proceed?</h5>
	      	</div>
	      	
	      </div> <!-- /modal-body -->

		  <div class="modal-footer">
		  	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>					
			<button type="button" class="btn btn-primary" id="dialogBtn" data-toggle="modal" data-dismiss="modal"> <i class="glyphicon glyphicon-ok-sign"></i> Proceed</button>
		  </div>
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>



<script src="custom/js/expiry.js"></script>
<script src="custom/js/product.js"></script>

<?php require_once 'includes/footer.php'; ?>