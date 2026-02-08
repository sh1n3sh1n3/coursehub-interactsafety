<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Counts</title>
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
                    <h2>Web Counts </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="dashboard.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Web Counts</strong>
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
                            <h5>Web Counts</h5>
                        </div>
						<?php $err = $msg = '';
						if(isset($_POST['submit'])) {
							$courses = mysqli_real_escape_string($conn, $_POST['courses']); 
							$rating = mysqli_real_escape_string($conn, $_POST['rating']); 
							$laststudents = mysqli_real_escape_string($conn, $_POST['laststudents']); 
							$students = mysqli_real_escape_string($conn, $_POST['students']); 
							$insert = $conn->query("UPDATE counts SET courses = '".$courses."',rating = '".$rating."',laststudents = '".$laststudents."',students = '".$students."' WHERE id='1'");
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
						$about = $conn->query("SELECT * FROM counts WHERE id='1'")->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data"> 
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">All Students Count</label>
                                    <div class="col-sm-10"><input type="number" class="form-control" name="students" value="<?php echo $about['students']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Last Year Students Count</label>
                                    <div class="col-sm-10"><input type="number" class="form-control" name="laststudents" value="<?php echo $about['laststudents']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Rating Count</label>
                                    <div class="col-sm-10"><input type="number" step=".1" class="form-control" name="rating" value="<?php echo $about['rating']; ?>"/></div>
                                </div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Courses Count</label>
                                    <div class="col-sm-10"><input type="number" class="form-control" name="courses" value="<?php echo $about['courses']; ?>"/></div>
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