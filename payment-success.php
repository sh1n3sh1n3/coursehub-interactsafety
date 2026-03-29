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
            $_SESSION['registration_prefill'] = [
                'fullname' => trim((string) (($register_details['fname'] ?? '') . ' ' . ($register_details['lname'] ?? ''))),
                'email' => (string) ($register_details['email'] ?? ''),
                'phone' => (string) ($register_details['workplace_phone'] ?? '')
            ];
            unset(
                $_SESSION['pin_user'],
                $_SESSION['registration_otp'],
                $_SESSION['registration_otp_verified'],
                $_SESSION['registration_resume_flow'],
                $_SESSION['registration_welcome_complete']
            );
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
    		    $start_date = $fetchdates ? date('l, j F Y', strtotime($fetchdates['date'])).' at '.date('g:i A', strtotime($fetchdates['starttime'])) : '-';
    		    $end_date = $fetchdateslast ? date('l, j F Y', strtotime($fetchdateslast['date'])).' at '.date('g:i A', strtotime($fetchdateslast['starttime'])) : '-';
    		    $location_text = ($course_city ? $course_city['name'].' - ' : '').$course_locations['location'].($course_locations['title'] ? ' ('.$course_locations['title'].')' : '');
    		    $map_link = !empty($course_locations['maplink']) ? $course_locations['maplink'] : '';
    		    $course_dates_list = '';
    		    $day_index = 0;
    		    $courseDatesForEmail = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$course_slots['id']."' ORDER BY date ASC, starttime ASC");
    		    while ($cd = $courseDatesForEmail->fetch_assoc()) {
    		        $day_index++;
    		        $course_dates_list .= "<li><strong>Day ".$day_index.":</strong> ".date('l, j F Y', strtotime($cd['date']))." (".date('g:i A', strtotime($cd['starttime']))." - ".date('g:i A', strtotime($cd['endtime'])).")</li>";
    		    }
    		    if ($course_dates_list === '') {
    		        $course_dates_list = "<li>-</li>";
    		    }
    		    $paid_on = date('d-M-Y');
    		    $attendee_names = trim(($register_details['title'] ?? '').' '.$register_details['fname'].' '.$register_details['lname']);
    		    $display_amount = '$'.number_format((float)$course_details['price'], 2);
    		    $receipt_txn = $orderno;
    		    $receiptBody = "<p><strong>Payment received</strong></p>";
    		    $receiptBody .= "<p>Thank you for your booking. This email confirms that payment has been successfully received for the ".htmlspecialchars($course_details['title']).".</p>";
    		    $receiptBody .= "<h3 style='margin-top:24px;'>Receipt Details</h3>";
    		    $receiptBody .= "<ul style='line-height:1.6;'><li><strong>Course:</strong> ".htmlspecialchars($course_details['title'])."</li><li><strong>Invoice Number:</strong> ".htmlspecialchars($invoiceno)."</li><li><strong>Date Paid:</strong> ".htmlspecialchars($paid_on)."</li><li><strong>Payment Method:</strong> Credit Card / Stripe</li></ul>";
    		    $receiptBody .= "<h3 style='margin-top:24px;'>Payment Summary</h3>";
    		    $receiptBody .= "<ul style='line-height:1.6;'><li><strong>Amount Paid:</strong> ".htmlspecialchars($display_amount)."</li><li><strong>Transaction ID:</strong> ".htmlspecialchars($receipt_txn)."</li></ul>";
    		    $receiptBody .= "<h3 style='margin-top:24px;'>Attendee(s)</h3>";
    		    $receiptBody .= "<ul style='line-height:1.6;'><li>".htmlspecialchars($attendee_names)."</li></ul>";
    		    $receiptBody .= "<h3 style='margin-top:24px;'>Important</h3>";
    		    $receiptBody .= "<p>A separate email has been sent with full course details, including dates, location, and attendance information.</p>";
    		    $receiptBody .= "<h3 style='margin-top:24px;'>Need Help?</h3>";
    		    $receiptBody .= "<p>If you have any questions regarding this payment or require a formal tax invoice:</p>";
    		    $receiptBody .= "<ul style='line-height:1.6;'><li><strong>Email:</strong> <a href='mailto:info@interactsafety.com.au'>info@interactsafety.com.au</a></li></ul>";
    		    $receiptBody .= "<h3 style='margin-top:24px;'>Thank You</h3>";
    		    $receiptBody .= "<p>We appreciate your commitment to workplace health and safety.</p>";
    		    $receiptBody .= "<p style='margin-top:24px;'>Regards,<br>Interact Safety Training Team</p>";

    		    $confirmBody = "<p>Hi ".htmlspecialchars($register_details['fname']).",</p>";
    		    $confirmBody .= "<p>Your booking for the ".htmlspecialchars($course_details['title'])." has been confirmed.</p>";
    		    $confirmBody .= "<p>This WorkSafe-approved training will provide you with the knowledge and practical skills to effectively represent your designated work group and contribute to improving workplace health and safety.</p>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>Course Details</h3>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li><strong>Course:</strong> ".htmlspecialchars($course_details['title'])."</li><li><strong>Dates:</strong><ul style='margin-top:6px;'>".$course_dates_list."</ul></li><li><strong>Location:</strong> ".htmlspecialchars($location_text)."</li></ul>";
    		    $confirmBody .= "<p><strong>Additional details:</strong></p>";
    		    if (!empty($course_slots['remarks'])) $confirmBody .= "<p>".nl2br(htmlspecialchars($course_slots['remarks']))."</p>";
    		    if ($map_link) $confirmBody .= "<p><a href='".htmlspecialchars($map_link)."' target='_blank'>View map link</a></p>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>What to Expect</h3>";
    		    $confirmBody .= "<p>This course is designed to be practical, engaging, and directly relevant to your workplace.</p>";
    		    $confirmBody .= "<p>Throughout the program, you will:</p>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li>Work through real workplace scenarios</li><li>Take part in group discussions and activities</li><li>Build confidence in your role as a Health and Safety Representative</li><li>Understand your powers and entitlements under the OHS Act</li></ul>";
    		    $confirmBody .= "<p>You'll leave with practical tools you can take straight back into your workplace.</p>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>Important Information for HSRs</h3>";
    		    $confirmBody .= "<p>Under the Occupational Health and Safety Act 2004:</p>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li>HSRs are entitled to attend approved training</li><li>HSRs have the right to choose their training course in consultation with their employer</li></ul>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>Attendance Requirements</h3>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li>Attendance is required across all scheduled sessions</li><li>Participation is expected throughout the course</li><li>Late arrival or missed sessions may impact course completion</li></ul>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>What's Provided</h3>";
    		    $confirmBody .= "<p>To support your learning, the following will be provided:</p>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li>Training folder and course materials</li><li>Morning tea and lunch (sandwiches/wraps)</li><li>Tea and coffee</li></ul>";
    		    $confirmBody .= "<p>If you prefer to bring your own lunch or explore other options, there are a variety of cafes and shops located nearby. A fridge is also available for your use.</p>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>What to Bring</h3>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li>Pens (highlighters optional)</li><li>Water bottle (optional)</li></ul>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>Need Help?</h3>";
    		    $confirmBody .= "<p>If you have any questions or need to make changes to your booking:</p>";
    		    $confirmBody .= "<ul style='line-height:1.6;'><li><strong>Email:</strong> <a href='mailto:info@interactsafety.com.au'>info@interactsafety.com.au</a></li></ul>";
    		    $confirmBody .= "<h3 style='margin-top:24px;'>Final Note</h3>";
    		    $confirmBody .= "<p>We look forward to working with you and supporting you in your role as a Health and Safety Representative.</p>";
    		    $confirmBody .= "<p style='margin-top:24px;'>Regards,<br>Interact Safety Training Team</p>";
    		    $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->SMTPDebug  = 0;
                    $mail->Host       = $emailaccount['host'];
                    $mail->Port       = $emailaccount['port'];
                    $mail->SMTPSecure = 'tls';
                    $mail->SMTPAuth   = true;
                    $mail->IsHTML(true);
                    $mail->CharSet    = 'UTF-8';
                    $mail->Username   = $emailaccount['email'];
                    $mail->Password   = $emailaccount['password'];
                    $mail->addAddress($email, $userdataname);
                    $mail->setFrom($impactem, $impacttitle);
                    $mail->addReplyTo($impactem, $impacttitle);
                    $mail->Subject = "Payment Receipt - ".$course_details['title'];
                    $mail->Body    = $receiptBody;
                    $mail->Send();

                    $mail2 = new PHPMailer(true);
                    $mail2->isSMTP();
                    $mail2->SMTPDebug  = 0;
                    $mail2->Host       = $emailaccount['host'];
                    $mail2->Port       = $emailaccount['port'];
                    $mail2->SMTPSecure = 'tls';
                    $mail2->SMTPAuth   = true;
                    $mail2->IsHTML(true);
                    $mail2->CharSet    = 'UTF-8';
                    $mail2->Username   = $emailaccount['email'];
                    $mail2->Password   = $emailaccount['password'];
                    $mail2->addAddress($email, $userdataname);
                    $mail2->setFrom($impactem, $impacttitle);
                    $mail2->addReplyTo($impactem, $impacttitle);
                    $mail2->Subject = "Your enrolment is confirmed - ".$course_details['title'];
                    $mail2->Body    = $confirmBody;
                    $mail2->Send();
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
    $conf_start = $fetchdates ? date('l, j F Y', strtotime($fetchdates['date'])).' at '.date('g:i A', strtotime($fetchdates['starttime'])) : '-';
    $conf_end = $fetchdateslast ? date('l, j F Y', strtotime($fetchdateslast['date'])).' at '.date('g:i A', strtotime($fetchdateslast['starttime'])) : '-';
    $conf_location = ($course_city ? $course_city['name'].' - ' : '').$course_locations['location'].($course_locations['title'] ? ' ('.$course_locations['title'].')' : '');
    $student_email = $register_details['email'];
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Booking confirmed - <?php echo htmlspecialchars($course_details['title']); ?>" />
    <title>Booking confirmed - <?php echo htmlspecialchars($course_details['title']); ?></title>
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