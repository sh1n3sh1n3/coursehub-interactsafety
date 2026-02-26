<?php include 'include/conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactph = $emailaccount['phone'];
$impactem = $emailaccount['email1'];  ?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Learnpro - Education University School Kindergarten Learning HTML Template" />
    <meta name="keywords" content="education,school,university,educational,learn,learning,teaching,workshop" />
    <meta name="author" content="ThemeMascot" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Interact Safety</title>
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

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20" id="book">

                    <div class="section-content">
                        <div class="row">

                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Interact Safety: Registration</h2>
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
								$dob = mysqli_real_escape_string($conn, $_POST['dob']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$phone = mysqli_real_escape_string($conn, $_POST['phone']);
								$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
								$gender = mysqli_real_escape_string($conn, $_POST['gender']);
								$usi = mysqli_real_escape_string($conn, $_POST['usi']);
								$building = mysqli_real_escape_string($conn, $_POST['building']);
								$flat = mysqli_real_escape_string($conn, $_POST['flat']);
								$street= mysqli_real_escape_string($conn, $_POST['street']);
								$streetname = mysqli_real_escape_string($conn, $_POST['streetname']);
								$streettype = mysqli_real_escape_string($conn, $_POST['streettype']);
								$suburb = mysqli_real_escape_string($conn, $_POST['suburb']);
								$state = mysqli_real_escape_string($conn, $_POST['state']);
								$postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
								$indegenousstatus = mysqli_real_escape_string($conn, $_POST['indegenousstatus']);
								$birthcountry = mysqli_real_escape_string($conn, $_POST['birthcountry']);
								$mainlanguage = mysqli_real_escape_string($conn, $_POST['mainlanguage']);
								$labourforcestatus = mysqli_real_escape_string($conn, $_POST['labourforcestatus']);
								$atschool = mysqli_real_escape_string($conn, $_POST['atschool']);
								$schoollevel = mysqli_real_escape_string($conn, $_POST['schoollevel']);
								$yearcompleted = mysqli_real_escape_string($conn, $_POST['yearcompleted']);
								$disability = mysqli_real_escape_string($conn, $_POST['disability']);
								$disabilitydetails = $_POST['disabilitydetail'];
								$disabilitydetail = '';
								foreach($disabilitydetails as $disabilitydetail1) {
								    $disabilitydetail .= $disabilitydetail1.', ';
								}
								$education = mysqli_real_escape_string($conn, $_POST['education']);
								$educationdetails = $_POST['educationdetail'];
								$educationdetail = '';
								foreach($educationdetails as $educationdetail1) {
								    $educationdetail .= $educationdetail1.', ';
								}
								$proficiency = mysqli_real_escape_string($conn, $_POST['proficiency']);
								$password = randomPassword();
								$generated_code = genRandomString();
                    			$check_random_string_row = $conn->query('SELECT generated_code FROM registration1 WHERE (generated_code="'.$generated_code.'")')->fetch_assoc();
                    			if($generated_code == $check_random_string_row['generated_code']){
                    			    $generated_code = genRandomString();
                    			}
								$courseid = $_GET['courseid'];
								$locid = $_GET['locid'];
								$slotid = $_GET['slotid'];
								$cityid = $_GET['cityid'];
								$sql="INSERT INTO registration1 (title,fname,lname,email,phone,mobile,dob,courseid,locid,slotid,cityid,gender,usi,building,flat,street,streetname,streettype,suburb,state,postcode,indegenousstatus,birthcountry, mainlanguage, labourforcestatus, atschool, schoollevel, yearcompleted, disability, disabilitydetail, education, educationdetail, proficiency, password, generated_code) VALUES('".$title."','".$fname."','".$lname."','".$email."','".$phone."','".$mobile."','".$dob."','".$courseid."','".$locid."', '".$slotid."', '".$cityid."', '".$gender."', '".$usi."', '".$building."', '".$flat."','".$street."', '".$streetname."', '".$streettype."', '".$suburb."', '".$state."', '".$postcode."','".$indegenousstatus."','".$birthcountry."','".$mainlanguage."', '".$labourforcestatus."', '".$atschool."', '".$schoollevel."', '".$yearcompleted."', '".$disability."', '".$disabilitydetail."', '".$education."', '".$educationdetail."', '".$proficiency."', '".$password."', '".$generated_code."')";
    							$insert = $conn->query($sql);
    							$last_id = mysqli_insert_id($conn);
    							if($insert){
    							    $_SESSION['pin_user'] = $last_id;
    								$msg = 'Data Added Successfully.';
    								if($emailaccount['status'] == '1') {
        							    $userdataname = $title.' '.$fname.' '.$lname;
        							    $txt1 = "Hi ".$fname.",<br>";
                        				$txt1 .= "Welcome to the Company.<br/>Your login details are below:<br>";
                        				$txt1 .= "Email : ".$email."<br>";
                        				$txt1 .= "Mobile : ".$mobile."<br>";
                        				$txt1 .= "Phone : ".$phone."<br>";
                        				$txt1 .= "Password : ".$password."<br>Regards<br>Company";
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
								$dob = mysqli_real_escape_string($conn, $_POST['dob']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$phone = mysqli_real_escape_string($conn, $_POST['phone']);
								$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
								$gender = mysqli_real_escape_string($conn, $_POST['gender']);
								$usi = mysqli_real_escape_string($conn, $_POST['usi']);
								$building = mysqli_real_escape_string($conn, $_POST['building']);
								$flat = mysqli_real_escape_string($conn, $_POST['flat']);
								$street= mysqli_real_escape_string($conn, $_POST['street']);
								$streetname = mysqli_real_escape_string($conn, $_POST['streetname']);
								$streettype = mysqli_real_escape_string($conn, $_POST['streettype']);
								$suburb = mysqli_real_escape_string($conn, $_POST['suburb']);
								$state = mysqli_real_escape_string($conn, $_POST['state']);
								$postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
								$indegenousstatus = mysqli_real_escape_string($conn, $_POST['indegenousstatus']);
								$birthcountry = mysqli_real_escape_string($conn, $_POST['birthcountry']);
								$mainlanguage = mysqli_real_escape_string($conn, $_POST['mainlanguage']);
								$labourforcestatus = mysqli_real_escape_string($conn, $_POST['labourforcestatus']);
								$atschool = mysqli_real_escape_string($conn, $_POST['atschool']);
								$schoollevel = mysqli_real_escape_string($conn, $_POST['schoollevel']);
								$yearcompleted = mysqli_real_escape_string($conn, $_POST['yearcompleted']);
								$disability = mysqli_real_escape_string($conn, $_POST['disability']);
								$disabilitydetails = $_POST['disabilitydetail'];
								$disabilitydetail = '';
								foreach($disabilitydetails as $disabilitydetail1) {
								    $disabilitydetail .= $disabilitydetail1.', ';
								}
								$education = mysqli_real_escape_string($conn, $_POST['education']);
								$educationdetails = $_POST['educationdetail'];
								$educationdetail = '';
								foreach($educationdetails as $educationdetail1) {
								    $educationdetail .= $educationdetail1.', ';
								}
								$loggedid = $_POST['loggedid'];
								$proficiency = mysqli_real_escape_string($conn, $_POST['proficiency']);
								$courseid = $_GET['courseid'];
								$locid = $_GET['locid'];
								$slotid = $_GET['slotid'];
								$cityid = $_GET['cityid'];
								$sqlquery="UPDATE registration1 SET title = '".$title."', fname = '".$fname."', lname = '".$lname."', email='".$email."', phone = '".$phone."', mobile = '".$mobile."', dob = '".$dob."', courseid = '".$courseid."', locid = '".$locid."', slotid = '".$slotid."', cityid = '".$cityid."', gender = '".$gender."', usi = '".$usi."', building = '".$building."', flat = '".$flat."', street = '".$street."', streetname = '".$streetname."', streettype = '".$streettype."', suburb = '".$suburb."', state = '".$state."', postcode = '".$postcode."', indegenousstatus = '".$indegenousstatus."', birthcountry = '".$birthcountry."', mainlanguage = '".$mainlanguage."', labourforcestatus = '".$labourforcestatus."', atschool = '".$atschool."', schoollevel = '".$schoollevel."', yearcompleted = '".$yearcompleted."', disability = '".$disability."', disabilitydetail = '".$disabilitydetail."', education = '".$education."', educationdetail = '".$educationdetail."', proficiency = '".$proficiency."' WHERE id=".$loggedid;
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
    						    $fetchRegis = $conn->query("SELECT * FROM registration1 WHERE id= '".$_SESSION['pin_user']."'")->fetch_assoc();
    						    $disabilitydetail_str = $fetchRegis['disabilitydetail'];
    						    $disabilitydetail_ar = explode(', ',$disabilitydetail_str);
    						    $educationdetail_str = $fetchRegis['educationdetail'];
    						    $educationdetail_ar = explode(', ',$educationdetail_str);
						    ?>
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="loggedid" value="<?php echo $fetchRegis['id']; ?>"/>
                            <div class="panel panel-default">
                                <div class="panel-heading">Basic Details:</div>
                                <div class="panel-body">
                                        <div class="form-group  row">
                                            <label class="control-label col-sm-3" for="title"><span class="mandatory">*</span>Title:</label>
                                            <div class="col-sm-9">
                                                <select name="title" id="title" class="form-control" required>
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
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>DOB:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="dob" required id="dob" value="<?php echo $fetchRegis['dob']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>Email(used as login username):</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" id="email" required placeholder="Enter Email" oninput="checkuniq(this.value, 'email')" value="<?php echo $fetchRegis['email']; ?>">
                                                <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                            <div class="form-group row">
                                        <label class="control-label col-sm-3" for="gender"><span class="mandatory">*</span>Gender:</label>
                                        <div class="col-sm-9">
                                            <select id="sch" class="form-control" name="gender" required>
                                              
                                                <option value="">Select</option>
                                                <option value="Male" <?php if($fetchRegis['gender'] == 'Male') { echo 'selected'; }?>>Male</option>
                                                <option value="Female" <?php if($fetchRegis['gender'] == 'Female') { echo 'selected'; }?>>Female</option>
                                                <option value="X" <?php if($fetchRegis['gender'] == 'X') { echo 'selected'; }?>>X</option>
                                                
                                            </select>

                                        </div>
                                    </div>

                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="usi">Unique Student Identifier (USI):</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="usi" id="usi" placeholder="Enter USI" value="<?php echo $fetchRegis['usi']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="building">Building/property name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="building" id="building" placeholder="Enter Building/property name" value="<?php echo $fetchRegis['building']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="flat">Flat/Unit details:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="flat" id="flat" placeholder="Enter Flat/Unit details" value="<?php echo $fetchRegis['flat']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="street"><span class="mandatory">*</span>Street/lot number:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="street" id="street" required placeholder="Street/lot number" value="<?php echo $fetchRegis['street']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="streetname"><span class="mandatory">*</span>Street Name:</label>
                                            <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="streetname" id="streetname" required placeholder="Enter Street Name" value="<?php echo $fetchRegis['streetname']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="streettype"><span class="mandatory">*</span>Street Type:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="streettype" id="streettype" required placeholder="Enter Street Type" value="<?php echo $fetchRegis['streettype']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="suburb"><span class="mandatory">*</span>Suburb:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="suburb" name="suburb" required placeholder="Enter Suburb" value="<?php echo $fetchRegis['suburb']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="state"><span class="mandatory">*</span>State:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State" value="<?php echo $fetchRegis['state']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="postcode"><span class="mandatory">*</span>Post Code:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="postcode" id="postcode" required placeholder="Enter Post Code" value="<?php echo $fetchRegis['postcode']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="phone"><span class="mandatory">*</span>Phone Number:</label>
                                            <div class="col-sm-9">
                                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" type="text" class="form-control" maxlength="10" id="phone" name="phone" required placeholder="Enter Phone Number" value="<?php echo $fetchRegis['phone']; ?>">
                                                <p id="phoneerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="mobile"><span class="mandatory">*</span>Mobile Number(used as login username):</label>
                                            <div class="col-sm-9">
                                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" type="text" class="form-control" maxlength="10" id="mobile" name="mobile" required placeholder="Enter Mobile Number" oninput="checkuniq(this.value, 'mobile')" value="<?php echo $fetchRegis['mobile']; ?>">
                                                <p id="mobileerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname">Labour Force Status   :</label>
                                            <div class="col-sm-9">

                                                <select name="labourforcestatus" id="labor" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="05" <?php if($fetchRegis['labourforcestatus'] == '05') { echo 'selected'; }?>>Employed - unpaid worker in a family business/05</option>
                                                    <option value="01" <?php if($fetchRegis['labourforcestatus'] == '01') { echo 'selected'; }?>>Full time employee/01</option>
                                                    <option value="08" <?php if($fetchRegis['labourforcestatus'] == '08') { echo 'selected'; }?>>Not employed - not seeking employment/08</option>
                                                    <option value="@@" <?php if($fetchRegis['labourforcestatus'] == '@@') { echo 'selected'; }?>>Not stated/@@</option>
                                                    <option value="02" <?php if($fetchRegis['labourforcestatus'] == '02') { echo 'selected'; }?>>Part time employee/02</option>
                                                    <option value="03" <?php if($fetchRegis['labourforcestatus'] == '03') { echo 'selected'; }?>>Self employed - not employing others/03</option>
                                                    <option value="04" <?php if($fetchRegis['labourforcestatus'] == '04') { echo 'selected'; }?>>Self-Employed - Employing Others/04</option>
                                                    <option value="06" <?php if($fetchRegis['labourforcestatus'] == '06') { echo 'selected'; }?>>Unemployed - seeking full time work/06</option>
                                                    <option value="07" <?php if($fetchRegis['labourforcestatus'] == '07') { echo 'selected'; }?>>Unemployed - seeking part time work/07</option>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">School Details</div>
                                <div class="panel-body">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="sch">School Level:</label>
                                        <div class="col-sm-9">
                                            <input type="radio" name="atschool" group="schoollevel" value="Not Stated" <?php if($fetchRegis['atschool'] == 'Not Stated') { echo 'checked'; }?>> Not Stated
                                            <input type="radio" name="atschool" group="schoollevel" value="Yes" <?php if($fetchRegis['atschool'] == 'Yes') { echo 'checked'; }?>> Yes
                                            <input type="radio" name="atschool" group="schoollevel" value="No" <?php if($fetchRegis['atschool'] == 'No') { echo 'checked'; }?>> No

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="sch">School Level:</label>
                                        <div class="col-sm-9">
                                            <select id="sch" class="form-control" name="schoollevel">
                                                <option value="">Select</option>
                                                <option value="02" <?php if($fetchRegis['schoollevel'] == '02') { echo 'selected'; }?>>Did not go to school/02</option>
                                                <option value="@@" <?php if($fetchRegis['schoollevel'] == '@@') { echo 'selected'; }?>>Not stated/@@</option>
                                                <option value="10" <?php if($fetchRegis['schoollevel'] == '10') { echo 'selected'; }?>>Year 10/10</option>
                                                <option value="11" <?php if($fetchRegis['schoollevel'] == '11') { echo 'selected'; }?>>Year 11/11</option>
                                                <option value="12" <?php if($fetchRegis['schoollevel'] == '12') { echo 'selected'; }?>>Year 12/12</option>
                                                <option value="08" <?php if($fetchRegis['schoollevel'] == '08') { echo 'selected'; }?>>Year 8 or below/08</option>
                                                <option value="09" <?php if($fetchRegis['schoollevel'] == '09') { echo 'selected'; }?>>Year 9 or equivalent/09</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="yearcompleted">Year Completed:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="yearcompleted" id="yearcompleted" value="<?php echo $fetchRegis['yearcompleted']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Other Details</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="indegenousstatus"><span class="mandatory">*</span>Indigenous Status:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="indegenousstatus"  required id="indegenousstatus">
                                                <option value="">Select</option>
                                                <option value="-" <?php if($fetchRegis['indegenousstatus'] == '-') { echo 'selected'; }?>>---</option
                                                <option value="Yes, Aboriginal AND Torres Strait Islander" <?php if($fetchRegis['indegenousstatus'] == 'Yes, Aboriginal AND Torres Strait Islander') { echo 'selected'; }?>>Yes, Aboriginal AND Torres Strait Islander</option>
                                                <option value="No, Neither Aboriginal nor Torres Strait Islander" <?php if($fetchRegis['indegenousstatus'] == 'No, Neither Aboriginal nor Torres Strait Islander') { echo 'selected'; }?>>No, Neither Aboriginal nor Torres Strait Islander</option>
                                                <option value="Not stated" <?php if($fetchRegis['indegenousstatus'] == 'Not stated') { echo 'selected'; }?>>Not stated</option>
                                                <option value="Yes, Aboriginal" <?php if($fetchRegis['indegenousstatus'] == 'Yes, Aboriginal') { echo 'selected'; }?>>Yes, Aboriginal</option>
                                                <option value="Yes, Aboriginal AND Torres Strait Islander" <?php if($fetchRegis['indegenousstatus'] == 'Yes, Aboriginal AND Torres Strait Islander') { echo 'selected'; }?>>Yes, Aboriginal AND Torres Strait Islander</option>
                                                <option value="Yes, Torres Strait Islander" <?php if($fetchRegis['indegenousstatus'] == 'Yes, Torres Strait Islander') { echo 'selected'; }?>>Yes, Torres Strait Islander</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="mainlanguage">Main Language:</label>
                                        <div class="col-sm-9">
                                            <select id="mainlanguage" class="form-control" name="mainlanguage">
                                                <option value="">Select</option>
                                                <?php $languagessql = $conn->query("SELECT * FROM languages order by name ASC"); $classtag1 = '';
                                                while($fetchlanguages = $languagessql->fetch_assoc()) {
                                                    if($fetchRegis['mainlanguage'] == $fetchlanguages['name']) { $classtag1 = 'selected'; }
                                                    echo '<option value="'.$fetchlanguages['name'].'" '.$classtag1.'>'.$fetchlanguages['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="spoken_english_proficiency_id">Proficiency in spoken English:</label>
                                        <div class="col-sm-9">
                                            <select id="spoken_english_proficiency_id" class="form-control" name="proficiency">
                                                <option value="">Select</option>
                                                <option value="4" <?php if($fetchRegis['proficiency'] == '4') { echo 'selected'; }?>>Not at all</option>
                                                <option value="@" <?php if($fetchRegis['proficiency'] == '@') { echo 'selected'; }?>>Not stated</option>
                                                <option value="3" <?php if($fetchRegis['proficiency'] == '3') { echo 'selected'; }?>>Not well</option>
                                                <option value="1" <?php if($fetchRegis['proficiency'] == '1') { echo 'selected'; }?>>Very well</option>
                                                <option value="2" <?php if($fetchRegis['proficiency'] == '2') { echo 'selected'; }?>>Well</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="indigenous_status_id">Country of Birth:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="birthcountry">
                                                <option value="">Select</option>
                                                <?php $countriessql = $conn->query("SELECT * FROM countries order by name ASC");$classtag='';
                                                while($fetchcountries = $countriessql->fetch_assoc()) {
                                                    if($fetchRegis['birthcountry'] == $fetchcountries['name']) { $classtag = 'selected'; }
                                                    echo '<option value="'.$fetchcountries['name'].'" '.$classtag.'>'.$fetchcountries['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Disability <input type="radio" name="disability"  value="Not Stated"> Not Stated
                                    <input type="radio" name="disability" value="Yes" <?php if($fetchRegis['disability'] == 'Yes') { echo 'checked'; }?>> Yes
                                    <input type="radio" name="disability" value="No" <?php if($fetchRegis['disability'] == 'No') { echo 'checked'; }?>> No
                                </div>
                                <div class="panel-body">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="disability">Hearing/Deaf:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="disabilitydetail[]" value="Hearing/Deaf" <?php if(in_array('Hearing/Deaf', $disabilitydetail_ar)) { echo 'checked'; }?>>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="disability">Intellectual:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="disabilitydetail[]" value="Intellectual" <?php if(in_array('Intellectual', $disabilitydetail_ar)) { echo 'checked'; }?>>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Prior Education: <input type="radio" name="education" value="Not Stated"> Not Stated
                                    <input type="radio" name="education" value="Yes" <?php if($fetchRegis['education'] == 'Yes') { echo 'checked'; }?>> Yes
                                    <input type="radio" name="education" value="No" <?php if($fetchRegis['education'] == 'No') { echo 'checked'; }?>> No
                                </div>
                                <div class="panel-body">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="Bachelor Degree or Higher Degree level">Bachelor Degree or Higher Degree level:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="educationdetail[]" value="Bachelor Degree or Higher Degree level" <?php if(in_array('Bachelor Degree or Higher Degree level', $educationdetail_ar)) { echo 'checked'; }?>>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="Doctoral Degree">Doctoral Degree:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="educationdetail[]" value="Doctoral Degree" <?php if(in_array('Doctoral Degree', $educationdetail_ar)) { echo 'checked'; }?>>

                                        </div>
                                    </div>

                                </div>
                            </div>
                             <button class="btn btn-primary btn-sm" type="submit" name="update">Continue</button>
                             </form>
                             <?php } else { ?>
                             <form method="post" enctype="multipart/form-data">
                                   
                            <div class="panel panel-default">
                                <div class="panel-heading">Basic Details:</div>
                                <div class="panel-body">
                                        <div class="form-group  row">
                                            <label class="control-label col-sm-3" for="title"><span class="mandatory">*</span>Title:</label>
                                            <div class="col-sm-9">
                                                <select name="title" id="title" class="form-control" required>
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
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>DOB:</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="dob" required id="dob" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname"><span class="mandatory">*</span>Email(used as login username):</label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" name="email" id="email" required placeholder="Enter Email" oninput="checkuniq(this.value, 'email')">
                                                <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                            <div class="form-group row">
                                        <label class="control-label col-sm-3" for="gender"><span class="mandatory">*</span>Gender:</label>
                                        <div class="col-sm-9">
                                            <select id="sch" class="form-control" name="gender" required>
                                              
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="X">X</option>
                                                
                                            </select>

                                        </div>
                                    </div>

                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="usi">Unique Student Identifier (USI):</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="usi" id="usi" placeholder="Enter USI">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="building">Building/property name:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="building" id="building" placeholder="Enter Building/property name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="flat">Flat/Unit details:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="flat" id="flat" placeholder="Enter Flat/Unit details">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="street"><span class="mandatory">*</span>Street/lot number:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="street" id="street" required placeholder="Street/lot number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="streetname"><span class="mandatory">*</span>Street Name:</label>
                                            <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="streetname" id="streetname" required placeholder="Enter Street Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="streettype"><span class="mandatory">*</span>Street Type:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="streettype" id="streettype" required placeholder="Enter Street Type">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="suburb"><span class="mandatory">*</span>Suburb:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="suburb" name="suburb" required placeholder="Enter Suburb">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="state"><span class="mandatory">*</span>State:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="state" name="state" required placeholder="Enter State">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="postcode"><span class="mandatory">*</span>Post Code:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="postcode" id="postcode" required placeholder="Enter Post Code">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="phone"><span class="mandatory">*</span>Phone Number:</label>
                                            <div class="col-sm-9">
                                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" maxlength="10" type="text" class="form-control" id="phone" name="phone" required placeholder="Enter Phone Number">
                                                <p id="phoneerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="mobile"><span class="mandatory">*</span>Mobile Number(used as login username):</label>
                                            <div class="col-sm-9">
                                                <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" pattern="[0-9]+" maxlength="10" type="text" class="form-control" id="mobile" name="mobile" required placeholder="Enter Mobile Number" oninput="checkuniq(this.value, 'mobile')">
                                                <p id="mobileerr" style="display:none; color:#e83e8c"></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="control-label col-sm-3" for="fname">Labour Force Status   :</label>
                                            <div class="col-sm-9">

                                                <select name="labourforcestatus" id="labor" class="form-control">
                                                    <option value="05">Employed - unpaid worker in a family business/05</option>
                                                    <option value="05">---</option>
                                                    <option value="@@"></option>
                                                    <option value="05">Employed - unpaid worker in a family business/05</option>
                                                    <option value="01">Full time employee/01</option>
                                                    <option value="08">Not employed - not seeking employment/08</option>
                                                    <option value="@@">Not stated/@@</option>
                                                    <option value="02">Part time employee/02</option>
                                                    <option value="03">Self employed - not employing others/03</option>
                                                    <option value="04">Self-Employed - Employing Others/04</option>
                                                    <option value="06">Unemployed - seeking full time work/06</option>
                                                    <option value="07">Unemployed - seeking part time work/07</option>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">School Details</div>
                                <div class="panel-body">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="sch">School Level:</label>
                                        <div class="col-sm-9">
                                            <input type="radio" name="atschool" group="schoollevel" value="Not Stated"> Not Stated
                                            <input type="radio" name="atschool" group="schoollevel" value="Yes"> Yes
                                            <input type="radio" name="atschool" group="schoollevel" value="No"> No

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="sch">School Level:</label>
                                        <div class="col-sm-9">
                                            <select id="sch" class="form-control" name="schoollevel">
                                                <option value="09">Year 9 or equivalent/09</option>
                                                <option value="09">---</option>
                                                <option value="@@"></option>
                                                <option value="02">Did not go to school/02</option>
                                                <option value="@@">Not stated/@@</option>
                                                <option value="10">Year 10/10</option>
                                                <option value="11">Year 11/11</option>
                                                <option value="12">Year 12/12</option>
                                                <option value="08">Year 8 or below/08</option>
                                                <option value="09">Year 9 or equivalent/09</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="yearcompleted">Year Completed:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="yearcompleted" id="yearcompleted">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Other Details</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="indegenousstatus"><span class="mandatory">*</span>Indigenous Status:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="indegenousstatus"  required id="indegenousstatus">
                                                <option value="">Select</option>
                                                <option value="-">---</option
                                                <option value="Yes, Aboriginal AND Torres Strait Islander">Yes, Aboriginal AND Torres Strait Islander</option>
                                                <option value="No, Neither Aboriginal nor Torres Strait Islander">No, Neither Aboriginal nor Torres Strait Islander</option>
                                                <option value="Not stated">Not stated</option>
                                                <option value="Yes, Aboriginal">Yes, Aboriginal</option>
                                                <option value="Yes, Aboriginal AND Torres Strait Islander">Yes, Aboriginal AND Torres Strait Islander</option>
                                                <option value="Yes, Torres Strait Islander">Yes, Torres Strait Islander</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="mainlanguage">Main Language:</label>
                                        <div class="col-sm-9">
                                            <select id="mainlanguage" class="form-control" name="mainlanguage">
                                                <option value="">Select</option>
                                                <?php $languagessql = $conn->query("SELECT * FROM languages order by name ASC");
                                                while($fetchlanguages = $languagessql->fetch_assoc()) {
                                                    echo '<option value="'.$fetchlanguages['name'].'">'.$fetchlanguages['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="spoken_english_proficiency_id">Proficiency in spoken English:</label>
                                        <div class="col-sm-9">
                                            <select id="spoken_english_proficiency_id" class="form-control" name="proficiency">
                                                <option value="2">Well</option>
                                                <option value="2">---</option>
                                                <option value="">Select</option>
                                                <option value="4">Not at all</option>
                                                <option value="@">Not stated</option>
                                                <option value="3">Not well</option>
                                                <option value="1">Very well</option>
                                                <option value="2">Well</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="indigenous_status_id">Country of Birth:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="birthcountry">
                                                <option value="">Select</option>
                                                <?php $countriessql = $conn->query("SELECT * FROM countries order by name ASC");
                                                while($fetchcountries = $countriessql->fetch_assoc()) {
                                                    echo '<option value="'.$fetchcountries['name'].'">'.$fetchcountries['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Disability <input type="radio"name="disability"  value="Not Stated"> Not Stated
                                    <input type="radio" name="disability" value="Yes"> Yes
                                    <input type="radio" name="disability" value="No"> No
                                </div>
                                <div class="panel-body">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="disability">Hearing/Deaf:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="disabilitydetail[]" value="Hearing/Deaf">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="disability">Intellectual:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="disabilitydetail[]" value="Intellectual">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Prior Education: <input type="radio" name="education" value="Not Stated"> Not Stated
                                    <input type="radio" name="education" value="Yes"> Yes
                                    <input type="radio" name="education" value="No"> No
                                </div>
                                <div class="panel-body">

                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="Bachelor Degree or Higher Degree level">Bachelor Degree or Higher Degree level:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="educationdetail[]" value="Bachelor Degree or Higher Degree level">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="Doctoral Degree">Doctoral Degree:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="educationdetail[]" value="Doctoral Degree">

                                        </div>
                                    </div>

                                </div>
                            </div>
                             <button class="btn btn-primary btn-sm" type="submit" name="submit">Continue</button>
                             </form>
                             <?php } ?>
                        </div>
                    </div>
                    
                </div>
            </section>
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
          <form id="reservation_form_popup_login" name="reservation_form" class="reservation-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
              <div class="alert alert-danger" role="alert" id="LoginErr" style="display:none">  </div>
              <div class="alert alert-success" role="alert" id="Loginmsg" style="display:none">  </div>
            <h3 class="text-center mt-0 mb-30">login to your account!</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Email OR Mobile" id="reservation_name" name="reservation_username" required="" class="form-control" aria-required="true" type="text">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Your Password" id="reservation_name" name="reservation_password" required="" class="form-control" aria-required="true" type="password">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 mt-0">
                  <input name="form_botcheck" class="form-control" value="" type="hidden">
                  <button type="submit" id="uploadbtn" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Login Now</button>
                </div>
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
        	$.ajax({
        		type: "POST",
        		url: 'checkstudent.php',
        		data:{val:val,type:type},
        		success: function(response){ console.log(response);
        			if(response=='1'){				
        				$("#email").val('');
        		        $("#emailerr").css('display', 'block');
        				$("#emailerr").text(val+ ' Email address already exist!! Please Login to continue.');
        				$('#LoginModal').modal('show');
        			} else if(response=='2'){			
        				$("#mobile").val('');
        		        $("#mobileerr").css('display', 'block');
        				$("#mobileerr").text(val+ ' Mobile Number already exist!! Please Login to continue.');
        				$('#LoginModal').modal('show');
        			}  else if(response=='3'){			
        				$("#phone").val('');
        		        $("#phoneerr").css('display', 'block');
        				$("#phoneerr").text(val+ ' Phone Number already exist!! Please Login to continue.');
        				$('#LoginModal').modal('show');
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
        $(document).ready(function (e) {
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
        });
    </script>
</body>
</html>