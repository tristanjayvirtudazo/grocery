<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<div id="release-product-messages"></div>
<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Product</li>
		</ol>

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Product</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

				<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-default button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Product </button>
				</div> <!-- /div-action -->	
							
				
				<table class="table" id="manageProductTable">
					<thead>
						<tr>
							<th style="width:10%;">Photo</th>							
							<th>Product Name</th>
							<th>Price</th>							
							<th>Quantity</th>
							<th>UOM</th>
							<th>Brand</th>
							<th>Category</th>
							<!-- <th>Manufactured Date</th> -->
							<!-- <th>Expiry Date</th> -->
							<th>Status</th>		
							<th style="width:15%;">Options</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- add product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-product-messages"></div>

	      	<div class="form-group">
	        	<label for="productImage" class="col-sm-3 control-label">Product Image: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
					    <!-- the avatar markup -->
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
					    <div class="kv-avatar center-block">					        
					        <input type="file" class="form-control" id="productImage" placeholder="Product Name" name="productImage" class="file-loading" style="width:auto;"/>
					    </div>
				      
				    </div>
	        </div> <!-- /form-group-->	     	           	       

	        <div class="form-group">
	        	<label for="productName" class="col-sm-3 control-label">Product Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	    

	        <div class="form-group">
	        	<label for="quantity" class="col-sm-3 control-label">Quantity: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	    
			
			<div class="form-group">
	        	<label for="quantity" class="col-sm-3 control-label">Unit of Measure: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="uom" placeholder="UOM" name="uom" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->

	        <div class="form-group">
	        	<label for="rate" class="col-sm-3 control-label">Price: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="number" step="0.01" class="form-control" id="rate" placeholder="Price" name="rate" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
			
			<div class="form-group">
	        	<label for="categoryName" class="col-sm-3 control-label">Category Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select type="text" class="form-control" id="categoryName" placeholder="Category Name" name="categoryName" >
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	

	        <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="brandName" name="brandName">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_active, brand_status, category FROM brands WHERE brand_status = 1 AND brand_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option data-onbrand-category='".$row[4]."' value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->					        	         	       

	        <div class="form-group">
	        	<label for="productStatus" class="col-sm-3 control-label">Status: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="productStatus" name="productStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Available</option>
				      	<option value="2">Not Available</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	 

	        <div class="form-group">
	        	<label for="manif_date" class="col-sm-3 control-label">Manifactured date: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="Date" class="form-control" id="manif_date" placeholder="" name="manufactured_date" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	

	        <div class="form-group" >
	        	<label for="manif_date" class="col-sm-3 control-label">Expiry Date: </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-8">
				      <input type="Date" class="form-control" id="expiry_date" placeholder="Expiry Date" name="expiry_date" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
			
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->

