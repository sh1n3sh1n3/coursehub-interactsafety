<?php
$information = $conn->query("SELECT * FROM information WHERE id='1'")->fetch_assoc();
// Course detail links for footer (same logic as index.php: first course in category)
$footerHsrInitialHref = '#';
$footerHsrRefresherHref = '#';
$catInitial = $conn->query("SELECT id FROM category WHERE status='1' AND (title LIKE '%Initial%' OR title LIKE '%initial%') ORDER BY title ASC LIMIT 1");
if ($catInitial && $catInitial->num_rows > 0) {
    $cid = $catInitial->fetch_assoc()['id'];
    $first = $conn->query("SELECT id, replace(slug,' ','-') as slug FROM courses WHERE catid='".$cid."' ORDER BY id ASC LIMIT 1");
    if ($first && $first->num_rows > 0) { $f = $first->fetch_assoc(); $footerHsrInitialHref = 'courses-detail/'.$f['id'].'/'.$f['slug']; }
}
$catRefresher = $conn->query("SELECT id FROM category WHERE status='1' AND (title LIKE '%Refresher%' OR title LIKE '%refresher%') ORDER BY title ASC LIMIT 1");
if ($catRefresher && $catRefresher->num_rows > 0) {
    $cid = $catRefresher->fetch_assoc()['id'];
    $first = $conn->query("SELECT id, replace(slug,' ','-') as slug FROM courses WHERE catid='".$cid."' ORDER BY id ASC LIMIT 1");
    if ($first && $first->num_rows > 0) { $f = $first->fetch_assoc(); $footerHsrRefresherHref = 'courses-detail/'.$f['id'].'/'.$f['slug']; }
}
?>
<footer id="footer" class="footer" data-bg-color="#212331">
    <div class="container pt-70 pb-40">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="widget dark">
                    <a class="sm-pull-center" style="margin: 0px 45px 0 0; width:320px;max-width:100%;display: flex; align-items: center; justify-content: start;" href="index.php">
                        <img src="images/logo/white-logo.svg" alt="Interact Safety" style="width:320px;height:50px;max-width:100%;object-fit:contain;">
                    </a>
                    <?php if(!empty($information['address'])) { ?> <p class="mt-15 font-12 mb-0"><?php echo ($information['address']); ?></p><?php } ?>
                    <h5 class="text-white font-weight-600 mt-20 mb-10">Contact us</h5>
                    <ul class="list mt-5">
                      <?php if(!empty($information['phone'])) { ?><li class="m-0 pl-0 pr-10"> <i class="fa fa-phone text-theme-colored2 mr-5"></i> <a class="text-gray" href="tel:<?php echo preg_replace('/\s+/', '', $information['phone']); ?>"><?php echo htmlspecialchars($information['phone']); ?></a> </li><?php } ?>
                      <?php if(!empty($information['email'])) { ?> <li class="m-0 pl-0 pr-10"> <i class="fa fa-envelope-o text-theme-colored2 mr-5"></i><a class="" href="mailto:<?php echo htmlspecialchars($information['email']); ?>"><?php echo htmlspecialchars($information['email']); ?></a> </li><?php } ?>
                    </ul>
                    <ul class="styled-icons icon-sm icon-bordered icon-circled clearfix mt-10">                        
                      <?php if(!empty($information['facebook']) && $information['facebook'] != '#') { ?><li><a href="<?php echo $information['facebook']; ?>" target="_blank"><i class="fa fa-facebook text-theme-colored2"></i></a></li><?php } ?>
                      <?php if(!empty($information['instagram']) && $information['instagram'] != '#') { ?><li><a href="<?php echo $information['instagram']; ?>" target="_blank"><i class="fa fa-instagram text-theme-colored2"></i></a></li><?php } ?>
                      <?php if(!empty($information['youtube']) && $information['youtube'] != '#') { ?><li><a href="<?php echo $information['youtube']; ?>" target="_blank"><i class="fa fa-youtube text-theme-colored2"></i></a></li><?php } ?>
                      <?php if(!empty($information['twitter']) && $information['twitter'] != '#') { ?><li><a href="<?php echo $information['twitter']; ?>" target="_blank"><i class="fa fa-twitter text-theme-colored2"></i></a></li><?php } ?>
                      <?php if(!empty($information['linkden']) && $information['linkden'] != '#') { ?><li><a href="<?php echo $information['linkden']; ?>" target="_blank"><i class="fa fa-linkedin text-theme-colored2"></i></a></li><?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                  <div class="widget dark">
                      <h4 class="widget-title line-bottom-theme-colored-2">Useful Links</h4>
                      <ul class="angle-double-right list-border">
                          <li><a href="index.php">Home</a></li>
                          <li style="letter-spacing: -0.5px;"><a href="<?php echo htmlspecialchars($footerHsrInitialHref); ?>">HSR Initial OHS Training Course (5 Days)</a></li>
                          <li style="letter-spacing: -0.5px;"><a href="<?php echo htmlspecialchars($footerHsrRefresherHref); ?>">HSR Refresher OHS Training Course (1 Day)</a></li>
                          <li><a href="contact.php">Group Bookings &amp; On-Site Training</a></li>
                          <li><a href="contact.php">Contact</a></li>
                      </ul>
                  </div>
              </div>
              <div class="col-sm-6 col-md-3">
                  <div class="widget dark">
                      <h4 class="widget-title line-bottom-theme-colored-2">Policies</h4>
                      <ul class="angle-double-right list-border">
                          <li><a href="terms-conditions.php">Booking Terms and Conditions</a></li>
                          <li><a href="privacy-policy.php">Privacy Policy</a></li>
                          <li><a href="cancellation-policy.php">Cancellation &amp; Rescheduling Policy</a></li>
                          <li><a href="refund-policy.php">Refund Policy</a></li>
                      </ul>
                  </div>
              </div>
              <div class="col-sm-6 col-md-3">
                  <div class="widget dark">
                      <h4 class="widget-title line-bottom-theme-colored-2">Enquiries &amp; Course Bookings</h4>
                      <p class="text-gray mb-10">Email: <a href="mailto:info@interactsafety.com.au" class="text-theme-colored2">info@interactsafety.com.au</a></p>
                      <p class="font-12 text-gray mb-10">To ensure accurate enrolment details and confirmed training records, all bookings and enquiries are managed via email.</p>
                      <p class="font-12 text-gray mb-0"><strong class="text-white">Response Time:</strong> 1–2 Business Days</p>
                  </div>
              </div>
        </div>
    </div>
    <div class="footer-bottom" data-bg-color="#2b2d3b">
        <div class="container pt-20 pb-20">
            <div class="row">
                <div class="col-md-12">
                    <p class="font-12 text-black-777 m-0 sm-text-center">© 2026 Interact Safety Pty Ltd. All Rights Reserved.</p>
                </div>
                <!--<div class="col-md-6 text-right">
                    <div class="widget no-border m-0">
                        <ul class="list-inline sm-text-center mt-5 font-12">
                            <li><a href="#">FAQ</a> </li>
                            <li>|</li>
                            <li><a href="#">Help Desk</a></li>
                            <li>|</li>
                            <li><a href="#">Support</a></li>
                        </ul>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</footer>
<a class="scrollToTop" href="javascript:"><i class="fa fa-angle-up"></i></a>
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
          <form id="reservation_form_popup" name="reservation_form" class="reservation-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
              <div class="alert alert-danger" role="alert" id="LoginErr" style="display:none">  </div>
              <div class="alert alert-success" role="alert" id="Loginmsg" style="display:none">  </div>
            <h3 class="text-center mt-0 mb-30">login to your account!</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Registered Email" id="reservation_username" name="reservation_username" required="" class="form-control" aria-required="true" type="email">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Your Password" id="reservation_password" name="reservation_password" required="" class="form-control" aria-required="true" type="password">
                  <p>Forgot your password? <a style="text-decoration:underline" href="javascript:" data-toggle="modal" data-target="#PasswordModal">Click here</a></p>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 mt-0">
                  <input name="form_botcheck" class="form-control" value="" type="hidden">
                  <button type="submit" id="uploadbtn" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Login Now</button>
                  <p class="pull-right">Don't have account? <a style="text-decoration:underline" href="javascript:" data-toggle="modal" data-target="#AccountModal">Create Account</a></p>
                </div>
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
          <form id="reset_form_popup" name="reset_form" class="rest-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
              <div class="alert alert-danger" role="alert" id="ResetPasswordErr" style="display:none">  </div>
              <div class="alert alert-success" role="alert" id="ResetPasswordmsg" style="display:none">  </div>
            <h3 class="text-center mt-0 mb-30">Reset account password!</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter Registered Email" id="reservation_name" name="reservation_username" required="" class="form-control" aria-required="true" type="email">
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

<div id="AccountModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="bg-theme-colored2 p-15 pt-10 mt-0 mb-0 text-white">Create Account</h3>
      </div>
      <div class="modal-body">
          <section class="">
  <div class="container position-relative p-0" style="max-width: 570px;">
    
    <div class="section-content bg-white">
      <div class="row">
        <div class="col-md-12">
          <!-- Register Form Starts -->
          <form id="account_form_popup" name="account_form" class="reservation-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
              <div class="alert alert-danger" role="alert" id="CreateErr" style="display:none">  </div>
              <div class="alert alert-success" role="alert" id="Createmsg" style="display:none">  </div>
            <h3 class="text-center mt-0 mb-30">Fill your details to create an account!</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-10">
                  <input placeholder="Enter First Name" id="account_fname" name="account_fname" required="" class="form-control" aria-required="true" type="text">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-10">
                  <input placeholder="Enter Last Name" id="account_lname" name="account_lname" required="" class="form-control" aria-required="true" type="text">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-10">
                  <input placeholder="Enter Email Address" id="account_username" name="account_username" required="" class="form-control" aria-required="true" type="email">
                  <p id="createemailerr" style="display:none; color:#e83e8c"></p>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-10">
                  <input placeholder="Enter Password" id="account_password" name="account_password" required="" class="form-control" aria-required="true" type="password">
                  <i onclick="showAccPassword()" id="toggle_password" class="fa fa-eye" style="position: absolute;right: 25px;top: 10px;z-index: 9;cursor: pointer;"></i>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-10">
                  <input placeholder="Confirm Password" id="account_cpassword" name="account_cpassword" required="" class="form-control" aria-required="true" type="password">
                  <i onclick="showAccCPassword()" id="toggle_cpassword" class="fa fa-eye" style="position: absolute;right: 25px;top: 10px;z-index: 9;cursor: pointer;"></i>
                    <span id='account_err_message'></span>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 mt-0">
                  <input name="form_botcheck" class="form-control" value="" type="hidden">
                  <button type="submit" id="uploadbtn1" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Submit</button>
                  <p class="pull-right">Already have account? <a style="text-decoration:underline" href="javascript:" data-toggle="modal" data-target="#LoginModal">Login</a></p>
                </div>
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

<div id="OTPModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verify Your Email</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
          <div class='alert alert-success alert-dismissible' id="resendmsg">
			  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			  We've sent an email with your code to <br><span id="OTPModalemaill"></span>
	      </div>
          <div class="alert alert-danger alert-dismissible" role="alert" id="OTPErr" style="display:none">  </div>
          <div class="alert alert-success alert-dismissible" role="alert" id="OTPmsg" style="display:none">  </div>
        <form name="otp_form" id="otp_form" class="otp-form mb-0 bg-silver-deep p-30" method="post" action="javascript:" autocomplete="off">
            <h3 class="text-center mt-0 mb-30">Enter the code</h3>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group mb-30">
                  <input placeholder="Enter OTP" id="reservation_otp" name="reservation_otp" required="" class="form-control" aria-required="true" type="text">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group mb-0 mt-0">
                  <button type="submit" id="submitbtn" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Continue</button>
                </div>
                <p>Didn't receive an email? <a style="text-decoration:underline" href="javascript:" onclick="resendcode()">Resend</a>
                <input type="hidden" id="Resendemail" name="Resendemail"></p>
                <div id="myloaderotp" style="display:none;width:100%;height:100px;"></div>
              </div>
            </div>
          </form>
      </div>
    </div>

  </div>
</div>

<div id="VerSucModal" class="modal fade" role="dialog" style='z-index:1045'>
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
          <div class='alert alert-success' style='background-color:transparent !important;border:1px solid transparent !important;'>
			  <center><i style="border: 2px solid;padding: 20px;border-radius: 38px;font-size: 35px;" class="fa fa-check"></i>
			  <br>
			  <h3>Email Verified</h3>
			  <p>Your email address was successfully verified. </p>
			  </center>
	      </div>
            <div class="form-group mb-0 mt-0">
              <a href="javascript:" data-toggle="modal" data-target="#LoginModal" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat">Login </a>
            </div>
      </div>
    </div>

  </div>
</div>