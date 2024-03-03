<?php
require_once 'core.php';
require_once 'extras.php';

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

$currentDate = date('Y-m-d');


$sql = "SELECT p.product_id, p.product_name, p.product_image, p.brand_id,
        p.categories_id, p.manufactured_date, p.expiry_date, p.quantity, p.price, p.active, p.status,
        b.brand_name, c.categories_name, p.unit
        FROM product AS p
        INNER JOIN brands AS b ON p.brand_id = b.brand_id
        INNER JOIN categories AS c ON p.categories_id = c.categories_id";


if ($role != 'admin') {
    $sql .= " WHERE p.status = 1 AND branch = '$branch' AND p.quantity > 0";
} else {
    $sql .= " WHERE p.status = 1 AND p.quantity > 0";
}

$sql .= " GROUP BY p.expiry_date";

$result = $connect->query($sql);
$output = ['data' => []];
$temp = [];
$count = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $expiryDate = strtotime($row['expiry_date']);
        $isActive = $row['quantity'] > 0 ? true : false;

        $productId = $row['product_id'];
        $brandId = $row['brand_id'];
        $categoryId = $row['categories_id'];
        $productName = $row['product_name'];
        $dataPrice = $row['price'];

        $price = "&#8369; ".number_format(doubleval($row['price']), 2, '.', ',');

       
        $difference = dateDiffInDays($currentDate, date('Y-m-d',$expiryDate));

        if ($isActive) {
            if ($difference > 0 && $difference <= 7) {
                $active = "<label class='label label-warning'>Warning</label>";

                $button = '
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a type="button" data-toggle="modal" data-target="#releaseProductModal" id="releaseProductModalBtn" onclick="releaseProduct(this)" data-id="'.$row['product_id'].'"><i class="glyphicon glyphicon-share"></i> Release Item</a></li>
                        <li><a type="button" data-toggle="modal" data-target="#editDialog" id="removeProductModalBtn" onclick="checkAction(this)" data-action="delete" data-id="'.$row['product_id'].'" data-name="'.$row['product_name'].'" data-brand="'.$row['brand_id'].'" data-page="expiryPage" data-category="'.$row['categories_id'].'" data-price="'.$row['price'].'"><i class="glyphicon glyphicon-trash"></i> Remove</a></li>
                    </ul>
                </div>';

                $currentProduct = $row['product_name'];
                $output['data'][] = [
                    $row['product_name'],
                    $price,
                    $row['quantity'],
                    $row['brand_name'],
                    $row['unit'],
                    $row['categories_name'],
                    // $row['manufactured_date'],
                    $row['expiry_date'],
                    $active,
                    $button,
                ];
            }elseif ($difference <= 0){
                $active = "<label class='label label-danger'>Expired</label>";

                $button = '
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a type="button" data-toggle="modal" data-target="#editDialog" id="removeProductModalBtn" onclick="checkAction(this)" data-id="'.$row['product_id'].'" data-action="delete" data-id="'.$row['product_id'].'" data-name="'.$row['product_name'].'" data-brand="'.$row['brand_id'].'" data-page="expiryPage" data-category="'.$row['categories_id'].'" data-price="'.$row['price'].'"><i class="glyphicon glyphicon-trash"></i> Remove</a></li>
                    </ul>
                </div>';

                $currentProduct = $row['product_name'];
                $output['data'][] = [
                    $row['product_name'],
                    $price,
                    $row['quantity'],
                    $row['brand_name'],
                    $row['unit'],
                    $row['categories_name'],
                    // $row['manufactured_date'],
                    $row['expiry_date'],
                    $active,
                    $button,
                    $difference
                ];
            }
        } else {
            $active = "<label class='label label-danger'>Not Available</label>";
        }
    }
} else {
    // echo 'No Data';
}

$connect->close();

echo json_encode($output);



//Function

