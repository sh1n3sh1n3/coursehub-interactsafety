<?php 
session_start();
include 'include/conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount ? $emailaccount['title1'] : '';
$impactph = $emailaccount ? $emailaccount['phone'] : '';
$impactem = $emailaccount ? $emailaccount['email1'] : '';
$slotid_get = isset($_GET['slotid']) ? mysqli_real_escape_string($conn, $_GET['slotid']) : '';
$course_slots = $slotid_get !== '' ? $conn->query("SELECT * FROM course_slots WHERE id='".$slotid_get."'")->fetch_assoc() : null;
$course_details = !empty($_GET['courseid']) ? $conn->query("SELECT * FROM courses WHERE id='".mysqli_real_escape_string($conn, $_GET['courseid'])."'")->fetch_assoc() : null;
$sessionemail = ''; $backbutn = '';
if(isset($_SESSION['client_emaill']) && $course_slots && $course_slots['type'] == 'private') {
    $sessionemail = $_SESSION['client_emaill'];
    $backbutn = '1';
}

function genRandomString() {
    $length = 5;
    $characters = '023456789abcdefghijkmnopqrstuvwxyz';
    $max = strlen($characters) - 1;
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, $max)];
    }
    return $string;
}

/** Generate 6-digit OTP and optionally send by email. Returns OTP. On local, skips sending. */
function sendRegistrationOtp($conn, $email, $name, $emailaccount) {
    $otp = (string) rand(100000, 999999);
    if ($emailaccount && $emailaccount['status'] == '1') {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host       = $emailaccount['host'];
            $mail->Port       = $emailaccount['port'];
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth   = true;
            $mail->IsHTML(true);
            $mail->Username   = $emailaccount['email'];
            $mail->Password   = $emailaccount['password'];
            $mail->addAddress($email, $name);
            $mail->setFrom($emailaccount['email1'], $emailaccount['title1']);
            $mail->addReplyTo($emailaccount['email1'], $emailaccount['title1']);
            $mail->Subject = 'Your verification code - Company Name';
            $mail->Body    = 'Dear ' . htmlspecialchars($name) . ',<br><br>Your verification code is: <strong>' . $otp . '</strong><br><br>Regards,<br>Company Name';
            $mail->send();
        } catch (Exception $e) {
            // leave $otp set; caller can still use it for local fallback
        }
    }
    return $otp;
}

// Build base URL for redirects (same logic as head_script.php)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath = ($scriptDir === '/coursehub' || strpos($scriptDir, '/coursehub/') === 0) ? '/coursehub' : '';
$redirectBaseUrl = $protocol . '://' . $host . $basePath;
$isLocalhost = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);

$err = $msg = $errup = $msgup = '';
$last_id = null;
$loggedid = null;

