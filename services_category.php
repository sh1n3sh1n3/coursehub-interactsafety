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

    <title>Services | Company Name</title>
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

           
            
            <section>
                <div class="container pt-70 pb-40">
                    <div class="section-content">
                        <div class="row multi-row-clearfix">
                            	<?php $count=0;
					$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM services_category WHERE status='1' order by title ASC");
					while($fetchcourses = $courses->fetch_assoc()) {$count++; $id = $fetchcourses['id'];  ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="event-list bg-silver-light maxwidth500 mb-30">
                                    <a href="services/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                                    <div class="thumb">
                                        <img style="height:180px" src="assets/images/services/<?php echo $fetchcourses['image']; ?>" alt class="img-fullwidth">
                                      
                                    </div>
                                    <div class="event-list-details border-1px bg-white clearfix p-15 pt-15 pb-30 text-center" style="height:100px;overflow:hidden">
                                        <h5 class="text-uppercase font-weight-600 font-16 mb-5"><?php echo $fetchcourses['title']; ?></h5>
                                    </div></a>
                                </div>
                            </div>
                         	<?php } ?>
                         
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