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
                    <h2>Students </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="students.php">Students</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Student</strong>
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
                            <h5>Add Student</h5>
                        </div>
						<?php 
						$err = $msg = '';
						if(isset($_POST['submit'])) {
							$name = mysqli_real_escape_string($conn, $_POST['name']);
							$phone = mysqli_real_escape_string($conn, $_POST['phone']);
							$email = mysqli_real_escape_string($conn, $_POST['email']);
							$status = mysqli_real_escape_string($conn, $_POST['status']);
							$dob = mysqli_real_escape_string($conn, $_POST['dob']);
							$gender = mysqli_real_escape_string($conn, $_POST['gender']);
							$fathername = mysqli_real_escape_string($conn, $_POST['fathername']);
							$certificatenumber = mysqli_real_escape_string($conn, $_POST['certificatenumber']);
							$issuedate = mysqli_real_escape_string($conn, $_POST['issuedate']);
							$insert = $conn->query("INSERT INTO students (certificatenumber,issuedate,name,phone,email,status,gender,fathername,dob,created_by) VALUES('".$certificatenumber."','".$issuedate."','".$name."','".$phone."','".$email."','".$status."','".$gender."','".$fathername."', '".$dob."', '".$_SESSION['admin']."')");
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
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="name" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Father's Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="fathername" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Date of Birth</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="dob" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10"><input type="number" class="form-control" required name="phone" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10"><input type="email" class="form-control" required name="email" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Registration Number</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="certificatenumber" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Issue Date</label>
                                    <div class="col-sm-10"><input type="date" class="form-control" required name="issuedate" value=""></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Gender</label>
                                    <div class="col-sm-10">
										<select class="form-control m-b" required name="gender">
											<option value="">Select</option>
											<option value='Male'>Male</option>
											<option value='Female'>Female</option>
										</select>
                                    </div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
										<select class="form-control m-b" required name="status">
											<option value="">Select</option>
											<option value='1' selected>Yes</option>
											<option value='0'>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Save</button>
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