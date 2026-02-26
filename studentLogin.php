<?php session_start(); 
include('include/conn.php'); 
include('include/enc_dec.php');?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="Learnpro - Education University School Kindergarten Learning HTML Template" />
    <meta name="keywords" content="education,school,university,educational,learn,learning,teaching,workshop" />
    <meta name="author" content="ThemeMascot" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Interact Safety</title>
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
        <?php
        include("include/head.php");
        ?>
     <div class="main-content">

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20" id="book">

                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36">Student Login</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active">Student Login</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="single-service">    
                            <h2 class="text-uppercasetext-theme-colored mt-0 mt-sm-30">LOGIN TO YOUR ACCOUNT</h2>
                            <div class="double-line-bottom-theme-colored-2"></div>
                                <div class="section-content bg-white">
                                  <div class="row">
                                    <div class="col-md-12">
                                      <!-- Register Form Starts -->
                                      <form id="reservation_form_login" name="reservation_form" class="reservation-form mb-0" method="post" action="javascript:">
                                          <div class="alert alert-danger" role="alert" id="LoginErr" style="display:none">  </div>
                                          <div class="alert alert-success" role="alert" id="Loginmsg" style="display:none">  </div>
                                          <input type="hidden" name="courseid" value="<?php echo decryptStringArray($_GET['courseid']); ?>"/>
                                          <input type="hidden" name="locid" value="<?php echo decryptStringArray($_GET['locid']); ?>"/>
                                          <input type="hidden" name="slotid" value="<?php echo decryptStringArray($_GET['slotid']); ?>"/>
                                          <input type="hidden" name="teacherid" value="<?php echo decryptStringArray($_GET['teacherid']); ?>"/>
                                        <div class="row">
                                          <div class="col-sm-12">
                                            <div class="form-group mb-30">
                                              <input placeholder="Enter Registered Email" id="reservation_username_atta" name="reservation_username" required="" class="form-control" aria-required="true" type="email">
                                            </div>
                                          </div>
                                          <div class="col-sm-12">
                                            <div class="form-group mb-30">
                                              <input placeholder="Enter Your Password" id="reservation_password_atta" name="reservation_password" required="" class="form-control" aria-required="true" type="password">
                                            </div>
                                          </div>
                                          <div class="col-sm-12">
                                            <div class="form-group mb-0 mt-0">
                                              <input name="form_botcheck" class="form-control" value="" type="hidden">
                                              <button type="submit" id="uploadbtn_atta" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Login Now</button>
                                            </div>
                                          </div>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="attandanceModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-body" id="AttandanceBody">
                        
                      </div>
                    </div>
                  </div>
                </div>
            </section>
        </div>

        <?php
        include("include/footer.php");
        ?>
    </div>
    <?php
    include("include/footer_script.php");
    ?>
    <script>
        $("#reservation_form_login").on('submit',(function(e) {
          e.preventDefault();
          $.ajax({
               url: "loginStu.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
               success: function(data) { console.log(data);
                   if(data == '1') {
                       $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html("Wrong password entered!! Please try again!!");
                   } else if(data == '2') {
                       $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html("Account not active!!");
                   } else if(data == '3') {
                       $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html("Please check your credentials. No record found!!");
                   } else if(data == '4') {
                       $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html("Something wrong!! It seems like you are not authorized for this course. Please contact administration!!");
                   } else if(data == '5') {
                       $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html("Attadnace already submitted!!");
                   } else if(data == '6') {
                       $("#Loginmsg").css('display', 'none');
                       $("#LoginErr").css('display', 'block');
                       $("#LoginErr").html('').html("Something wrong. It seems like you don't have class today!!");
                   } else {
                       $("#LoginErr").css('display', 'none');
                       $("#Loginmsg").css('display', 'block');
                       $("#Loginmsg").html('').html('Login Success.');
                       //$("#AttandanceBody").html('').html(data);
                       //$('#attandanceModal').modal('toggle');
                      window.location.href=data;
                   }
                 
              },       
            });
         }));
    </script>
</body>
</html>