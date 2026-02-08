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
                    <h2>Jobs </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="jobs.php">Jobs</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Job</strong>
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
                            <h5>Add Job</h5>
                        </div>
						<?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$name = mysqli_real_escape_string($conn, $_POST['name']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$phone = mysqli_real_escape_string($conn, $_POST['phone']);
								$company = mysqli_real_escape_string($conn, $_POST['company']);
								$location = mysqli_real_escape_string($conn, $_POST['location']);
								$type = mysqli_real_escape_string($conn, $_POST['type']);
								$position = mysqli_real_escape_string($conn, $_POST['position']);
								$website = mysqli_real_escape_string($conn, $_POST['website']);
								$initials = mysqli_real_escape_string($conn, $_POST['initials']);
								$description = mysqli_real_escape_string($conn, $_POST['description']);
							$insert = $conn->query("INSERT INTO jobs (name,description,status,email,phone,company,location,type,position,website,initials) VALUES('".$name."','".$description."','1','".$email."','".$phone."','".$company."','".$location."','".$type."','".$position."','".$website."','".$initials."')");
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
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contact Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="name" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contact Email</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="email" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contact Phone</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="phone" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Company Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="company" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Location</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="location" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Type</label>
                                    <div class="col-sm-10">
									<select class="form-control" required name="type">
										<option value="Full-time Employment">Full-time Employment</option>
										<option value="Part-time Employment">Part-time Employment</option>
										<option value="Full-T/Part-time Employment">Full-T/Part-time Employment</option>
										<option value="Independent Contractor">Independent Contractor</option>
									</select></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Position</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="position" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Website</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="website" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Description</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="description"></textarea></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Enter Your Initials</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="initials" value=""></div>
                                </div>
                                <div class="hr-line-dashed"></div>    
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Submit</button>
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