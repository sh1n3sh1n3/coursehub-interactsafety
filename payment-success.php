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
    $register_details = $conn->query("SELECT * FROM registration WHERE id='".mysqli_real_escape_string($conn, $registerid)."'")->fetch_assoc();
    $course_details = $conn->query("SELECT * FROM courses WHERE id='".mysqli_real_escape_string($conn, $courseid)."'")->fetch_assoc();
    $fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='".$courseid."'")->fetch_assoc();
    $course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".$slotid."'")->fetch_assoc();
    $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$course_slots['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
    $fetchdateslast = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$course_slots['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
    $course_locations = $conn->query("SELECT * FROM locations WHERE id='".mysqli_real_escape_string($conn, $locid)."'")->fetch_assoc();
    $course_city = $conn->query("SELECT * FROM cities WHERE id='".mysqli_real_escape_string($conn, $cityid)."'")->fetch_assoc();
    if (!$register_details || !$course_details || !$course_slots || !$course_locations) {
        header('Location: index.php');
        exit;
    }
    $orderdata = $conn->query("SELECT * FROM sale ORDER BY id DESC LIMIT 1")->fetch_assoc();
    $industry_type = $conn->query("SELECT * FROM industry_type WHERE id='".mysqli_real_escape_string($conn, $register_details['industry_type'])."'")->fetch_assoc();
    $industry_title = $industry_type ? $industry_type['title'] : '';
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
	    $sql="INSERT INTO sale (date, invoiceno, vrno, orderno, courseid, slotid, user, fname, lname, email, address1,assign_to,assigned,industry_type,paymenttag,paymentmethod,paymentid,amount,netamount,hsrornot,position,company,postal_address,workplace_contact,workplace_email,workplace_phone,emergency_contact,emergency_phone,special_requirements,food_requirements, instruction) SELECT now(), '".$invoiceno."','".$vrno."','".$orderno."','".$courseid."','".$slotid."',id, fname,lname,email,postal_address,'".$course_slots['teacherid']."',1,'".$register_details['industry_type']."',1,'Online','".$orderno."','".$course_details['price']."','".$course_details['price']."','".$register_details['hsr_or_not']."', '".$register_details['position']."','".$register_details['company']."','".$register_details['postal_address']."','".$register_details['workplace_contact']."','".$register_details['workplace_email']."','".$register_details['workplace_phone']."','".$register_details['emergency_contact']."','".$register_details['emergency_phone']."','".$register_details['special_requirements']."','".$register_details['food_requirements']."','".$register_details['instruction']."' FROM registration WHERE id='".$registerid."'";
	    $insert = $conn->query($sql);
	    
    	if($insert){
    	    $last_id = $conn->insert_id;
    	    if (!empty($_SESSION['client_course_code'])) {
    	        $conn->query("UPDATE private_course SET registration_id = '".mysqli_real_escape_string($conn, $registerid)."', sale_id='".$last_id."', status='sold' WHERE course_code = '".mysqli_real_escape_string($conn, $_SESSION['client_course_code'])."' AND course_id='".mysqli_real_escape_string($conn, $courseid)."' AND slot_id='".mysqli_real_escape_string($conn, $slotid)."'");
    	    }
    	    $remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid = '".$courseid."' AND slotid='".$slotid."'");
    	    if($remain_places->num_rows > 0) {
    	        $fetchremain_places = $remain_places->fetch_assoc();
    	        $pencount = $fetchremain_places['count'] + 1;
    	        $conn->query("UPDATE remain_places SET count='".$pencount."' WHERE courseid = '".$courseid."' AND slotid='".$slotid."'");
    	    }
    	    if($emailaccount['status'] == '1') {
    		    $userdataname = trim(($register_details['title'] ?? '').' '.$register_details['fname'].' '.$register_details['lname']);
    		    $email = $register_details['email'];
    		    $course_link = $urlcourse."courses-detail/".$fetchcourses['id']."/".$fetchcourses['slug'];
    		    $start_date = $fetchdates ? date('l, j F Y', strtotime($fetchdates['date'])).' at '.date('g:i A', strtotime($fetchdates['starttime'])) : '—';
    		    $end_date = $fetchdateslast ? date('l, j F Y', strtotime($fetchdateslast['date'])).' at '.date('g:i A', strtotime($fetchdateslast['starttime'])) : '—';
    		    $location_text = ($course_city ? $course_city['name'].' — ' : '').$course_locations['location'].($course_locations['title'] ? ' ('.$course_locations['title'].')' : '');
    		    $map_link = !empty($course_locations['maplink']) ? $course_locations['maplink'] : '';
    		    $what_to_bring = !empty($course_slots['remarks']) ? trim($course_slots['remarks']) : 'Photo ID; notepad and pen; any materials advised in your course joining instructions.';
    		    $txt1 = "<p>Hi ".htmlspecialchars($register_details['fname']).",</p>";
    		    $txt1 .= "<p><strong>Your seat is confirmed.</strong> Thank you for your payment. Please find your booking and course information below.</p>";
    		    $txt1 .= "<h3 style='margin-top:24px;'>Course details</h3>";
    		    $txt1 .= "<ul style='line-height:1.6;'>";
    		    $txt1 .= "<li><strong>Course:</strong> ".htmlspecialchars($course_details['title'])."</li>";
    		    $txt1 .= "<li><strong>Start:</strong> ".$start_date."</li>";
    		    $txt1 .= "<li><strong>End:</strong> ".$end_date."</li>";
    		    $txt1 .= "<li><a href='".htmlspecialchars($course_link)."' target='_blank'>View course details</a></li>";
    		    $txt1 .= "</ul>";
    		    $txt1 .= "<h3 style='margin-top:24px;'>Location</h3>";
    		    $txt1 .= "<p>".htmlspecialchars($location_text)."</p>";
    		    if ($map_link) $txt1 .= "<p><a href='".htmlspecialchars($map_link)."' target='_blank'>View on map</a></p>";
    		    if (!empty($course_slots['remarks'])) $txt1 .= "<p><strong>Venue notes:</strong> ".nl2br(htmlspecialchars($course_slots['remarks']))."</p>";
    		    $txt1 .= "<h3 style='margin-top:24px;'>What to bring</h3>";
    		    $txt1 .= "<p>".nl2br(htmlspecialchars($what_to_bring))."</p>";
    		    $txt1 .= "<p><strong>Please keep this email for reference and bring the items listed above on the day.</strong></p>";
    		    $txt1 .= "<h3 style='margin-top:24px;'>Contact details</h3>";
    		    $txt1 .= "<p>If you have any questions or need to change your booking, please contact us:</p>";
    		    $txt1 .= "<ul style='line-height:1.6;'>";
    		    $txt1 .= "<li><strong>Email:</strong> <a href='mailto:".htmlspecialchars($impactem)."'>".htmlspecialchars($impactem)."</a></li>";
    		    $txt1 .= "<li><strong>Phone:</strong> ".htmlspecialchars($impactph)."</li>";
    		    $txt1 .= "</ul>";
    		    $txt1 .= "<p style='margin-top:24px;'>Regards,<br>".htmlspecialchars($impacttitle)."</p>";
    		    $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->SMTPDebug  = 0;
                    $mail->Host       = $emailaccount['host'];
                    $mail->Port       = $emailaccount['port'];
                    $mail->SMTPSecure = 'tls';
                    $mail->SMTPAuth   = true;
                    $mail->IsHTML(true);
                    $mail->Username   = $emailaccount['email'];
                    $mail->Password   = $emailaccount['password'];
                    $mail->addAddress($email, $userdataname);
                    $mail->setFrom($impactem, $impacttitle);
                    $mail->addReplyTo($impactem, $impacttitle);
                    $mail->Subject = "Seat confirmed – ".$course_details['title'];
                    $mail->Body    = $txt1;
                    $mail->Send();
                } catch (Exception $e) {
                    $err = $e->getMessage();
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
<?php
    $conf_start = $fetchdates ? date('l, j F Y', strtotime($fetchdates['date'])).' at '.date('g:i A', strtotime($fetchdates['starttime'])) : '—';
    $conf_end = $fetchdateslast ? date('l, j F Y', strtotime($fetchdateslast['date'])).' at '.date('g:i A', strtotime($fetchdateslast['starttime'])) : '—';
    $conf_location = ($course_city ? $course_city['name'].' — ' : '').$course_locations['location'].($course_locations['title'] ? ' ('.$course_locations['title'].')' : '');
    $student_email = $register_details['email'];
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Booking confirmed – <?php echo htmlspecialchars($course_details['title']); ?>" />
    <title>Booking confirmed – <?php echo htmlspecialchars($course_details['title']); ?></title>
    <?php include("include/head_script.php"); ?>
    <style>
        .confirmation-hero { background: linear-gradient(135deg, #0d6b4c 0%, #0a5a3d 100%); color: #fff; padding: 32px 24px; border-radius: 8px; text-align: center; margin-bottom: 28px; }
        .confirmation-hero h1 { margin: 0 0 8px 0; font-size: 28px; font-weight: 700; }
        .confirmation-hero p { margin: 0; opacity: 0.95; font-size: 16px; }
        .conf-summary { border: 1px solid #e0e0e0; border-radius: 8px; padding: 24px; margin-bottom: 24px; background: #fafafa; }
        .conf-summary h3 { margin: 0 0 16px 0; font-size: 18px; color: #333; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; }
        .conf-summary .row-item { margin-bottom: 10px; }
        .conf-summary .row-item strong { display: inline-block; min-width: 140px; color: #555; }
        .conf-notice { background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 6px; padding: 16px 20px; margin-bottom: 24px; color: #2e7d32; }
        .btn-confirmation { display: inline-block; height: 32px; line-height: 32px; padding: 0 16px; background: #D8701A; color: #fff !important; text-decoration: none; border-radius: 6px; font-weight: 600; box-sizing: border-box; }
        .btn-confirmation:hover { background: #c46214; color: #fff; }
    </style>
</head>
<body class>
    <div id="wrapper" class="clearfix">
        <?php include("include/head.php"); ?>
        <div class="main-content">
            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Booking confirmed</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Confirmation</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="divider">
                <div class="container pt-50 pb-70">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="confirmation-hero">
                                <h1>Your seat is confirmed</h1>
                                <p>Thank you for your payment. Your booking is confirmed and your place is secured.</p>
                            </div>
                            <div class="conf-notice">
                                <strong>Check your email.</strong> A confirmation email has been sent to <strong><?php echo htmlspecialchars($student_email); ?></strong> with full course details, venue information, <strong>what to bring on the day</strong>, and our contact details. Please check your inbox (and spam folder) and keep that email for reference.
                            </div>
                            <div class="conf-summary">
                                <h3>Course details</h3>
                                <div class="row-item"><strong>Course</strong> <?php echo htmlspecialchars($course_details['title']); ?></div>
                                <div class="row-item"><strong>Start</strong> <?php echo $conf_start; ?></div>
                                <div class="row-item"><strong>End</strong> <?php echo $conf_end; ?></div>
                                <div class="row-item"><strong>Location</strong> <?php echo htmlspecialchars($conf_location); ?></div>
                            </div>
                            <p class="text-center" style="margin-top: 28px;">
                                <a href="index.php" class="btn-confirmation">Back to website</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include("include/footer.php"); ?>
    </div>
    <?php include("include/footer_script.php"); ?>
</body>
</html>