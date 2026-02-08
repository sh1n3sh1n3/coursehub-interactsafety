<?php

session_start();
include('../include/conn.php');
$courseid=$_POST['courseid'];
$locid=$_POST['locid'];
$slotid=$_POST['slotid'];
$cityid=$_POST['cityid'];
$registerid=$_POST['registerid']; 
$course_details = $conn->query("SELECT * FROM  courses WHERE id='".$courseid."'")->fetch_assoc();
$register_details = $conn->query("SELECT * FROM  registration WHERE id='".$registerid."'")->fetch_assoc();
$title = $course_details['title'];
$price = $course_details['price'];
$_SESSION['orderprice'] = $price;
$_SESSION['ordertitle'] = $title;
require_once 'config.php'; 
?>
<html>
<head>
<title>Pay</title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>

<div style="width:700px; margin:50 auto;">
<h1>Please Pay to complete order</h1>

<!-- Display status message -->
<div id="stripe-payment-message" class="hidden"></div>
<?php if(!empty($_SESSION['orderprice'])) { ?>
<p><strong>Charge $<?php echo $_SESSION['orderprice']; ?> for course <?php echo $_SESSION['ordertitle']; ?></strong></p>
<?php } ?>
<form id="stripe-payment-form" class="hidden">
	<input type='hidden' id='publishable_key' value='<?php echo STRIPE_PUBLISHABLE_KEY;?>'>
	<div class="form-group">
		<label><strong>Full Name</strong></label>
		<input type="text" id="fullname" class="form-control" maxlength="50" required autofocus value="<?php echo $register_details['fname'].' '.$register_details['lname']; ?>">
		<input type="hidden" id="courseid" value="<?php echo $courseid; ?>">
		<input type="hidden" id="locid" value="<?php echo $locid; ?>">
		<input type="hidden" id="slotid" value="<?php echo $slotid; ?>">
		<input type="hidden" id="cityid" value="<?php echo $cityid; ?>">
		<input type="hidden" id="registerid" value="<?php echo $registerid; ?>">
	</div>
	<div class="form-group">
		<label><strong>E-Mail</strong></label>
		<input type="email" id="email" class="form-control" maxlength="50" required value="<?php echo $register_details['email']; ?>">
	</div>
	<h3>Enter Credit Card Information</h3>
	<div id="stripe-payment-element">
        <!--Stripe.js will inject the Payment Element here to get card details-->
	</div>

	<button id="submit-button" class="pay">
		<div class="spinner hidden" id="spinner"></div>
		<span id="submit-text">Pay Now</span>
	</button>
</form>

<!-- Display the payment processing -->
<div id="payment_processing" class="hidden">
	<span class="loader"></span> Please wait! Your payment is processing...
</div>

<!-- Display the payment reinitiate button -->
<div id="payment-reinitiate" class="hidden">
	<button class="btn btn-primary" onclick="reinitiateStripe()">Reinitiate Payment</button>
</div>


</div>    
<script src="https://js.stripe.com/v3/"></script>
<script src="js/stripe-checkout.js" defer></script>
</body>
</html>