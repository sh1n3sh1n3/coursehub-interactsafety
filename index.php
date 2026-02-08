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
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Company Name</title>
    <?php
    include("include/head_script.php");
    ?>
</head>
<body>
<div id="wrapper" class="clearfix">
        <?php
        include("include/head.php");
        ?>
       

        <div class="main-content">
            <section id="home" class="bg-gray-lighter pb-140 mb-20">
                <div class="container pt-0 mt-10 bg-white pb-40">
                    <div class="section-content">
                        <div class="row multi-row-clearfix">
                            	<?php $count=0;
					$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM category WHERE status='1' order by title ASC");
					while($fetchcourses = $courses->fetch_assoc()) {$count++; $id = $fetchcourses['id'];  ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="event-list bg-silver-light maxwidth500 mb-20">
                                    <a href="courses/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                                    <div class="event-list-details border-1px bg-white clearfix text-center" style="overflow:hidden">
                                        <h5 class="text-uppercase font-weight-600 font-16 mb-5"><?php echo $fetchcourses['title']; ?></h5>
                                    </div>
                                    <div class="thumb">
                                        <img style="height:180px" src="assets/images/category/<?php echo $fetchcourses['image']; ?>" alt class="img-fullwidth">
                                    </div></a>
                                </div>
                            </div>
                         	<?php } ?>
                         
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container pt-0 pb-0">
                    <?php $webcounts = $conn->query("SELECT * FROM counts WHERE id='1'")->fetch_assoc(); ?>
                   <div class="section-content">
                      <div class="row equal-height-inner home-boxes" data-margin-top="-100px" style="margin-top: -100px;">
                         <div class="col-sm-12 col-md-3 pl-0 pl-sm-15 pr-1 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay3" style="min-height: 19.5em; visibility: visible;">
                            <div class="img-rounded sm-height-auto" data-bg-color="#D8701A" style="background: #D8701A !important; min-height: 273px;">
                               <div class="features-box-colored text-center p-15 pt-30 pb-20">
                                   <br>
                                  <h2 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-white"><?php echo number_format($webcounts['students']); ?></a></h2>
                                  <h4 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-dark">Qualified Students</a></h4>
                                  <br>
                               </div>
                            </div>
                         </div>
                         <div class="col-sm-12 col-md-3 pl-0 pl-sm-15 pr-1 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay3" style="min-height: 19.5em; visibility: visible;">
                            <div class="img-rounded sm-height-auto" data-bg-color="#D8701A" style="background: #D8701A !important; min-height: 273px;">
                               <div class="features-box-colored text-center p-15 pt-30 pb-20">
                                  <br><h2 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-white"><?php echo number_format($webcounts['laststudents']); ?></a></h2>
                                  <h4 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-dark">Students Last Year</a></h4><br>
                               </div>
                            </div>
                         </div>
                         <div class="col-sm-12 col-md-3 pl-0 pl-sm-15 pr-1 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay3" style="min-height: 19.5em; visibility: visible;">
                            <div class="img-rounded sm-height-auto" data-bg-color="#D8701A" style="background: #D8701A !important; min-height: 273px;">
                               <div class="features-box-colored text-center p-15 pt-30 pb-20">
                                   <br><h2 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-white"><?php echo $webcounts['rating']; ?></a></h2>
                                  <h4 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-dark">Student Satisfaction</a></h4><br>
                               </div>
                            </div>
                         </div>
                         <div class="col-sm-12 col-md-3 pl-0 pl-sm-15 pr-0 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay3" style="min-height: 19.5em; visibility: visible;">
                            <div class="img-rounded sm-height-auto" data-bg-color="#D8701A" style="background: #D8701A !important; min-height: 273px;">
                               <div class="features-box-colored text-center p-15 pt-30 pb-20">
                                   <br><h2 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-white"><?php echo number_format($webcounts['courses']); ?></a></h2>
                                  <h4 class="text-uppercase font-weight-600 mt-0"><a href="javascript:" class="text-dark">e-Learning Courses</a></h4><br>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
            </section>
            <section>
                <div class="container pb-70">
                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <?php $aboutus = $conn->query("SELECT * FROM aboutus WHERE id='1'")->fetch_assoc(); ?>
                                <h2 class="text-uppercasetext-theme-colored mt-0 mt-sm-30">COMPANY SAFETY AND TRAINING </h2>
                                <div class="double-line-bottom-theme-colored-2"></div>
                                <?php $string = $aboutus['description'];//strip_tags($aboutus['description']);
                                    if (strlen($string) > 2500) {
                                        $stringCut = substr($string, 0, 2500);
                                        $endPoint = strrpos($stringCut, ' ');
                                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                        $string .= '... <br><a href="about.php" class="btn btn-colored btn-theme-colored2 text-white btn-lg pl-40 pr-40 mt-15">Read More</a>';
                                    }
                                    echo $string;
                                ?>
                                
                            </div>
                            <div class="col-md-6">
                                <img class="img-fullwidth maxwidth500" src="assets/images/about/<?php echo $aboutus['image']; ?>" alt>
                            </div>
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