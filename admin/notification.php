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
                    <h2>About us </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>About Us</strong>
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
                            <h5>About Us Content</h5>
                        </div>
						<?php 
							$err = $msg = '';
						if(isset($_POST['submit'])) {
							$dashboard = mysqli_real_escape_string($conn, $_POST['dashboard']); 
							$header = mysqli_real_escape_string($conn, $_POST['header']); 
							$checkout = mysqli_real_escape_string($conn, $_POST['checkout']); 
							$insert = $conn->query("UPDATE notifications SET header = '".$header."', dashboard = '".$dashboard."', checkout = '".$checkout."' WHERE id='1'");
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
						$about = $conn->query("SELECT * FROM notifications WHERE id='1'")->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">   
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Top Header</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="header" rows="10"><?php echo $about['header']; ?></textarea></div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Checkout Page</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="checkout" rows="10"><?php echo $about['checkout']; ?></textarea></div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Dashboard</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="dashboard" rows="10"><?php echo $about['dashboard']; ?></textarea></div>
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