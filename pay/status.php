<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
// Include the DB config & class files
session_start();
include('../include/conn.php');
require_once 'config.php';
require_once 'dbclass.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
$protocol = isset($_SERVER['HTTPS']) &&
    $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';
$urlcourse = $base_url;
$emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
$impacttitle = $emailaccount['title1'];
$impactph = $emailaccount['phone'];
$impactem = $emailaccount['email1'];

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . '://' . $host;
$payPageBase = rtrim($baseUrl, '/') . '/pay';

function formatPaymentAmount($amount, $currency)
{
    $formattedAmount = number_format((float) $amount, 2, '.', ',');
    $normalizedCurrency = strtoupper(trim((string) $currency));

    if ($normalizedCurrency === '' || $normalizedCurrency === 'AUD') {
        return '$' . $formattedAmount;
    }

    return $formattedAmount . ' ' . $normalizedCurrency;
}

// Return from Stripe after Pay Now: check payment status and either show completed (redirect to self with tid) or not completed + Try again
$payment_intent_id = isset($_GET['payment_intent']) ? trim($_GET['payment_intent']) : '';
if (!empty($payment_intent_id) && !empty($_GET['customer_id'])) {
    require_once __DIR__ . '/vendor/autoload.php';
    require_once 'config.php';
    \Stripe\Stripe::setApiKey(STRIPE_SECRET_API_KEY);
    $customer_id = trim($_GET['customer_id']);
    $courseid = isset($_GET['courseid']) ? $_GET['courseid'] : '';
    $locid = isset($_GET['locid']) ? $_GET['locid'] : '';
    $slotid = isset($_GET['slotid']) ? $_GET['slotid'] : '';
    $cityid = isset($_GET['cityid']) ? $_GET['cityid'] : '';
    $registerid = isset($_GET['registerid']) ? $_GET['registerid'] : '';
    $redirect_status = isset($_GET['redirect_status']) ? $_GET['redirect_status'] : '';
    try {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        $payment = $paymentIntent;
    } catch (Exception $e) {
        $payment = null;
    }
    if ($payment && $payment->status === 'succeeded') {
        // Save to stripe_payment then redirect to self with tid so success page loads
        $transaction_id = $payment->id;
        $amount = ($payment->amount / 100);
        $currency = $payment->currency;
        $item_description = isset($payment->description) ? $payment->description : '';
        $payment_status = $payment->status;
        $fullname = $email = '';
        try {
            $customerData = \Stripe\Customer::retrieve($customer_id);
            if (!empty($customerData->name)) {
                $fullname = $customerData->name;
            }
            if (!empty($customerData->email)) {
                $email = $customerData->email;
            }
        } catch (Exception $e) {
        }
        $db = new DB;
        $db->query("SELECT id FROM `stripe_payment` WHERE transaction_id=:transaction_id");
        $db->bind(":transaction_id", $transaction_id);
        $row = $db->result();
        if (empty($row)) {
            $db->query("INSERT INTO `stripe_payment` (`fullname`, `email`, `item_description`, `currency`, `amount`, `transaction_id`, `payment_status`) VALUES (:fullname, :email, :item_description, :currency, :amount, :transaction_id, :payment_status)");
            $db->bind(":fullname", $fullname);
            $db->bind(":email", $email);
            $db->bind(":item_description", $item_description);
            $db->bind(":currency", $currency);
            $db->bind(":amount", $amount);
            $db->bind(":transaction_id", $transaction_id);
            $db->bind(":payment_status", $payment_status);
            $db->execute();
        }
        $db->close();
        header("Location: " . $payPageBase . "/status.php?tid=" . urlencode($transaction_id));
        exit;
    }
    // Payment not completed: show Try again page
    $payPageUrl = $payPageBase . '/' . $courseid . '/' . $locid . '/' . $slotid . '/' . $cityid . '/' . $registerid;
?>
    <!DOCTYPE html>
    <html dir="ltr" lang="en">

    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Payment not completed – Interact Safety</title>
        <?php include('../include/head_script.php'); ?>
        <style>
            .status-panel {
                max-width: 560px;
                margin: 0 auto;
                padding: 32px 24px;
                text-align: center;
            }

            .status-panel h2 {
                margin-top: 0;
                color: #333;
            }

            .btn-try-again {
                display: inline-block;
                margin-top: 16px;
                padding: 0 24px;
                height: 40px;
                line-height: 40px;
                background: #D8701A;
                color: #fff !important;
                text-decoration: none;
                border-radius: 6px;
                font-weight: 600;
            }

            .btn-try-again:hover {
                background: #c46214;
                color: #fff !important;
            }
        </style>
    </head>

    <body class>
        <div id="wrapper" class="clearfix">
            <?php include('../include/head.php'); ?>
            <div class="main-content">
                <section class="divider">
                    <div class="container pt-50 pb-70">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="panel panel-default status-panel">
                                    <div class="panel-body">
                                        <h2>Payment not completed</h2>
                                        <p>Your payment was not completed. Please try again to confirm your seat.</p>
                                        <a href="<?php echo htmlspecialchars($payPageUrl); ?>" class="btn btn-primary btn-try-again">Try again</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include('../include/footer_script.php'); ?>
    </body>

    </html>
<?php
    exit;
}

