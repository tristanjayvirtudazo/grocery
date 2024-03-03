<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$productId 			= $_POST['productId'];
	$productName 		= $_POST['editProductName']; 
	$barcodeNumber 		= $_POST['editRate'];
	$quantity 			= $_POST['editQuantity'];
	$brandName 			= $_POST['editBrandName'];
	$categoryName 		= $_POST['editCategoryName'];
	$productStatus 		= $_POST['editProductStatus'];
	$manufactured_date 	= $_POST['manufactured_date'];
	$uom 				= $_POST['unit'];
	$expiry_date 		= $_POST['expiry_date2'];


				
	$sql = "UPDATE product SET product_name = '$productName', brand_id = '$brandName', categories_id = '$categoryName', quantity = '$quantity', price = '$barcodeNumber', active = '$productStatus', status = 1, manufactured_date = '$manufactured_date', expiry_date = '$expiry_date', unit = '$uom' WHERE product_id = $productId ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);

header("Location: ../product.php");
 
