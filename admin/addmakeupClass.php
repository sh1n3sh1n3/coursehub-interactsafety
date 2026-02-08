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
                    <h2>Add Makeup Classes </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="makeupClass.php">Makeup Classes</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Makeup Classes</strong>
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
                            <h5>Add Makeup Classes</h5>
                        </div>
						<?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {
							    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
								$studentid = mysqli_real_escape_string($conn, $_POST['studentid']);
								$makeupday = mysqli_real_escape_string($conn, $_POST['makeupday']);
								$slotid = mysqli_real_escape_string($conn, $_POST['slotid']);
								$date = mysqli_real_escape_string($conn, $_POST['joindate']);
								$oldslot = $_POST['oldslot'];
    							$insert = $conn->query("INSERT INTO makeup_classes (courseid,studentid,makeupday,slotid,date,oldslot) VALUES('".$courseid."','".$studentid."','".$makeupday."','".$slotid."','".$date."', '".$oldslot."')");	
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
                            <form method="post" id="form" enctype="multipart/form-data">
                        		<div class="form-group">
									<div class="row">
    									<label class="col-sm-2 col-form-label pr-0">Select Course</label>
    									<div class="col-sm-3">
    										<select class="form-control select" required name="courseid" id="courseid" onchange="getslots(this.value)">
    											<option value="">Select</option>
    											<?php $count=0;
    											$contact = $conn->query("SELECT * FROM courses WHERE status='1' order by id ASC");
    											while($fetch = $contact->fetch_assoc()) {$count++; ?>
    											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
    											<?php } ?>
    										</select>
    									</div>
    									<div class="col-sm-1"></div>
    									<label class="col-sm-2 col-form-label pr-0">Select Slot</label>
    									<div class="col-sm-4">
    										<select class="form-control select" required name="oldslot" id="oldslot" onchange="getavailCourse(this.value)">
    											<option value="">Select</option>
    										</select>
    									</div>
									</div>
									<div class="row">
    									<label class="col-sm-2 col-form-label pr-0">Select Student</label>
    									<div class="col-sm-3">
    										<select class="form-control select" required name="studentid" id="studentid" onchange="getmakeupday(this.value)">
    											<option value="">Select</option>
    										</select>
    									</div>
    									<div class="col-sm-1"></div>
    									<label class="col-sm-2 col-form-label pr-0">Select Makeup Day</label>
                                    	<div class="col-sm-4">
    										<select class="form-control" required name="makeupday" id="makeupday">
    											<option value="">Select</option>
    										</select>
    									</div>
									</div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
									<label class="col-sm-2 col-form-label"><h4>Available course dates</h4></label>
                                    <div class="col-sm-12" id="courseavailable">
                                        
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
function getslots(course) {
    $.ajax({
		type: "POST",
		url: 'getavailSlot.php',
		data:{course: course},
		success: function(response){
		    $("#oldslot").html('').html(response);
		    $("#studentid").html('').trigger('change');
		    $("#makeupday").html('').trigger('change');
		}
   });
	$.ajax({
		type: "POST",
		url: 'getavailCourse.php',
		data:{course: course},
		success: function(response){
		    $("#courseavailable").html('').html(response);
		}
   });
}
function getavailCourse(course) {
   $.ajax({
		type: "POST",
		url: 'getmakeupStudent.php',
		data:{course: course},
		success: function(response){console.log(response);
		    $("#studentid").html('').html(response);
		    $("#makeupday").html('').trigger('change');
		}
   });
}
function getmakeupday(st) {
    var course = $("#courseid").val();
    var slot = $("#oldslot").val();
   $.ajax({
		type: "POST",
		url: 'getmakeupstDays.php',
		data:{course: course, student: st, slot:slot},
		success: function(response){ console.log(response);
		    $("#makeupday").html('').html(response);
		}
   });
}
function checkdates(date, slotid) {
    $.ajax({
		type: "POST",
		url: 'checkdates.php',
		data:{date: date, slotid: slotid},
		success: function(response){ 
		    if(response == '0') {
		        $(".error_"+slotid).text('').text("Not valid date!!");
		        $("#joindate_"+slotid).val('');
		    } else {
		        $(".error_"+slotid).text('');
		    }
		}
   });
}
$(document).ready(function(e) {
$("button[type='submit']").click(function(e){
        var check = true;
        $("input:radio").each(function(){
            var name = $(this).attr("name");
            if($("input:radio[name="+name+"]:checked").length == 0){
                check = false;
            }
        });
 
        if(check){
            
        }else{
            e.preventDefault();
            alert('Please select at least one slot.'); 
        }
    });
});
function makereq(id) {
    $(".joindate").prop("required", false);
    $("#joindate_"+id).prop("required", true);
}
</script>
</body>
</html>