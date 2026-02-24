<?php
session_start();
include('../include/conn.php');

// Accept GET (from redirect/rewrite) or POST
$courseid = isset($_REQUEST['courseid']) ? $_REQUEST['courseid'] : '';
$locid = isset($_REQUEST['locid']) ? $_REQUEST['locid'] : '';
$slotid = isset($_REQUEST['slotid']) ? $_REQUEST['slotid'] : '';
$cityid = isset($_REQUEST['cityid']) ? $_REQUEST['cityid'] : '';
$registerid = isset($_REQUEST['registerid']) ? $_REQUEST['registerid'] : '';

if (empty($courseid) || empty($registerid)) {
    header('Location: ../index.php');
    exit;
}

$register_details = $conn->query("SELECT * FROM registration WHERE id='".mysqli_real_escape_string($conn, $registerid)."'")->fetch_assoc();
$course_details = $conn->query("SELECT * FROM courses WHERE id='".mysqli_real_escape_string($conn, $courseid)."'")->fetch_assoc();
$industry_type = $register_details && !empty($register_details['industry_type'])
    ? $conn->query("SELECT * FROM industry_type WHERE id='".mysqli_real_escape_string($conn, $register_details['industry_type'])."'")->fetch_assoc()
    : null;
$course_slots = $conn->query("SELECT * FROM course_slots WHERE id='".mysqli_real_escape_string($conn, $slotid)."'")->fetch_assoc();

if (!$register_details || !$course_details || !$course_slots) {
    header('Location: ../index.php');
    exit;
}

$title = $course_details['title'];
$price = $course_details['price'];
$_SESSION['orderprice'] = $price;
$_SESSION['ordertitle'] = $title;
$_SESSION['registerid'] = $registerid;
$_SESSION['courseid'] = $courseid;

require_once 'config.php';