// Process POST before any output so redirect can work (MVP: Full Name, Email, Phone, Course only)
if (isset($_POST['submit'])) {
    $courseid = isset($_GET['courseid']) ? $_GET['courseid'] : '';
    $locid = isset($_GET['locid']) ? $_GET['locid'] : '';
    $slotid = isset($_GET['slotid']) ? $_GET['slotid'] : '';
    $cityid = isset($_GET['cityid']) ? $_GET['cityid'] : '';
    if ($courseid === '' || $locid === '' || $slotid === '' || $cityid === '') {
        $err = 'Invalid registration link. Missing course/slot parameters. Please use the link from the course page.';
    } else {
    $fullname = trim(mysqli_real_escape_string($conn, $_POST['fullname']));
    $parts = explode(' ', $fullname, 2);
    $fname = $parts[0];
    $lname = isset($parts[1]) ? $parts[1] : '';
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $generated_code = genRandomString();
    $check_random_string_row = $conn->query('SELECT generated_code FROM registration WHERE (generated_code="'.mysqli_real_escape_string($conn, $generated_code).'")')->fetch_assoc();
    if ($check_random_string_row && $generated_code == $check_random_string_row['generated_code']) {
        $generated_code = genRandomString();
    }
    $title = $position = $company = $postal_address = $special_requirements = $food_requirements = $instruction = '';
    $workplace_contact = $workplace_email = $emergency_contact = $emergency_phone = '';
    $industry_type = $hsr_or_not = '0';
    $password = '';
    // Pending enrolment only: no seat, no confirmation email until payment succeeds
    $sql = "INSERT INTO registration (title,fname,lname,email,position,company,postal_address,courseid,locid,slotid,cityid,industry_type,hsr_or_not,workplace_contact,workplace_email,workplace_phone,emergency_contact,emergency_phone,special_requirements,food_requirements, password, generated_code, instruction, verifyEmail, payment_status) VALUES ('".$title."','".$fname."','".$lname."','".$email."','".$position."','".$company."','".$postal_address."','".$courseid."','".$locid."', '".$slotid."', '".$cityid."', '".$industry_type."', '".$hsr_or_not."', '".$workplace_contact."', '".$workplace_email."','".$phone."', '".$emergency_contact."', '".$emergency_phone."', '".$special_requirements."', '".$food_requirements."', '".$password."', '".$generated_code."', '".$instruction."', '1', 'pending')";
    $insert = $conn->query($sql);
    $last_id = mysqli_insert_id($conn);
    if ($insert) {
        $_SESSION['pin_user'] = $last_id;
        $otp = sendRegistrationOtp($conn, $email, trim($fullname), $emailaccount);
        $_SESSION['registration_otp'] = $otp;
        if ($isLocalhost) {
            $_SESSION['registration_otp_verified'] = true;
        }
        $msg = $isLocalhost ? 'Details saved. Please complete the rest of the form below.' : 'A verification code has been sent to your email. Enter it below to continue.';
        $redirectUrl = $redirectBaseUrl . '/registration/' . $courseid . '/' . $locid . '/' . $slotid . '/' . $cityid;
        header("Location: " . $redirectUrl);
        exit;
    } else {
        $err = $conn->error;
    }
    }
}

if (isset($_POST['update'])) {
    $fullname = trim(mysqli_real_escape_string($conn, $_POST['fullname']));
    $parts = explode(' ', $fullname, 2);
    $fname = $parts[0];
    $lname = isset($parts[1]) ? $parts[1] : '';
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $loggedid = (int)$_POST['loggedid'];
    $courseid = $_GET['courseid'];
    $locid = $_GET['locid'];
    $slotid = $_GET['slotid'];
    $cityid = $_GET['cityid'];
    $sqlquery = "UPDATE registration SET fname = '".$fname."', lname = '".$lname."', email='".$email."', workplace_phone = '".$phone."' WHERE id=".$loggedid;
    $update = $conn->query($sqlquery);
    if ($update) {
        $otp = sendRegistrationOtp($conn, $email, trim($fullname), $emailaccount);
        $_SESSION['registration_otp'] = $otp;
        if ($isLocalhost) {
            $_SESSION['registration_otp_verified'] = true;
        }
        $msgup = $isLocalhost ? 'Details updated. Please complete the rest of the form below.' : 'A new verification code has been sent to your email.';
        $redirectUrl = $redirectBaseUrl . '/registration/' . $courseid . '/' . $locid . '/' . $slotid . '/' . $cityid;
        header("Location: " . $redirectUrl);
        exit;
    } else {
        $errup = $conn->error;
    }
}

// Verify OTP (production): compare and set session, then redirect to show full form
if (isset($_POST['verify_otp']) && isset($_SESSION['pin_user'])) {
    $courseid = isset($_GET['courseid']) ? $_GET['courseid'] : '';
    $locid = isset($_GET['locid']) ? $_GET['locid'] : '';
    $slotid = isset($_GET['slotid']) ? $_GET['slotid'] : '';
    $cityid = isset($_GET['cityid']) ? $_GET['cityid'] : '';
    $entered = isset($_POST['otp']) ? trim($_POST['otp']) : '';
    if (isset($_SESSION['registration_otp']) && $entered === (string)$_SESSION['registration_otp']) {
        $_SESSION['registration_otp_verified'] = true;
        unset($_SESSION['registration_otp']);
        $msg = 'Email verified. Please complete the rest of the form below.';
    } else {
        $err = 'Invalid or expired code. Please try again or request a new code.';
    }
    $redirectUrl = $redirectBaseUrl . '/registration/' . $courseid . '/' . $locid . '/' . $slotid . '/' . $cityid;
    header("Location: " . $redirectUrl);
    exit;
}

