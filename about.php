<?php session_start(); include('include/conn.php'); 
$aboutus = $conn->query("SELECT * FROM aboutus WHERE id='1'")->fetch_assoc(); ?>

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
                                <h2 class="text-theme-colored2 font-36">About Us</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    
                                    <li class="active">About Us</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="single-service">    
                            <h2 class="text-uppercasetext-theme-colored mt-0 mt-sm-30">COMPANY SAFETY AND TRAINING </h2>
                            <div class="double-line-bottom-theme-colored-2"></div>
                               <?php echo $aboutus['description']; ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                           
                                <div class="widget border-1px bg-silver-deep p-15">
                                   
                                    <div class="categories">
                                        <ul class="list-border">	                                       
	                                        <li class="mb-1"><a  href="#"> About </a></li>	
	                                        <li class="mb-1"><a  href="#"> Clients </a></li>	
	                                        <li class="mb-1"><a  href="#"> Testimonials </a></li>	
	                                        <li class="mb-1"><a  href="#"> Careers </a></li>	
	                                       
                                        </ul>
                                    </div>
                                </div>
                                    <img src="assets/images/about/<?php echo $aboutus['image']; ?>">
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
</body>
</html>