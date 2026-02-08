<?php @session_start();
	include 'include/conn.php';
	$registerid=$_GET['registerid'];
	$courseid=$_GET['courseid'];
    $register_details = $conn->query("SELECT * FROM  registration WHERE id='".$registerid."'")->fetch_assoc();
    $course_details = $conn->query("SELECT * FROM  courses WHERE id='".$courseid."'")->fetch_assoc();
    $industry_type = $conn->query("SELECT * FROM  industry_type WHERE id='".$register_details['industry_type']."'")->fetch_assoc();
    $course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".$_GET['slotid']."'")->fetch_assoc();
	?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo $course_details['title']; ?>" />
    <meta name="keywords" content="<?php echo $course_details['title']; ?>" />
    <meta name="author" content="<?php echo $course_details['title']; ?>" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Company Name</title>
    <?php
    include("include/head_script.php");
    ?>
    <style>
        html {
            scroll-behavior: smooth;
        }
.payment-method .radiobutton {
    float: left;
    margin: 0 5px 0 0;
    width: 30%;
    height: 70px;
    position: relative;
    vertical-align: middle;
    margin-bottom:20px;
}

.payment-method .radiobutton label,
.payment-method .radiobutton input {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}

.payment-method .radiobutton input[type="radio"] {
  opacity: 0.011;
  z-index: 100;
}

.payment-method .radiobutton input[type="radio"]:checked + label {
  background: #20b8be;
  border-radius: 4px;
}