// If transaction ID is not empty 
if (!empty($_GET['tid'])) {
    $transaction_id  = $_GET['tid'];
    $email_status = isset($_SESSION['payment_email_status'][$transaction_id]) ? $_SESSION['payment_email_status'][$transaction_id] : null;

    $db = new DB;
    // Fetch the transaction details from DB using Transaction ID
    $db->query("SELECT * FROM `stripe_payment` WHERE transaction_id=:transaction_id");
    $db->bind(":transaction_id", $transaction_id);
    $row = $db->result();
    $db->close();
    if (!empty($row)) {
        $fullname = $row['fullname'];
        $email = $row['email'];
        $item_description = $row['item_description'];
        $currency = $row['currency'];
        $amount = $row['amount'];
        $display_amount = formatPaymentAmount($amount, $currency);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
<?php if (!empty($row)) {
    $print = explode('_', $fullname);
    $courseid = $print['1'];
    $locid = $print['2'];
    $slotid = $print['3'];
    $cityid = $print['4'];
    $registerid = $print['5'];
    $register_details = $conn->query("SELECT * FROM registration WHERE id='" . $registerid . "'")->fetch_assoc();
    $course_details = $conn->query("SELECT * FROM courses WHERE id='" . $courseid . "'")->fetch_assoc();
    $fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='" . $courseid . "'")->fetch_assoc();
    $course_slots = $conn->query("SELECT * FROM course_slots WHERE id='" . $slotid . "'")->fetch_assoc();
    $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='" . $course_slots['id'] . "' ORDER BY date ASC LIMIT 1")->fetch_assoc();
    $fetchdateslast = $conn->query("SELECT * FROM course_dates WHERE slot_id='" . $course_slots['id'] . "' ORDER BY date DESC LIMIT 1")->fetch_assoc();
    $course_locations = $conn->query("SELECT * FROM locations WHERE id='" . $locid . "'")->fetch_assoc();
    $course_city = $conn->query("SELECT * FROM cities WHERE id='" . $cityid . "'")->fetch_assoc();
    $orderdata = $conn->query("SELECT * FROM sale ORDER BY id DESC LIMIT 1")->fetch_assoc();
    $industry_type = $conn->query("SELECT * FROM  industry_type WHERE id='" . $register_details['industry_type'] . "'")->fetch_assoc();
    $oldvr = $orderdata['vrno'];
    $vrno = $oldvr + 1;
    if (date('m') >  3) {
        $minyear = date('y');
        $maxyear = date('y') + 1;
    } else {
        $minyear = date('y') - 1;
        $maxyear = date('y');
    }
    $coursestitle = '';
    $invoiceno = 'CN/' . $minyear . '-' . $maxyear . '/' . $vrno;
    $orderno = 'ORD' . $minyear . '-' . $maxyear . $vrno;
    $seeltdata = $conn->query("SELECT * FROM sale WHERE courseid=" . $courseid . " AND slotid=" . $slotid . " AND user=" . $register_details['id'] . "");
    $insert = false;
    $email_failed = ($email_status === 'failed');
    if ($seeltdata->num_rows ==  0) {
        $sql = "INSERT INTO sale (date, invoiceno, vrno, orderno, courseid, slotid, user, fname, lname, email, address1,assign_to,assigned,industry_type,paymenttag,paymentmethod,paymentid,amount,netamount,hsrornot,position,company,postal_address,workplace_contact,workplace_email,workplace_phone,emergency_contact,emergency_phone,special_requirements,food_requirements, instruction) SELECT now(), '" . $invoiceno . "','" . $vrno . "','" . $orderno . "','" . $courseid . "','" . $slotid . "',id, fname,lname,email,postal_address,'" . $course_slots['teacherid'] . "',1,'" . $register_details['industry_type'] . "',1,'Online','" . $transaction_id . "','" . $course_details['price'] . "','" . $course_details['price'] . "','" . $register_details['hsr_or_not'] . "', '" . $register_details['position'] . "','" . $register_details['company'] . "','" . $register_details['postal_address'] . "','" . $register_details['workplace_contact'] . "','" . $register_details['workplace_email'] . "','" . $register_details['workplace_phone'] . "','" . $register_details['emergency_contact'] . "','" . $register_details['emergency_phone'] . "','" . $register_details['special_requirements'] . "','" . $register_details['food_requirements'] . "','" . $register_details['instruction'] . "' from registration where id='" . $registerid . "'";
        $insert = $conn->query($sql);
    }
    $saleCreatedNow = !empty($insert);
    if ($seeltdata->num_rows > 0 || $saleCreatedNow) {
        $last_id = $saleCreatedNow ? $conn->insert_id : 0;
        // Payment success: mark registration as paid (seat confirmed, course register populated)
        $conn->query("UPDATE registration SET payment_status = 'paid' WHERE id = '" . mysqli_real_escape_string($conn, $registerid) . "'");
        if (!empty($_SESSION['client_course_code'])) {
            $conn->query("UPDATE private_course SET registration_id = " . $registerid . ", sale_id=" . $last_id . ", status='sold' WHERE course_code = '" . mysqli_real_escape_string($conn, $_SESSION['client_course_code']) . "' AND course_id=" . $courseid . " AND slot_id=" . $slotid . "");
        }
        $remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid = " . $courseid . " AND slotid=" . $slotid . "");
        if ($remain_places->num_rows > 0) {
            $fetchremain_places = $remain_places->fetch_assoc();
            $pencount = $fetchremain_places['count'] + 1;
            $conn->query("UPDATE remain_places SET count=" . $pencount . " WHERE courseid = " . $courseid . " AND slotid=" . $slotid . "");
        }
        $display_amount = formatPaymentAmount($amount, $currency);
        if ($emailaccount['status'] == '1' && $saleCreatedNow) {
            $userdataname = trim(($register_details['title'] ?? '') . ' ' . $register_details['fname'] . ' ' . $register_details['lname']);
            $email = $register_details['email'];
            $course_link = $baseUrl . "/courses-detail/" . $fetchcourses['id'] . "/" . $fetchcourses['slug'];
            $start_date = $fetchdates ? date('l, j F Y', strtotime($fetchdates['date'])) . ' at ' . date('g:i A', strtotime($fetchdates['starttime'])) : '-';
            $end_date = $fetchdateslast ? date('l, j F Y', strtotime($fetchdateslast['date'])) . ' at ' . date('g:i A', strtotime($fetchdateslast['starttime'])) : '-';
            $location_text = ($course_city ? $course_city['name'] . ' - ' : '') . $course_locations['location'] . ($course_locations['title'] ? ' (' . $course_locations['title'] . ')' : '');
            $map_link = !empty($course_locations['maplink']) ? $course_locations['maplink'] : '';
            $course_dates_list = '';
            $day_index = 0;
            $courseDatesForEmail = $conn->query("SELECT * FROM course_dates WHERE slot_id='" . (int)$course_slots['id'] . "' ORDER BY date ASC, starttime ASC");
            while ($cd = $courseDatesForEmail->fetch_assoc()) {
                $day_index++;
                $course_dates_list .= "<li><strong>Day " . $day_index . ":</strong> " . date('l, j F Y', strtotime($cd['date'])) . " (" . date('g:i A', strtotime($cd['starttime'])) . " - " . date('g:i A', strtotime($cd['endtime'])) . ")</li>";
            }
            if ($course_dates_list === '') {
                $course_dates_list = "<li>-</li>";
            }
            $paid_on = date('d-M-Y');
            $attendee_names = trim(($register_details['title'] ?? '') . ' ' . $register_details['fname'] . ' ' . $register_details['lname']);
            $receiptBody = "<p><strong>Payment received</strong></p>";
            $receiptBody .= "<p>Thank you for your booking. This email confirms that payment has been successfully received for the " . htmlspecialchars($course_details['title']) . ".</p>";
            $receiptBody .= "<h3 style='margin-top:24px;'>Receipt Details</h3>";
            $receiptBody .= "<ul style='line-height:1.6;'>";
            $receiptBody .= "<li><strong>Course:</strong> " . htmlspecialchars($course_details['title']) . "</li>";
            $receiptBody .= "<li><strong>Invoice Number:</strong> " . htmlspecialchars($invoiceno) . "</li>";
            $receiptBody .= "<li><strong>Date Paid:</strong> " . htmlspecialchars($paid_on) . "</li>";
            $receiptBody .= "<li><strong>Payment Method:</strong> Credit Card / Stripe</li>";
            $receiptBody .= "</ul>";
            $receiptBody .= "<h3 style='margin-top:24px;'>Payment Summary</h3>";
            $receiptBody .= "<ul style='line-height:1.6;'>";
            $receiptBody .= "<li><strong>Amount Paid:</strong> " . htmlspecialchars($display_amount) . "</li>";
            $receiptBody .= "<li><strong>Transaction ID:</strong> " . htmlspecialchars($transaction_id) . "</li>";
            $receiptBody .= "</ul>";
            $receiptBody .= "<h3 style='margin-top:24px;'>Attendee(s)</h3>";
            $receiptBody .= "<ul style='line-height:1.6;'><li>" . htmlspecialchars($attendee_names) . "</li></ul>";
            $receiptBody .= "<h3 style='margin-top:24px;'>Important</h3>";
            $receiptBody .= "<p>A separate email has been sent with full course details, including dates, location, and attendance information.</p>";
            $receiptBody .= "<h3 style='margin-top:24px;'>Need Help?</h3>";
            $receiptBody .= "<p>If you have any questions regarding this payment or require a formal tax invoice:</p>";
            $receiptBody .= "<ul style='line-height:1.6;'><li><strong>Email:</strong> <a href='mailto:info@interactsafety.com.au'>info@interactsafety.com.au</a></li></ul>";
            $receiptBody .= "<h3 style='margin-top:24px;'>Thank You</h3>";
            $receiptBody .= "<p>We appreciate your commitment to workplace health and safety.</p>";
            $receiptBody .= "<p style='margin-top:24px;'>Regards,<br>Interact Safety Training Team</p>";

            $confirmBody = "<p>Hi " . htmlspecialchars($register_details['fname']) . ",</p>";
            $confirmBody .= "<p>Your booking for the " . htmlspecialchars($course_details['title']) . " has been confirmed.</p>";
            $confirmBody .= "<p>This WorkSafe-approved training will provide you with the knowledge and practical skills to effectively represent your designated work group and contribute to improving workplace health and safety.</p>";
            $confirmBody .= "<h3 style='margin-top:24px;'>Course Details</h3>";
            $confirmBody .= "<ul style='line-height:1.6;'>";
            $confirmBody .= "<li><strong>Course:</strong> " . htmlspecialchars($course_details['title']) . "</li>";
            $confirmBody .= "<li><strong>Dates:</strong><ul style='margin-top:6px;'>" . $course_dates_list . "</ul></li>";
            $confirmBody .= "<li><strong>Location:</strong> " . htmlspecialchars($location_text) . "</li>";
            $confirmBody .= "</ul>";
            $confirmBody .= "<p><strong>Additional details:</strong></p>";
            if (!empty($course_slots['remarks'])) $confirmBody .= "<p>" . nl2br(htmlspecialchars($course_slots['remarks'])) . "</p>";
            if ($map_link) $confirmBody .= "<p><a href='" . htmlspecialchars($map_link) . "' target='_blank'>View map link</a></p>";
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
            $email_failed = false;
            try {
                $mail->isSMTP();
                $mail->SMTPDebug  = 0;
                $mail->Host       = $emailaccount['host'];
                $mail->Port       = $emailaccount['port'];
                $mail->SMTPSecure = 'tls'; // port 587 uses STARTTLS
                $mail->SMTPAuth   = true;
                $mail->IsHTML(true);
                $mail->CharSet    = 'UTF-8';
                $mail->Username   = $emailaccount['email']; // SMTP account username
                $mail->Password   = $emailaccount['password'];       // SMTP account password
                $mail->addAddress($email, $userdataname);  //Add a recipient
                $mail->setFrom($impactem, $impacttitle);
                $mail->addReplyTo($impactem, $impacttitle);
                $mail->Subject = "Payment Receipt - " . $course_details['title'];
                $mail->Body    = $receiptBody;
                if ($mail->Send()) {
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
                    $mail2->Subject = "Your enrolment is confirmed - " . $course_details['title'];
                    $mail2->Body    = $confirmBody;
                    $mail2->Send();
                    $_SESSION['payment_email_status'][$transaction_id] = 'sent';
                } else {
                    $email_failed = true;
                    $_SESSION['payment_email_status'][$transaction_id] = 'failed';
                }
            } catch (Exception $e) {
                $email_failed = true;
                $_SESSION['payment_email_status'][$transaction_id] = 'failed';
            }
            $_SESSION['orderprice'] = '';
            $_SESSION['ordertitle'] = '';
            $conf_start = $fetchdates ? date('l, j F Y', strtotime($fetchdates['date'])) . ' at ' . date('g:i A', strtotime($fetchdates['starttime'])) : '-';
            $conf_end = $fetchdateslast ? date('l, j F Y', strtotime($fetchdateslast['date'])) . ' at ' . date('g:i A', strtotime($fetchdateslast['starttime'])) : '-';
            $conf_location = ($course_city ? $course_city['name'] . ' - ' : '') . $course_locations['location'] . ($course_locations['title'] ? ' (' . $course_locations['title'] . ')' : '');
?>
            <!DOCTYPE html>
            <html dir="ltr" lang="en">

            <head>
                <meta name="viewport" content="width=device-width,initial-scale=1.0" />
                <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
                <title>Payment successful - Seat confirmed</title>
                <?php include('../include/head_script.php'); ?>
                <style>
                    .confirmation-hero {
                        background: linear-gradient(135deg, #D8701A 0%, #c46214 100%);
                        color: #fff;
                        padding: 32px 24px;
                        border-radius: 8px;
                        text-align: center;
                        margin-bottom: 28px;
                    }

                    .confirmation-hero h1,
                    .confirmation-hero p {
                        color: #fff !important;
                    }

                    .confirmation-hero h1 {
                        margin: 0 0 8px 0;
                        font-size: 28px;
                        font-weight: 700;
                    }

                    .confirmation-hero p {
                        margin: 0;
                        opacity: 0.95;
                        font-size: 16px;
                    }

                    .conf-summary {
                        border: 1px solid #e8e8e8;
                        border-radius: 8px;
                        padding: 24px;
                        margin-bottom: 24px;
                        background: #fff;
                    }

                    .conf-summary h3 {
                        margin: 0 0 16px 0;
                        font-size: 18px;
                        color: #333;
                        border-bottom: 2px solid #D8701A;
                        padding-bottom: 8px;
                    }

                    .conf-summary .row-item {
                        margin-bottom: 10px;
                    }

                    .conf-summary .row-item strong {
                        display: inline-block;
                        min-width: 140px;
                        color: #555;
                    }

                    .conf-notice {
                        background: #fff5ee;
                        border: 1px solid #D8701A;
                        border-radius: 6px;
                        padding: 16px 20px;
                        margin-bottom: 24px;
                        color: #333;
                    }

                    .conf-notice.email-failed {
                        background: #fff8e1;
                        border: 1px solid #D8701A;
                        color: #333;
                    }

                    .btn-continue {
                        display: inline-block;
                        height: 32px;
                        line-height: 32px;
                        padding: 0 16px;
                        background: #D8701A;
                        color: #fff !important;
                        text-decoration: none;
                        border-radius: 6px;
                        font-weight: 600;
                        box-sizing: border-box;
                    }

                    .btn-continue:hover {
                        background: #c46214;
                        color: #fff !important;
                    }
                </style>
            </head>

            <body class>
                <div id="wrapper" class="clearfix">
                    <?php include('../include/head.php'); ?>
                    <div class="main-content">
                        <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="<?php echo $baseUrl; ?>/images/bg/bg1.jpg">
                            <div class="container pt-20 pb-20">
                                <div class="section-content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-theme-colored2 font-36">Payment successful</h2>
                                            <ol class="breadcrumb text-left mt-10 white">
                                                <li><a href="<?php echo $baseUrl; ?>/">Home</a></li>
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
                                            <h1>Payment successful. Your seat is confirmed.</h1>
                                            <p>All booking and course details will be delivered to you via email.</p>
                                        </div>
                                        <?php if (empty($email_failed)) { ?>
                                            <div class="conf-notice">
                                                A confirmation email has been sent to <strong><?php echo htmlspecialchars($email); ?></strong> with your receipt, course details, venue information, <strong>what to bring on the day</strong>, and our contact details. Please check your inbox (and spam folder) and keep it for reference.
                                            </div>
                                        <?php } else { ?>
                                            <div class="conf-notice email-failed">
                                                <strong>We could not send your confirmation email.</strong> Your booking and payment are recorded. Please save your Transaction ID below and contact us for a copy: <?php echo htmlspecialchars($impactem); ?> or <?php echo htmlspecialchars($impactph); ?>.
                                            </div>
                                        <?php } ?>
                                        <div class="conf-summary">
                                            <h3>Course details</h3>
                                            <div class="row-item"><strong>Course</strong> <?php echo htmlspecialchars($course_details['title']); ?></div>
                                            <div class="row-item"><strong>Start</strong> <?php echo $conf_start; ?></div>
                                            <div class="row-item"><strong>End</strong> <?php echo $conf_end; ?></div>
                                            <div class="row-item"><strong>Location</strong> <?php echo htmlspecialchars($conf_location); ?></div>
                                        </div>
                                        <div class="conf-summary">
                                            <h3>Payment receipt</h3>
                                            <div class="row-item"><strong>Name</strong> <?php echo htmlspecialchars(trim($register_details['fname'] . ' ' . $register_details['lname'])); ?></div>
                                            <div class="row-item"><strong>Email</strong> <?php echo htmlspecialchars($email); ?></div>
                                            <div class="row-item"><strong>Transaction ID</strong> <code><?php echo htmlspecialchars($transaction_id); ?></code></div>
                                            <div class="row-item"><strong>Amount</strong> <?php echo htmlspecialchars($display_amount); ?></div>
                                        </div>
                                        <p class="text-center" style="margin-top: 28px;">
                                            <a href="<?php echo htmlspecialchars(rtrim($baseUrl, '/') . '/'); ?>" class="btn-continue">Back to website</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <?php include('../include/footer.php'); ?>
                </div>
                <?php include('../include/footer_script.php'); ?>
            </body>

            </html>
    <?php }
    } else {
        // 		$err = $conn->error;
    }
} else { ?>
    <!DOCTYPE html>
    <html dir="ltr" lang="en">

    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>Transaction failed – Interact Safety</title>
        <?php include('../include/head_script.php'); ?>
    </head>

    <body class>
        <div id="wrapper" class="clearfix">
            <div class="main-content">
                <section class="divider">
                    <div class="container pt-50 pb-70">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="alert alert-danger">
                                    <h2 class="mt-0">Transaction could not be confirmed</h2>
                                    <p>We could not find or confirm this payment. If you were charged, please contact us with your transaction details.</p>
                                    <p><a href="<?php echo $baseUrl; ?>/">Return to home</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php include('../include/footer_script.php'); ?>
    </body>

    </html>
<?php } ?>