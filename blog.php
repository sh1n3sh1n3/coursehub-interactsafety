<?php session_start();
 include('include/conn.php');  ?>
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
                                <h2 class="text-theme-colored2 font-36">Blog</h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="#">Home</a></li>
                                    <li class="active">Blog</li>
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
                              	<?php $count=0;
					$blogs = $conn->query("SELECT *, replace(replace(replace(replace(slug, '''', ''), ' ','-'),'’',''),'–','') as slug FROM blogs WHERE status='1' order by id DESC");
					while($fetchblogs = $blogs->fetch_assoc()) {$count++; ?>
                                <div class="col-sm-6 col-md-6">
                                <article class="post clearfix mb-30">
                                    <div class="entry-header">
                                        <div class="post-thumb thumb">
                                            <a href="blog-details/<?php echo $fetchblogs['id']; ?>/<?php echo $fetchblogs['slug']; ?>"><img src="assets/images/blog/<?php echo $fetchblogs['image']; ?>" alt class="img-responsive img-fullwidth"></a>
                                        </div>
                                        <div class="entry-date media-left text-center flip bg-theme-colored border-top-theme-colored2-3px pt-5 pr-15 pb-5 pl-15">
                                            <ul>
                                                <li class="font-16 text-white font-weight-600"><?php echo date('d', strtotime($fetchblogs['postdate'])); ?></li>
                                                <li class="font-12 text-white text-uppercase"><?php echo date('Y', strtotime($fetchblogs['postdate'])); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="entry-content p-15">
                                        <div class="entry-meta media no-bg no-border mt-0 mb-10">
                                            <div class="media-body pl-0">
                                                <div class="event-content pull-left flip">
                                                    <div style="height:60px;overflow:hidden"><h4 class="entry-title text-white text-uppercase font-weight-600 m-0 mt-5"><a href="blog-details/<?php echo $fetchblogs['id']; ?>/<?php echo $fetchblogs['slug']; ?>"><?php echo $fetchblogs['title']; ?></a></h4>
                                                    </div>
                                                    <ul class="list-inline">
                                                        <li><i class="fa fa-user-o mr-5 text-theme-colored2"></i>By <?php echo $fetchblogs['postedby']; ?></li>
                                             
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5" style="height:80px;overflow:hidden">
                                            	<?php $blogcontent = strip_tags($fetchblogs['content']);
											$blogid = $fetchblogs['id'];
										if (strlen($blogcontent) > 200) {
											$stringCut = substr($blogcontent, 0, 200);
											$endPoint = strrpos($stringCut, ' ');
											$blogcontent = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
											$blogcontent .= '...';
										}
										echo $blogcontent;?>
                                        </div>
                                        <a class="btn btn-default btn-flat font-12 mt-10 ml-5" href="blog-details/<?php echo $fetchblogs['id']; ?>/<?php echo $fetchblogs['slug']; ?>"> View Details</a>
                                    </div>
                                </article>
                            </div>
                           		<?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                           
                                <div class="widget border-1px bg-silver-deep p-15">
                                   <h4 class="widget-title line-bottom-theme-colored-2">Latest Blog</h4>
                                    <div class="categories">
                                        <ul class="list-border">
                                            	    	<?php $count1=0;
					$blogs1 = $conn->query("SELECT *, replace(replace(replace(replace(slug, '''', ''), ' ','-'),'’',''),'–','') as slug FROM blogs WHERE status='1' order by postdate DESC limit 10");
					while($fetchblogs1 = $blogs1->fetch_assoc()) {$count1++; ?>                                   
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