// Build base URL for back link (same as head_script)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$basePath = ($scriptDir === '/coursehub' || strpos($scriptDir, '/coursehub/') === 0) ? '/coursehub' : '';
$baseUrl = $protocol . '://' . $host . $basePath;
$payBaseUrl = rtrim($baseUrl, '/') . '/pay'; // used for Stripe JS (avoid double slash after head_script overwrites $baseUrl)
$backUrl = $baseUrl . '/registration/' . $courseid . '/' . $locid . '/' . $slotid . '/' . $cityid;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo htmlspecialchars($course_details['title']); ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($course_details['title']); ?>" />
    <meta name="author" content="Company Name" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Payment - Company Name</title>
    <?php include('../include/head_script.php'); ?>
    <style>
        html { scroll-behavior: smooth; }
        .form-control { height:30px !important; }
        #stripe-payment-form .form-control { height: auto !important; padding: 8px 12px; }
        .hidden { display: none !important; }
        #payment_processing { text-align: center; padding: 20px; }
        #payment-reinitiate { margin-top: 15px; }
        .loader { display: inline-block; width: 20px; height: 20px; border: 2px solid #ccc; border-top-color: #333; border-radius: 50%; animation: spin 0.8s linear infinite; vertical-align: middle; }
        @keyframes spin { to { transform: rotate(360deg); } }
        /* Enrollment process buttons: 40px primary, 32px secondary, padding 16px/12px, border-radius 6px */
        /* Enrollment workflow buttons: orange, 32px height */
        #submit-button { position: relative; min-width: 120px; height: 32px; line-height: 32px; padding: 0 16px; border-radius: 6px; box-sizing: border-box; background: #D8701A !important; border: none !important; }
        #submit-button:hover:not(:disabled) { background: #c46214 !important; }
        .main-content .btn-primary.btn-sm { height: 32px; line-height: 32px; padding: 0 16px; border-radius: 6px; border: none; box-sizing: border-box; background: #D8701A !important; color: #fff !important; }
        .main-content .btn-primary.btn-sm:hover { background: #c46214 !important; color: #fff !important; }
        .main-content .btn-default.btn-sm { height: 32px; line-height: 32px; padding: 0 12px; border-radius: 6px; box-sizing: border-box; background: #fff !important; color: #333 !important; border: 1px solid #ddd !important; }
        .main-content .btn-default.btn-sm:hover { background: #f5f5f5 !important; color: #333 !important; border-color: #ccc !important; }
        #submit-button .btn-spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.4); border-top-color: #fff; border-radius: 50%; animation: spin 0.7s linear infinite; vertical-align: middle; margin-right: 8px; }
        #submit-button:disabled { cursor: not-allowed; opacity: 0.9; }
        #payment-details-body { padding-bottom: 0; }
        #stripe-payment-form .form-group.mt-20 { margin-bottom: 0; margin-top: 15px; }
        #stripe-payment-form .form-group:last-child { margin-bottom: 0; }
    </style>
</head>
<body class>
    <div id="wrapper" class="clearfix">
        <div class="main-content">
            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="<?php echo $baseUrl; ?>/images/bg/bg1.jpg">
                <div class="container pt-20 pb-20">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36"><?php echo htmlspecialchars($course_details['title']); ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="<?php echo $baseUrl; ?>/">Home</a></li>
                                    <li class="active">Payment</li>
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
                            <h4 class="mt-0 mb-30 line-bottom-theme-colored-2"><?php echo htmlspecialchars($course_details['title']); ?></h4>

                            <?php if ($course_slots['type'] !== 'public') {
                                if (isset($_POST['submit'])) {
                                    header('Location: ' . $baseUrl . '/payment-success/' . $courseid . '/' . $locid . '/' . $slotid . '/' . $cityid . '/' . $registerid);
                                    exit;
                                }
                            ?>
                            <form method="post">
                            <?php } ?>

                            <div class="panel panel-default">
                                <div class="panel-heading">PERSONAL DETAILS</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">First Name:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['fname']); ?></label>
                                        <label class="control-label col-sm-2">Last Name:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['lname']); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Email:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['email']); ?></label>
                                        <label class="control-label col-sm-2">Industry Type:</label>
                                        <label class="control-label col-sm-4"><?php echo $industry_type ? htmlspecialchars($industry_type['title']) : '-'; ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">HSR WORKPLACE DETAILS</div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Position:</label>
                                        <label class="col-sm-4"><?php echo htmlspecialchars($register_details['position']); ?></label>
                                        <label class="control-label col-sm-2">Company:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['company']); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Postal Address:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['postal_address']); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-12">Part A: If you are an HSR or Deputy HSR</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input disabled type="radio" <?php if ($register_details['hsr_or_not'] == '1') echo 'checked'; ?> value="1"> You are an elected HSR <br>
                                                <input disabled type="radio" <?php if ($register_details['hsr_or_not'] == '2') echo 'checked'; ?> value="2"> You are an elected Deputy HSR
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-12">Part B: If you are not an HSR or Deputy HSR</label>
                                        <div class="col-sm-12">
                                            <div class="panel-heading">
                                                <input disabled type="radio" <?php if ($register_details['hsr_or_not'] == '3') echo 'checked'; ?> value="3"> Manager/Supervisor <br>
                                                <input disabled type="radio" <?php if ($register_details['hsr_or_not'] == '4') echo 'checked'; ?> value="4"> Member of your HSC <br>
                                                <input disabled type="radio" <?php if ($register_details['hsr_or_not'] == '5') echo 'checked'; ?> value="5"> Other (e.g. unemployed, professional development)
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Workplace Contact:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['workplace_contact']); ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Workplace Email:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['workplace_email']); ?></label>
                                        <label class="control-label col-sm-2">Workplace Phone:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['workplace_phone']); ?></label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Emergency Contact:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['emergency_contact']); ?></label>
                                        <label class="control-label col-sm-2">Emergency Phone:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['emergency_phone']); ?></label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Additional Learning Requirements:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['special_requirements']); ?></label>
                                        <label class="control-label col-sm-2">Food Allergies:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['food_requirements']); ?></label>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Instruction:</label>
                                        <label class="control-label col-sm-4"><?php echo htmlspecialchars($register_details['instruction']); ?></label>
                                    </div>
                                </div>
                            </div>

                            <?php if ($course_slots['type'] == 'public') { ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table ordertable" style="margin-bottom:0;border:1px solid #ccc;">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" style="border-top:1px none"><h4>Order Summary</h4></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($course_details['title']); ?></td>
                                                            <td>AUD $<?php echo htmlspecialchars($course_details['price']); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="border-top:1px none">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="background-color:#e8e4e4;"><center><h4><?php echo strtoupper(date('l')); ?></h4><?php echo strtoupper(date('F d, Y h:i A')); ?></center></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if ($course_slots['type'] == 'public') { ?>
                            <div class="panel panel-default" id="panel-payment-details">
                                <div class="panel-heading">Payment Details</div>
                                <div class="panel-body" id="payment-details-body">
                                    <div id="stripe-payment-message" class="alert alert-danger hidden" role="alert"></div>
                                    <form id="stripe-payment-form" class="hidden">
                                        <input type="hidden" id="publishable_key" value="<?php echo htmlspecialchars(STRIPE_PUBLISHABLE_KEY); ?>">
                                        <input type="hidden" id="courseid" value="<?php echo htmlspecialchars($courseid); ?>">
                                        <input type="hidden" id="locid" value="<?php echo htmlspecialchars($locid); ?>">
                                        <input type="hidden" id="slotid" value="<?php echo htmlspecialchars($slotid); ?>">
                                        <input type="hidden" id="cityid" value="<?php echo htmlspecialchars($cityid); ?>">
                                        <input type="hidden" id="registerid" value="<?php echo htmlspecialchars($registerid); ?>">
                                        <div class="form-group">
                                            <label class="control-label"><strong>Full Name</strong></label>
                                            <input type="text" id="fullname" class="form-control" maxlength="50" required value="<?php echo htmlspecialchars($register_details['fname'].' '.$register_details['lname']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><strong>E-Mail</strong></label>
                                            <input type="email" id="email" class="form-control" maxlength="50" required value="<?php echo htmlspecialchars($register_details['email']); ?>">
                                        </div>
                                        <h4>Enter payment details</h4>
                                        <div id="stripe-payment-element"><!-- Stripe Payment Element --></div>
                                    </form>
                                    <div id="payment_processing" class="hidden">
                                        <span class="loader"></span> <strong>Please wait!</strong> Your payment is processing...
                                    </div>
                                    <div id="payment-reinitiate" class="hidden">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="reinitiateStripe()">Try again</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-20 mb-20">
                                <label class="control-label" style="font-weight:normal;display:block;margin-bottom:15px;">
                                    <input type="checkbox" id="terms_agree" name="terms_agree" required form="stripe-payment-form"> I have read and agree to the <a href="<?php echo rtrim($baseUrl, '/'); ?>/terms-conditions.php" target="_blank" rel="noopener">Terms and Conditions</a> of this course.
                                </label>
                                <div class="btn-group-inline" style="display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
                                    <a href="<?php echo htmlspecialchars($backUrl); ?>" class="btn btn-default btn-sm">Back</a>
                                    <button type="submit" id="submit-button" form="stripe-payment-form" class="btn btn-primary btn-sm" disabled>
                                        <span class="btn-spinner hidden" id="spinner" aria-hidden="true"></span>
                                        <span id="submit-text">Pay Now</span>
                                    </button>
                                </div>
                            </div>
                            <?php } ?>

                            <?php if ($course_slots['type'] !== 'public') { ?>
                            <a href="<?php echo htmlspecialchars($backUrl); ?>" class="btn btn-default btn-sm">Back</a>
                            <button type="submit" name="submit" class="btn btn-primary btn-sm">Continue</button>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include('../include/footer_script.php'); ?>
    <?php if ($course_slots['type'] == 'public') { ?>
    <script src="https://js.stripe.com/v3/"></script>
    <script>var PAY_BASE = '<?php echo htmlspecialchars($payBaseUrl); ?>';</script>
    <script src="<?php echo htmlspecialchars($payBaseUrl); ?>/js/stripe-checkout.js" defer></script>
    <script>
        document.getElementById('terms_agree').addEventListener('change', function() {
            document.getElementById('submit-button').disabled = !this.checked;
        });
        document.getElementById('submit-button').disabled = true;
    </script>
    <?php } ?>
</body>
</html>
