<?php 
session_start();
include 'include/conn.php';
include 'include/enc_dec.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$emailto = $emailaccount['emailto'];
$nameto = $emailaccount['nameto'];
$impactem = $emailaccount['email1'];
$id = decryptStringArray($_GET['id']);
$title = decryptStringArray($_GET['title']);
$fetchstu = $conn->query("SELECT * FROM sale WHERE id='".$id."'")->fetch_assoc();
$userdata = $conn->query("SELECT * FROM registration WHERE id='".$fetchstu['user']."'")->fetch_assoc();
$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetchstu['courseid']."'")->fetch_assoc();
$slotdata = $conn->query("SELECT * FROM course_slots WHERE id='".$fetchstu['slotid']."'")->fetch_assoc();
$timedata = $conn->query("SELECT * FROM course_dates WHERE id='".$title."'")->fetch_assoc();
$attan = strtoupper(substr($userdata['fname'], 0, 1).''.substr($userdata['lname'], 0, 1));
$fname = $fetchstu['fname'];
$lname = $fetchstu['lname'];
$email = $fetchstu['email'];
$ccemail = $fetchstu['workplace_email'];
if(!empty($fetchstu['workplace_contact'])) {
$ccname = $fetchstu['workplace_contact'];
    $userdataname = '<b>'.$fname.' '.$lname.'</b>';
} else {
   $ccname =  $fname.' '.$lname;
    $userdataname = "you";
}
$opurse_startdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$slotdata['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
$coustartdate = $opurse_startdates['date'];
$course_datesd = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchstu['slotid']."' AND date <= '".date('Y-m-d')."'");
$ccn = 0; $abs = 0; $missed = $misday = '';
while($dattessd = $course_datesd->fetch_assoc()) {
        if($dattessd['date'] == date('Y-m-d')) {
            if($dattessd['starttime'] <= date('H:i:s')) {
                $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
                if($attandance->num_rows > 0) { $ccn++; } else { $ccn++; $abs++; $missed.='Day '.$ccn.' on '.date("d-M-Y",strtotime($dattessd['date'])).', '; $misday .= $ccn.', '; } }
        } else {
            $attandance = $conn->query("SELECT * FROM tbl_attendance WHERE courseid='".$fetchstu['courseid']."' AND slotid='".$fetchstu['slotid']."' AND tbl_student_id='".$fetchstu['user']."' AND submitdate='".$dattessd['date']."' AND isDeleted='0'");
            if($attandance->num_rows > 0) { $ccn++; } else { $ccn++; $abs++; $missed.='Day '.$ccn.' on '.date("d-M-Y",strtotime($dattessd['date'])).', '; $misday .= $ccn.', '; }
        }   
}
$missed = rtrim($missed,', ');
$misday = rtrim($misday,', ');
$missedarray = explode(", ",$misday);
$cnt=0;$dates='';
$course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".$timedata['slot_id']."' AND makecapacity > 0");
while($fetchcouslot = $course_slots->fetch_assoc()) { $cnt++;$dates='';
    $location = $conn->query("SELECT * FROM locations WHERE id=".$fetchcouslot['locid'])->fetch_assoc();
    $cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcouslot['cityid'])->fetch_assoc();
    $states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
    $opurse_enddates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
    $cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' AND date > '".date('Y-m-d')."' ORDER BY date ASC");
    $ccnntt=0; 
    while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
        $courid = encryptStringArray($fetchdates['id']);
        $startdate = date('d/M/Y', strtotime($fetchdates['date']));
        $starttimeh = date('h:i A', strtotime($fetchdates['starttime']));
        $endtimeh = date('h:i A', strtotime($fetchdates['endtime']));
        $dates .= "<a href='$url/request/$id/$courid'><b>".$startdate." (".$starttimeh."-".$endtimeh.") - ".$location['title']." ".$location['location']." ".$cities['name']." ".$states['name']."</b></a><br>";
    }
    $slotid = $fetchcouslot['id'];
    $course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
    if($course_dates['date'] >= date('Y-m-d')) {
        $txt1 .= "<tr>".
            "<td>".$dates."</td>".
        "</tr>";
    }
} 
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Learnpro - Education University School Kindergarten Learning HTML Template" />
    <meta name="keywords" content="education,school,university,educational,learn,learning,teaching,workshop" />
    <meta name="author" content="ThemeMascot" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Company Name</title>
    <?php
    include("include/head_script.php");
    ?>
    <style>
        html {
            scroll-behavior: smooth;
        }
        .form-control
        {
            height:30px !important;
        }
    </style>