// Full enrollment form submit: update registration, then redirect to payment page
if (isset($_POST['submit_full_btn']) && isset($_SESSION['pin_user'])) {
    $rid = (int)$_SESSION['pin_user'];
    $title = mysqli_real_escape_string($conn, $_POST['title'] ?? '');
    $position = mysqli_real_escape_string($conn, $_POST['position'] ?? '');
    $company = mysqli_real_escape_string($conn, $_POST['company'] ?? '');
    $postal_address = mysqli_real_escape_string($conn, $_POST['postal_address'] ?? '');
    $industry_type = isset($_POST['industry_type']) ? (int)$_POST['industry_type'] : 0;
    $hsr_or_not = isset($_POST['hsr_or_not']) ? mysqli_real_escape_string($conn, $_POST['hsr_or_not']) : '0';
    $workplace_contact = mysqli_real_escape_string($conn, $_POST['workplace_contact'] ?? '');
    $workplace_email = mysqli_real_escape_string($conn, $_POST['workplace_email'] ?? '');
    $emergency_contact = mysqli_real_escape_string($conn, $_POST['emergency_contact'] ?? '');
    $emergency_phone = mysqli_real_escape_string($conn, $_POST['emergency_phone'] ?? '');
    $special_requirements = mysqli_real_escape_string($conn, $_POST['special_requirements'] ?? '');
    $food_requirements = mysqli_real_escape_string($conn, $_POST['food_requirements'] ?? '');
    $instruction = mysqli_real_escape_string($conn, $_POST['instruction'] ?? '');
    $uq = "UPDATE registration SET title='".$title."', position='".$position."', company='".$company."', postal_address='".$postal_address."', industry_type='".$industry_type."', hsr_or_not='".$hsr_or_not."', workplace_contact='".$workplace_contact."', workplace_email='".$workplace_email."', emergency_contact='".$emergency_contact."', emergency_phone='".$emergency_phone."', special_requirements='".$special_requirements."', food_requirements='".$food_requirements."', instruction='".$instruction."' WHERE id=".$rid;
    if ($conn->query($uq)) {
        $reg = $conn->query("SELECT courseid, locid, slotid, cityid FROM registration WHERE id=".$rid)->fetch_assoc();
        if ($reg) {
            header("Location: ".$redirectBaseUrl."/pay/".$reg['courseid']."/".$reg['locid']."/".$reg['slotid']."/".$reg['cityid']."/".$rid);
            exit;
        }
        $msg = 'Enrollment saved. <a href="'.$redirectBaseUrl.'/pay/'.$_GET['courseid'].'/'.$_GET['locid'].'/'.$_GET['slotid'].'/'.$_GET['cityid'].'/'.$rid.'">Go to payment</a>.';
    } else {
        $err = $conn->error;
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
        html { scroll-behavior: smooth; }
        .form-control { height:30px !important; }
        .select2-container {width:100% !important;}
        /* Enrollment process buttons: orange, 32px height */
        .main-content .btn-primary.btn-sm,
        .main-content .btn-primary:not(.btn-sm) { height: 32px; line-height: 32px; padding: 0 16px; border-radius: 6px; border: none; box-sizing: border-box; background: #D8701A !important; color: #fff !important; }
        .main-content .btn-primary.btn-sm:hover,
        .main-content .btn-primary:not(.btn-sm):hover { background: #c46214 !important; color: #fff !important; }
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
    						if(!empty($err)){
    						  echo "
    							<div class='alert alert-danger alert-dismissible'>
    							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    							  <h4><i class='fa fa-warning'></i> Error!</h4>
    							  ".$err."
    							</div>
    						  ";
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
    						if(!empty($msg) || !empty($msgup)){
    						  echo "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>".($msg ? $msg : $msgup)."</div>";
    						}
    						$showOtpStep = isset($_SESSION['pin_user']) && $_SESSION['pin_user'] && !$isLocalhost && empty($_SESSION['registration_otp_verified']);
    						$showFullForm = isset($_SESSION['pin_user']) && $_SESSION['pin_user'] && ($isLocalhost || !empty($_SESSION['registration_otp_verified']));
    						if ($showFullForm) {
    						    $fetchRegis = $conn->query("SELECT * FROM registration WHERE id='".$_SESSION['pin_user']."'")->fetch_assoc();
    						    $industry_types = $conn->query("SELECT * FROM industry_type WHERE status='1' ORDER BY title ASC");
    						?>
    						<div class="panel panel-default mb-20">
    						    <div class="panel-heading">Your details</div>
    						    <div class="panel-body">
    						        <p><strong>Name:</strong> <?php echo htmlspecialchars(trim($fetchRegis['fname'].' '.$fetchRegis['lname'])); ?> &nbsp;|&nbsp; <strong>Email:</strong> <?php echo htmlspecialchars($fetchRegis['email']); ?> &nbsp;|&nbsp; <strong>Course:</strong> <?php echo $course_details ? htmlspecialchars($course_details['title']) : '—'; ?></p>
    						    </div>
    						</div>
    						<form method="post" enctype="multipart/form-data" autocomplete="off">
    						    <div class="panel panel-default">
    						        <div class="panel-heading">Complete your enrolment</div>
    						        <div class="panel-body">
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Title:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="title" placeholder="e.g. Mr, Ms" value="<?php echo htmlspecialchars($fetchRegis['title']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Position:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="position" value="<?php echo htmlspecialchars($fetchRegis['position']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Company:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="company" value="<?php echo htmlspecialchars($fetchRegis['company']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Postal address:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="postal_address" value="<?php echo htmlspecialchars($fetchRegis['postal_address']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Industry type:</label>
    						                <div class="col-sm-9">
    						                    <select class="form-control" name="industry_type"><option value="0">— Select —</option><?php while ($it = $industry_types->fetch_assoc()) { echo '<option value="'.$it['id'].'"'.($fetchRegis['industry_type']==$it['id']?' selected':'').'>'.htmlspecialchars($it['title']).'</option>'; } ?></select>
    						                </div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">HSR / role:</label>
    						                <div class="col-sm-9">
    						                    <label class="radio-inline"><input type="radio" name="hsr_or_not" value="1" <?php if ($fetchRegis['hsr_or_not']=='1') echo 'checked'; ?>> HSR</label>
    						                    <label class="radio-inline"><input type="radio" name="hsr_or_not" value="2" <?php if ($fetchRegis['hsr_or_not']=='2') echo 'checked'; ?>> Deputy HSR</label>
    						                    <label class="radio-inline"><input type="radio" name="hsr_or_not" value="3" <?php if ($fetchRegis['hsr_or_not']=='3') echo 'checked'; ?>> Manager/Supervisor</label>
    						                    <label class="radio-inline"><input type="radio" name="hsr_or_not" value="4" <?php if ($fetchRegis['hsr_or_not']=='4') echo 'checked'; ?>> HSC member</label>
    						                    <label class="radio-inline"><input type="radio" name="hsr_or_not" value="5" <?php if ($fetchRegis['hsr_or_not']=='5') echo 'checked'; ?>> Other</label>
    						                    <label class="radio-inline"><input type="radio" name="hsr_or_not" value="0" <?php if (empty($fetchRegis['hsr_or_not']) || $fetchRegis['hsr_or_not']=='0') echo 'checked'; ?>> —</label>
    						                </div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Workplace contact:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="workplace_contact" value="<?php echo htmlspecialchars($fetchRegis['workplace_contact']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Workplace email:</label>
    						                <div class="col-sm-9"><input type="email" class="form-control" name="workplace_email" value="<?php echo htmlspecialchars($fetchRegis['workplace_email']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Emergency contact:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="emergency_contact" value="<?php echo htmlspecialchars($fetchRegis['emergency_contact']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Emergency phone:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="emergency_phone" value="<?php echo htmlspecialchars($fetchRegis['emergency_phone']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Special / learning requirements:</label>
    						                <div class="col-sm-9"><textarea class="form-control" name="special_requirements" rows="2"><?php echo htmlspecialchars($fetchRegis['special_requirements']); ?></textarea></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Food allergies:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="food_requirements" value="<?php echo htmlspecialchars($fetchRegis['food_requirements']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Instruction / notes:</label>
    						                <div class="col-sm-9"><textarea class="form-control" name="instruction" rows="2"><?php echo htmlspecialchars($fetchRegis['instruction']); ?></textarea></div>
    						            </div>
    						            <div class="form-group row">
    						                <div class="col-sm-12"><button class="btn btn-primary btn-sm" type="submit" name="submit_full_btn" value="1">Complete enrolment</button></div>
    						            </div>
    						        </div>
    						    </div>
    						</form>
    						<?php } elseif ($showOtpStep) {
    						    $fetchRegis = $conn->query("SELECT * FROM registration WHERE id='".$_SESSION['pin_user']."'")->fetch_assoc();
    						?>
    						<div class="panel panel-default mb-20">
    						    <div class="panel-heading">Verify your email</div>
    						    <div class="panel-body">
    						        <p>We sent a 6-digit code to <strong><?php echo htmlspecialchars($fetchRegis['email']); ?></strong>. Enter it below.</p>
    						        <form method="post" class="form-inline">
    						            <input type="text" name="otp" maxlength="6" pattern="[0-9]{6}" placeholder="000000" class="form-control" style="width:120px" required>
    						            <button type="submit" name="verify_otp" value="1" class="btn btn-primary btn-sm">Verify</button>
    						        </form>
    						    </div>
    						</div>
    						<form method="post" enctype="multipart/form-data" autocomplete="off">
    						    <input type="hidden" name="loggedid" value="<?php echo $fetchRegis['id']; ?>"/>
    						    <div class="panel panel-default">
    						        <div class="panel-heading">Enrolment (MVP)</div>
    						        <div class="panel-body">
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3"><span class="mandatory">*</span>Full Name:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="fullname" required value="<?php echo htmlspecialchars(trim($fetchRegis['fname'].' '.$fetchRegis['lname'])); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3"><span class="mandatory">*</span>Email:</label>
    						                <div class="col-sm-9"><input type="email" class="form-control" name="email" required value="<?php echo htmlspecialchars($fetchRegis['email']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Phone:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($fetchRegis['workplace_phone']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Course:</label>
    						                <div class="col-sm-9"><p class="form-control-static"><?php echo $course_details ? htmlspecialchars($course_details['title']) : '—'; ?></p></div>
    						            </div>
    						            <div class="form-group row">
    						                <div class="col-sm-12"><button class="btn btn-primary btn-sm" type="submit" name="update">Resend code &amp; Continue</button></div>
    						            </div>
    						        </div>
    						    </div>
    						</form>
    						<?php } elseif (isset($_SESSION['pin_user']) && $_SESSION['pin_user']) {
    						    $fetchRegis = $conn->query("SELECT * FROM registration WHERE id='".$_SESSION['pin_user']."'")->fetch_assoc();
    						?>
    						<form method="post" enctype="multipart/form-data" autocomplete="off">
    						    <input type="hidden" name="loggedid" value="<?php echo $fetchRegis['id']; ?>"/>
    						    <div class="panel panel-default">
    						        <div class="panel-heading">Enrolment (MVP)</div>
    						        <div class="panel-body">
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3"><span class="mandatory">*</span>Full Name:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="fullname" required value="<?php echo htmlspecialchars(trim($fetchRegis['fname'].' '.$fetchRegis['lname'])); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3"><span class="mandatory">*</span>Email:</label>
    						                <div class="col-sm-9"><input type="email" class="form-control" name="email" required value="<?php echo htmlspecialchars($fetchRegis['email']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Phone:</label>
    						                <div class="col-sm-9"><input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($fetchRegis['workplace_phone']); ?>"></div>
    						            </div>
    						            <div class="form-group row">
    						                <label class="control-label col-sm-3">Course:</label>
    						                <div class="col-sm-9"><p class="form-control-static"><?php echo $course_details ? htmlspecialchars($course_details['title']) : '—'; ?></p></div>
    						            </div>
    						            <div class="form-group row">
    						                <div class="col-sm-12"><button class="btn btn-primary btn-sm" type="submit" name="update">Continue</button></div>
    						            </div>
    						        </div>
    						    </div>
    						</form>
    						<?php } else { ?>
                             <p id="formerr" style="display:none; color:#e83e8c"></p>
                             <form method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="panel panel-default">
                                <div class="panel-heading">Enrolment (MVP)</div>
                                <div class="panel-body">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="fullname"><span class="mandatory">*</span>Full Name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="fullname" id="fullname" required placeholder="Enter Full Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="email"><span class="mandatory">*</span>Email:</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" id="email" required placeholder="Enter Email (used for certificate)" oninput="checkuniq(this.value,'email')">
                                            <p id="emailerr" style="display:none; color:#e83e8c"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3" for="phone">Phone:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-3">Course:</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static"><?php echo $course_details ? htmlspecialchars($course_details['title']) : '—'; ?></p>
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
        });
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