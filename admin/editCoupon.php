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
                            <strong>Edit Discount Coupon</strong>
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
                            <h5>Edit Discount Coupon</h5>
                        </div>
						<?php $err = $msg = '';
							if(isset($_POST['submit'])) {
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$discount = mysqli_real_escape_string($conn, $_POST['discount']);
								$id = mysqli_real_escape_string($conn, $_POST['id']);
							$insert = $conn->query("UPDATE coupons SET title= '".$title."',discount= '".$discount."', updated='".date('Y-m-d')."' WHERE id=".$id);
							if($insert){
								$msg = 'Data Updated Successfully.';
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
						$testimonial = $conn->query("SELECT * FROM coupons WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="title" value="<?php echo $testimonial['title']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>             
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Discount</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="discount" value="<?php echo $testimonial['discount']; ?>"></div>
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
</body>
</html>