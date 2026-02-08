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
                    <h2>Update Makeup Classes </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="makeupClass.php">Makeup Classes</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update Makeup Classes</strong>
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
                            <h5>Edit Makeup Classes</h5>
                        </div>
						<?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {
							    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
								$studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
								$makeupday = mysqli_real_escape_string($conn, $_POST['makeupday']);
								$slotid = mysqli_real_escape_string($conn, $_POST['slotid']);
								$date = mysqli_real_escape_string($conn, $_POST['joindate']);
    							$id = mysqli_real_escape_string($conn, $_POST['id']);
    							$insert = $conn->query("UPDATE makeup_classes SET courseid= '".$courseid."',date= '".$date."',studentid= '".$studentid."',makeupday= '".$makeupday."', slotid= '".$slotid."' WHERE id=".$id);
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
							$testimonial = $conn->query("SELECT * FROM makeup_classes WHERE id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
                            	<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
                        		<div class="form-group  row">
							        <label class="col-sm-1 col-form-label">Course</label>
									<div class="col-sm-3">
										<select class="form-control" required name="courseid">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM courses WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>" <?php if($testimonial['courseid'] == $fetch['id']) {echo 'selected';} ?>><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
									<label class="col-sm-1 col-form-label">Student</label>
									<div class="col-sm-3">
										<select class="form-control" required name="studentid" id="studentid">
											<option value="">Select</option>
											<?php $attandance = $conn->query("SELECT count(*) as count,tbl_student_id FROM tbl_attendance WHERE courseid='".$testimonial['courseid']."' GROUP by tbl_student_id");
                                            while($fetch = $attandance->fetch_assoc()) {
                                                if($fetch['count'] >= '1') {
                                                    $fetchers = $conn->query("SELECT * FROM registration WHERE id=".$fetch['tbl_student_id'])->fetch_assoc();?>
                                                    <option value="<?php echo $fetchers['id']; ?>" <?php if($testimonial['studentid'] == $fetchers['id']) {echo 'selected';} ?>><?php echo $fetchers['title'].' '.$fetchers['fname'].' '.$fetchers['lname']; ?></option>
                                                <?php }
                                            } ?>
										</select>
									</div>
									<label class="col-sm-1 col-form-label pr-0">Makeup Day</label>
                                	<div class="col-sm-3">
										<select class="form-control" required name="makeupday">
											<option value="">Select</option>
											<option value="2" <?php if($testimonial['makeupday'] == '2') {echo 'selected';} ?>>2</option>
											<option value="3" <?php if($testimonial['makeupday'] == '3') {echo 'selected';} ?>>3</option>
											<option value="4" <?php if($testimonial['makeupday'] == '4') {echo 'selected';} ?>>4</option>
											<option value="5" <?php if($testimonial['makeupday'] == '5') {echo 'selected';} ?>>5</option>
										</select>
									</div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
									<label class="col-sm-2 col-form-label"><h4>Available course dates</h4></label>
                                    <div class="col-sm-12" id="courseavailable">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Select Slot</th>
                                                    <th>Select Date</th>
                                                    <th>Course Dates</th>
                                                    <th>Venue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        <?php echo "SELECT * FROM course_slots WHERE courseid='".$testimonial['courseid']."' AND makecapacity > 0 AND startdate >= '".date('Y-m-d')."' AND enddate >= '".date('Y-m-d')."'";
                                        $course_slots = $conn->query("SELECT * FROM course_slots WHERE courseid='".$testimonial['courseid']."' AND makecapacity > 0 AND startdate >= '".date('Y-m-d')."' AND enddate >= '".date('Y-m-d')."'");
                                        while($fetchcouslot = $course_slots->fetch_assoc()) { 
                                        $location = $conn->query("SELECT * FROM locations WHERE id=".$fetchcouslot['locid'])->fetch_assoc();
                                        $cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcouslot['cityid'])->fetch_assoc();
                                        $states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
                                        ?>
                                            <tr>
                                                <td><input type="radio" value="<?php echo $fetchcouslot['id']; ?>" name="slotid" <?php if($testimonial['slotid'] == $fetchcouslot['id']) {echo 'checked';} ?>/></td>
                                                <td><input type="date" value="<?php if($testimonial['slotid'] == $fetchcouslot['id']) {echo $testimonial['date'];} ?>" name="joindate" min="<?php echo $fetchcouslot['startdate']; ?>" max="<?php echo $fetchcouslot['enddate']; ?>"/></td>
                                                <td><?php echo date('d-M-Y', strtotime($fetchcouslot['startdate'])).' '.date('h:i A', strtotime($fetchcouslot['starttime'])).' - '.date('d-M-Y', strtotime($fetchcouslot['enddate'])).' '.date('h:i A', strtotime($fetchcouslot['endtime'])); ?></td>
                                                <td><?php echo $location['title'].' '.$location['location'].' '.$cities['name'].' '.$states['name']; ?></td>
                                            </tr>
                                        <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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
<script>
function getavailCourse(course) {
	$.ajax({
		type: "POST",
		url: 'getavailCourse.php',
		data:{course: course},
		success: function(response){ console.log(response);
		    $("#courseavailable").html('').html(response);
		}
   });
   $.ajax({
		type: "POST",
		url: 'getmakeupStudent.php',
		data:{course: course},
		success: function(response){ console.log(response);
		    $("#studentid").html('').html(response);
		}
   });
}
</script>
</body>
</html>