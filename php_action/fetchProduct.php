<?php
require_once 'core.php';

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

$sql = "SELECT p.product_id, p.product_name, p.product_image, p.brand_id,
        p.categories_id, p.manufactured_date, p.expiry_date, SUM(p.quantity) as quantity, p.price, p.active, p.status,
        b.brand_name, c.categories_name, p.unit
        FROM product AS p
        INNER JOIN brands AS b ON p.brand_id = b.brand_id
        INNER JOIN categories AS c ON p.categories_id = c.categories_id";

if ($role != 'admin') {
    $sql .= " WHERE p.status = 1 AND branch = '$branch' AND p.quantity > 0";
} else {
    $sql .= " WHERE p.status = 1 AND p.quantity > 0";
}

$sql .= " GROUP BY p.product_name, p.brand_id, p.categories_id, p.unit, p.price 
          ORDER BY p.product_name, quantity DESC, p.expiry_date DESC";

$result = $connect->query($sql);
$output = ['data' => []];
$temp = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $active = $row['quantity'] > 0 ? "<label class='label label-success'>Available</label>" : "<label class='label label-danger'>Not Available</label>";

        $imageUrl = substr($row['product_image'], 3);
        $productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";
        $price = "&#8369; ".number_format(doubleval($row['price']), 2, '.', ',');

        $button = '';
        if ($row['quantity'] > 0) {
            $productId = $row['product_id'];
            $brandId = $row['brand_id'];
            $categoryId = $row['categories_id'];
            $productName = $row['product_name'];
            $dataPrice = $row['price'];
            $button = '
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a type="button" data-toggle="modal" data-target="#editDialog" id="editProductModalBtn" onclick="checkAction(this)" data-id="'.$productId.'" data-action="edit" data-name="'.$productName.'" data-brand="'.$brandId.'" data-category="'.$categoryId.'" data-price="'.$dataPrice.'"><i class="glyphicon glyphicon-edit"></i> Edit</a></li>
                        <li><a type="button" data-toggle="modal" data-target="#releaseProductModal" id="releaseProductModalBtn" onclick="releaseProduct(this)" data-id="'.$productId.'"><i class="glyphicon glyphicon-share"></i> Release Item</a></li>
                        <li><a type="button" data-toggle="modal" data-target="#editDialog" id="removeProductModalBtn" onclick="checkAction(this)" data-id="'.$productId.'" data-action="delete" data-page="productPage" data-name="'.$productName.'" data-brand="'.$brandId.'" data-category="'.$categoryId.'" data-price="'.$dataPrice.'"><i class="glyphicon glyphicon-trash"></i> Remove</a></li>
                    </ul>
                </div>';
        }

            $currentProduct = $row['product_name'];
            $output['data'][] = [
                $productImage,
                $row['product_name'],
                $price,
                $row['quantity'],
                $row['unit'],
                $row['brand_name'],
                $row['categories_name'],
                // $row['manufactured_date'],
                // $row['expiry_date'],
                $active,
                $button
            ];
    }
}

$connect->close();

echo json_encode($output);
