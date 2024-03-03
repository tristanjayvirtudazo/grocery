<?php
require_once 'core.php';
// Assuming you have retrieved the start and end dates from the HTML form
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date));

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

if($role != 'admin'){
	$sql = "SELECT product.branch, product.product_id, product.product_name, product.brand_id,
	product.categories_id, product.manufactured_date, product.expiry_date, product.quantity, product.price, product.active, product.status, 
	brands.brand_name, categories.categories_name FROM product 
   	INNER JOIN brands ON product.brand_id = brands.brand_id 
   	INNER JOIN categories ON product.categories_id = categories.categories_id  
   	WHERE product.status = 1 AND branch = '$branch' AND product.date BETWEEN '$start_date' AND '$end_date'";
}else{
	$sql = "SELECT product.branch, product.product_id, product.product_name, product.brand_id,
	product.categories_id, product.manufactured_date, product.expiry_date, product.quantity, product.price, product.active, product.status, 
	brands.brand_name, categories.categories_name FROM product 
   	INNER JOIN brands ON product.brand_id = brands.brand_id 
   	INNER JOIN categories ON product.categories_id = categories.categories_id  
   	WHERE product.status = 1 AND product.date BETWEEN '$start_date' AND '$end_date'";
}

// Execute the query
$result = $connect->query($sql);

// Check if the query was successful
if ($result) {
    // Create an array to store the fetched data
    $data = array();

    // Fetch the rows and add them to the data array
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Convert the data array to JSON format
    $json_data = json_encode($data);

    // Return the JSON response
    header('Content-Type: application/json');
    echo $json_data;
} else {
    echo "Error executing query: " . $connect->error;
}

// Close the database connection
$connect->close();
?>
