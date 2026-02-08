<?php session_start();
include('include/conn.php');
$policy = $conn->query("SELECT * FROM policy WHERE id='1'")->fetch_assoc();
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

    <title>Privacy Policy | Company Name</title>
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
                                <h2 class="text-theme-colored2 font-36">Privacy Policy</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    	<li><a href="privacy-policy.php" class="active">Privacy Policy</a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="single-service">                             
                              	<?php echo $policy['content']; ?>
                               
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