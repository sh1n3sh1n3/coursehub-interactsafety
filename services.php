<?php session_start(); include('include/conn.php'); 


$cate_details = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM services_category")->fetch_assoc();
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
    <meta name="description" content="<?php echo $cate_details['title']; ?>" />
    <meta name="keywords" content="<?php echo $cate_details['title']; ?>" />
    <meta name="author" content="<?php echo $cate_details['title']; ?>" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title><?php echo $cate_details['title']; ?> | Interact Safety</title>
    <?php
    include("include/head_script.php");
    ?>
</head>
<body class>
<div id="wrapper" class="clearfix">
        <?php
        include("include/head.php");
        ?>
       

        <div class="main-content">

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20">

                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2 class="text-theme-colored2 font-36"><?php echo $cate_details['title']; ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="services_category.php">Services</a></li>
                                    <li class="active"><?php echo $cate_details['title']; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section>
                <div class="container pt-70 pb-40">
                    <div class="section-content">
                    <div class="panel panel-warning">

<div class="panel-body"> 

    <div class="row multi-row-clearfix">
        
        	<?php $count=0;
        	$catid=$_GET['id'];
        	
					$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM services WHERE status='1' and catid='".$catid."'  order by title ASC");
					if($courses->num_rows > 0) {
					while($fetchcourses = $courses->fetch_assoc()) {$count++; $id = $fetchcourses['id'];  ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="event-list bg-silver-light maxwidth500 mb-30">
                                    <a href="service-details/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>"><div class="thumb">
                                        <img style="height:180px" src="assets/images/services/<?php echo $fetchcourses['image']; ?>" alt class="img-fullwidth">
                                      
                                    </div>
                                    <div class="event-list-details border-1px bg-white clearfix p-15 pt-15 pb-30">
                                        <div style="height:50px;overflow:hidden">
                                        <h5 class="text-uppercase font-weight-600 font-14 mb-5"><a href="service-details/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>"><?php echo $fetchcourses['title']; ?></a></h5>
                                        </div>
                                     
                                         </div>
                                         </a>
                                </div>
                            </div>
                            
                            <?php } } else { ?>
                            	<div class="col-sm-12 col-md-12"><h3><center>No record found!!</center></h3></div>
                            	<?php } ?>
                            
                            
                            
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