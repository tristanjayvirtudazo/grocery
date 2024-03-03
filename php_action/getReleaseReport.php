<?php

require_once 'core.php';
// Assuming you have retrieved the start and end dates from the HTML form
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$start_date = date('Y-m-d', strtotime($start_date));
$end_date = date('Y-m-d', strtotime($end_date));

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

// Construct the SQL query with the dynamic dates
if($role != 'admin'){
	$sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name, 
    categories.categories_name, releases.branch
	FROM releases
	INNER JOIN product ON product.product_id = releases.product_id
	INNER JOIN brands ON brands.brand_id = releases.brand
	INNER JOIN categories ON categories.categories_id = releases.category
	WHERE releases.branch = '$branch' AND releases.release_date BETWEEN '$start_date' AND '$end_date'";
}else{
	$sql = "SELECT product.product_name, releases.total_released, releases.total_released_price, releases.release_date, brands.brand_name,
    categories.categories_name, releases.branch
	FROM releases
	INNER JOIN product ON product.product_id = releases.product_id
	INNER JOIN brands ON brands.brand_id = releases.brand
	INNER JOIN categories ON categories.categories_id = releases.category
    WHERE releases.release_date BETWEEN '$start_date' AND '$end_date'";
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
