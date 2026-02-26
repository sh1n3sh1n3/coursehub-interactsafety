<?php session_start();
include('include/conn.php');
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';
include "phpqrcode/qrlib.php";        
if (!file_exists($PNG_TEMP_DIR))
	mkdir($PNG_TEMP_DIR);
if(isset($_SESSION['pin_user']) && !empty($_SESSION['pin_user']) && $_SESSION['pin_user'] != '') {
    $fetchRegis = $conn->query("SELECT * FROM registration WHERE id= '".$_SESSION['pin_user']."'")->fetch_assoc();
    $disabilitydetail_str = $fetchRegis['disabilitydetail'];
    $disabilitydetail_ar = explode(', ',$disabilitydetail_str);
    $educationdetail_str = $fetchRegis['educationdetail'];
    $educationdetail_ar = explode(', ',$educationdetail_str);
    $filename = $PNG_TEMP_DIR.'test.png';
    $errorCorrectionLevel = 'H';   
    $matrixPointSize = 4;  
    $generated_code = $fetchRegis['generated_code'];
    $qrdata = $generated_code;
    QRcode::png($qrdata, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    $img = file_get_contents($PNG_WEB_DIR.basename($filename));
    $data = base64_encode($img); 
} else {
    echo '<script>window.location.href="index.php"</script>';
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo $blog['title']; ?> " />
    <meta name="keywords" content="<?php echo $blog['title']; ?> " />
    <meta name="author" content="Interact Safety" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title><?php echo $blog['title']; ?> | Interact Safety</title>
    <?php
    include("include/head_script.php");
    ?>
    <style>
html {
  scroll-behavior: smooth;
}
hr {
    margin-top: 5px;
    margin-bottom: 5px;
    border: 0;
    border-top: 1px solid #eee;
}
    </style>
</head>

<body class>
    <div id="wrapper" class="clearfix">
        <?php
        include("include/head.php");
        ?>
        <div class="main-content">
            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="text-theme-colored2 font-36">My Account</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="#">Home</a></li>
                                    <li class="active">Account</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <?php $err = $msg = '';
                                if(isset($_POST['submit'])) {
                                    $password = mysqli_real_escape_string($conn, $_POST['password']);
                                    $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);
                                    $loggid = $_POST['loggid'];
                                    $up = $conn->query("UPDATE registration SET password='".$password."' WHERE id=".$loggid);
                                    if($up) {
                                        $msg = 'Password change successfully.';
                                    } else {
                                        $msg = 'Something wrong!!';
                                    }
                                }
                                
                                $errup = $msgup = '';
							if(isset($_POST['update'])) {
							    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
								$lname = mysqli_real_escape_string($conn, $_POST['lname']);
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$position = mysqli_real_escape_string($conn, $_POST['position']);
								$company = mysqli_real_escape_string($conn, $_POST['company']);
								$postal_address = mysqli_real_escape_string($conn, $_POST['postal_address']);
								$hsr_or_not = mysqli_real_escape_string($conn, $_POST['hsr_or_not']);
								$workplace_contact = mysqli_real_escape_string($conn, $_POST['workplace_contact']);
								$workplace_email= mysqli_real_escape_string($conn, $_POST['workplace_email']);
								$workplace_phone = mysqli_real_escape_string($conn, $_POST['workplace_phone']);
								$emergency_contact = mysqli_real_escape_string($conn, $_POST['emergency_contact']);
								$emergency_phone = mysqli_real_escape_string($conn, $_POST['emergency_phone']);
								$special_requirements = mysqli_real_escape_string($conn, $_POST['special_requirements']);
								$food_requirements = mysqli_real_escape_string($conn, $_POST['food_requirements']);
								$instruction = mysqli_real_escape_string($conn, $_POST['instruction']);
								$loggedid = $_POST['loggedid'];
								$sqlquery="UPDATE registration SET title = '".$title."', fname = '".$fname."', lname = '".$lname."', email='".$email."', position = '".$position."', company = '".$company."', postal_address = '".$postal_address."', hsr_or_not = '".$hsr_or_not."', workplace_contact = '".$workplace_contact."', workplace_email = '".$workplace_email."', workplace_phone = '".$workplace_phone."', emergency_contact = '".$emergency_contact."', emergency_phone = '".$emergency_phone."', special_requirements = '".$special_requirements."', food_requirements = '".$food_requirements."', instruction='".$instruction."' WHERE id=".$loggedid;
    							$update = $conn->query($sqlquery);
    							if($update){
    								$msgup = 'Account Updated Successfully.';
    							} else {
    								$errup = $conn->error;
    							}
    						}
                                ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-4">
                                        <ul class="nav nav-tabs account-tabs bg-silver-deep" role="tablist">
                                            <li class="nav-item" role="presentation"><a href="account.php" class="font-15 text-uppercase">Dashboard </a></li>
                                            <li class="nav-item" role="presentation"><a href="editAccount.php" class="font-15 text-uppercase">Edit Account </a></li>
                                            <li class="nav-item active" role="presentation"><a href="orders.php" class="font-15 text-uppercase">Orders </a></li>
                                            <li class="nav-item" role="presentation"><a href="password.php" class="font-15 text-uppercase">Change Password </a></li>
                                            <li class="nav-item" role="presentation"><a href="logout.php" class="font-15 text-uppercase">Logout </a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="tab-content p-0" style="border:1px none">
                                        <div role="tabpanel" class="tab-pane active" id="free-orders">
                                            <?php 
                        						if(!empty($errup)){
                        						  echo "
                        							<div class='alert alert-danger alert-dismissible'>
                        							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        							  <h4><i class='fa fa-warning'></i> Error!</h4>
                        							  ".$errup."
                        							</div>
                        						  ";
                        						}
                        						if(!empty($msgup)){
                        						    echo "
                        							<div class='alert alert-success alert-dismissible'>
                        							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        							  <h4><i class='fa fa-success'></i> Success!</h4>
                        							  ".$msgup."
                        							</div>
                        						  ";
                        						}
                                            ?>
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
                        							  <h4><i class='fa fa-success'></i> Success!</h4>
                        							  ".$msg."
                        							</div>
                        						  ";
                        						}
                                            ?>
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width:28%">Order Details</th>
                                                        <th style="width:25%">Slot</th>
                                                        <th style="width:27%">Location & Teacher</th>
                                                        <th style="width:10%">Attandance</th>
                                                        <th style="width:10%">Certificate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $salesql = $conn->query("SELECT * FROM sale WHERE user='".$_SESSION['pin_user']."' ORDER BY id DESC");
                                                    if($salesql->num_rows > 0) {$dates=$invitees='';
                                                        while($fetchsql = $salesql->fetch_assoc()) {$dates=$invitees='';
                                                            $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetchsql['courseid']."'")->fetch_assoc();
                                                            $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE courseid='".$fetchsql['courseid']."' AND id='".$fetchsql['slotid']."'")->fetch_assoc();
                                        					$cities = $conn->query("SELECT * FROM cities WHERE id=".$sqlcourseslot['cityid'])->fetch_assoc();
                                                            $locs = $conn->query("SELECT * FROM locations WHERE id=".$sqlcourseslot['locid'])->fetch_assoc();
                                        					$states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
                                                            $locscheck = $conn->query("SELECT * FROM location_checklist WHERE location_id=".$locs['id'])->fetch_assoc();
                                                            $teacehrname='Not assigned';
                                                            $course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='".$sqlcourseslot['id']."' AND status='1' AND is_deleted='0' AND accepted='1' ORDER BY id ASC");
                                                            while($fetchteacherss = $course_teachers->fetch_assoc()) {
                                                                $fetchteach = $conn->query("SELECT * FROM teachers WHERE id=".$fetchteacherss['teacherid'])->fetch_assoc();
                                                                $invitees .= $fetchteach['title'].',';
                                                            }
                                                            $course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$sqlcourseslot['id']."'");
                                        					while($fetchdates = $course_dates->fetch_assoc()) {
                                        					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
                                        					}
                            								$coursecode='';
                            								$private_course = $conn->query("SELECT * FROM private_course WHERE slot_id='".$sqlcourseslot['id']."'")->fetch_assoc();
                                                            if($sqlcourseslot['type'] == 'private') {
                                        				        $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=".$sqlcourseslot['id'])->fetch_assoc();
                                                                $coursecode = ' ('.$fetchprivate['course_code'].')';
                                                            }
                                                            $amt = '0';
                            								if($sqlcourseslot['type'] == 'private') {
                            								    $amt = $private_course['course_fees'];
                            								} else {
                            								    $amt = $fetchsql['amount'];
                            								}
                                                            $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$sqlcourseslot['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
                                        					$coursedate = date('Y-m-d', strtotime($fetchdates['date']));
                                        					$coursedatetime = date('Y-m-d H:i:s', strtotime($fetchdates['date'].' '.$fetchdates['starttime']));
                                                            $curdatetime = date('Y-m-d H:i:s');
                                                            $invitees = rtrim($invitees,",");
                                                            $dates = rtrim($dates,"<hr>");
                                                    ?>
                                                    <tr>
                                                        <td scope="row"><b>Order No. </b><?php echo $fetchsql['orderno']; ?>
                                                        <hr><b>Amount : </b>$<?php echo $amt; ?>
                                                        <hr><b>Course : </b><?php echo $sqlcourses['title']; ?>
                                                        </td>
                                                        <td><?php echo $dates; ?></td>
                                                        <td><b>Location : </b><?php if(!empty($locscheck['room_location'])) { echo $locscheck['room_location'].', '; } 
                                                        if(!empty($locscheck['venue_details'])) { echo $locscheck['venue_details'].', '; } 
                                                        if(!empty($sqlcourseslot['locid'])) { echo $locs['title'].', '; }
                                                        if(!empty($sqlcourseslot['cityid'])) { echo $cities['name'].', '; }
                                                        if(!empty($sqlcourseslot['cityid'])) { echo $states['name']; } ?>
                                                        <hr><b>Teacher : </b><?php echo $invitees; ?></td>
                                                        <?php if($curdatetime > $coursedatetime) { ?>
                                                        <td><a class="btn btn-info btn-xs" href="javascript:" onclick="viewattandance(<?php echo $fetchsql['courseid']; ?>, <?php echo $fetchsql['slotid']; ?>, <?php echo $sqlcourseslot['locid']; ?>, <?php echo $fetchsql['user']; ?>)">View Attandance</a></td>
                                                        <?php } else { ?>
                                                        <td>Course not started!</td>
                                                        <?php } ?>
                                                        <?php
                                                        $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id = '".$_SESSION['pin_user']."' AND courseid='".$fetchsql['courseid']."' AND slotid='".$fetchsql['slotid']."'");
                                                        if($tbl_attendance->num_rows > 0) {
                                                        if($fetchsql['generateCertificate'] == '1') { ?>
                                                        <td><a class="btn btn-dark btn-xs" target="_blank" href="certificate.php?id=<?php echo $fetchsql['id']; ?>">Download</a></td>
                                                        <?php } else { echo '<td>Not generated</td>'; }} ?>
                                                    </tr>
                                                    <?php }} else { ?>
                                                    
                                                    <?php } ?>
                                                    
                                                    <?php $invitees=$dates=''; $salesql = $conn->query("SELECT * FROM makeup_classes WHERE studentid='".$_SESSION['pin_user']."' ORDER BY id ASC");
                                                    if($salesql->num_rows > 0) {
                                                        while($fetchsql = $salesql->fetch_assoc()) {$invitees=$dates='';
                                                            $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetchsql['courseid']."'")->fetch_assoc();
                                                            $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE courseid='".$fetchsql['courseid']."' AND id='".$fetchsql['slotid']."'")->fetch_assoc();
                                        					$cities = $conn->query("SELECT * FROM cities WHERE id=".$sqlcourseslot['cityid'])->fetch_assoc();
                                                            $locs = $conn->query("SELECT * FROM locations WHERE id=".$sqlcourseslot['locid'])->fetch_assoc();
                                        					$states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
                                                            $locscheck = $conn->query("SELECT * FROM location_checklist WHERE location_id=".$locs['id'])->fetch_assoc();
                                                            $teacehrname='Not assigned';
                                                            $course_teachers = $conn->query("SELECT * FROM course_teachers WHERE course_id='".$fetchsql['courseid']."' AND slot_id='".$fetchsql['slotid']."' AND status='1' AND is_deleted='0' AND accepted='1' ORDER BY id ASC");
                                                            while($fetchteacherss = $course_teachers->fetch_assoc()) {
                                                                $fetchteach = $conn->query("SELECT * FROM teachers WHERE id=".$fetchteacherss['teacherid'])->fetch_assoc();
                                                                $invitees .= $fetchteach['title'].',';
                                                            }
                                                            $course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$sqlcourseslot['id']."'");
                                        					while($fetchdates = $course_dates->fetch_assoc()) {
                                        					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
                                        					}
                            								$coursecode='';
                            								$private_course = $conn->query("SELECT * FROM private_course WHERE slot_id='".$sqlcourseslot['id']."'")->fetch_assoc();
                                                            if($sqlcourseslot['type'] == 'private') {
                                        				        $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=".$sqlcourseslot['id'])->fetch_assoc();
                                                                $coursecode = ' ('.$fetchprivate['course_code'].')';
                                                            }
                                                            $amt = '0';
                                                            $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$sqlcourseslot['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
                                        					$coursedate = date('Y-m-d', strtotime($fetchdates['date']));
                                        					$coursedatetime = date('Y-m-d H:i:s', strtotime($fetchdates['date'].' '.$fetchdates['starttime']));
                                                            $curdatetime = date('Y-m-d H:i:s');
                                                            $invitees = rtrim($invitees,",");
                                                            $dates = rtrim($dates,"<hr>");
                                                    ?>
                                                    <tr>
                                                        <td scope="row"><b>Order No. </b><?php echo $fetchsql['orderno']; ?>
                                                        <hr><b>Amount : </b>$<?php echo $amt; ?>
                                                        <hr><b>Course : </b><?php echo $sqlcourses['title']; ?>
                                                        </td>
                                                        <td><?php echo date('d-M-Y', strtotime($fetchsql['date'])); ?></td>
                                                        <td><b>Location : </b><?php if(!empty($locscheck['room_location'])) { echo $locscheck['room_location'].', '; } 
                                                        if(!empty($locscheck['venue_details'])) { echo $locscheck['venue_details'].', '; } 
                                                        if(!empty($sqlcourseslot['locid'])) { echo $locs['title'].', '; }
                                                        if(!empty($sqlcourseslot['cityid'])) { echo $cities['name'].', '; }
                                                        if(!empty($sqlcourseslot['cityid'])) { echo $states['name']; } ?>
                                                        <hr><b>Teacher : </b><?php echo $invitees; ?></td>
                                                        <?php if($curdatetime > $coursedatetime) { ?>
                                                        <td><a class="btn btn-info btn-xs" href="javascript:" onclick="viewattandance(<?php echo $fetchsql['courseid']; ?>, <?php echo $fetchsql['slotid']; ?>, <?php echo $sqlcourseslot['locid']; ?>, <?php echo $fetchsql['studentid']; ?>)">View Attandance</a></td>
                                                        <?php } else { ?>
                                                        <td>Course not started!</td>
                                                        <?php } ?>
                                                        <?php
                                                        $tbl_attendance = $conn->query("SELECT * FROM tbl_attendance WHERE tbl_student_id = '".$_SESSION['pin_user']."' AND courseid='".$fetchsql['courseid']."' AND slotid='".$fetchsql['slotid']."'");
                                                        if($tbl_attendance->num_rows > 0) {
                                                        if($fetchsql['generateCertificate'] == '1') { ?>
                                                        <td><a class="btn btn-dark btn-xs" target="_blank" href="certificate.php?id=<?php echo $fetchsql['id']; ?>">Download</a></td>
                                                        <?php } else { echo '<td>Not generated</td>'; }} ?>
                                                    </tr>
                                                    <?php }} else { ?>
                                                    
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div id="attandanceModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><center>Scan this QR Code here for your attedance</center></h4>
                  </div>
                  <div class="modal-body" id="AttandanceBody">
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            
              </div>
            </div>
            <div id="attandancegetModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
            
                <!-- Modal content-->
                <div class="modal-content" id="Attandanceget">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            
              </div>
            </div>
        </div><?php
        include("include/footer.php");
        ?>
    </div>
    <?php
    include("include/footer_script.php");
    ?>
    <script>
        jQuery('.validatedForm').validate({
            rules: {
                password: {
                    minlength: 8,
                },
                password_confirm: {
                    minlength: 8,
                    equalTo: "#password"
                }
            }
        });
        function getmydata(course, slot, locid, user) {
            $.ajax({
        		type: "POST",
        		url: 'getQRCode.php',
        		data:{course:course,slot:slot, locid:locid, user:user},
        		success: function(res){
        			$("#AttandanceBody").html('').html(res);
        			$('#attandanceModal').modal('toggle');
        		}
           });   
        }
        function viewattandance(course, slot, locid, user) {
            $.ajax({
        		type: "POST",
        		url: 'getAttandance.php',
        		data:{course:course,slot:slot, locid:locid, user:user},
        		success: function(res){
        			$("#Attandanceget").html('').html(res);
        			$('#attandancegetModal').modal('toggle');
        		}
           });   
        }
        function checkuniq(val, type, valid) {
            if(type=='email') {
        		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        		if(regex.test(val) == true) {
        			$("#emailerr").text('');
        		    $("#emailerr").css('display', 'none');
        		} else {
        		    $("#emailerr").css('display', 'block');
        			$("#emailerr").text('Not a valid email address!!'); return false;
        		}
        	} 
        	if(type=='mobile') {
        		var filter = /^\d*(?:\.\d{1,2})?$/;
                  if (filter.test(val)) {
                    if(val.length==10){
        				$("#mobileerr").text('');
        		        $("#mobileerr").css('display', 'none');
        			} else {
        		        $("#mobileerr").css('display', 'block');
                        $("#mobileerr").text('Please put 10  digit mobile number');return false;
        			}
        		  } else {
        		        $("#mobileerr").css('display', 'block');
                      $("#mobileerr").text('Not a valid number');return false;
        		  }
        	} 
        	if(type=='phone') {
        		var filter = /^\d*(?:\.\d{1,2})?$/;
                  if (filter.test(val)) {
                    if(val.length==10){
        				$("#phoneerr").text('');
        		        $("#phoneerr").css('display', 'none');
        			} else {
        		        $("#phoneerr").css('display', 'block');
                        $("#phoneerr").text('Please put 10  digit phone number');return false;
        			}
        		  } else {
        		        $("#phoneerr").css('display', 'block');
                      $("#phoneerr").text('Not a valid number');return false;
        		  }
        	} 
        	$.ajax({
        		type: "POST",
        		url: 'checkstudentin.php',
        		data:{val:val,type:type, id:valid},
        		success: function(res){
        		    const response = res.split("_");
        			if(response[0]=='1'){				
        				$("#email").val('').val(response[1]);
        		        $("#emailerr").css('display', 'block');
        				$("#emailerr").text(val+ ' Email address already exist!!');
        			} else if(response[0]=='2'){			
        				$("#mobile").val('').val(response[1]);
        		        $("#mobileerr").css('display', 'block');
        				$("#mobileerr").text(val+ ' Mobile Number already exist!!');
        			}  else if(response[0]=='3'){			
        				$("#phone").val('').val(response[1]);
        		        $("#phoneerr").css('display', 'block');
        				$("#phoneerr").text(val+ ' Phone Number already exist!!');
        			} else{				
        				$("#emailerr").text('');
        				$("#phoneerr").text('');
        				$("#mobileerr").text('');
        		        $("#emailerr").css('display', 'none');
        		        $("#phoneerr").css('display', 'none');
        		        $("#mobileerr").css('display', 'none');
        			}
        		}
           });
        }
    </script>
</body>
</html>