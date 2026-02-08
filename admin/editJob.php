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
                            <strong>Edit Job</strong>
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
                            <h5>Edit Job</h5>
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
								$id = mysqli_real_escape_string($conn, $_POST['id']);
							$insert = $conn->query("UPDATE jobs SET name= '".$name."',description= '".$description."', email= '".$email."', phone= '".$phone."', company= '".$company."', location= '".$location."', type= '".$type."', position= '".$position."', website= '".$website."', initials= '".$initials."' , updated='".date('Y-m-d')."' WHERE id=".$id);
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
						$testimonial = $conn->query("SELECT * FROM jobs WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Contact Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="name" value="<?php echo $testimonial['name']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contact Email</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="email" value="<?php echo $testimonial['email']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Contact Phone</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="phone" value="<?php echo $testimonial['phone']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Company Name</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="company" value="<?php echo $testimonial['company']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Location</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="location" value="<?php echo $testimonial['location']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Type</label>
                                    <div class="col-sm-10">
									<select class="form-control" required name="type">
										<option value="Full-time Employment" <?php if($testimonial['type'] == 'Full-time Employment') {echo 'selected';} ?>>Full-time Employment</option>
										<option value="Part-time Employment" <?php if($testimonial['type'] == 'Part-time Employment') {echo 'selected';} ?>>Part-time Employment</option>
										<option value="Full-T/Part-time Employment" <?php if($testimonial['type'] == 'Full-T/Part-time Employment') {echo 'selected';} ?>>Full-T/Part-time Employment</option>
										<option value="Independent Contractor" <?php if($testimonial['type'] == 'Independent Contractor') {echo 'selected';} ?>>Independent Contractor</option>
									</select></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Position</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="position" value="<?php echo $testimonial['position']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Website</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="website" value="<?php echo $testimonial['website']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Job Description</label>
                                    <div class="col-sm-10"><textarea class="form-control ckeditor" name="description"><?php echo $testimonial['description']; ?></textarea></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Enter Your Initials</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="initials" value="<?php echo $testimonial['initials']; ?>"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
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