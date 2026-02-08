<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Information</title>
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
                    <h2>Information </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Information</strong>
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
                            <h5>Update Information</h5>
                        </div>
						<?php $err = $msg = '';
						if(isset($_POST['submit'])) {
							$address = mysqli_real_escape_string($conn, $_POST['address']); 
							$invoiceadd = mysqli_real_escape_string($conn, $_POST['invoiceadd']); 
							$mailing = mysqli_real_escape_string($conn, $_POST['mailing']); 
							$email = mysqli_real_escape_string($conn, $_POST['email']); 
							$contact = mysqli_real_escape_string($conn, $_POST['contact']); 
							$working = mysqli_real_escape_string($conn, $_POST['working']);  
							$about = mysqli_real_escape_string($conn, $_POST['about']);  
							$facebook = mysqli_real_escape_string($conn, $_POST['facebook']);  
							$instagram = mysqli_real_escape_string($conn, $_POST['instagram']);  
							$youtube = mysqli_real_escape_string($conn, $_POST['youtube']);  
							$whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);  
							$phone = mysqli_real_escape_string($conn, $_POST['phone']); 
							$linkden = mysqli_real_escape_string($conn, $_POST['linkden']); 
							$twitter = mysqli_real_escape_string($conn, $_POST['twitter']); 
							$insert = $conn->query("UPDATE information SET invoiceadd='".$invoiceadd."',mailing='".$mailing."', linkden = '".$linkden."',twitter = '".$twitter."',address = '".$address."',email = '".$email."',contact = '".$contact."',working = '".$working."', about = '".$about."', facebook = '".$facebook."', instagram = '".$instagram."', youtube = '".$youtube."', whatsapp = '".$whatsapp."', phone = '".$phone."' WHERE id='1'");
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
						$about = $conn->query("SELECT * FROM information WHERE id='1'")->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">  
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contact</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="contact" value="<?php echo $about['contact']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="email" value="<?php echo $about['email']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Working Hours</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="working" value="<?php echo $about['working']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="address" rows="4"><?php echo $about['address']; ?></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Mailing</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="mailing" rows="4"><?php echo $about['mailing']; ?></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Invoice Address</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="invoiceadd" rows="4"><?php echo $about['invoiceadd']; ?></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">About</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="about" rows="4"><?php echo $about['about']; ?></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Facebook</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="facebook" value="<?php echo $about['facebook']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Instagram</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="instagram" value="<?php echo $about['instagram']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Youtube</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="youtube" value="<?php echo $about['youtube']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Whatsapp</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="whatsapp" value="<?php echo $about['whatsapp']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="phone" value="<?php echo $about['phone']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Twitter</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="twitter" value="<?php echo $about['twitter']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">LinkedIn</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="linkden" value="<?php echo $about['linkden']; ?>"/></div>
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