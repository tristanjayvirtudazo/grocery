<?php

require_once 'core.php';

$data = $_GET['obj'];
$response = [
                "data"  => [],
                "items" => 0
            ];
$productName = $data['productName'];
$unit        = $data['unit'];
$brand       = $data['brand'];
$category    = $data['category'];
$price       = $data['price'];
$page        = $data['page'];

$queryString = "";

if ($data['productId'] != ''){
    $product_id = $data['productId'];
}else{
    $product_id = '';
}

if ($page == 'productPage'){
    $queryString .= "SELECT p.product_id, p.price, p.product_name, p.quantity, p.expiry_date, p.brand_id, p.categories_id
                FROM product AS p
                WHERE p.product_name = '$productName' AND
                      p.status = 1 AND
                      p.active = 1 AND
                      p.unit = '$unit' AND
                      p.brand_id = '$brand' AND 
                      p.categories_id = '$category' AND
                      p.price = '$price' AND
                      p.quantity > 0";
}elseif ($page == 'expiryPage') {
    $queryString .= "SELECT p.product_id, p.price, p.product_name, p.quantity, p.expiry_date, p.brand_id, p.categories_id
                FROM product AS p
                WHERE p.status = 1 AND
                      p.active = 1 AND
                      p.product_id = $product_id AND
                      p.quantity > 0";
}

$result = $connect->query($queryString);

if($result->num_rows > 0 && $result->num_rows < 2){
    array_push($response["data"],mysqli_fetch_assoc($result));
}else if($result->num_rows >= 2){
    while($row = mysqli_fetch_assoc($result)){
        array_push($response["data"], $row);
        $response["items"] += 1;
    }
}

$connect->close();

header("Content-Type: application/json");
echo json_encode($response);

