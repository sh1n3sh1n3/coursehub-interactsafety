<?php session_start(); include('include/conn.php'); 
$courseid=$_GET['id'];

$courses_details = $conn->query("SELECT * FROM courses WHERE id='".$courseid."'")->fetch_assoc();
$cate = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM category WHERE id=".$courses_details['catid'])->fetch_assoc();
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
    <meta name="description" content="<?php echo $courses_details['title']; ?>" />
    <meta name="keywords" content="<?php echo $courses_details['title']; ?>" />
    <meta name="author" content="<?php echo $courses_details['title']; ?>" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title><?php echo $courses_details['title']; ?> | Interact Safety</title>
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
                                <h2 class="text-theme-colored2 font-36"><?php echo $courses_details['title']; ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="courses/<?php echo $cate['id']; ?>/<?php echo $cate['slug']; ?>"><?php echo $cate['title']; ?></a></li>
                                    <li class="active"><?php echo $courses_details['title']; ?></li>
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
                              
                              
                                <h3 class="text-uppercase mt-30 mb-10"><?php echo $courses_details['title']; ?></h3>
                                <div class="double-line-bottom-theme-colored-2 mt-10"></div>
                                <p><?php echo $courses_details['aliascoursename']; ?></p>
                                <h5><?php echo $courses_details['short']; ?></h5>
                                <div><?php echo $courses_details['shortdescription']; ?></div>
                                <div id="book">&nbsp;</div>
                                <br>
                                <div  class="tab-content">
                                    <div class="tab-pane fade in active" id="tab1">
                                    <div id="course-dates"></div>
                                        <h2 class="line-bottom-theme-colored-2 mb-15"><strong>Course Dates</strong></h2>
                                        

                                <table id="datatable" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Start Date</th>
                                                <th>Places Left</th>
                                                <th></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count=0;
                                	        $courseid=$_GET['id'];
                        					$courses = $conn->query("SELECT * FROM course_slots WHERE type='public' AND isPublished='1' AND courseid='".$courseid."'");
                        				    if($courses->num_rows > 0) {
                        				    while($fetchcourses = $courses->fetch_assoc()) {
                        				        $count++; $id = $fetchcourses['id'];
                            					$cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcourses['cityid'])->fetch_assoc();
                                                $locs = $conn->query("SELECT * FROM locations WHERE id=".$fetchcourses['locid'])->fetch_assoc();
                                                $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$id."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
                                					$coursedate = date('Y-m-d', strtotime($fetchdates['date']));
                                					$coursedatetime = date('Y-m-d H:i:s', strtotime($fetchdates['date']).' '.strtotime($fetchdates['starttime']));
                                					$maxcapacity = $fetchcourses['maxcapacity'];
                                					$curdatetime = date('Y-m-d H:i:s');
                                					$curdate = date('Y-m-d');
                                					if($coursedatetime <= $curdatetime) {
                                					    $lefttext = 'Running Today';
                                					    $buttonttl = '';
                                					} else {
                                    					$remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid='".$courseid."' AND slotid='".$fetchcourses['id']."'")->fetch_assoc();
                                    					$leftplace = $maxcapacity - $remain_places['count'];
                                    					if($leftplace >= 10) {
                                    					    $lefttext = 'Places Available (1-10)';
                                    					    $buttonttl = '<a href="javascript:" class="btn btn-primary btn-sm" role="button">Book Now</a>';
                                    					} else if($leftplace > 0 && $leftplace <= 10) {
                                    					    $lefttext = 'Limited Places (11- '.$maxcapacity.')';
                                    					    $buttonttl = '<a href="javascript:" class="btn btn-primary btn-sm" role="button">Book Now</a>';
                                    					} else {
                                    					    $lefttext = 'Sold Out';
                                    					    $buttonttl = '<a href="javascript:" class="btn btn-warning btn-sm" role="button">Add Me To Waitlist</a>';
                                    					}
                                					}
                                					if($coursedate >= $curdate) {
                        					?>
                                            <tr>
                                                <td> <?php echo $cities['name'].' - '.$locs['location'].' ('.$locs['title'].')'; ?></td>
                                                <td><?php echo date('M d, Y', strtotime($fetchdates['date'])); ?> (<?php echo date('H:i:s', strtotime($fetchdates['starttime'])); ?> - <?php echo date('H:i:s', strtotime($fetchdates['endtime'])); ?>)</td>
                                                <td><?php echo $lefttext; ?></td>
                                                <td><?php echo $buttonttl; ?></td>
                                            </tr>
                                            <?php }}} else {
                                            echo '<tr><td>No record found!!</td><td></td><td></td><td></td></tr>';
                                            } ?>
                                         
                                            </tbody>
                                            </table>
                                            <form id="importform" name="importform" class="rest-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
                                                <input type="hidden" name="courseid" id="courseid" value="<?php echo $courseid; ?>"/>
                                                <div class="form-group  row"><label class="col-sm-3 col-form-label">Private Course Code</label>
                                                    <div class="col-sm-6"><input type="text" required minlength="8" maxlength="8" class="form-control" name="course_code" id="course_code"></div>
                                                    <div class="col-sm-3"><button type="submit" id="submitbook" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait..." style="pointer-events: none">Book Now</button></div>
                                                </div>
                                            </form>
                                            <p id="bookerr" style="display:none; color:red; font-weight:bold;"></p>
                                            <div id="myloaderabc"></div>
                                        <div id="course-details" class="fluid g-pt-30 g-pb-25">
				
					
					    <h2 class="line-bottom-theme-colored-2 mb-15" id="course-details"><strong>Course Details</strong></h2>
	<?php echo $courses_details['description']; ?>
							
						
				</div>
                                    </div>
                                 
                                    
                                </div>
                                <div><a class="btn btn-xl btn-theme-colored2 mt-30 pr-40 pl-40" href="courses-detail/<?php echo $courses_details['id']; ?>/<?php echo $_GET['title']; ?>#book">Scroll Up To Book</a></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                                <div class="widget border-1px bg-silver-deep p-15">
                                      <ul class="list-inline mb-15">
                                    <li>
                                        <i class="fa fa-dollar text-theme-colored2 font-48"></i>
                                        <div class="pull-right ml-5">
                                            <span>Course Price</span>
                                            <h4 class="mt-0"><?php echo $courses_details['price']; ?></h4>
                                        </div>
                                    </li>
                                    <li>
                                        <i class="fa fa-file-text text-theme-colored2 font-48"></i>
                                        <div class="pull-right ml-5">
                                            <span>Course</span>
                                            <h4 class="mt-0"><?php echo $cate['title']; ?></h4>
                                        </div>
                                    </li>
                                   
                                </ul>
                                    <div class="search-form">
                                         <img src="assets/images/course/<?php echo $courses_details['image']; ?>" alt>
                                    </div>
                                </div>
                                <div class="widget border-1px bg-silver-deep p-15">
                                    <h4 class="widget-title line-bottom-theme-colored-2 mb-10">Categories</h4>
                                    <div class="categories">
                                        <ul class="list-border">
	                                        <?php $count=0;
					$courses_detail = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM category WHERE status='1' order by title ASC");
					while($fetchcourses = $courses_detail->fetch_assoc()) {$count++; $id = $fetchcourses['id'];  ?>
	                                        
	                                        <li class="mb-1">
    	                                        <a  href="courses/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>"> <?php echo $fetchcourses['title']; ?>
    	                                        
                                            </a>
  	                                        </li>	
  	                                        	<?php } ?>
  	                                        
                                        </ul>
                                    </div>
                                </div>
                                <div class="widget border-1px bg-silver-deep p-15">
                                    <h4 class="widget-title line-bottom-theme-colored-2">Featured Courses</h4>
                                    <div class="product-list">
                                        <?php $count1=0;
        	
                                        	$courses1 = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE status='1' and catid='".$courses_details['catid']."'  order by title ASC");
					while($fetchcourses1 = $courses1->fetch_assoc()) {$count1++; $id1 = $fetchcourses1['id'];  ?>
                                        
                                        
                                        <div class="media">
                                            <a class="media-left pull-left flip" href="courses-detail/<?php echo $fetchcourses1['id']; ?>/<?php echo $fetchcourses1['slug']; ?>">
                                                <img class="media-object thumb" width="80" src="assets/images/course/<?php echo $fetchcourses1['image']; ?>" alt>
                                            </a>
                                            <div class="media-body">
                                                <h5 class="media-heading product-title mb-0"><a href="courses-detail/<?php echo $fetchcourses1['id']; ?>/<?php echo $fetchcourses1['slug']; ?>"><?php echo $fetchcourses1['title']; ?></a></h5>
                                                
                                                <span class="price">$<?php echo $fetchcourses1['price']; ?></span>
                                            </div>
                                        </div>
                                        
                                        	<?php } ?>
                            
                                        
                                        
                                    </div>
                                </div>
                                
                                <!--<div class="widget border-1px bg-silver-deep p-15">                                    
                                   <a href="#"><img class="img-fluid" src="images/brisbane_-_gold_coast_map_-_brisonly.gif"></a>
                                </div>-->
                                <div class="widget border-1px bg-silver-deep p-15">
                                    <h4 class="widget-title line-bottom-theme-colored-2">Quick Contact</h4>
                                    <form id="quick_contact_form_sidebar" name="footer_quick_contact_form" class="quick-contact-form" action="#" method="post">
                                        <div class="form-group">
                                            <input name="form_email" class="form-control" type="text" required placeholder="Enter Email">
                                        </div>
                                        <div class="form-group">
                                        <textarea name="form_message" class="form-control" required placeholder="Enter Message" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input name="form_botcheck" class="form-control" type="hidden" value />
                                            <button type="submit" class="btn btn-default btn-flat btn-xs btn-quick-contact text-gray pt-5 pb-5" data-loading-text="Please wait...">Send Message</button>
                                        </div>
                                    </form>
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