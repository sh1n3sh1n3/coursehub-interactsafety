<?php include('session.php');
$updateid = (int) $_GET['id'];
$err = $msg = '';
if(isset($_POST['submit'])) {
    $type = mysqli_real_escape_string($conn, $_POST['type']);
    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
	$locid = mysqli_real_escape_string($conn, $_POST['locid']);
	$city = mysqli_real_escape_string($conn, $_POST['city']);
	$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $maxcapacity = mysqli_real_escape_string($conn, $_POST['maxcapacity']);
    $mincapacity = mysqli_real_escape_string($conn, $_POST['mincapacity']);
    $makecapacity= mysqli_real_escape_string($conn, $_POST['makecapacity']);
    $map_location= '';//mysqli_real_escape_string($conn, $_POST['map_location']);
    $map_location_url= '';//mysqli_real_escape_string($conn, $_POST['map_location_url']);
    $dates_array = $_POST['date'];
    $teacher_array = $_POST['teacherid'];
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$insert = $conn->query("UPDATE course_slots SET map_location= '".$map_location."',map_location_url= '".$map_location_url."',courseid= '".$courseid."',locid= '".$locid."', cityid= '".$city."',maxcapacity='".$maxcapacity."',makecapacity='".$makecapacity."',mincapacity='".$mincapacity."',remarks= '".$remarks."' WHERE id=".$id);
	if($insert){
	    foreach($dates_array as $dkey => $dates) {
	        $date = $dates;
	        $starttime = $_POST['starttime'][$dkey];
	        $endtime = $_POST['endtime'][$dkey];
	        $dateid = $_POST['dateid'][$dkey];
	        if($dateid != '0') {
	            $conn->query("UPDATE course_dates SET date='".$date."', starttime='".$starttime."', endtime='".$endtime."' WHERE id=".$dateid);
	        } else {
	            $conn->query("INSERT INTO course_dates (course_id, slot_id, date, starttime, endtime) VALUES ('".$courseid."','".$id."', '".$date."','".$starttime."','".$endtime."')");
	        }
	    }
	    foreach($teacher_array as $tkey => $teachers) {
	        $teacherid = $teachers;
	        $conn->query("INSERT INTO course_teachers (course_id, slot_id, teacherid) VALUES ('".$courseid."','".$id."','".$teacherid."')");
	    }
	    $conn->query("UPDATE remain_places SET courseid = '".$courseid."', total = '".$maxcapacity."', makecapacity='".$makecapacity."' WHERE slotid='".$id."'");
	    if($type == 'private') {
	        $conn->query("UPDATE private_course SET course_id = '".$courseid."' WHERE slot_id = '".$id."'");
	    }
		$msg = 'Data Added Successfully.';
	} else {
		$err = $conn->error;
	}
}
?>
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
                    <h2>Update Schedule Course </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="courses.php">Courses</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Update Schedule Course</strong>
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
                            <h5>Edit Courses Slots</h5>
                        </div>
						<?php 
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
							$testimonial = $conn->query("SELECT * FROM course_slots WHERE id=".$updateid)->fetch_assoc();
							$private_course = $conn->query("SELECT * FROM private_course WHERE slot_id=".$updateid)->fetch_assoc();
							$all_course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$updateid."' ORDER BY id DESC LIMIT 1")->fetch_assoc();
							$all_course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='".$updateid."' AND status='1' AND is_deleted='0'");
							$teachers_id='';
							while($fetchteach = $all_course_teachers->fetch_assoc()) {
							    $teachers_id .= $fetchteach['teacherid'].',';
							}
							$teachers_id = rtrim($teachers_id,',');
							$rowIdx = $all_course_dates['id'];
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data" action="">
                            	<input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>"/>
                            	<input type="hidden" name="oldtechid" value="<?php echo $testimonial['teacherid']; ?>"/>
                            	<input type="hidden" name="type" value="<?php echo $testimonial['type']; ?>"/>
                        		<div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Course Type</label>
                                        <div class="radio inline" style="padding-top: 6px;">
                                            <input type="radio" onclick="checktype(this.value)" disabled id="Public" value="public" <?php if($testimonial['type'] == 'public') {echo 'checked';} ?>>
                                            <label for="Public"> Public </label>
                                        </div>
                                        <div class="radio inline ml-3" style="padding-top: 6px;">
                                            <input type="radio" onclick="checktype(this.value)" disabled id="Private" value="private" <?php if($testimonial['type'] == 'private') {echo 'checked';} ?>>
                                            <label for="Private"> Private</label>
                                        </div>
								</div>
                                <div class="hr-line-dashed"></div>  
								<div class="form-group clientDiv row" id="clientDiv" style="display:<?php if($testimonial['type'] == 'public') {echo 'none';} else {echo 'flex';} ?>">
                                    <label class="col-sm-2 col-form-label">Client Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="client_email" name="client_email" value="<?php echo $private_course['client_email']; ?>" readonly>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Course Fees</label>
                                    <div class="col-sm-4">
                                        <input type="number" step="0.01" class="form-control" id="course_fees" name="course_fees" value="<?php echo $private_course['course_fees']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="hr-line-dashed clientDiv" style="display:<?php if($testimonial['type'] == 'public') {echo 'none';} else {echo 'flex';} ?>"></div>  
                        		<div class="form-group  row">
							        <label class="col-sm-2 col-form-label">Select Course</label>
									<div class="col-sm-4">
										<select class="form-control" required name="courseid">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM courses WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>" <?php if($testimonial['courseid'] == $fetch['id']) {echo 'selected';} ?>><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
									<label class="col-sm-2 col-form-label">Add Teacher</label>
									<div class="col-sm-4">
										<select class="form-control select" <?php if(!empty($teachers_id)) { } else { echo 'required';}?> name="teacherid[]" multiple>
											<option value="">Select</option>
											<?php $count=0;
											if(!empty($teachers_id)) {
											    $Eteachers = $conn->query("SELECT * FROM teachers WHERE status='1' AND id NOT IN (".$teachers_id.") order by id ASC");
											} else {
											    $Eteachers = $conn->query("SELECT * FROM teachers WHERE status='1' order by id ASC");
											}
											while($fetchers = $Eteachers->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetchers['id']; ?>"><?php echo $fetchers['title']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="hr-line-dashed"></div>  
                                <div class="form-group row" style="position:relative">
                                    <div class="col-sm-12">
                                        <p id="successnote" style="display:none;color:#5eba7d;font-weight:bold;margin: 0 auto;font-size: 18px;border: 1px solid;padding: 10px 20px;"></p>
                                        <table class="table" id="datatable2">
                                            <thead>
                                                <th>Teacher</th>
                                                <th>Request Status</th>
                                                <th>Request Sent</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                            <?php $teachers_query = "SELECT * FROM course_teachers WHERE slot_id='".$testimonial['id']."' AND status='1' AND is_deleted='0'";
                                                $course_teachers = $conn->query($teachers_query);
                                                while($fetchteachers = $course_teachers->fetch_assoc()) {
                                                    $Efetchteachers = $conn->query("SELECT * FROM teachers WHERE id='".$fetchteachers['teacherid']."'")->fetch_assoc();
                                                    if($fetchteachers['accepted'] == '1') {
                                                        $statusrequest = 'Accepted';
                                                    } else if($fetchteachers['accepted'] == '2') {
                                                        $statusrequest = 'Decline';
                                                    } else {
                                                        $statusrequest = 'Pending';
                                                    }
                                                    ?>
                                                <tr id="Teacherdiv_<?php echo $fetchteachers['id']; ?>">
                                                    <td><?php echo $Efetchteachers['title']; ?></td>
                                                    <td><?php echo $statusrequest; ?></td>
                                                    <td><?php echo date('d/M/Y h:i A', strtotime($fetchteachers['updated'])); ?></td>
                                                    <td><a href="javascript:" class="btn btn-danger" onclick="deleteTeacher(<?php echo $fetchteachers['id']; ?>)">Delete</a></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>  
                                <?php 
                                $cities = $conn->query("SELECT * FROM cities WHERE id=".$testimonial['cityid'])->fetch_assoc();
                                $states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
                                ?>
                                <div class="form-group  row">
									<label class="col-sm-2 col-form-label">Location</label>
                                    	<div class="col-sm-4">
										<select class="form-control" required name="locid" onchange="getdata(this.value)">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM locations WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>" <?php if($testimonial['locid'] == $fetch['id']) {echo 'selected';} ?>><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
                                    <label class="col-sm-2 col-form-label">City</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" class="form-control" name="city" id="city" value="<?php echo $cities['id']; ?>">
                                        <input type="text" readonly class="form-control" id="cityname" value="<?php echo $cities['name']; ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">State</label>
                                    <div class="col-sm-4">
                                        <input type="text" readonly class="form-control" id="statename" value="<?php echo $states['name']; ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Session Min Capacity</label>
                                    <div class="col-sm-4">
                                        <input type="number" min="1" class="form-control" id="mincapacity" name="mincapacity" value="<?php echo $testimonial['mincapacity']; ?>">
                                    </div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Session Max Capacity</label>
                                    <div class="col-sm-4">
                                        <input type="number"  min="1" class="form-control" id="maxcapacity" name="maxcapacity" value="<?php echo $testimonial['maxcapacity']; ?>">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Allow Makeup Capacity</label>
                                    <div class="col-sm-4">
                                        <input type="number" min="1" class="form-control" id="makecapacity" name="makecapacity" value="<?php echo $testimonial['makecapacity']; ?>">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group row" style="position:relative">
                                    <div class="col-sm-2"><button type="button" onclick="fetchnotes()" class="btn btn-primary">Add New</button></div>
                                    <div class="col-sm-10">
                                        <table class="table" id="datatable1">
                                            <thead>
                                                <th>Date <span style="color:red">*</span></th>
                                                <th>Start Time <span style="color:red">*</span></th>
                                                <th>End Time <span style="color:red">*</span></th>
                                            </thead>
                                            <tbody><tr></tr>
                                            <?php $dates_query = "SELECT * FROM course_dates WHERE slot_id='".$testimonial['id']."'";
                                                $course_dates = $conn->query($dates_query);
                                                if($course_dates->num_rows > 0) {
                                                while($fetchdates = $course_dates->fetch_assoc()) {
                                                    ?>
                                                <tr id="Notediv_<?php echo $fetchdates['id']; ?>">
                                                    <td><input type="hidden" name="dateid[]" value="<?php echo $fetchdates['id']; ?>"><input type="date" class="form-control" required name="date[]" value="<?php echo $fetchdates['date']; ?>"></td>
                                                    <td><input type="time" class="form-control" required name="starttime[]" value="<?php echo $fetchdates['starttime']; ?>"></td>
                                                    <td><input type="time" class="form-control" required name="endtime[]" value="<?php echo $fetchdates['endtime']; ?>"></td>
                                                    <td></td>
                                                </tr>
                                                <?php }} else { ?>
                                                <tr id="Notediv_1">
                                                    <td><input type="hidden" name="dateid[]" value="0"><input type="date" class="form-control" required name="date[]" value=""  min="<?php echo date('Y-m-d'); ?>"></td>
                                                    <td><input type="time" class="form-control" required name="starttime[]" value=""></td>
                                                    <td><input type="time" class="form-control" required name="endtime[]" value=""></td>
                                                    <td></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
								<div class="hr-line-dashed d-none"></div>
                                <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Map Location</label>
                                    <div class="col-sm-10"><textarea class="form-control" name="map_location" id="map_location"><?php echo $testimonial['map_location']; ?></textarea></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Map Location URL</label>
                                    <div class="col-sm-10"><textarea class="form-control" name="map_location_url" id="map_location_url"><?php echo $testimonial['map_location_url']; ?></textarea></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Additional Venue Notes:</label>
                                    <div class="col-sm-10"><textarea class="form-control" name="remarks" id="remarks"><?php echo $testimonial['remarks']; ?></textarea></div>
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
            <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                        <div class="modal-body" style="padding: 20px 30px 20px 30px;">
                            <h3 class="mb-0">Are you sure you want to delete?</h3>
                            <input type="hidden" id="deleteID"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="confirmd()">Confirm</button>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
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
function checktype(val) {
    if(val == 'private') {
        $(".clientDiv").css('display', 'flex');
        $("#client_email").prop("required", true);
        $("#course_fees").prop("required", true);
    } else {
        $(".clientDiv").css('display', 'none');
        $("#client_email").prop("required", false);
        $("#course_fees").prop("required", false);
    }
}
function getdata(val) {
	$.ajax({
		type: "POST",
		url: 'getdata.php',
		data:{val: val},
		success: function(response){ 
		    const myArray = response.split("_");
		    $("#city").val('').val(myArray[0]);
		    $("#cityname").val('').val(myArray[1]);
		    $("#statename").val('').val(myArray[2]);
		    $("#map_location_url").val('').val(myArray[3]);
		    $("#map_location").val('').val(myArray[4]);
		    $("#remarks").val('').val(myArray[5]);
		}
   });
}
var rowIdx = parseInt('<?php echo $rowIdx; ?>');
function fetchnotes() { rowIdx++;
    $('#datatable1 tbody tr:last').after('<tr id="Notediv_'+rowIdx+'"><td><input type="hidden" name="dateid[]" value="0"/><input type="date" class="form-control" required name="date[]" value="" min="<?php echo date('Y-m-d'); ?>"></td><td><input type="time" class="form-control" required name="starttime[]" value=""></td><td><input type="time" class="form-control" required name="endtime[]" value=""></td><td><a href="javascript:" onclick="removeNote('+rowIdx+')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a></td></tr>');
}
function removeNote(id) {
    $("tr#Notediv_"+id).remove();
}

function confirmd() {
    $('#myModal').modal('toggle');
    var id = $('#deleteID').val();
    var slot = '<?php echo $updateid; ?>';
    $.ajax({
       url: "deleteCTeacher.php",
       type: "POST",
       data:  {id:id,slot:slot},
       success: function(data) { 
             $("#datatable2 tbody").html('').html(data); 
             $("#successnote").css('display', 'block');
             $("#successnote").css('border', '1px solid red');
             $("#successnote").css('color', 'red');
             $("#successnote").html('').html("Teacher Deleted Successfully.");
             setTimeout(function() {
                $("#successnote").slideUp( "slow", function() {});
            }, 3000);
        },       
    });
}
function deleteTeacher(id) {
    $('#deleteID').val('').val(id);
    $('#myModal').modal('toggle');
}
</script>
</body>
</html>