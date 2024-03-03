<?php
include 'php_action/postReview.php';

$branchId = $_GET['branchId'];
$fetchSql = "SELECT * FROM reviews WHERE branch_id = '$branchId'";
$result = $connect->query($fetchSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://js.hcaptcha.com/1/api.js" async defer></script>

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



  <title>Reviews</title>
</head>
<body>
  <br>
  <br><br>
  <div class="container">
    <div class="row" id="expiryTable"> 
      <div class="panel panel-default">
            <div class="panel-heading">
              <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Reviews</div>
                      
            </div> <!-- /panel-heading -->

            <div class="panel-body">
              <div class="div-action pull pull-right" style="padding-bottom:20px;">
                <button class="btn btn-default button1" data-toggle="modal" id="addReviewModalBtn" data-target="#addReviewModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Review </button>
              </div> <!-- /div-action -->	

              <?php if(!empty($statusMsg)){ ?>
                <p class="col-sm-3 alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></p>
              <?php }?>
              
              <?php
              if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
              ?>
              <div class="review">
                <hr width="100%">
                  <div class="reviewer">
                    <strong><?= $row['name'];  ?></strong>
                  </div>
                  <div class="review-content">
                    <div class="review-text">
                      <?= $row['review']; ?>
                    </div>
                    <div class="review-date">
                      <?= $row['date']; ?>
                    </div>
                  </div>
                <hr width="100%">
              </div>
              <?php
                }
              }else{
              ?>

              <div class="review">
                <hr width="100%">
                  <div class="review-content">
                    <div class="review-text">
                      No Data.
                    </div>
                  </div>
                <hr width="100%">
              </div>

              <?php }
              $connect->close();
              ?>
              <!-- /table -->

            </div> <!-- /panel-body -->
      </div> <!-- /panel -->	
    </div>

      <!-- add review -->
      <div class="modal fade" tabindex="-1" role="dialog" id="addReviewModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><i class="glyphicon glyphicon-eye"></i> Add Review</h4>
            </div>
            <div class="modal-body">

              <form class="form-horizontal" id="postReviewForm" action="" method="POST">				    
                  <br />

                <input type="text" class="hidden" name="branchId" id="branchId" value="<?php echo $_GET['branchId']; ?>">

                <div class="form-group">
                <label for="fullName" class="col-sm-3 control-label">Full Name: </label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" id="fullName" placeholder="Full Name" name="fullName" autocomplete="off">
                  </div>
                </div> <!-- /form-group-->
                
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label">Email: </label>
                    <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" autocomplete="off">
                    </div>
                </div> <!-- /form-group-->

                <div class="form-group">
                  <label for="comment" class="col-sm-3 control-label">Comment: </label>
                    <div class="col-sm-8">
                    <textarea class="form-control" name="comment" id="comment" cols="30" rows="10"></textarea>
                    </div>
                </div> <!-- /form-group-->

                <div class="form-group">
                  <label for="captcha" class="col-sm-3 control-label">Captcha </label>
                  <div class="col-sm-8">
                    <div class="h-captcha" data-sitekey="59e2ba2f-a50a-414b-9dd6-dec59d778b1d"></div>
                  </div>  
                </div>
                

                <div class="modal-footer editProductFooter1">
                  <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
                  
                  <button type="submit" class="btn btn-success" id="postBtn" name="postBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Post</button>
                </div> <!-- /modal-footer -->				     
              </form> <!-- /.form -->		
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <!-- /categories brand -->

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

  </div>
</body>
</html>




<script src="custom/js/expiry.js"></script>
<script src="custom/js/product.js"></script>
<script src="custom/js/reviews.js"></script>

<?php require_once 'includes/footer.php'; ?>