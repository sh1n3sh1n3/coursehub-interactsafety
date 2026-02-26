<?php session_start(); include('include/conn.php'); 
$locid=$_GET['id'];

$location_details = $conn->query("SELECT * FROM locations WHERE id='".$locid."'")->fetch_assoc();

//require_once('phpmailer/class.phpmailer.php');
  //  $emailaccount = $conn->query("SELECT * FROM emails WHERE type='support'")->fetch_assoc();
    //$refitcertifiedph = $emailaccount['phone'];
    //$refitcertifiedem = $emailaccount['email1'];
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo $location_details['title']; ?>" />
    <meta name="keywords" content="<?php echo $location_details['title']; ?>" />
    <meta name="author" content="<?php echo $location_details['title']; ?>" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title><?php echo $location_details['title']; ?> | Interact Safety</title>
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
                                <h2 class="text-theme-colored2 font-36"><?php echo $location_details['title']; ?>: Location</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>                                    
                                     <li><a href="locations.php">Locations</a></li>
                                    <li class="active"><?php echo $location_details['title']; ?></li>
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
                        <h4 class="mt-0 mb-30 line-bottom-theme-colored-2">Location: <?php echo $location_details['title']; ?></h4>
                        </div>
                    </div>
                    <div class="row pt-10">
                         <div class="col-md-5">
                             <div class="row">
                                 
                                 <div class="col-sm-12 col-md-12">
                            <div class="contact-info text-center bg-silver-light border-1px pt-20 mb-10">
                                <i class="fa fa-map-marker font-36 mb-10 text-theme-colored2"></i>
                                <h4>Address</h4>
                                <h6 class="text-gray"><?php echo $location_details['address']; ?></h6>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="contact-info text-center bg-silver-light border-1px pt-20  pb-20 mb-10">
                                <i class="fa fa-phone font-36 mb-10 text-theme-colored2"></i>
                                <h4>Call Us</h4>
                                <h6 class="text-gray">Phone: <?php echo $location_details['phone']; ?></h6>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 col-md-12">
                            <div class="contact-info text-center bg-silver-light border-1px  pt-20  pb-20 mb-10">
                                <i class="fa fa-envelope font-36 mb-10 text-theme-colored2"></i>
                                <h4>Email</h4>
                                <h6 class="text-gray"><a href="emailto:<?php echo $location_details['email']; ?>" class="__cf_email__" ><?php echo $location_details['email']; ?></a></h6>
                            </div>
                        </div>
                        
                    </div>
                        </div>
                        <div class="col-md-7">
                            
                            
                            <iframe  src="<?php echo $location_details['map']; ?>" height="500" width="100%" style="border:0;" allowfullscreen loading="lazy" ></iframe>
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
document.addEventListener("DOMContentLoaded", function () {
    document.body.style.overflow = 'auto';
    document.documentElement.style.overflow = 'auto';
});
$(window).off('wheel mousewheel DOMMouseScroll');
$(document).off('wheel mousewheel DOMMouseScroll');

</script>
</body>
</html>