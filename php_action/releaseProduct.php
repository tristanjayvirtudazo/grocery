<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());
$branch = $_SESSION['branch'];

if($_POST) {
	$productId = $_POST['productId1'];
	$productName 	= $_POST['editProductName1']; 
	$barcodeNumber 	= $_POST['editRate1'];
	$brandName 		= $_POST['editBrandName1'];
	$categoryName 	= $_POST['editCategoryName1'];
	$productStatus 	= $_POST['editProductStatus1'];
	$releaseQuantity = $_POST['releaseQuantity'];

	$fetchsql = "SELECT product_id, product_name, quantity FROM product WHERE product_name = '$productName' and quantity != 0 ORDER BY expiry_date";
	$fetchresult = $connect->query($fetchsql);
	if($fetchresult->num_rows > 0){
		$temp_quantity = intval($releaseQuantity);
		while ($fetchrow = mysqli_fetch_assoc($fetchresult)) {
			if ($temp_quantity != 0){
				$currentProductId = $fetchrow['product_id'];
				$availableQuantity = intval($fetchrow['quantity']);
				$deductedQuantity = min($availableQuantity, $temp_quantity);
				$newQuantity = $availableQuantity - $deductedQuantity;

				$sql = "UPDATE product SET quantity = '$newQuantity' WHERE product_id = '$currentProductId' ";

				try {
					if ($connect->query($sql)) {
						$temp_quantity -= $deductedQuantity;
						$valid['success'] = true;
						$valid['messages'] = "Successfully Update";
					}
				} catch (Exception $e) {
					$valid['success'] = false;
					$valid['messages'] = $e->getMessage();
					echo json_encode($valid);
				}
			}
		}
	}else{
		$valid['success'] = false;
		$valid['messages'] = "Server Error";
		echo json_encode($valid);
	}

    $totalPrice = doubleval($barcodeNumber) * doubleval($releaseQuantity);
				
	
    $sql2 = "INSERT INTO releases (product_id, brand, category, total_released, total_released_price, release_date, branch) 
			VALUES ('$productId', '$brandName', '$categoryName', '$releaseQuantity', '$totalPrice', CURRENT_TIMESTAMP, '$branch')";

	try {
		$connect->query($sql2);

		$valid['success'] = true;
		$valid['messages'] = "Item Released Successfully.";	
	} catch (Exception $e){
		$valid['success'] = false;
		$valid['messages'] = "Server Error";
		echo json_encode($valid);
	}
	
    

} // /$_POST
	 
$connect->close();

echo json_encode($valid);

// header("Location: ../product.php");

 
