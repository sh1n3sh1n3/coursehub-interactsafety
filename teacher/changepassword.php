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
                    <h2>Change Password </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Change Password</strong>
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
                            <h5>Change Password</h5>
                        </div>
						<?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$oldpass = md5($_POST['oldpass']);
								$newpass = md5($_POST['newpass']);
								$newpass1 = $_POST['newpass'];
								$id = mysqli_real_escape_string($conn, $_POST['id']);
								if($admin['password'] == $oldpass) {
									$insert = $conn->query("UPDATE teachers SET password= '".$newpass."' ,pass1= '".$newpass1."' WHERE id=".$id);
									if($insert){
										$msg = 'Data Updated Successfully.';
									} else {
										$err = $conn->error;
									}
								} else {
									$err = "Wrong old password!!";
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
							<input type="hidden" name="id" value="<?php echo $_SESSION['teacher']; ?>"/>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Old Password</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="oldpass"></div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">New Password</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="newpass"></div>
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