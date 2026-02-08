<?php @session_start();
	include 'include/conn.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    $protocol = isset($_SERVER['HTTPS']) && 
    $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
    $urlcourse = $base_url;
    $emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
    $impacttitle = $emailaccount['title1'];
    $impactph = $emailaccount['phone'];
    $impactem = $emailaccount['email1'];
	$registerid=$_GET['registerid'];
	$courseid = $_GET['courseid'];
	$locid = $_GET['locid'];
	$slotid = $_GET['slotid'];
	$cityid = $_GET['cityid'];
    $register_details = $conn->query("SELECT * FROM registration WHERE id='".$registerid."'")->fetch_assoc();
    $course_details = $conn->query("SELECT * FROM courses WHERE id='".$courseid."'")->fetch_assoc();
    $fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='".$courseid."'")->fetch_assoc();
    $course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".$slotid."'")->fetch_assoc();
    $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$course_slots['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
    $fetchdateslast = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$course_slots['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
    $course_locations = $conn->query("SELECT * FROM locations WHERE id='".$locid."'")->fetch_assoc();
    $course_city = $conn->query("SELECT * FROM cities WHERE id='".$cityid."'")->fetch_assoc();
    $orderdata = $conn->query("SELECT * FROM sale ORDER BY id DESC LIMIT 1")->fetch_assoc();
    $industry_type = $conn->query("SELECT * FROM  industry_type WHERE id='".$register_details['industry_type']."'")->fetch_assoc();
	$oldvr = $orderdata['vrno'];
	$vrno = $oldvr + 1;
	if (date('m') >  3) {
		$minyear = date('y');
		$maxyear = date('y') + 1;
	}
	else {
		$minyear = date('y') - 1;
		$maxyear = date('y');
	}
	$coursestitle='';
	$invoiceno = 'CN/'.$minyear.'-'.$maxyear.'/'.$vrno;
	$orderno = 'ORD'.$minyear.'-'.$maxyear.$vrno;
	$seeltdata = $conn->query("SELECT * FROM sale WHERE courseid='".$courseid."' AND slotid='".$slotid."' AND user='".$register_details['id']."'");
	if($seeltdata->num_rows > 0) { } else {
	    $sql="INSERT INTO sale (date, invoiceno, vrno, orderno, courseid, slotid, user, fname, lname, email, address1,assign_to,assigned,industry_type,paymenttag,paymentmethod,paymentid,amount,netamount,hsrornot,position,company,postal_address,workplace_contact,workplace_email,workplace_phone,emergency_contact,emergency_phone,special_requirements,food_requirements, instruction) SELECT now(), '".$invoiceno."','".$vrno."','".$orderno."','".$courseid."','".$slotid."',id, fname,lname,email,postal_address,'".$course_slots['teacherid']."',1,'".$register_details['industry_type']."',1,'Online','".$orderno."','".$course_details['price']."','".$course_details['price']."','".$register_details['hsr_or_not']."', '".$register_details['position']."','".$register_details['company']."','".$register_details['postal_address']."','".$register_details['workplace_contact']."','".$register_details['workplace_email']."','".$register_details['workplace_phone']."','".$register_details['emergency_contact']."','".$register_details['emergency_phone']."','".$register_details['special_requirements']."','".$register_details['food_requirements']."','".$register_details[' instruction']."' from registration where id='".$registerid."'";
	    $insert = $conn->query($sql);
	    
    	if($insert){
    	    $last_id = $conn->insert_id;
    	    $conn->query("UPDATE private_course SET registration_id = '".$registerid."', sale_id='".$last_id."', status='sold' WHERE course_code = '".$_SESSION['client_course_code']."' AND course_id='".$courseid."' AND slot_id='".$slotid."'");
    	    $remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid = '".$courseid."' AND slotid='".$slotid."'");
    	    if($remain_places->num_rows > 0) {
    	        $fetchremain_places = $remain_places->fetch_assoc();
    	        $pencount = $fetchremain_places['count'] + 1;
    	        $conn->query("UPDATE remain_places SET count='".$pencount."' WHERE courseid = '".$courseid."' AND slotid='".$slotid."'");
    	    }
    	    if($emailaccount['status'] == '1') {
    		    $userdataname = $register_details['title'].' '.$register_details['fname'].' '.$register_details['lname'];
    		    $email = $register_details['email'];
    		    $tips = "<h4>Here are some tips for attending a course:</h4>
                        <b>Prepare</b>
                        <p>Consider what you want to gain from the course, and how you can apply what you learn. Review the course joining instructions, which may include details about the venue, timings, course length, and what to bring. </p>
                        <b>Create a routine</b>
                        <p>Set aside time each day for the course, and build your schedule around it. This will help you prioritize the course and reduce distractions. </p>
                        <b>Make a study plan</b>
                        <p>Create a comprehensive strategy that includes everything you need to cover, and how much time you have. Leave the last few days for revision. </p>
                        <b>Take notes</b>
                        <p>Taking notes helps you absorb information and gives you a written record to refer back to later. </p>
                        <b>Ask questions</b>
                        <p>Asking relevant questions shows that you are engaged and eager to learn. </p> ";
    		    $txt1 = "Hi ".$register_details['fname'].",<br>";
    			$txt1 .= "Order Success.<br/>Order details are below:<br>";
    			$txt1 .= "Course : ".$course_details['title']."<br>";
    			$txt1 .= "Course Link : <a target='_blank' href='".$urlcourse."courses-detail/".$fetchcourses['id']."/".$fetchcourses['slug']."'>Click Here</a><br>";
    			$txt1 .= "Start Date & Slot : ".date('d-M-Y', strtotime($fetchdates['date'])).' '.date('h:i A', strtotime($fetchdates['starttime']))."<br>";
    			$txt1 .= "End Date : ".date('d-M-Y', strtotime($fetchdateslast['date'])).' '.date('h:i A', strtotime($fetchdateslast['starttime']))."<br>";
    			$txt1 .= "Location : ".$course_city['name'].' - '.$course_locations['location'].' ('.$course_locations['title'].')'."<br>";
    			$txt1 .= "Location Map : <a target='_blank' href='".$course_locations['maplink']."'>Click Here</a><br>";
    			$txt1 .= "Venue Notes : ".$course_slots['remarks']."<br>";
    			$txt1 .= "".$tips."<br>";
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
    	} else {
    // 		$err = $conn->error;
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
		  <h4><i class='fa fa-suucess'></i> Error!</h4>
		  ".$err."
		</div>
	  ";
	}

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
							if(isset($_POST['submit'])) {
							 
						   $courseid=$_GET['courseid'];
						    $locid=$_GET['locid'];
						    $slotid=$_GET['slotid'];
						    $cityid=$_GET['cityid'];
						    $registerid=$_GET['registerid'];
						    $_SESSION['registerid']=$registerid;
						    $_SESSION['courseid']=$courseid;
						  //  echo "<script>location.href='target-page.php';</script>";
						    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]";
						  //  echo $actual_link; die;
						 header("Location: ".$actual_link."/payment-success/".$courseid."/".$locid."/".$slotid."/".$cityid."/".$last_id."/".$registerid);
						}
						?>
						
 <form method="post" enctype="multipart/form-data">
                                   
                            <div class="panel panel-default">
                              
                                <div class="panel-body">
                                    <center>
                                        <img src="images/success.png" width="300px" />
                                    </center>
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
                                      
                                      </div>
                                      <center>
                                    <a href="index.php" class="btn btn-primary btn-lg" >Go to Website</a>
                                    <a href="account.php" class="btn btn-primary btn-lg" >Go to Panel</a>
                                   
                                    </center>
                                     <br>
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
    <?php
    include("include/footer_script.php");
    ?>
</body>
</html>