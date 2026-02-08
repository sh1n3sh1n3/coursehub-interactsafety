<?php session_start(); include('include/conn.php'); 
$catid=$_GET['id'];

$cat_details = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM services_category WHERE id='".$catid."'")->fetch_assoc();



$service_details = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM services WHERE catid='".$cat_details['id']."'")->fetch_assoc();

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

    <title><?php echo $service_details['title']; ?> | Company Name</title>
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
                <div class="container pt-20 pb-20" >

                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36"><?php echo $service_details['title']; ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="services/<?php echo $cat_details['id']; ?>/<?php echo $cat_details['slug']; ?>"><?php echo $cat_details['title']; ?></a></li>
                                    <li class="active"><?php echo $service_details['title']; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-9 pull-right flip sm-pull-none">
                            <div class="blog-posts single-post">
                                <article class="post clearfix mb-0">
                                    <div class="entry-header">
                                        <div class="post-thumb thumb"> <img src="assets/images/services/<?php echo $service_details['image']; ?>" alt="<?php echo $service_details['title']; ?>" class="img-responsive img-fullwidth"> </div>
                                    </div>
                                    <div class="entry-content">
                                        <div class="entry-meta media no-bg no-border mt-15 pb-20">
                                            <!--<div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">-->
                                            <!--    <ul>-->
                                            <!--        <li class="font-16 text-white font-weight-600"><?php echo date('d', strtotime($blog['postdate'])); ?></li>-->
                                            <!--        <li class="font-12 text-white text-uppercase"><?php echo date('Y', strtotime($blog['postdate'])); ?></li>-->
                                            <!--    </ul>-->
                                            <!--</div>-->
                                            <div class="media-body pl-15">
                                                <div class="event-content pull-left flip">
                                                    <h3 class="entry-title text-white text-uppercase pt-0 mt-0"><a href="blog-single-right-sidebar.html"><?php echo $service_details['title']; ?></a></h3>
                                              
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </article>
                              <?php echo $service_details['description']; ?>
                              
                            </div>
                        </div>
                         <div class="col-sm-12 col-md-3">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                           
                                <div class="widget border-1px bg-silver-deep p-15">
                                   <h4 class="widget-title line-bottom-theme-colored-2">Services</h4>
                                    <div class="categories">
                                        <ul class="list-border">
                                            	    	<?php $count1=0;
		
					
        	
					$courses = $conn->query("SELECT *,replace(replace(replace(replace(slug, '''', ''), ' ','-'),'’',''),'–','') as slug FROM services WHERE status='1'  order by title ASC limit 10");
					while($fetchblogs1 = $courses->fetch_assoc()) {$count1++; $id = $fetchblogs1['id'];  ?>
					
	                                        <li class="mb-1"><a  href="blog-details/<?php echo $fetchblogs1['id']; ?>/<?php echo $fetchblogs1['slug']; ?>"> <?php echo $fetchblogs1['title']; ?> </a></li>	
	                                      
	                                       	<?php } ?>
                                        </ul>
                                    </div>
                                </div>
                    
                            </div>
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
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                           
                                <div class="widget border-1px bg-silver-deep p-15">
                                  <img src="images/People.jpg" alt>
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