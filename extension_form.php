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
$emailto = $emailaccount['emailto'];
$nameto = $emailaccount['nameto'];
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
                                <h2 class="text-theme-dark font-36">Extension request for completing HSR 
                                <img style="float:right;margin-bottom:0" src="images/worksafe.png"/></h2>
                                <h2 style="margin-top:0" class="text-theme-dark font-36">initial training past 6 month period</h2>
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
							    $provider = mysqli_real_escape_string($conn, $_POST['provider']);
								$submittedby = mysqli_real_escape_string($conn, $_POST['submittedby']);
								$ondate = mysqli_real_escape_string($conn, $_POST['ondate']);
								$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
								$course_date = mysqli_real_escape_string($conn, $_POST['course_date']);
								$expected_date = mysqli_real_escape_string($conn, $_POST['expected_date']);
								$reason = mysqli_real_escape_string($conn, $_POST['reason']);
								$missed_days = $_POST['missed_days'];
								$misseddays = implode(',', $missed_days);
								$sql="INSERT INTO extension_form (ondate,provider,submittedby,fullname,course_date,expected_date,reason,missed_days) VALUES ('".$ondate."','".$provider."','".$submittedby."','".$fullname."','".$course_date."','".$expected_date."','".$reason."','".$misseddays."')";
    							$insert = $conn->query($sql);
    							$last_id = mysqli_insert_id($conn);
    							if($insert){
    								$msg = 'Your request has been successfully submitted. We will respond within five business days.';
    								if($emailaccount['status'] == '1') {
        							    $txt1 = "Dear Admin,<br>";
                        				$txt1 .= "New extension request is submitted with following details:<br>";
                        				$txt1 .= "Name : ".$fullname."<br>";
                        				$txt1 .= "Course Start date : ".$course_date."<br>";
                        				$txt1 .= "Missed Days : ".$misseddays."<br>";
                        				$txt1 .= "Expected Date : ".$expected_date."<br>";
                        				$txt1 .= "Reason for extension : ".$reason."<br>Regards<br>Company";
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
                                <div class="panel-heading text-center text-dark" style="background: #FFC000;font-weight: bold;font-size: 16px;letter-spacing: 3px;">Instructions</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <ul type="1">
                                            <li>1. Complete sections 1-3 of this form, and return by email to <b>HSR training Team</b> at <br> 
                                            <a style="color:#FFC000">&nbsp;&nbsp;&nbsp;&nbsp;training_provider@worksafe.vic.gov.au</a>.</li>
                                            <li>2. The HSR Training Team will consider your request and respond within five business days.</li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading text-white" style="background:#808080">Section 1 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Provider details</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="provider">WorkSafe approved provider:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="provider" id="provider" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="submittedby">Form Submitted by:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="submittedby" id="submittedby" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="ondate">Submission date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="ondate" id="ondate" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading text-white" style="background:#808080">Section 2 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Participant details</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="fullname">Participant full name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="fullname" id="fullname" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="course_date">HSR initial course start date:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="course_date" id="course_date" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="missed_days">Days missed:</label>
                                        <div class="col-sm-9">
                                            <input type="checkbox" name="missed_days[]" value="1"> Day 1
                                            <input style="margin-left:40px" type="checkbox" name="missed_days[]" value="2"> Day 2
                                            <input style="margin-left:40px" type="checkbox" name="missed_days[]" value="3"> Day 3
                                            <input style="margin-left:40px" type="checkbox" name="missed_days[]" value="4"> Day 4
                                            <input style="margin-left:40px" type="checkbox" name="missed_days[]" value="5"> Day 5
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="expected_date">Expected date to complete the course:</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" name="expected_date" id="expected_date" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading text-white" style="background:#808080">Section 3 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Reason for extension</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12" for="reason">Please provide a details/reason for the extension request for the participant named in Section 2:</label>
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