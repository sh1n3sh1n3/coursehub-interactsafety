<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
include('session.php'); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactph = $emailaccount['phone'];
$impactem = $emailaccount['email1'];
$protocol = isset($_SERVER['HTTPS']) && 
$_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
$urlcourse = $base_url;
?>
<!DOCTYPE html>
<html>
<head>
<?php include('includes/head.php'); ?>
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
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
                    <h2>Schedule Course </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="courses.php">Courses</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Schedule Course</strong>
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
                            <h5>Add Courses Slots</h5>
                        </div>
						<?php 
                            function genRandomString($length = 8) {
                                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                $maxIndex = strlen($characters) - 1; // ✅ correct
                                $string = '';
                            
                                for ($i = 0; $i < $length; $i++) {
                                    $string .= $characters[random_int(0, $maxIndex)];
                                }
                                return $string;
                            }
							$err = $msg = '';
							if(isset($_POST['submit'])) {
							    $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
								$locid = mysqli_real_escape_string($conn, $_POST['locid']);
								$city = mysqli_real_escape_string($conn, $_POST['city']);
								$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
							    $maxcapacity = mysqli_real_escape_string($conn, $_POST['maxcapacity']);
							    $mincapacity = mysqli_real_escape_string($conn, $_POST['mincapacity']);
							    $makecapacity= mysqli_real_escape_string($conn, $_POST['makecapacity']);
							    $map_location= '';//mysqli_real_escape_string($conn, $_POST['map_location']);
							    $map_location_url= '';//mysqli_real_escape_string($conn, $_POST['map_location_url']);
							    $type = mysqli_real_escape_string($conn, $_POST['type']);
							    $dates_array = $_POST['date'];
							    $teacher_array = $_POST['teacherid'];
    							$insert = $conn->query("INSERT INTO course_slots (type,courseid,locid,cityid,remarks,maxcapacity, mincapacity, makecapacity, map_location, map_location_url) VALUES('".$type."','".$courseid."','".$locid."','".$city."','".$remarks."','".$maxcapacity."', '".$mincapacity."', '".$makecapacity."', '".$map_location."', '".$map_location_url."')");	
    							if($insert){
    							    $lastid = $conn->insert_id;
    							    foreach($dates_array as $dkey => $dates) {
    							        $date = $dates;
    							        $starttime = $_POST['starttime'][$dkey];
    							        $endtime = $_POST['endtime'][$dkey];
    							        $conn->query("INSERT INTO course_dates (course_id, slot_id, date, starttime, endtime) VALUES ('".$courseid."','".$lastid."', '".$date."','".$starttime."','".$endtime."')");
    							    }
    							    foreach($teacher_array as $tkey => $teachers) {
    							        $teacherid = $teachers;
    							        $conn->query("INSERT INTO course_teachers (course_id, slot_id, teacherid) VALUES ('".$courseid."','".$lastid."','".$teacherid."')");
    							    }
    							    $conn->query("INSERT INTO remain_places (courseid, slotid, total, count, makecapacity) VALUES ('".$courseid."','".$lastid."', '".$maxcapacity."', '0', '".$makecapacity."')");
    							    if($type == 'private') {
        							    $client_email = mysqli_real_escape_string($conn, $_POST['client_email']);
        							    $course_fees = mysqli_real_escape_string($conn, $_POST['course_fees']);
        							    $client_name = mysqli_real_escape_string($conn, $_POST['client_email']);
    							    	$course_code = genRandomString();
                            			$check_random_string_row = $conn->query('SELECT course_code FROM private_course WHERE (course_code="'.$course_code.'")')->fetch_assoc();
                            			if($course_code == $check_random_string_row['course_code']){
                            			    $course_code = genRandomString();
                            			}
    							        $conn->query("INSERT INTO private_course (course_id, slot_id, client_name, client_email, course_fees, course_code) VALUES ('".$courseid."','".$lastid."', '".$client_name."', '".$client_email."', '".$course_fees."', '".$course_code."')");
    							        if($emailaccount['status'] == '1') {
    							            $course_details = $conn->query("SELECT * FROM courses WHERE id='".$courseid."'")->fetch_assoc();
    							            $fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='".$courseid."'")->fetch_assoc();
    							            $course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".$lastid."'")->fetch_assoc();
    							            $course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$lastid."'");
    							            $dates='';
                        					while($fetchdates = $course_dates->fetch_assoc()) {
                        					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<br>';
                        					}
                                            $course_locations = $conn->query("SELECT * FROM locations WHERE id='".$locid."'")->fetch_assoc();
                                            $course_city = $conn->query("SELECT * FROM cities WHERE id='".$city."'")->fetch_assoc();
                                		    $userdataname = $client_name;
                                		    $email = $client_email;
                                		    $txt1 = "Hi ".$client_name.",<br><br>";
                                			$txt1 .= "<b>Your Private course details are below:</b>"."<br><br>";
                                			$txt1 .= "Course: ".$course_details['title']."<br>";
                                			$txt1 .= "Course Fees: ".$course_fees."<br>";
                                			$txt1 .= "Course Code: ".$course_code."<br>";
                                			$txt1 .= "Course Link: <a target='_blank' href='".$urlcourse."courses-detail/".$fetchcourses['id']."/".$fetchcourses['slug']."'>Click Here</a><br>";
                                			$txt1 .= "Date & Time: ".$dates."<br>";
                                			$txt1 .= "Location: ".$course_city['name'].' - '.$course_locations['location'].' ('.$course_locations['title'].')'."<br>";
                                			$txt1 .= "Location Map: <a target='_blank' href='".$course_locations['maplink']."'>Click Here</a><br>";
                                			$txt1 .= "Venue Notes: ".$course_slots['remarks']."<br>";
                                			$txt1 .= "<br>Regards<br>Company";
                                		    $mail = new PHPMailer(true);
                                            try {
                                                $mail->SMTPDebug  = 0; // debugging: 1 = errors and messages, 2 = messages only
                                                $mail->SMTPAuth   = true; // authentication enabled
                                                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                                                $mail->Host       = $emailaccount['host'];; // SMTP server
                                                $mail->Port       = $emailaccount['port'];                    // set the SMTP port for the GMAIL server
                                                $mail->IsHTML(true);
                                                $mail->Username   = $emailaccount['email']; // SMTP account username
                                                $mail->Password   = $emailaccount['password'];       // SMTP account password
                                                $mail->addAddress($email, $userdataname);  //Add a recipient
                                                $mail->setFrom($impactem, $impacttitle);
                                                $mail->addReplyTo($impactem, $impacttitle);
                                                $mail->Subject = "Welcome to Company!!";
                                                $mail->Body    = $txt1;
                                                if($mail->Send()) {
                                                    // $msg = 'Data Added Successfully.';
                                                }
                                            } catch (phpmailerException $e) {
                                              $err = $e->errorMessage(); 
                                            } catch (Exception $e) {
                                              $err = $e->getMessage(); //Boring error messages from anything else!
                                            }
                                	    }
    							    }
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
                        		<div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Course Type</label>
                                        <div class="radio inline" style="padding-top: 6px;">
                                            <input type="radio" onclick="checktype(this.value)" id="Public" value="public" name="type" checked="">
                                            <label for="Public"> Public </label>
                                        </div>
                                        <div class="radio inline ml-3" style="padding-top: 6px;">
                                            <input type="radio" onclick="checktype(this.value)" id="Private" value="private" name="type">
                                            <label for="Private"> Private</label>
                                        </div>
								</div>
                                <div class="hr-line-dashed"></div>  
								<div class="form-group clientDiv row" id="clientDiv" style="display:none">
                                    <label class="col-sm-2 col-form-label">Client Email</label>
                                    <div class="col-sm-4">
                                        <input type="email" class="form-control" id="client_email" name="client_email">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Course Fees</label>
                                    <div class="col-sm-4">
                                        <input type="number" step="0.01" class="form-control" id="course_fees" name="course_fees">
                                    </div>
                                </div>
                                <div class="hr-line-dashed clientDiv" style="display:none"></div>  
                        		<div class="form-group  row">
									<label class="col-sm-2 col-form-label">Select Course</label>
									<div class="col-sm-4">
										<select class="form-control" required name="courseid">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM courses WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
									<label class="col-sm-2 col-form-label">Select Teacher</label>
									<div class="col-sm-4">
										<select class="select form-control" required name="teacherid[]" multiple>
											<option value="">Select</option>
											<?php $count=0;
											$Eteachers = $conn->query("SELECT * FROM teachers WHERE status='1' order by id ASC");
											while($fetchers = $Eteachers->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetchers['id']; ?>"><?php echo $fetchers['title']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
									<label class="col-sm-2 col-form-label">Location</label>
                                	<div class="col-sm-4">
										<select class="form-control" required name="locid" onchange="getdata(this.value)">
											<option value="">Select</option>
											<?php $count=0;
											$contact = $conn->query("SELECT * FROM locations WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
											<?php } ?>
										</select>
									</div>
									<label class="col-sm-2 col-form-label">City</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" class="form-control" name="city" id="city">
                                        <input type="text" readonly class="form-control" id="cityname">
                                    </div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">State</label>
                                    <div class="col-sm-4">
                                        <input type="text" readonly class="form-control" id="statename">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Session Min Capacity</label>
                                    <div class="col-sm-4">
                                        <input type="number" value="1" min="1" class="form-control" id="mincapacity" name="mincapacity">
                                    </div>
								</div>
                                <div class="hr-line-dashed"></div>  
                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Session Max Capacity</label>
                                    <div class="col-sm-4">
                                        <input type="number" value="19" min="1" class="form-control" id="maxcapacity" name="maxcapacity">
                                    </div>
                                    <label class="col-sm-2 col-form-label">Allow Makeup Capacity</label>
                                    <div class="col-sm-4">
                                        <input type="number" value="1" min="1" class="form-control" id="makecapacity" name="makecapacity">
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
                                                <tr id="Notediv_1">
                                                    <td><input type="date" class="form-control" required name="date[]" value=""  min="<?php echo date('Y-m-d'); ?>"></td>
                                                    <td><input type="time" class="form-control" required name="starttime[]" value=""></td>
                                                    <td><input type="time" class="form-control" required name="endtime[]" value=""></td>
                                                    <td></td>
                                                </tr>
                                            </tbody> 
                                        </table>
                                    </div>
                                </div>
								<div class="hr-line-dashed d-none"></div>
                                <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Map Location</label>
                                    <div class="col-sm-10"><textarea class="form-control" name="map_location" id="map_location"></textarea></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Map Location URL</label>
                                    <div class="col-sm-10"><textarea class="form-control" name="map_location_url" id="map_location_url"></textarea></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Additional Venue Notes:</label>
                                    <div class="col-sm-10"><textarea class="form-control" name="remarks" id="remarks"></textarea></div>
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
var rowIdx = 1;
function fetchnotes() { rowIdx++;
    $('#datatable1 tbody tr:last').after('<tr id="Notediv_'+rowIdx+'"><td><input type="date" class="form-control" required name="date[]" value="" min="<?php echo date('Y-m-d'); ?>"></td><td><input type="time" class="form-control" required name="starttime[]" value=""></td><td><input type="time" class="form-control" required name="endtime[]" value=""></td><td><a href="javascript:" onclick="removeNote('+rowIdx+')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> </a></td></tr>');
}
function removeNote(id) {
    $("tr#Notediv_"+id).remove();
}
</script>
</body>
</html>