<?php
require_once 'php_action/core.php';
require_once 'php_action/extras.php';

$branch = $_SESSION['branch'];
$role = $_SESSION['role_type'];

$currentDate = date('Y-m-d');
$badge = '';

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

if ($role != 'admin') {
  $sql .= " WHERE p.status = 1 AND branch = '$branch' 
              AND p.quantity > 0";
} else {
  $sql .= " WHERE p.status = 1 AND p.quantity > 0";
}

if ($result->num_rows > 0) {
  $count = 0;
  while ($row = $result->fetch_assoc()) {
    $isActive = $row['quantity'] > 0 ? true : false;
    $expiryDate = date('Y-m-d', strtotime($row['expiry_date']));

    $dateDifference = dateDiffInDays($currentDate, $expiryDate);

    if ($isActive) {
      if ($dateDifference <= 0 || $dateDifference <= 7) {
        $count += 1;
      }
    }
  }
  $badge .= "<span class='badge'>" . $count . "</span>";
}

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Tab Title -->
  <title>Nerissa's Grocery Store's Inventory Management System</title>

  <!-- bootstrap -->
  <link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
  <!-- bootstrap theme-->
  <link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
  <!-- font awesome -->
  <link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">

  <!-- qrscanner -->
  <script src="/stock/assests/plugins/qrscanner/adapter.min.js"></script>
  <script src="assests/plugins/qrscanner/vue.min.js"></script>
  <script src="assests/plugins/qrscanner/instascan.min.js"></script>

  <!-- jquery -->
  <script src="assests/jquery/jquery-3.6.1.min.js"></script>
  <!-- jquery ui -->
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
  <script src="assests/bootstrap/js/bootstrap.min.js"></script>

</head>
<!-- Whole Background Color -->

<body style="background-color: #ffffff">

  <!-- Header BG Color -->
  <nav class="navbar navbar-static-top" style="background-color: #eda034;">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div>
          <img style="padding: 15px" src="./assests/images/banner.png" width="200" alt="banner">
        </div>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <!-- Right Title Bar is the Selection -->
        <ul class="nav navbar-nav navbar-right" style="padding-top: 25px; font-size: 1.1em">

          <li id="navDashboard"><a href="index.php" style="color: white;"><i class="glyphicon glyphicon-list-alt"></i> Dashboard</a></li>

          <li id="navBrand"><a href="brand.php" style="color: white;"><i class="glyphicon glyphicon-btc"></i> Brand</a></li>

          <li id="navCategories"><a href="categories.php" style="color: white;"> <i class="glyphicon glyphicon-th-list"></i> Category</a></li>

          <li id="navProduct"><a href="product.php" style="color: white;"> <i class="glyphicon glyphicon-ruble"></i> Product </a></li>

          <li id="navReport"><a href="report.php" style="color: white;"> <i class="glyphicon glyphicon-check"></i> Report </a></li>

          <li id="navExpired"><a href="expiredProducts.php" style="color: white;">Product Alerts<?php echo $badge ?></a></li>

          <?php
          if ($_SESSION['role_type'] == 'admin') {
          ?>
            <li id="navUsers"><a href="users.php" style="color: white;"> <i class="glyphicon glyphicon-user"></i> Users </a></li>
          <?php } ?>

          <li class="dropdown" id="navSetting">
            <a style="color: white;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Setting</a></li>
              <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
            </ul>
          </li>

        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <div class="container">