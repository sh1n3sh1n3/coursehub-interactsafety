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
                                <h2 class="text-theme-colored2 font-36">Interact Safety: Clients</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="#">Home</a></li>
                                    <li><a href="courses.php">About Us</a></li>
                                    <li class="active">Our Clients</li>
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
                              <h2>Our Clients</h2>
                                <p class="g-font-size-18">When safety matters, these companies look to the best. You can too.</p>
                                <p>We are proud of the work we do for our clients and take a can-do attitude into all projects. Meeting your objectives, adding value and building lasting, trusted relationships are our goals.</p>
                                <p>We have a wide range of clients across many industries, from small businesses to major national and international corporations.</p>
                        
                				<div class="g-overflow-hidden">
                                  <div class="row text-center mx-0 g-ml-minus-1 g-mb-minus-1">
                                      <?php $count=0;
                    					$blogs = $conn->query("SELECT * FROM clients WHERE status='1' order by id ASC");
                    					while($fetchblogs = $blogs->fetch_assoc()) {$count++; ?>
                                            <div class="col-6 col-sm-4 col-md-3 px-0">
                                              <div class="g-brd-left g-brd-bottom g-brd-gray-light-v4 g-py-40">
                                                <img class="img-fluid g-width-120" src="assets/images/clients/<?php echo $fetchblogs['image']; ?>" alt="NuFarm Limited">
                                              </div>
                                            </div>
                           		        <?php } ?>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                           
                                <div class="widget border-1px bg-silver-deep p-15">
                                   <h4 class="widget-title line-bottom-theme-colored-2">Featured Courses</h4>
                                    <div class="categories">
                                        <ul class="list-border">
                        	    		<?php $count=0;
                        					$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE status='1' and featuredcourse='1'  order by title ASC");
                        					while($fetchcourses = $courses->fetch_assoc()) {$count++; $id = $fetchcourses['id'];  ?>                                 
	                                        <li class="mb-1"><a  href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>"> <?php echo $fetchcourses['title']; ?> </a></li>	
	                                       	<?php } ?>
                                        </ul>
                                    </div>
                                </div>
                    
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