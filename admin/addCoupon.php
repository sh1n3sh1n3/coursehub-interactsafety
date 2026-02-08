<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
<?php include('includes/head.php'); ?>
</head>

<body>

    <div id="wrapper">
    <?php include('includes/sidebar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <?php include('includes/header.php'); ?>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Discount Coupons </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="coupons.php">Discount Coupons</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Discount Coupon</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Add Discount Coupon</h5>
                        </div>
						<?php $err = $msg = '';
							if(isset($_POST['submit'])) {
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$discount = mysqli_real_escape_string($conn, $_POST['discount']);
							$insert = $conn->query("INSERT INTO coupons (title,discount) VALUES('".$title."','".$discount."')");
							if($insert){
								$msg = 'Data Added Successfully.';
							} else {
								$err = $conn->error;
							}
						}
						if(!empty($err)){
						  echo "
							<div class='alert alert-danger alert-dismissible'>
							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							  <h4><i class='fa fa-warning'></i> Error!</h4>
							  ".$err."
							</div>
						  ";
						}
						if(!empty($msg)){
						  echo "
							<div class='alert alert-success alert-dismissible'>
							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							  <h4><i class='fa fa-check'></i> Success!</h4>
							  ".$msg."
							</div>
						  ";
						}
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10"><input type="text" id="checkuser" class="form-control" onchange="checkcode(this.value)" required name="title" value="">
									<p id="accounterr" style="color:red"></p></div>
                                </div>
                                <div class="hr-line-dashed"></div>             
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Discount</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="discount" value=""></div>
                                </div>
                                <div class="hr-line-dashed"></div>    
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="reset">Cancel</button>
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/footer.php'); ?>

        </div>
        </div>
<?php include('includes/foot.php'); ?>
<script>
function checkcode(title) {
	$.ajax({
        url: "checkcode.php",
        type: "POST",
        data: {title:title}
    }).done(function(data){
		if(data == '1') {
			$('#accounterr').html('').html('Coupon already exist!');
			$('#accounterr').css('display', 'block');
			$('#checkuser').val('');
		}
    })
}
</script>
</body>
</html>