</head>
<body class>
    <div id="wrapper" class="clearfix">

        <div class="main-content">

            <section class="inner-header divider overlay-theme-colored-1">
                <div class="container pt-20 pb-20" id="book">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-dark font-36">Makeup class request</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="divider">
                <div class="container pt-15 pb-70">
                    <div class="row pt-10">
                        <div class="col-md-12">
                            <?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$submittedby = mysqli_real_escape_string($conn, $_POST['submittedby']);
								$ondate = mysqli_real_escape_string($conn, $_POST['ondate']);
								$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
								$course_date = mysqli_real_escape_string($conn, $_POST['course_date']);
								$expected_date = mysqli_real_escape_string($conn, $_POST['expected_date']);
								$reason = mysqli_real_escape_string($conn, $_POST['reason']);
								$missed_days = $_POST['missed_days'];
								$misseddays = implode(',', $missed_days);
								$sql="INSERT INTO makeup_form (ondate,submittedby,fullname,course_date,expected_date,reason,missed_days) VALUES ('".$ondate."','".$submittedby."','".$fullname."','".$course_date."','".$expected_date."','".$reason."','".$misseddays."')";
    							$insert = $conn->query($sql);
    							$last_id = mysqli_insert_id($conn);
    							if($insert){
    								$msg = 'Your request has been successfully submitted. We will respond within five business days.';
    								if($emailaccount['status'] == '1') {
        							    $txt1 = "Dear Admin,<br><br>";
                        				$txt1 .= "Makeup Class request is submitted with following details:<br><br>";
                        				$txt1 .= "Name : ".$fullname."<br>";
                        				$txt1 .= "Course Start date : ".date('d-M-Y', strtotime($course_date))."<br>";
                        				$txt1 .= "Missed Days : ".$misseddays."<br>";
                        				$txt1 .= "Expected Date : ".date('d-M-Y', strtotime($expected_date))."<br>";
                        				$txt1 .= "Reason for extension : ".$reason."<br><br>";
                                    	$txt1 .= "Kind Regards, <br><br>";
                                    	$txt1 .= "<b>".$emailaccount['title1']."</b><br>";
                                    	$txt1 .= "<b>".$emailaccount['email1']."</b><br>";
                                    	$txt1 .= "<b>".$emailaccount['phone']."</b><br>";
        							    $mail = new PHPMailer(true);
                                        try {
                                            $mail->isSMTP();
                                            $mail->SMTPDebug  = 0;
                                            $mail->Host       = $emailaccount['host'];
                                            $mail->Port       = $emailaccount['port'];
                                            $mail->SMTPSecure = 'tls'; // port 587 uses STARTTLS
                                            $mail->SMTPAuth   = true;
                                            $mail->IsHTML(true);
                                            $mail->Username   = $emailaccount['email']; // SMTP account username
                                            $mail->Password   = $emailaccount['password'];       // SMTP account password
                                            $mail->addAddress($emailto, $nameto);  //Add a recipient
                                            $mail->setFrom($impactem, $impacttitle);
                                            $mail->addReplyTo($impactem, $impacttitle);
                                            $mail->Subject = "New Request for Extension!!";
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
    							} else {
    								$err = $conn->error;
    							}
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
    						if(!empty($err)){
    						  echo "
    							<div class='alert alert-danger alert-dismissible'>
    							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    							  <h4><i class='fa fa-warning'></i> Error!</h4>
    							  ".$err."
    							</div>
    						  ";
    						}
						    ?>
                             <form method="post" enctype="multipart/form-data">
                            <div class="panel panel-default">
                                <div class="panel-heading text-white" style="background:#808080">Request Information</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="ondate">Submission date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="ondate" id="ondate" value="<?php echo date('Y-m-d'); ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="fullname">Participant full name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $fname.' '.$lname; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="course_date">Course start date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="course_date" id="course_date" value="<?php echo $coustartdate; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="missed_days">Days missed:</label>
                                        <div class="col-sm-9">
                                            <input style="margin-left:0px;pointer-events:none" type="checkbox" name="missed_days[]" <?php if(in_array('1', $missedarray)) {echo 'checked';} ?> value="1"> Day 1
                                            <input style="margin-left:40px;pointer-events:none" type="checkbox" name="missed_days[]" <?php if(in_array('2', $missedarray)) {echo 'checked';} ?> value="2"> Day 2
                                            <input style="margin-left:40px;pointer-events:none" type="checkbox" name="missed_days[]" <?php if(in_array('3', $missedarray)) {echo 'checked';} ?> value="3"> Day 3
                                            <input style="margin-left:40px;pointer-events:none" type="checkbox" name="missed_days[]" <?php if(in_array('4', $missedarray)) {echo 'checked';} ?> value="4"> Day 4
                                            <input style="margin-left:40px;pointer-events:none" type="checkbox" name="missed_days[]" <?php if(in_array('5', $missedarray)) {echo 'checked';} ?> value="5"> Day 5
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="expected_date">Expected date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="expected_date" id="expected_date" value="<?php echo $timedata['date']; ?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="submittedby">Form Submitted by:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="submittedby" id="submittedby" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12" for="reason">Please provide a details/reason:</label>
                                        <div class="col-sm-12">
                                            <textarea rows="4" style="height:auto !important" class="form-control" name="reason" id="reason" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-sm" type="submit" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </form>
                        </div>
                    </div>
                    
                </div>
            </section>
            
        </div>
    </div>
    <?php include("include/footer_script.php"); ?>
</body>
</html>