<!-- release Item -->
<div class="modal fade" id="releaseProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	    	
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Release Product</h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">
	      	<div class="div-loading">
	      		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
	      	</div>

	      	<div class="div-result">
				  <!-- Nav tabs -->
				    <div role="tabpanel" class="tab-pane" id="productInfo1">
				    	<form class="form-horizontal" id="releaseProductForm" action="php_action/releaseProduct.php" method="POST">				    
				    		<br />

							<div class="form-group">
							<label for="editProductName1" class="col-sm-3 control-label">Product Name: </label>
							<label class="col-sm-1 control-label">: </label>
								<div class="col-sm-8">
								<input type="text" class="form-control" id="editProductName1" placeholder="Product Name" name="editProductName1" autocomplete="off" readonly>
								</div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="editQuantity1" class="col-sm-3 control-label">Quantity: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<input type="number" class="form-control" id="editQuantity1" placeholder="Quantity" name="editQuantity1" autocomplete="off" readonly>
									</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="unit" class="col-sm-3 control-label">Unit of Measure: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<input type="text" class="form-control" id="releaseUnit" placeholder="UOM" name="releaseUnit" autocomplete="off" disabled>
									</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="editRate1" class="col-sm-3 control-label">Price: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<input type="number" step="0.01" class="form-control" id="editRate1" placeholder="Barcode Number" name="editRate1" autocomplete="off" readonly>
									</div>
							</div> <!-- /form-group-->

							<div class="form-group">
								<label for="releaseType" class="col-sm-3 control-label">Release Type: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
										<div class="row">
											<div class="col-sm-4">
												<input type="radio" id="releaseType1" placeholder="Barcode Number" name="releaseType" autocomplete="off">
												<label for="releaseType1">Wholesale</label>
											</div>
											<div class="col-sm-3">
												<input type="radio" id="releaseType2" placeholder="Barcode Number" name="releaseType" autocomplete="off">
												<label for="releaseType2">Retail</label>
											</div>
										</div>
									</div>
							</div> <!-- /form-group-->		     	        

							<div class="form-group" hidden>
								<label for="editBrandName1" class="col-sm-3 control-label">Brand Name: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<select class="form-control" id="editBrandName1" name="editBrandName1" readonly>
										<option value="">~~SELECT~~</option>
										<?php 
										$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
												$result = $connect->query($sql);

												while($row = $result->fetch_array()) {
													echo "<option value='".$row[0]."'>".$row[1]."</option>";
												} // while
												
										?>
									</select>
									</div>
							</div> <!-- /form-group-->	

							<div class="form-group" hidden>
								<label for="editCategoryName1" class="col-sm-3 control-label">Category Name: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<select type="text" class="form-control" id="editCategoryName1" name="editCategoryName1" >
										<option value="">~~SELECT~~</option>
										<?php 
										$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
												$result = $connect->query($sql);

												while($row = $result->fetch_array()) {
													echo "<option value='".$row[0]."'>".$row[1]."</option>";
												} // while
												
										?>
									</select>
									</div>
							</div> <!-- /form-group-->					        	         	       

							<div class="form-group" hidden>
								<label for="editProductStatus1" class="col-sm-3 control-label">Status: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<select class="form-control" id="editProductStatus1" name="editProductStatus1">
										<option value="">~~SELECT~~</option>
										<option value="1">Available</option>
										<option value="2">Not Available</option>
									</select>
									</div>
							</div> <!-- /form-group-->
							
							<div class="form-group">
								<label for="releaseQuantity" class="col-sm-3 control-label">Number of Quantity to be released: </label>
								<label class="col-sm-1 control-label">: </label>
									<div class="col-sm-8">
									<input type="number" class="form-control" id="releaseQuantity" placeholder="Quantity" name="releaseQuantity" autocomplete="off" >
									</div>
							</div> <!-- /form-group-->	 

							<div class="modal-footer editProductFooter1">
								<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
								
								<button type="submit" class="btn btn-success" id="releaseProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Release</button>
							</div> <!-- /modal-footer -->				     
			        </form> <!-- /.form -->				     	
				    </div>    
				    <!-- /product info -->
				  </div>

				</div>
	      	
	      </div> <!-- /modal-body -->
	      	      
     	
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>

<!-- choose edit modal -->
<div class="modal fade" id="selectEditModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-edit"></i> Select a Product to Edit</h4>
			</div>

			<div class="modal-body">
				<div class="div-result">
					<table class="table">
						<thead>
							<tr>
								<th>Product Name</th>
								<th>Price</th>
								<th>Quantity</th>
								<th>Expiry Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="selectEditTbody">
						</tbody>
					</table>
				</div>
			</div>

		</div>
	</div>
</div>

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

