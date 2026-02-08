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
                    <h2>Update Orders</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="orders.php">Orders</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update Orders</strong>
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
                            <h5>Update Orders</h5>
                        </div>
						<?php $err = $msg = '';
							if(isset($_POST['submit'])) {
								$assign_to = mysqli_real_escape_string($conn, $_POST['assign_to']);
								$alreadyassign = $_POST['alreadyassign'];
								$courseid = $_POST['courseid'];
								$count = $_POST['count'];
								$id = mysqli_real_escape_string($conn, $_POST['id']);
    							$insert = $conn->query("UPDATE sale SET assign_to= '".$assign_to."', assigned = '1', assign_at='".date('Y-m-d H:i:s')."', updated='".date('Y-m-d')."' WHERE id=".$id);
    							if($alreadyassign == '0') {
    							    $nowcount = $count + 1;
    							    $conn->query("UPDATE remain_places SET count = '".$nowcount."' WHERE courseid = '".$courseid."'");
    							}
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
    						$testimonial = $conn->query("SELECT * FROM sale WHERE id=".$_GET['id'])->fetch_assoc();
    						$remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid=".$testimonial['courseid'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
							<input type="hidden" name="count" value="<?php echo $remain_places['count']; ?>"/>
							<input type="hidden" name="courseid" value="<?php echo $testimonial['courseid']; ?>"/>
							<input type="hidden" name="alreadyassign" value="<?php echo $testimonial['assigned']; ?>"/>
								<div class="form-group  row"><label class="col-sm-2 col-form-label">Assign to</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" required name="assign_to">
                                            <option value="">Select</option>
                                            <?php $teachers = $conn->query("SELECT * FROM teachers WHERE status='1'");
                                            while($fetchteacher = $teachers->fetch_assoc()) { ?>
                                            <option value="<?php echo $fetchteacher['id']; ?>" <?php if($testimonial['assign_to'] == $fetchteacher['id']) {echo 'selected';}?>><?php echo $fetchteacher['title']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
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