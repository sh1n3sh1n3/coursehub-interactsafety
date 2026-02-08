<?php include('session.php'); 
$id = $_SESSION['teacher'];
$select1 = $conn->query("SELECT * FROM teachers WHERE id = '".$id."'")->fetch_assoc();?>
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
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Profile</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Profile</h5>
                        </div>
						<?php $err=$msg='';
							if(isset($_POST['update'])) {
								$name = $_POST['name'];
								$phone = $_POST['phone'];
								$email = $_POST['email'];
								if(isset($_POST['old_pass']) && isset($_POST['new_pass']) && !empty($_POST['old_pass'])&& !empty($_POST['new_pass'])) {
									$old_pass = md5($_POST['old_pass']);
									$new_pass = md5($_POST['new_pass']);
									$new_pass1 = $_POST['new_pass'];
									if($old_pass == $select1['password']){
										$update = $conn->query("UPDATE teachers SET password = '".$new_pass."',pass1 = '".$new_pass1."',title = '".$name."', mobile = '".$phone."',email = '".$email."' WHERE id=".$id);
										if($update){
											$msg = 'Your data has been updated successfully.';
										}else {
											$err = $conn->error;
										}
									} else {
										$err = 'Wrong Old Password';
									}
								} else {
									$update = $conn->query("UPDATE teachers SET title = '".$name."', mobile = '".$phone."',email = '".$email."' WHERE id=".$id);
									if($update){
										$msg = 'Your data has been updated successfully.';
									}else {
										$err = $conn->error;
									}
								}
							}?>
							<?php if(!empty($err)){
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
									$select = $conn->query("SELECT * FROM teachers WHERE id = '".$id."'")->fetch_assoc();?>
                        <div class="ibox-content">
                            <div>
                                <div class="feed-activity-list">
								<form class="account-frm" method="POST">
									<div class="hr-line-dashed"></div>
									<div class="form-group  row"><label class="col-sm-2 col-form-label">Full Name</label>
										<div class="col-sm-10"><input type="text" required class="form-control" name="name" value="<?php echo $select['title']; ?>"></div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group  row"><label class="col-sm-2 col-form-label">Phone</label>
										<div class="col-sm-10"><input type="text" required class="form-control" name="phone" value="<?php echo $select['mobile']; ?>"></div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
										<div class="col-sm-10"><input type="email" required class="form-control" name="email" value="<?php echo $select['email']; ?>"></div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group  row"><label class="col-sm-2 col-form-label">Old Password</label>
										<div class="col-sm-10"><input type="password" class="form-control" name="old_pass" value=""></div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group  row"><label class="col-sm-2 col-form-label">New Password</label>
										<div class="col-sm-10"><input type="password" class="form-control" name="new_pass" value=""></div>
									</div>
									<div class="hr-line-dashed"></div>
									<div class="form-group row">
										<div class="col-sm-4 col-sm-offset-2">
											<button class="btn btn-white btn-sm" type="reset">Cancel</button>
											<button class="btn btn-primary btn-sm" type="submit" name="update">Save changes</button>
										</div>
									</div>
									</form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div><?php include('includes/footer.php'); ?>

        </div>
        </div>
<?php include('includes/foot.php'); ?>
</body>
</html>