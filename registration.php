<?php 
session_start();
include 'include/conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactph = $emailaccount['phone'];
$impactem = $emailaccount['email1']; 
$course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".$_GET['slotid']."'")->fetch_assoc();
$sessionemail = ''; $backbutn = '';
if(isset($_SESSION['client_emaill']) && $course_slots['type'] == 'private') {
    $sessionemail = $_SESSION['client_emaill'];
    $backbutn = '1';
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
        .select2-container {width:100% !important;}
    </style>
</head>
<body class>
    <div id="wrapper" class="clearfix">

        <div class="main-content">

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20" id="book">

                    <div class="section-content">
                        <div class="row">

                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Company Name Safety and Training: Registration</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Registration</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="divider">
                <div class="container pt-50 pb-70"> 
                    <div class="row pt-10">
                        <div class="col-md-12">
                        <?php if($backbutn == '1') { ?>
                            <a class="btn btn-primary" href="javascript:" onclick="window.history.go(-1); return false;" style="position:absolute;right:0;z-index: 9;cursor: pointer;">Back</a>
                        <?php } ?>
                            <h4 class="mt-0 mb-30 line-bottom-theme-colored-2">ENTER YOUR DETAILS BELOW:?</h4>
                            <?php 
                            function randomPassword() {
                                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                                $pass = array(); //remember to declare $pass as an array
                                $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                                for ($i = 0; $i < 8; $i++) {
                                    $n = rand(0, $alphaLength);
                                    $pass[] = $alphabet[$n];
                                }
                                return implode($pass); //turn the array into a string
                            }
                            function genRandomString() {
                                $length = 5;
                                $characters = '023456789abcdefghijkmnopqrstuvwxyz';
                                $string = '';    
                            
                                for ($p = 0; $p < $length; $p++) {
                                    $string .= $characters[mt_rand(0, strlen($characters))];
                                }
                                return $string;
                            }
							$err = $msg = '';
							if(isset($_POST['submit'])) {
							    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
								$lname = mysqli_real_escape_string($conn, $_POST['lname']);
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$position = mysqli_real_escape_string($conn, $_POST['position']);
								$company = mysqli_real_escape_string($conn, $_POST['company']);
								$postal_address = mysqli_real_escape_string($conn, $_POST['postal_address']);
								$industry_type = mysqli_real_escape_string($conn, $_POST['industry_type']);
								$hsr_or_not = mysqli_real_escape_string($conn, $_POST['hsr_or_not']);
								$workplace_contact = mysqli_real_escape_string($conn, $_POST['workplace_contact']);
								$workplace_email= mysqli_real_escape_string($conn, $_POST['workplace_email']);
								$workplace_phone = mysqli_real_escape_string($conn, $_POST['workplace_phone']);
								$emergency_contact = mysqli_real_escape_string($conn, $_POST['emergency_contact']);
								$emergency_phone = mysqli_real_escape_string($conn, $_POST['emergency_phone']);
								$special_requirements = mysqli_real_escape_string($conn, $_POST['special_requirements']);
								$food_requirements = mysqli_real_escape_string($conn, $_POST['food_requirements']);
								$instruction = mysqli_real_escape_string($conn, $_POST['instruction']);
								$password = mysqli_real_escape_string($conn, $_POST['password']);//randomPassword();
								$generated_code = genRandomString();
                    			$check_random_string_row = $conn->query('SELECT generated_code FROM registration WHERE (generated_code="'.$generated_code.'")')->fetch_assoc();
                    			if($generated_code == $check_random_string_row['generated_code']){
                    			    $generated_code = genRandomString();
                    			}
								$courseid = $_GET['courseid'];
								$locid = $_GET['locid'];
								$slotid = $_GET['slotid'];
								$cityid = $_GET['cityid'];
								$sql="INSERT INTO registration (title,fname,lname,email,position,company,postal_address,courseid,locid,slotid,cityid,industry_type,hsr_or_not,workplace_contact,workplace_email,workplace_phone,emergency_contact,emergency_phone,special_requirements,food_requirements, password, generated_code, instruction, verifyEmail) VALUES ('".$title."','".$fname."','".$lname."','".$email."','".$position."','".$company."','".$postal_address."','".$courseid."','".$locid."', '".$slotid."', '".$cityid."', '".$industry_type."', '".$hsr_or_not."', '".$workplace_contact."', '".$workplace_email."','".$workplace_phone."', '".$emergency_contact."', '".$emergency_phone."', '".$special_requirements."', '".$food_requirements."', '".$password."', '".$generated_code."', '".$instruction."', '1')";
    							$insert = $conn->query($sql);
    							$last_id = mysqli_insert_id($conn);
    							if($insert){
    							    $_SESSION['pin_user'] = $last_id;
    								$msg = 'Data Added Successfully.';
    								if($emailaccount['status'] == '1') {
        							    $userdataname = $title.' '.$fname.' '.$lname;
        							    $txt1 = "Hi ".$fname.",<br>";
                        				$txt1 .= "Welcome to the Company.<br/>Your login details are below:<br>";
                        				$txt1 .= "Username : ".$email."<br>";
                        				$txt1 .= "Password : ".$password."<br><br>Regards<br>Company";
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
    						    $courseid=$_GET['courseid'];
    						    $locid=$_GET['locid'];
    						    $slotid=$_GET['slotid'];
    						    $cityid=$_GET['cityid'];
    						    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
    						    header("Location: ".$actual_link."/payment-confirmation/".$courseid."/".$locid."/".$slotid."/".$cityid."/".$last_id);
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
								$industry_type = mysqli_real_escape_string($conn, $_POST['industry_type']);
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
								$courseid = $_GET['courseid'];
								$locid = $_GET['locid'];
								$slotid = $_GET['slotid'];
								$cityid = $_GET['cityid'];
								$sqlquery="UPDATE registration SET title = '".$title."', fname = '".$fname."', lname = '".$lname."', email='".$email."', position = '".$position."', company = '".$company."', postal_address = '".$postal_address."', courseid = '".$courseid."', locid = '".$locid."', slotid = '".$slotid."', cityid = '".$cityid."', industry_type = '".$industry_type."', hsr_or_not = '".$hsr_or_not."', workplace_contact = '".$workplace_contact."', workplace_email = '".$workplace_email."', workplace_phone = '".$workplace_phone."', emergency_contact = '".$emergency_contact."', emergency_phone = '".$emergency_phone."', special_requirements = '".$special_requirements."', food_requirements = '".$food_requirements."', instruction='".$instruction."' WHERE id=".$loggedid;
    							$update = $conn->query($sqlquery);
    							if($update){
    								$msgup = 'Data Added Successfully.';
    							} else {
    								$errup = $conn->error;
    							}
    						}
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
    						    $courseid=$_GET['courseid'];
    						    $locid=$_GET['locid'];
    						    $slotid=$_GET['slotid'];
    						    $cityid=$_GET['cityid'];
    						    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
    						    header("Location: ".$actual_link."/payment-confirmation/".$courseid."/".$locid."/".$slotid."/".$cityid."/".$loggedid);
    						}
    						if(isset($_SESSION['pin_user']) && !empty($_SESSION['pin_user']) && $_SESSION['pin_user'] != '') {
    						    $fetchRegis = $conn->query("SELECT * FROM registration WHERE id= '".$_SESSION['pin_user']."'")->fetch_assoc();
						    ?>
                        <form method="post" enctype="multipart/form-data" autocomplete="off">
                            <input type="hidden" name="loggedid" value="<?php echo $fetchRegis['id']; ?>"/>
                            <div class="panel panel-default">
                                <div class="panel-heading">Basic Details:</div>
                                <div class="panel-body">
                                        <div class="form-group d-none row" style="display:none">
                                            <label class="control-label col-sm-3" for="title"><span class="mandatory">*</span>Title:</label>
                                            <div class="col-sm-9">
                                                <select name="title" id="title" class="form-control">
                                                   <option value="">Select</option>
                                                    <option value="Mr" <?php if($fetchRegis['title'] == 'Mr') { echo 'selected'; }?>>Mr</option>
                                                    <option value="Miss" <?php if($fetchRegis['title'] == 'Miss') { echo 'selected'; }?>>Miss</option>
                                                    <option value="Mr" <?php if($fetchRegis['title'] == 'Mr') { echo 'selected'; }?>>Mr</option>
                                                    <option value="Mrs" <?php if($fetchRegis['title'] == 'Mrs') { echo 'selected'; }?>>Mrs</option>
                                                    <option value="Ms" <?php if($fetchRegis['title'] == 'Ms') { echo 'selected'; }?>>Ms</option>
                                                    <option value="Dr" <?php if($fetchRegis['title'] == 'Dr') { echo 'selected'; }?>>Dr</option>
                                                    <option value="Hon" <?php if($fetchRegis['title'] == 'Hon') { echo 'selected'; }?>>Hon</option>
                                                    <option value="Prof" <?php if($fetchRegis['title'] == 'Prof') { echo 'selected'; }?>>Prof</option>
                                                    <option value="Rev" <?php if($fetchRegis['title'] == 'Rev') { echo 'selected'; }?>>Rev</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>First Name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="fname" id="fname" required placeholder="Enter First Name" value="<?php echo $fetchRegis['fname']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="lname"><span class="mandatory">*</span>Last Name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="lname" id="lname" required placeholder="Enter Last Name" value="<?php echo $fetchRegis['lname']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>Username(email):</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" id="email" autocomplete="off" required placeholder="Enter Email" oninput="checkuniq(this.value, 'email')" value="<?php echo $fetchRegis['email']; ?>">
                                                <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">HSR WORKPLACE DETAILS</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="position"><span class="mandatory">*</span>Position:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required name="position" id="position" value="<?php echo $fetchRegis['position']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="company"><span class="mandatory">*</span>Company:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required name="company" id="company" value="<?php echo $fetchRegis['company']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="postal_address">Postal Address:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="postal_address" id="postal_address" value="<?php echo $fetchRegis['postal_address']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="industry_type"><span class="mandatory">*</span>Industry Type:</label>
                                        <div class="col-sm-9">
                                            <select id="industry_type" class="form-control" required name="industry_type">
                                                <option value="">Select</option>
                                                <?php $languagessql = $conn->query("SELECT * FROM industry_type WHERE status='1'");
                                                while($fetchlanguages = $languagessql->fetch_assoc()) { $classtag1='';
                                                    if($fetchRegis['industry_type'] == $fetchlanguages['id']) { $classtag1 = 'selected'; }
                                                    echo '<option value="'.$fetchlanguages['id'].'" '.$classtag1.'>'.$fetchlanguages['title'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12" for="hsr_or_not">Part A: Tick only one (If you are an HSR or Deputy HSR, complete Part A. Do not complete Part B.)</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input type="radio" name="hsr_or_not" value="1" <?php if($fetchRegis['hsr_or_not'] == '1') { echo 'checked'; }?>> You are an elected HSR <br>
                                                <input type="radio" name="hsr_or_not" value="2" <?php if($fetchRegis['hsr_or_not'] == '2') { echo 'checked'; }?>> You are an elected Deputy HSR
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12" for="hsr_or_not">Part B: If you are not an HSR or Deputy HSR you are...</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <label><input type="radio" name="hsr_or_not" value="3" <?php if($fetchRegis['hsr_or_not'] == '3') { echo 'checked'; }?>> Manager/Supervisor </label><br>
                                                <label><input type="radio" name="hsr_or_not" value="4" <?php if($fetchRegis['hsr_or_not'] == '4') { echo 'checked'; }?>> Member of your HSC </label><br>
                                                <label><input type="radio" name="hsr_or_not" value="5" <?php if($fetchRegis['hsr_or_not'] == '5') { echo 'checked'; }?>> Other (e.g. unemployed, professional development)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="workplace_contact">Workplace Contact:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="workplace_contact" id="workplace_contact" value="<?php echo $fetchRegis['workplace_contact']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="workplace_email">Workplace Contact Email:</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="workplace_email" id="workplace_email" value="<?php echo $fetchRegis['workplace_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="workplace_phone">Workplace Contact Phone:</label>
                                        <div class="col-sm-9">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" class="form-control" name="workplace_phone" id="workplace_phone" value="<?php echo $fetchRegis['workplace_phone']; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 style="padding: 10px 0;font-weight: bolder;">PARTICIPANT EMERGENCY CONTACT</h5>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="emergency_contact">Emergency Contact Person:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="emergency_contact" id="emergency_contact" value="<?php echo $fetchRegis['emergency_contact']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="emergency_phone">Emergency Contact Phone:</label>
                                        <div class="col-sm-9">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" class="form-control" name="emergency_phone" id="emergency_phone" value="<?php echo $fetchRegis['emergency_phone']; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="special_requirements">Additional Learning Requirements:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="special_requirements" id="special_requirements" value="<?php echo $fetchRegis['special_requirements']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="food_requirements">Food Allergies:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="food_requirements" id="food_requirements" value="<?php echo $fetchRegis['food_requirements']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="instruction">Instruction:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="instruction" id="instruction" value="<?php echo $fetchRegis['instruction']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <button class="btn btn-primary btn-sm" type="submit" name="update">Continue</button>
                             </form>
                             <?php } else { ?>
                             <p id="formerr" style="display:none; color:#e83e8c"></p>
                             <form method="post" enctype="multipart/form-data" autocomplete="off">
                                   
                            <div class="panel panel-default">
                                <div class="panel-heading">Basic Details:</div>
                                <div class="panel-body">
                                        <div class="form-group d-none row" style="display:none">
                                            <label class="control-label col-sm-3" for="title"><span class="mandatory">*</span>Title:</label>
                                            <div class="col-sm-9">
                                                <select name="title" id="title" class="form-control">
                                                   <option value="">Select</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Miss">Miss</option>
                                                    <option value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Ms">Ms</option>
                                                    <option value="Dr">Dr</option>
                                                    <option value="Hon">Hon</option>
                                                    <option value="Prof">Prof</option>
                                                    <option value="Rev">Rev</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>First Name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="fname" id="fname" required placeholder="Enter First Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="lname"><span class="mandatory">*</span>Last Name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="lname" id="lname" required placeholder="Enter Last Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="email"><span class="mandatory">*</span>Username(email):</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" id="email" required autocomplete="off" placeholder="Enter Email" oninput="checkuniq(this.value, 'email')">
                                                <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="password"><span class="mandatory">*</span>Password:</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="password" id="password" autocomplete="off" required placeholder="Enter Password">
                                                <i onclick="showPassword()" id="toggle_password" class="fa fa-eye" style="position: absolute;right: 25px;top: 10px;z-index: 9;cursor: pointer;"></i>
                                                <p id="passworderr" style="display:none; color:#e83e8c"></p>
                                            <p style="padding-left: 20px;">Forgot your password? <a style="text-decoration:underline" href="javascript:" data-toggle="modal" data-target="#PasswordModal">Click here</a></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="conpassword"><span class="mandatory">*</span>Confirm Password:</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" name="conpassword" autocomplete="off" id="confirm_password" required placeholder="Enter Confirm Password">
                                                <i onclick="showCPassword()" id="toggle_cpassword" class="fa fa-eye" style="position: absolute;right: 25px;top: 10px;z-index: 9;cursor: pointer;"></i>
                                                <span id='err_message'></span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <button class="btn btn-primary btn-sm pull-right" type="button" name="submitbtnn" id="submitbtnn" onclick="submitme()">Submit</button>
                                            </div>
                                        </div>
                                        <div id="myloader" style="display:none;width:100%;height:100px;"></div>
                                </div>
                            </div>
                          <div class="alert alert-danger alert-dismissible" role="alert" id="OTPErr" style="display:none">  </div>
                          <div class="alert alert-success alert-dismissible" role="alert" id="OTPmsg" style="display:none">  </div>
                            <div class="panel panel-default" style="display:none" id="HSRafterverfic">
                                <div class="panel-heading">HSR WORKPLACE DETAILS</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="position"><span class="mandatory">*</span>Position:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required name="position" id="position">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="company"><span class="mandatory">*</span>Company:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" required name="company" id="company">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="postal_address">Postal Address:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="postal_address" id="postal_address">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="industry_type"><span class="mandatory">*</span>Industry Type:</label>
                                        <div class="col-sm-9">
                                            <select id="industry_type" class="form-control" required name="industry_type">
                                                <option value="">Select</option>
                                                <?php $languagessql = $conn->query("SELECT * FROM industry_type WHERE status='1'");
                                                while($fetchlanguages = $languagessql->fetch_assoc()) { $classtag1='';
                                                    if($fetchRegis['industry_type'] == $fetchlanguages['id']) { $classtag1 = 'selected'; }
                                                    echo '<option value="'.$fetchlanguages['id'].'" '.$classtag1.'>'.$fetchlanguages['title'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12" for="hsr_or_not">Part A: Tick only one (If you are an HSR or Deputy HSR, complete Part A. Do not complete Part B.)</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input type="radio" checked name="hsr_or_not" value="1"> You are an elected HSR <br>
                                                <input type="radio" name="hsr_or_not" value="2"> You are an elected Deputy HSR
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12" for="hsr_or_not">Part B: If you are not an HSR or Deputy HSR you are...</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input type="radio" name="hsr_or_not" value="3"> Manager/Supervisor <br>
                                                <input type="radio" name="hsr_or_not" value="4"> Member of your HSC <br>
                                                <input type="radio" name="hsr_or_not" value="5"> Other (e.g. unemployed, professional development)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="workplace_contact">Workplace Contact:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="workplace_contact" id="workplace_contact">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="workplace_email">Workplace Contact Email:</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="workplace_email" id="workplace_email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="workplace_phone">Workplace Contact Phone:</label>
                                        <div class="col-sm-9">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" class="form-control" name="workplace_phone" id="workplace_phone">
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 style="padding: 10px 0;font-weight: bolder;">PARTICIPANT EMERGENCY CONTACT</h5>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="emergency_contact">Emergency Contact Person:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="emergency_contact" id="emergency_contact">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="emergency_phone">Emergency Contact Phone:</label>
                                        <div class="col-sm-9">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" class="form-control" name="emergency_phone" id="emergency_phone">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="special_requirements">Additional Learning Requirements:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="special_requirements" id="special_requirements">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="food_requirements">Food Allergies:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="food_requirements" id="food_requirements">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="instruction">Instruction:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="instruction" id="instruction">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary btn-sm" type="submit" name="submit">Continue</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             </form>
                             <?php } ?>
                        </div>
                    </div>
                    
                </div>
            </section>
            <div id="OTPModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Verify Your Email</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                      <div class='alert alert-success alert-dismissible' id="resendmsg">
    					  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    					  We've sent an email with your code to <br><span id="OTPModalemaill"></span>
				      </div>
                    <form name="otp_form_acc" id="otp_form_acc" class="otp-form mb-0 bg-silver-deep p-30" method="post" action="javascript:" autocomplete="off">
                        <h3 class="text-center mt-0 mb-30">Enter the code</h3>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="form-group mb-30">
                              <input placeholder="Enter OTP" id="reservation_otp" name="reservation_otp" required="" class="form-control" aria-required="true" type="text">
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="form-group mb-0 mt-0">
                              <button type="submit" id="submitbtn" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Continue</button>
                            </div>
                            <p>Didn't receive an email? <a style="text-decoration:underline" href="javascript:" onclick="resendcode()">Resend</a>
                            <input type="hidden" id="Resendemail" name="Resendemail"></p>
                            <div id="myloaderotp" style="display:none;width:100%;height:100px;"></div>
                          </div>
                        </div>
                      </form>
                  </div>
                </div>
            
              </div>
            </div>
        </div>
<div id="LoginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="bg-theme-colored2 p-15 pt-10 mt-0 mb-0 text-white">Login Form</h3>
      </div>
      <div class="modal-body">
          <section class="">
  <div class="container position-relative p-0" style="max-width: 570px;">
    
    <div class="section-content bg-white">
      <div class="row">
        <div class="col-md-12">
          <!-- Register Form Starts -->
          <form id="reservation_form_popup_login" name="reservation_form" class="reservation-form mb-0 bg-silver-deep p-30" method="post" action="javascript:" autocomplete="off">
              <div class="alert alert-danger" role="alert" id="LoginErr" style="display:none">  </div>
              <div class="alert alert-success" role="alert" id="Loginmsg" style="display:none">  </div>
            <h3 class="text-center mt-0 mb-30">login to your account!</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Registered Email" id="reservation_name" name="reservation_username" required="" class="form-control" aria-required="true" type="email">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Your Password" id="reservation_password" name="reservation_password" required="" class="form-control" aria-required="true" type="password">
                  <p>Reset your password<a href="">Click here</a></p>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 mt-0">
                  <input name="form_botcheck" class="form-control" value="" type="hidden">
                  <button type="submit" id="uploadbtn" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Login Now</button>
                </div>
                <div id="myloader" style="display:none;width:100%;height:100px;"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="VerSucModal" class="modal fade" role="dialog" style='z-index:1045'>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
          <div class='alert alert-success mb-0' style='background-color:transparent !important;border:1px solid transparent !important;'>
			  <center><i style="border: 2px solid;padding: 20px;border-radius: 38px;font-size: 35px;" class="fa fa-check"></i>
			  <br>
			  <h3>Email Verified</h3>
			  <p>Your email address was successfully verified. </p>
			  </center>
	      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<div id="PasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="bg-theme-colored2 p-15 pt-10 mt-0 mb-0 text-white">Reset Password Form</h3>
      </div>
      <div class="modal-body">
          <section class="">
  <div class="container position-relative p-0" style="max-width: 570px;">
    
    <div class="section-content bg-white">
      <div class="row">
        <div class="col-md-12">
          <!-- Register Form Starts -->
          <form id="reset_form_popup_acc" name="reset_form" class="rest-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
              <div class="alert alert-danger" role="alert" id="ResetPasswordErr" style="display:none">  </div>
              <div class="alert alert-success" role="alert" id="ResetPasswordmsg" style="display:none">  </div>
            <h3 class="text-center mt-0 mb-30">Reset account password!</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Registered Email" id="reservation_username" name="reservation_username" required="" class="form-control" aria-required="true" type="email">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 mt-0">
                  <input name="form_botcheck" class="form-control" value="" type="hidden">
                  <button type="submit" id="resetbtn" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Submit</button>
                </div>
                <div id="myloader" style="display:none;width:100%;height:100px;"></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    </div>
    <?php include("include/footer_script.php"); ?>
    <script>
        function checkuniq(val, type) {
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
        }
        function submitme() {
            var val = $("#email").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            var fname = $("#fname").val();
            var lname = $("#lname").val();
    		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    		if(val != '' && password != '' && fname != '' && lname != '' && confirm_password != '') {
    		    if(password == confirm_password) {
    		if(regex.test(val) == true) {
            	$.ajax({
            		type: "POST",
            		url: 'checkstudent.php',
            		data:{val:val,password:password,type:'email'},
                    beforeSend: function(){
                        $("#myloader").css("display","block");
                        $("#myloader").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                        $("#submitbtnn").prop("disabled", true);
                    },
            		success: function(response){ console.log(response);
                        $("#submitbtnn").prop("disabled", false);
                         $("#myloader").css("display","none");
                         $("#myloader").css("background","#fff");
            			if(response=='1'){				
            				// $("#email").val('');
            		      //  $("#emailerr").css('display', 'block');
            				// $("#emailerr").text(val+ ' Email address already exist!!');
            				// $('#LoginModal').modal('show');
            		      //  $('#OTPModal').modal('hide');
                            location.reload();
            			} else if(response=='2'){				
            				// $("#email").val('');
            		        $("#passworderr").css('display', 'block');
            				$("#passworderr").text('Email already exist. You have entered wrong password! Please check your password and try login again!');
            				// $('#LoginModal').modal('show');
            		        $('#OTPModal').modal('hide');
            			} else{				
            				$("#emailerr").text('');
            				$("#phoneerr").text('');
            				$("#mobileerr").text('');
    		                $("#formerr").css('display', 'none');
            		        $("#emailerr").css('display', 'none');
            		        $("#phoneerr").css('display', 'none');
            		        $("#mobileerr").css('display', 'none');
            		        $('#OTPModalemaill').text('').text(val);
            		        $('#Resendemail').val('').val(val);
            		        $('#OTPModal').modal('show');
            			}
            		}
               });
    		} else {
    		    $("#emailerr").css('display', 'block');
    			$("#emailerr").text('Not a valid email address!!'); return false;
    		}
    		} else {
    		    $("#formerr").css('display', 'block');
    			$("#formerr").text('Passwords do not match!'); 
    			$("#confirm_password").focus(); return false;
    		}} else {
    		    $("#formerr").css('display', 'block');
    			$("#formerr").text('Please fill out all required fields!!'); return false;
    		}
        }
        $(document).ready(function (e) {
            $('input').attr('autocomplete','off');
         $("#reservation_form_popup_login").on('submit',(function(e) {
          e.preventDefault();
          $.ajax({
               url: "login.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
               success: function(data) {
                   if(data == 'success') {
                       $("#LoginErr").css('display', 'none');
                        $("#Loginmsg").css('display', 'block');
                       $("#Loginmsg").html('').html('Login Success.');
                        location.reload();
                   } else {
                        $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html(data);
                   }
                 
              },       
            });
         }));
     $("#reset_form_popup_acc").on('submit',(function(e) {
      e.preventDefault();
      $.ajax({
           url: "resetpassword.php",
           type: "POST",
           data:  new FormData(this),
           contentType: false,
           cache: false,
           processData:false,
            beforeSend: function(){
                $("#myloader").css("display","block");
                $("#myloader").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                $("#resetbtn").prop("disabled", true);
            },
           success: function(data) {
                $("#resetbtn").prop("disabled", false);
                 $("#myloader").css("display","none");
                 $("#myloader").css("background","#fff");
               if(data == 'success') {
                   $("#ResetPasswordErr").css('display', 'none');
                    $("#ResetPasswordmsg").css('display', 'block');
                   $("#ResetPasswordmsg").html('').html('Password successfully sent to your registered email address. Please check you email.');
        		        $('#LoginModal').modal('hide');
        		        setTimeout(function(){
                          $('#PasswordModal').modal('hide')
                        }, 5000);
                    
               } else {
                    $("#ResetPasswordmsg").css('display', 'none');
                   $("#ResetPasswordErr").css('display', 'block');
                   $("#ResetPasswordErr").html('').html(data);
               }
             
          },       
        });
     }));
         $("#otp_form_acc").on('submit',(function(e) {
          e.preventDefault();
          $.ajax({
               url: "checkOTP.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
            beforeSend: function(){
                $("#myloaderotp").css("display","block");
                $("#myloaderotp").css("background","url(images/preloaders/5.gif) center / 75px 75px no-repeat");
                $("#submitbtn").prop("disabled", true);
            },
               success: function(resp) {
                $("#myloaderotp").css("display","none");
                $("#submitbtn").prop("disabled", false);
                   if(resp == 'Yes') {
        		        $('#OTPModal').modal('hide');
                       $("#OTPmsg").css('display', 'block');
                       $("#OTPErr").css('display', 'none');
                       $("#passworderr").css('display', 'none');
                       $("#err_message").css('display', 'none');
                       $("#OTPmsg").html('').html('Verification Success. Please continue');
    		            $('#VerSucModal').modal('show');
                        $("#HSRafterverfic").css('display', 'block');
                        $("#otp_form_acc")[0].reset();
                        $('#OTPmsg').fadeIn('slow').delay(1000).hide(0);
                   } else {
        		        $('#OTPModal').modal('hide');
                        $("#HSRafterverfic").css('display', 'none');
                       $("#OTPErr").css('display', 'block');
                       $("#OTPmsg").css('display', 'none');
                        $("#otp_form_acc")[0].reset();
                       $("#OTPErr").html('').html('Verification failed. Please try again!');
                   }
              },       
            });
         }));
        });
        $('#confirm_password').on('keyup', function () {
          if ($('#password').val() == $('#confirm_password').val()) {
            $('#err_message').html('Password Matched.').css('color', 'green');
          } else 
            $('#err_message').html('Passwords do not match!').css('color', 'red');
        });
        function showPassword(){
            // toggle the type attribute
            password = document.querySelector(`#password`);
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.querySelector(`#toggle_password`).classList.toggle('fa-eye-slash');
        }
        function showCPassword(){
            // toggle the type attribute
            password = document.querySelector(`#confirm_password`);
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            document.querySelector(`#toggle_cpassword`).classList.toggle('fa-eye-slash');
        }
        
        // $(document).ready(function (e) {
        //     var sessionemail = '<?php echo $sessionemail; ?>';
        //     if(sessionemail != '' && sessionemail != null) {
        //         $("#email").val('').val(sessionemail);
        //         $("#email").prop('readonly', true);
        //     }
        // });
    </script>
</body>
</html>