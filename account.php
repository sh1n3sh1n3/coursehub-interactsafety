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
                                            <li class="nav-item active" role="presentation"><a href="account.php" class="font-15 text-uppercase">Dashboard </a></li>
                                            <li class="nav-item" role="presentation"><a href="editAccount.php" class="font-15 text-uppercase">Edit Account </a></li>
                                            <li class="nav-item" role="presentation"><a href="orders.php" class="font-15 text-uppercase">Orders </a></li>
                                            <li class="nav-item" role="presentation"><a href="password.php" class="font-15 text-uppercase">Change Password </a></li>
                                            <li class="nav-item" role="presentation"><a href="logout.php" class="font-15 text-uppercase">Logout </a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="tab-content p-0" style="border:1px none">
                                        <div role="tabpanel" class="tab-pane active" id="dashboard">
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
                                            <h4 class="text-gray pt-10 mt-0 mb-30">Welcome <?php echo $fetchRegis['fname']; ?></h4>
                                            </div>
                                            <hr>
                                            <div class="profile-log-switch">
                                                <dic class="row">
                                                    <div class="col-lg-6">
                                                       <div class="media-heading">
                                                          <h3 class="card-title mb-3 mt-0 font-weight-bold">Personal Details</h3>
                                                       </div>
                                                       <ul class="usertab-list mb-3">
                                                          <li><a href="javascript:void(0)"><strong class="text-dark">Full Name :</strong> <span class="user-1"> <?php echo $fetchRegis['title'].' '.$fetchRegis['fname'].' '.$fetchRegis['lname']; ?></span></a></li>
                                                          <li><a href="javascript:void(0)"><strong class="text-dark">Email Address :</strong> <span class="user-1"> <?php echo $fetchRegis['email']; ?></span></a></li>
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Position :</strong> <span class="user-1"> <?php echo $fetchRegis['position']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Company :</strong> <span class="user-1"> <?php echo $fetchRegis['company']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Postal Address :</strong> <span class="user-1"> <?php echo $fetchRegis['postal_address']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Workplace Contact :</strong> <span class="user-1"> <?php echo $fetchRegis['workplace_contact']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Workplace Email :</strong> <span class="user-1"> <?php echo $fetchRegis['workplace_email']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Workplace Phone :</strong> <span class="user-1"> <?php echo $fetchRegis['workplace_phone']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Emergency Contact :</strong> <span class="user-1"> <?php echo $fetchRegis['emergency_contact']; ?></span></a></li>-->
                                                          <!--<li><a href="javascript:void(0)"><strong class="text-dark">Emergency Phone :</strong> <span class="user-1"> <?php echo $fetchRegis['emergency_phone']; ?></span></a></li>-->
                                                       </ul>
                                                    </div>
                                                    <!--<div class="col-lg-6 row">-->
                                                    <!--    <div class="col-lg-6"></div>-->
                                                    <!--    <div class="col-lg-6">-->
                                                    <!--        <?php echo '<img style="float:right;width:100%" src="data:image/png;base64,'.$data.'" /><br><h5><a style="float:right;width:100%" class="btn btn-warning" download href="data:image/png;base64,'.$data.'">Download</a></h5>'; ?>-->
                                                    <!--    </div>-->
                                                    <!--</div>-->
                                                </dic>
                                            </div>
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