<!-- edit categories brand -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	    	
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Product</h4>
	      </div>
	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div class="div-loading">
	      		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
	      	</div>

	      	<div class="div-result">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab" data-toggle="tab">Photo</a></li>
				    <li role="presentation"><a href="#productInfo" aria-controls="profile" role="tab" data-toggle="tab">Product Info</a></li>    
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">

				  	
				    <div role="tabpanel" class="tab-pane active" id="photo">
				    	<form action="php_action/editProductImage.php" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">

				    	<br />
				    	<div id="edit-productPhoto-messages"></div>

				    	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Product Image: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">							    				   
						      <img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />
						    </div>
			        </div> <!-- /form-group-->	     	           	       
				    	
			      	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Select Photo: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
							    <!-- the avatar markup -->
									<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							    <div class="kv-avatar center-block">					        
							        <input type="file" class="form-control" id="editProductImage" placeholder="Product Name" name="editProductImage" class="file-loading" style="width:auto;"/>
							    </div>
						      
						    </div>
			        </div> <!-- /form-group-->	     	           	       

			        <div class="modal-footer editProductPhotoFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
				        
				        <!-- <button type="submit" class="btn btn-success" id="editProductImageBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button> -->
				      </div>
				      <!-- /modal-footer -->
				      </form>
				      <!-- /form -->
				    </div>
				    <!-- product image -->
				    <div role="tabpanel" class="tab-pane" id="productInfo">
				    	<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">				    
				    	<br />

				    	<div id="edit-product-messages"></div>

				    	<div class="form-group">
			        	<label for="editProductName" class="col-sm-3 control-label">Product Name: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editProductName" placeholder="Product Name" name="editProductName" autocomplete="off">
						    </div>
			        </div> <!-- /form-group-->	    

			        <div class="form-group">
			        	<label for="editQuantity" class="col-sm-3 control-label">Quantity: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="number" class="form-control" id="editQuantity" placeholder="Quantity" name="editQuantity" autocomplete="off">
						    </div>
			        </div> <!-- /form-group-->	      
					
					<div class="form-group">
						<label for="unit" class="col-sm-3 control-label">Unit of Measure: </label>
						<label class="col-sm-1 control-label">: </label>
							<div class="col-sm-8">
							<input type="text" class="form-control" id="unit" placeholder="UOM" name="unit" autocomplete="off">
							</div>
					</div> <!-- /form-group-->

			        <div class="form-group">
			        	<label for="editRate" class="col-sm-3 control-label">Price: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <input type="number" step="0.01" class="form-control" id="editRate" placeholder="Barcode Number" name="editRate" autocomplete="off">
						    </div>
			        </div> <!-- /form-group-->	     	        

			        <div class="form-group">
			        	<label for="editBrandName" class="col-sm-3 control-label">Brand Name: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <select class="form-control" id="editBrandName" name="editBrandName">
						      	<option value="">~~SELECT~~</option>
						      	<?php 
						      	$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
										$result = $connect->query($sql);

										while($row = $result->fetch_array()) {
											echo "<option value='".$row[0]."'>".$row[1]."</option>";
										} // while
										
						      	?>
						      </select>
						    </div>
			        </div> <!-- /form-group-->	

			        <div class="form-group">
			        	<label for="editCategoryName" class="col-sm-3 control-label">Category Name: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <select type="text" class="form-control" id="editCategoryName" name="editCategoryName" >
						      	<option value="">~~SELECT~~</option>
						      	<?php 
						      	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
										$result = $connect->query($sql);

										while($row = $result->fetch_array()) {
											echo "<option value='".$row[0]."'>".$row[1]."</option>";
										} // while
										
						      	?>
						      </select>
						    </div>
			        </div> <!-- /form-group-->					        	         	       

			        <div class="form-group">
			        	<label for="editProductStatus" class="col-sm-3 control-label">Status: </label>
			        	<label class="col-sm-1 control-label">: </label>
						    <div class="col-sm-8">
						      <select class="form-control" id="editProductStatus" name="editProductStatus">
						      	<option value="">~~SELECT~~</option>
						      	<option value="1">Available</option>
						      	<option value="2">Not Available</option>
						      </select>
						    </div>
			        </div> <!-- /form-group-->

					<div class="form-group">
						<label for="manufactured_date" class="col-sm-3 control-label">Manifactured date: </label>
						<label class="col-sm-1 control-label">: </label>
							<div class="col-sm-8">
							<input type="date" class="form-control" id="manufactured_date" placeholder="" name="manufactured_date" autocomplete="off">
							</div>
					</div> <!-- /form-group-->	

					<div class="form-group">
						<label for="expiry_date2" class="col-sm-3 control-label">Expiry Date: </label>
						<label class="col-sm-1 control-label">: </label>
							<div class="col-sm-8">
							<input type="date" class="form-control" id="expiry_date2" placeholder="" name="expiry_date2" autocomplete="off">
							</div>
					</div> <!-- /form-group-->					

			        <div class="modal-footer editProductFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
				        
				        <button type="submit" class="btn btn-success" id="editProductBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
				      </div> <!-- /modal-footer -->				     
			        </form> <!-- /.form -->				     	
				    </div>    
				    <!-- /product info -->
				  </div>

				</div>
	      	
	      </div> <!-- /modal-body -->
	      	      
     	
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- /categories brand -->

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


<script src="custom/js/product.js"></script>

<?php require_once 'includes/footer.php'; ?>