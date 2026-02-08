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
    <meta name="author" content="Company Name" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title><?php echo $blog['title']; ?> | Company Name</title>
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
                                            <li class="nav-item active" role="presentation"><a href="editAccount.php" class="font-15 text-uppercase">Edit Account </a></li>
                                            <li class="nav-item" role="presentation"><a href="orders.php" class="font-15 text-uppercase">Orders </a></li>
                                            <li class="nav-item" role="presentation"><a href="password.php" class="font-15 text-uppercase">Change Password </a></li>
                                            <li class="nav-item" role="presentation"><a href="logout.php" class="font-15 text-uppercase">Logout </a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="tab-content p-0" style="border:1px none">
                                        <div role="tabpanel" class="tab-pane active" id="orders">
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
                                            <div class="icon-box mb-0 p-0">
                                            <a href="#" class="icon icon-bordered icon-rounded icon-sm pull-left mb-0 mr-10">
                                            <i class="fa fa-user"></i>
                                            </a>
                                            <h4 class="text-gray pt-10 mt-0 mb-30">Edit Profile</h4>
                                            </div>
                                            <hr>
                                                <form method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="loggedid" value="<?php echo $fetchRegis['id']; ?>"/>
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" style="margin-bottom: 15px">Basic Details:</div>
                                                        <div class="panel-body p-0">
                                                                <div class="form-group col-md-2" style='display:none'>
                                                                    <label class="control-label " for="title">Title:</label>
                                                                    <div class="">
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
                                                                <div class="form-group col-md-5">
                                                                    <label class="control-label " for="fname">First Name:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="fname" id="fname" required value="<?php echo $fetchRegis['fname']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-5">
                                                                    <label class="control-label " for="lname">Last Name:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="lname" id="lname" required value="<?php echo $fetchRegis['lname']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="fname">Username(email):</label>
                                                                    <div class="">
                                                                        <input type="email" class="form-control" name="email" id="email" required oninput="checkuniq(this.value, 'email', <?php echo $fetchRegis['id']; ?>)" value="<?php echo $fetchRegis['email']; ?>">
                                                                        <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="position">Position:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" required name="position" id="position" value="<?php echo $fetchRegis['position']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="company">Company:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" required name="company" id="company" value="<?php echo $fetchRegis['company']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="postal_address">Postal Address:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="postal_address" id="postal_address" value="<?php echo $fetchRegis['postal_address']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label" for="hsr_or_not">Part A: Tick only one (If you are an HSR or Deputy HSR, complete Part A. Do not complete Part B.)</label>
                                                                    <div class="">
                                                                        <div class="panel-heading">
                                                                            <input type="radio" name="hsr_or_not" value="1" <?php if($fetchRegis['hsr_or_not'] == '1') { echo 'checked'; }?>> You are an elected HSR <br>
                                                                            <input type="radio" name="hsr_or_not" value="2" <?php if($fetchRegis['hsr_or_not'] == '2') { echo 'checked'; }?>> You are an elected Deputy HSR
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label" for="hsr_or_not">Part B: If you are not an HSR or Deputy HSR you are...</label>
                                                                    <div class="">
                                                                        <div class="panel-heading">
                                                                            <input type="radio" name="hsr_or_not" value="3" <?php if($fetchRegis['hsr_or_not'] == '3') { echo 'checked'; }?>> Manager/Supervisor <br>
                                                                            <input type="radio" name="hsr_or_not" value="4" <?php if($fetchRegis['hsr_or_not'] == '4') { echo 'checked'; }?>> Member of your HSC <br>
                                                                            <input type="radio" name="hsr_or_not" value="5" <?php if($fetchRegis['hsr_or_not'] == '5') { echo 'checked'; }?>> Other (e.g. unemployed, professional development)
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="workplace_contact">Workplace Contact:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="workplace_contact" id="workplace_contact" required value="<?php echo $fetchRegis['workplace_contact']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="workplace_email">Workplace Email:</label>
                                                                    <div class="">
                                                                            <input type="text" class="form-control" name="workplace_email" id="workplace_email" required value="<?php echo $fetchRegis['workplace_email']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="workplace_phone">Workplace Phone:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="workplace_phone" id="workplace_phone" required value="<?php echo $fetchRegis['workplace_phone']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="emergency_contact">Emergency Contact:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required value="<?php echo $fetchRegis['emergency_contact']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label " for="emergency_phone">Emergency Phone:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" id="emergency_phone" name="emergency_phone" required value="<?php echo $fetchRegis['emergency_phone']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label class="control-label" for="special_requirements">Additional Learning Requirements:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="special_requirements" id="special_requirements" value="<?php echo $fetchRegis['special_requirements']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label class="control-label" for="food_requirements">Food Allergies:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="food_requirements" id="food_requirements" value="<?php echo $fetchRegis['food_requirements']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-lg-6">
                                                                    <label class="control-label" for="instruction">Instruction:</label>
                                                                    <div class="">
                                                                        <input type="text" class="form-control" name="instruction" id="instruction" value="<?php echo $fetchRegis['instruction']; ?>">
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-dark btn-lg mt-15" type="submit" name="update">Submit</button>
                                                </form>
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