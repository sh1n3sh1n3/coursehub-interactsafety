<?php session_start(); include('include/conn.php'); 
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
    <meta name="description" content="Learnpro - Education University School Kindergarten Learning HTML Template" />
    <meta name="keywords" content="education,school,university,educational,learn,learning,teaching,workshop" />
    <meta name="author" content="ThemeMascot" />
    <?php if (strpos($_SERVER['HTTP_HOST'], 'localhost') === false && strpos($_SERVER['HTTP_HOST'], '127.0.0.1') === false) { ?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php } ?>
    <title>Interact Safety</title>
    <?php include("include/head_script.php"); ?>
    <style>
    #home .row.multi-row-clearfix { display: flex; flex-wrap: wrap; }
    #home .row.multi-row-clearfix > [class*="col-"] { display: flex; }
    #home .event-list { flex: 1; display: flex; flex-direction: column; min-height: 100%; }
    #home .event-list a { flex: 1; display: flex; flex-direction: column; }
    #home .event-list-details { flex: 0 0 auto; min-height: 80px; height: 80px; display: flex; align-items: center; justify-content: center; padding: 15px; }
    #home .event-list-details h5 { margin: 0; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    #home .event-list .thumb { flex: 0 0 200px; height: 200px; overflow: hidden; display: block; }
    #home .event-list .thumb img { object-fit: cover; width: 100%; height: 100%; display: block; transform: scale(1.3); transition: transform 0.4s ease; }
    #home .event-list:hover .thumb img { transform: scale(1.5); }
    </style>
</head>
<body>
<div id="wrapper" class="clearfix">
        <?php
        include("include/head.php");
        ?>
       

        <div class="main-content">
            <section id="about" class="pb-70">
                <div class="container">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-7">
                                <?php $aboutus = $conn->query("SELECT * FROM aboutus WHERE id='1'")->fetch_assoc(); ?>
                                <h2 class="text-uppercase text-theme-colored mt-0 mt-sm-30">About the business and myself</h2>
                                <div class="double-line-bottom-theme-colored-2"></div>
                                <?php $string = $aboutus['description'];
                                    if (strlen($string) > 2500) {
                                        $stringCut = substr($string, 0, 2500);
                                        $endPoint = strrpos($stringCut, ' ');
                                        $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                        $string .= '... <br><a href="about.php" class="btn btn-colored btn-theme-colored2 text-white btn-lg pl-40 pr-40 mt-15">Read More</a>';
                                    }
                                    echo $string;
                                ?>
                            </div>
                            <div class="col-md-5">
                                <img class="img-fullwidth maxwidth500" src="assets/images/about/<?php echo $aboutus['image']; ?>" alt="About the business">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="home" class="bg-gray-lighter pt-40 pb-40">
                <div class="container pt-40 pb-40 bg-white">
                    <div class="section-content">
                        <div class="row multi-row-clearfix">
                            	<?php $count=0;
					$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM category WHERE status='1' order by title ASC");
					while($fetchcourses = $courses->fetch_assoc()) {$count++; $id = $fetchcourses['id'];  ?>
                            <div class="col-sm-6 col-md-4">
                                <div class="event-list bg-silver-light maxwidth500">
                                    <a href="courses/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                                    <div class="event-list-details border-1px bg-white clearfix text-center" style="overflow:hidden">
                                        <h5 class="text-uppercase font-weight-600 font-16"><?php echo $fetchcourses['title']; ?></h5>
                                    </div>
                                    <div class="thumb">
                                        <img src="assets/images/category/<?php echo $fetchcourses['image']; ?>" alt class="img-fullwidth">
                                    </div></a>
                                </div>
                            </div>
                         	<?php } ?>
                         
                        </div>
                    </div>
                </div>
            </section>
            <section class="bg-silver-deep">
                <div class="container pt-70 pb-30">
                    <div class="section-title">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-uppercase title">Here is what  <span class="text-theme-colored2">our clients </span>say about us </h2>
                                <!--<p class="text-uppercase mb-0">Student and Parents Opinion</p>-->
                                <div class="double-line-bottom-theme-colored-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-30">
                            <div class="owl-carousel-2col boxed" data-dots="true">
                                <?php $count=0;
            					$testimonials = $conn->query("SELECT * FROM testimonials WHERE status = '1' order by id ASC");
            					while($fetchtestimonials = $testimonials->fetch_assoc()) {$count++; ?>
                                <div class="item">
                                    <div class="testimonial pt-10">
                                        <div class="thumb pull-left mb-0 mr-0">
                                            <img style="width:100px;height:100px" class="img-thumbnail img-circle" alt src="assets/images/testimonials/<?php echo $fetchtestimonials['image']; ?>" width="110">
                                        </div>
                                        <div class="testimonial-content">
                                            <h4 class="mt-0 font-weight-300"><?php echo $fetchtestimonials['content']; ?></h4>
                                            <h5 class="mt-10 font-16 mb-0"><?php echo $fetchtestimonials['name']; ?></h5>
                                            <h6 class="mt-5"><?php echo $fetchtestimonials['designation']; ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="clients bg-theme-colored2">
                <div class="container pt-10 pb-10">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="owl-carousel-6col clients-logo transparent text-center">
                                <?php
                					$clients = $conn->query("SELECT * FROM clients WHERE status='1' order by title ASC");
                					while($fetchclients = $clients->fetch_assoc()) { ?>
                                <div class="item"> <a href="assets/images/clients/<?php echo $fetchclients['image']; ?>" target="_blank"><img src="assets/images/clients/<?php echo $fetchclients['image']; ?>" alt></a></div>
                                <?php } ?>
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