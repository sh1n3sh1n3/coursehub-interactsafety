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
                    <h2>Update Results</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update Results</strong>
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
                            <h5>Update Results</h5>
                        </div>
						<?php $err = $msg = '';
							if(isset($_POST['submit'])) {
								$totalomarks = mysqli_real_escape_string($conn, $_POST['totalomarks']);
								$remarks = 'Marks updated by admin';
								$id = mysqli_real_escape_string($conn, $_POST['id']);
							$insert = $conn->query("UPDATE mock_history SET totalomarks= '".$totalomarks."',remarks= '".$remarks."' WHERE id=".$id);
							if($insert){
								$msg = 'Order Updated Successfully.';
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
						$mock_history = $conn->query("SELECT * FROM mock_history WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $mock_history['id']; ?>"/>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Total Marks</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="totalomarks" value="<?php echo $mock_history['totalomarks']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Update changes</button>
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