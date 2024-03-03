<?php 	

require_once 'core.php';

$brandId = $_POST['brandId'];

$sql = "SELECT brands.brand_id, brands.brand_name, brands.brand_active, brands.brand_status, categories.categories_id, categories.categories_name FROM brands
        INNER JOIN categories ON categories.categories_id = brands.brand_id
        WHERE brands.brand_id = $brandId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);