.payment-method .radiobutton label {
  cursor: pointer;
  z-index: 90;
  line-height: 2.4em;
  font-size:22px;
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
                                <h2 class="text-theme-colored2 font-36"><?php echo $course_details['title']; ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Contact</li>
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
                            <h4 class="mt-0 mb-30 line-bottom-theme-colored-2"><?php echo $course_details['title']; ?></h4>
                            <?php 
							$err = $msg = '';
							if(isset($_POST['submit'])) { echo '<script>alert("i am hitted");</script>';
    						   $courseid=$_GET['courseid'];
    						    $locid=$_GET['locid'];
    						    $slotid=$_GET['slotid'];
    						    $cityid=$_GET['cityid'];
    						    $registerid=$_GET['registerid'];
    						    $_SESSION['registerid']=$registerid;
    						    $_SESSION['courseid']=$courseid;
    						    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
        						header("Location: ".$actual_link."/payment-success/".$courseid."/".$locid."/".$slotid."/".$cityid."/".$registerid);
    						}
						?>
						
                            <?php if($course_slots['type'] == 'public') {
    						    $courseid=$_GET['courseid'];
    						    $locid=$_GET['locid'];
    						    $slotid=$_GET['slotid'];
    						    $cityid=$_GET['cityid'];
    						    $registerid=$_GET['registerid']; ?>
                        <form method="post" enctype="multipart/form-data" action="pay/index.php">
                            <input type="hidden" name="courseid" value="<?php echo $courseid; ?>"/>
                            <input type="hidden" name="locid" value="<?php echo $locid; ?>"/>
                            <input type="hidden" name="slotid" value="<?php echo $slotid; ?>"/>
                            <input type="hidden" name="cityid" value="<?php echo $cityid; ?>"/>
                            <input type="hidden" name="registerid" value="<?php echo $registerid; ?>"/>
                            <input type="hidden" name="order_amount" value="10"/>
                            <?php } else { ?>
                        <form method="post" enctype="multipart/form-data">
                            <?php } ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    PERSONAL DETAILS
                                </div>
                                <div class="panel-body">
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">First Name:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['fname']; ?></label>
                                    <label class="control-label col-sm-2" for="pwd">Last Name:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['lname']; ?></label>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Email:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['email']; ?></label>
                                    <label class="control-label col-sm-2" for="pwd">Industry Type:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $industry_type['title']; ?></label>
                                  </div>
                                </div>
                                <div class="panel panel-default">
                                <div class="panel-heading">
                                    HSR WORKPLACE DETAILS
                                </div>
                                <div class="panel-body">
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Position:</label>
                                    <label class="col-sm-4" for="pwd"><?php echo $register_details['position']; ?></label>
                                    <label class="control-label col-sm-2" for="pwd">Company:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['company']; ?></label>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Postal Address:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['postal_address']; ?></label>
                                  </div>
                                  <div class="form-group">
                                        <label class="control-label col-sm-12" for="hsr_or_not">Part A: If you are an HSR or Deputy HSR</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input disabled type="radio" name="hsr_or_not" value="1" <?php if($register_details['hsr_or_not'] == '1') { echo 'checked'; }?>> You are an elected HSR <br>
                                                <input disabled type="radio" name="hsr_or_not" value="2" <?php if($register_details['hsr_or_not'] == '2') { echo 'checked'; }?>> You are an elected Deputy HSR
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-12" for="hsr_or_not">Part B: If you are not an HSR or Deputy HSR</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input disabled type="radio" name="hsr_or_not" value="3" <?php if($register_details['hsr_or_not'] == '3') { echo 'checked'; }?>> Manager/Supervisor <br>
                                                <input disabled type="radio" name="hsr_or_not" value="4" <?php if($register_details['hsr_or_not'] == '4') { echo 'checked'; }?>> Member of your HSC <br>
                                                <input disabled type="radio" name="hsr_or_not" value="5" <?php if($register_details['hsr_or_not'] == '5') { echo 'checked'; }?>> Other (e.g. unemployed, professional development)
                                            </div>
                                        </div>
                                    </div>
                                  <hr>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Workplace Contact:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['workplace_contact']; ?></label>
                                    <label class="control-label col-sm-6" for="pwd">&nbsp;</label>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Workplace Email:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['workplace_email']; ?></label>
                                    <label class="control-label col-sm-2" for="pwd">Workplace Phone:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['workplace_phone']; ?></label>
                                  </div>
                                  <hr>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Emergency Contact:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['emergency_contact']; ?></label>
                                    <label class="control-label col-sm-2" for="pwd">Emergency Phone:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['emergency_phone']; ?></label>
                                  </div>
                                  <hr>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Additional Learning Requirements:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['special_requirements']; ?></label>
                                    <label class="control-label col-sm-2" for="pwd">Food Allergies:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['food_requirements']; ?></label>
                                  </div>
                                  <hr>
                                  <div class="form-group">
                                    <label class="control-label col-sm-2" for="pwd">Instruction:</label>
                                    <label class="control-label col-sm-4" for="pwd"><?php echo $register_details['instruction']; ?></label>
                                  </div>
                                </div>
                                </div>
                            </div>
                            <?php if($course_slots['type'] == 'public') { ?>
                             <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                    	<div class="row">
                                    		<!--<div class="col-md-8" style="padding-right:30px">
                                    	        <div class="row">
                                    		<div class="col-md-12" style="border: 1px solid #ccc;">
                                        			<h4>Select Payment Method</h4>
                                                    	<div class="payment-method">
                                                    		<div class="radiobutton">
                                                              <input type="radio" checked id="a25" name="check-substitution-2" />
                                                              <label class="btn btn-default" for="a25"><i class="fa fa-credit-card"></i> Credit Card</label>
                                                            </div>
                                                            <div class="radiobutton">
                                                              <input type="radio" id="a50" name="check-substitution-2" />
                                                              <label class="btn btn-default" for="a50"><i class="fa fa-exchange"></i> Bank Transfer </label>
                                                            </div>
                                                            <div class="radiobutton">
                                                              <input type="radio" id="a75" name="check-substitution-2" />
                                                              <label class="btn btn-default" for="a75"><i class="fa fa-paypal"></i> PayPal</label>
                                                            </div>
                                                    		<div class="col-md-11">
                                                    	        <div class="row">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="card_name">Name on Card:</label>
                                                                        <div class="">
                                                                            <input type="text" class="form-control" name="card_name" id="card_name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="card_number">Card Number:</label>
                                                                        <div class="">
                                                                            <input type="text" class="form-control" name="card_number" id="cr_no" placeholder="0000 0000 0000 0000" minlength="19" maxlength="19">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    		<div class="col-md-5">
                                                    	        <div class="row">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="card_expiry">Exp. Date:</label>
                                                                        <div class="">
                                                                            <input type="text" minlength="5" maxlength="5" class="form-control" name="card_expiry" id="exp" placeholder="MM/YY">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                    		<div class="col-md-5">
                                                    	        <div class="row">
                                                                    <div class="form-group">
                                                                        <label class="control-label" for="card_cvv">CVV:</label>
                                                                        <div class="">
                                                                            <input type="password" class="form-control" minlength="3" maxlength="3" name="card_cvv" id="card_cvv">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    	</div>
                                    			</div>
                                    		</div>
                                    		</div>-->
                                    		<div class="col-md-12" style="">
                                    	        <div class="row">
                                        			<table class="table ordertable" style="margin-bottom:0;border:1px solid #ccc;">
                                        				<tbody>
                                        					<tr>
                                        						<td colspan="2" style="border-top:1px none"><h4>Order Summary</h4></td>
                                        					</tr>
                                        					<tr>
                                        						<td><?php echo $course_details['title']; ?></td>
                                        						<td>AUD $<?php echo $course_details['price']; ?></td>
                                        					</tr>
                                        					<tr>
                                        						<td colspan="2" style="border-top:1px none">&nbsp;</td>
                                        					</tr>
                                        					<tr>
                                        						<td colspan="2" style="background-color:#e8e4e4;"><center><h4><?php echo strtoupper(date('l')); ?></h4><?php echo strtoupper(date('F d, Y h:i A')); ?></center></td>
                                        					</tr>
                                        				</tbody>
                                        			</table><br>
                                    			</div>
                                    		</div>
                                    	</div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Terms and Conditions
                                </div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-12">
                                            Please take the time to read and understand the following terms and conditions that relate specifically to your blended Work Safely at Heights course.
                                            By proceeding, you acknowledge and accept that:
                                            <ol type="1" style="list-style:number;padding-left:50px;text-align:justify">
                                                <li>If you have not provided a Unique Student Identifier (USI), this will delay processing your qualification. If you haven't provided your USI, please click the Back button until you arrive at the initial Student Details screen where you can fill in your USI.</li>
                                                <li>You will complete the pre-course study (approx. 3-4 hours) on the online learning platform, before attending the face-to-face practical component.</li>
                                                <li>You will bring a copy of your Completion Certificate to the face-to-face practical session, and you acknowledge if you fail to do this you will be ineligible to enter the practical, and will forfeit the full course fee.</li>
                                                <li>You have a suitable level of computer literacy skills. Your learning and assessment will be conducted on your own computer, and if you do not have a suitable level of computer experience, you will not be able to complete the course in the timeframe allotted.</li>
                                                <li>You can access a computer that meets the minimum System Requirements of Pinnacle’s e-Learning system (we officially support and recommend modern desktop or laptop computers running Google Chrome web browser). </li>
                                                <li>You have a stable home internet connection.</li>
                                                <li>Your enrolment period is active for 12 months and will be automatically deactivated at the conclusion of this period. You may be eligible to apply for an extension, however associated fees will be incurred.</li>
                                                <li>Where you are unable to complete your assigned face-to-face practical training day you will need to speak with our Sales and Service Team on 1300 990 810. Any changes to your original booking will incur a fee. Pinnacle will assess each individual case to determine the plan for re-booking and the fees that will apply.</li>
                                                <li>You have chosen this product with care, as we are not required to provide a refund if you change your mind about the services you asked for or chose the wrong service/product.</li>
                                                <li>You are aware that further terms and conditions apply to all Pinnacle courses, and you have been provided with the opportunity to review these prior to committing to purchase your course <a href="#">(open T&C's in new window).</a></li>
                                            </ol>
                                            <br>                                            
                                            <input type="checkbox" required> I have read and agree to the Terms and Conditions of this course. 
                                        </label>
                                        <center>Please ensure you select Confirm to finalise your payment and confirm your enrolment.</center>
                                    </div>
                                </div>
                            </div>
                            <a hrf="registration.php" class="btn btn-primary btn-sm" >Back</a>
                            <?php if($course_slots['type'] == 'public') { ?>
                                <button class="btn btn-primary btn-sm" type="submit" name="paynow">Pay Now</button>
                            <?php } else { ?>
                                <button class="btn btn-primary btn-sm" type="submit" name="submit">Continue</button>
                            <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php
    include("include/footer_script.php");
    ?>
    <script>
        /*$(document).ready(function(){
        //For Card Number formatted input
        var cardNum = document.getElementById('cr_no');
        cardNum.onkeyup = function (e) {
        if (this.value == this.lastValue) return;
        var caretPosition = this.selectionStart;
        var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
        var parts = [];
        
        for (var i = 0, len = sanitizedValue.length; i < len; i +=4) { parts.push(sanitizedValue.substring(i, i + 4)); } for (var i=caretPosition - 1; i>= 0; i--) {
            var c = this.value[i];
            if (c < '0' || c> '9') {
                caretPosition--;
                }
                }
                caretPosition += Math.floor(caretPosition / 4);
        
                this.value = this.lastValue = parts.join(' ');
                this.selectionStart = this.selectionEnd = caretPosition;
                }
        
                //For Date formatted input
                var expDate = document.getElementById('exp');
                expDate.onkeyup = function (e) {
                if (this.value == this.lastValue) return;
                    var caretPosition = this.selectionStart;
                    var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
                    var parts = [];
            
                    for (var i = 0, len = sanitizedValue.length; i < len; i +=2) { parts.push(sanitizedValue.substring(i, i + 2)); } for (var i=caretPosition - 1; i>= 0; i--) {
                        var c = this.value[i];
                        if (c < '0' || c> '9') {
                            caretPosition--;
                            }
                    }
                    caretPosition += Math.floor(caretPosition / 2);
    
                    this.value = this.lastValue = parts.join('/');
                    this.selectionStart = this.selectionEnd = caretPosition;
                }
        
            });*/
    </script>
</body>
</html>