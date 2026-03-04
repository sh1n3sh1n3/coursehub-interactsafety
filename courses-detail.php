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
    html { scroll-behavior: smooth; }
    /* Private Course Code: justify-between, 16px gap, input fills remaining width */
    #importform .form-group.row { display: flex; flex-wrap: nowrap; justify-content: space-between; align-items: center; gap: 16px; padding: 12px 16px; }
    #importform .form-group.row .col-form-label { margin-bottom: 0; padding: 0; white-space: nowrap; flex-shrink: 0; }
    #importform .form-group.row .col-sm-6 { flex: 1 1 auto; min-width: 0; padding: 0; }
    #importform .form-group.row .col-sm-3:last-child { flex-shrink: 0; padding: 0; }
    #importform #course_code { height: 32px; line-height: 32px; padding: 0 12px; border-radius: 6px; box-sizing: border-box; width: 100%; }
    #importform #submitbook { height: 32px; line-height: 32px; padding: 0 10px; border-radius: 6px; border: none; box-sizing: border-box; background: #D8701A !important; color: #fff !important; width: auto !important; min-width: 0; }
    #importform #submitbook:hover { background: #c46214 !important; color: #fff !important; }
    /* Scroll Up To Book – 40px height, 6px radius */
    .main-content .btn-theme-colored2.btn-xl { height: 40px; line-height: 40px; padding: 0 24px; border-radius: 6px; }
    .main-content #datatable .btn-primary.btn-sm { height: 32px; line-height: 32px; padding: 0 16px; border-radius: 6px; }
    .course-sidebar-info { background: #f5f0e8; border: 1px solid #e0d9cc; border-radius: 4px; padding: 14px 16px; margin-bottom: 12px; }
    .course-sidebar-info:last-child { margin-bottom: 0; }
    .course-sidebar-info .info-icon { font-size: 22px; color: #212331; margin-right: 12px; vertical-align: top; }
    .course-sidebar-info .info-title { font-weight: 700; color: #212331; margin: 0 0 6px 0; font-size: 15px; }
    .course-sidebar-info .info-desc { font-size: 13px; color: #6b6560; line-height: 1.45; margin: 0; }
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
                                <h2 class="text-theme-colored2 font-36"><?php echo htmlspecialchars($courses_details['title']); ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="courses/<?php echo $cate['id']; ?>/<?php echo $cate['slug']; ?>"><?php echo $cate['title']; ?></a></li>
                                    <li class="active"><?php echo htmlspecialchars($courses_details['title']); ?></li>
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
                              
                              
                                <h3 class="text-uppercase mt-30 mb-10"><?php echo htmlspecialchars($courses_details['title']); ?></h3>
                                <div class="double-line-bottom-theme-colored-2 mt-10"></div>
                                <?php if ($courseid == '1') { ?>
                                <p class="mb-0">Interact Safety is approved by WorkSafe Victoria to deliver the HSR Initial OHS Training Course.</p>
                                <?php } else {
                                    if (!empty($courses_details['shortdescription'])) { echo '<div class="mb-0">'.$courses_details['shortdescription'].'</div>'; }
                                    elseif (!empty($courses_details['aliascoursename'])) { echo '<p class="mb-0">'.htmlspecialchars($courses_details['aliascoursename']).'</p>'; }
                                } ?>
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
                                                <th>&nbsp;</th>
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
                                					$coursedatetime = date('Y-m-d H:i:s', strtotime($fetchdates['date'].' '.$fetchdates['starttime']));
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
                                    					    $buttonttl = '<a href="registration/'.$fetchcourses["courseid"].'/'.$fetchcourses["locid"].'/'.$fetchcourses["id"].'/'.$fetchcourses["cityid"].'" target="_blank" class="btn btn-primary btn-sm" role="button">Book Now</a>';
                                    					} else if($leftplace > 0 && $leftplace <= 10) {
                                    					    $lefttext = 'Limited Places (11- '.$maxcapacity.')';
                                    					    $buttonttl = '<a href="registration/'.$fetchcourses["courseid"].'/'.$fetchcourses["locid"].'/'.$fetchcourses["id"].'/'.$fetchcourses["cityid"].'" target="_blank" class="btn btn-primary btn-sm" role="button">Book Now</a>';
                                    					} else {
                                    					    $lefttext = 'Sold Out';
                                    					    $buttonttl = '<a href="waiting/'.$fetchcourses["courseid"].'/'.$fetchcourses["locid"].'/'.$fetchcourses["id"].'/'.$fetchcourses["cityid"].'" target="_blank" class="btn btn-warning btn-sm" role="button">Add Me To Waitlist</a>';
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
                                                    <div class="col-sm-3"><button type="submit" id="submitbook" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Book Now</button></div>
                                                </div>
                                            </form>
                                            <p id="bookerr" style="display:none; color:red; font-weight:bold;"></p>
                                            <div id="myloaderabc"></div>
                                        <div id="course-details" class="fluid g-pt-30 g-pb-25">
					                        <h2 class="line-bottom-theme-colored-2 mb-15" id="course-details"><strong>Course Details</strong></h2>
                                        	<?php
                                        	if ($courseid == '1') {
                                        	    // HSR Initial OHS Training Course – full content
                                        	    ?>
                                        	    <h3 class="mt-20 mb-10">Course Overview</h3>
                                        	    <p>The HSR Initial OHS Training Course is a WorkSafe-approved training course designed for elected Health and Safety Representatives (HSRs) and Deputy HSRs to develop the knowledge, practical skills, and confidence required to effectively carry out their role under the Occupational Health and Safety Act 2004.</p>
                                        	    <p>Delivered face-to-face, this five-day course focuses on consultation, issue resolution, hazard identification, risk management, and the powers and functions of HSRs within their designated work group. The training is practical, discussion-based, and aligned with real workplace consultation processes rather than theoretical delivery.</p>
                                        	    <p>Public courses are conducted at training venues across South East and Eastern Suburbs of Melbourne, with flexible on-site workplace group training available throughout Victoria.</p>
                                        	    <p>This training is delivered with a strong focus on workplace consultation systems, ensuring HSRs and management clearly understand their roles, responsibilities, and how effective consultation strengthens workplace safety performance.</p>

                                        	    <h3 class="mt-25 mb-10">Who Should Attend</h3>
                                        	    <p>This course is primarily intended for:</p>
                                        	    <ul class="list theme-colored">
                                        	        <li>Elected Health and Safety Representatives (HSRs)</li>
                                        	        <li>Deputy HSRs</li>
                                        	        <li>Newly elected HSRs requiring initial training</li>
                                        	    </ul>
                                        	    <p>The course is also valuable for:</p>
                                        	    <ul class="list theme-colored">
                                        	        <li>Managers and supervisors working alongside HSRs</li>
                                        	        <li>Health and Safety Committee members</li>
                                        	        <li>Senior leaders responsible for consultation and safety governance</li>
                                        	        <li>Employers seeking to strengthen consultation and HSR engagement within their organisation</li>
                                        	    </ul>
                                        	    <p><strong>Note:</strong> The primary audience remains elected HSRs in accordance with legislative requirements.</p>

                                        	    <h3 class="mt-25 mb-10">Workplace Group Bookings &amp; Organisational Training</h3>
                                        	    <p>Interact Safety offers flexible public enrolments and on-site workplace group training across Victoria, allowing organisations to train elected HSRs, Deputy HSRs, and relevant management representatives together where appropriate.</p>
                                        	    <p>Group bookings support a stronger understanding of the HSR role, consultation obligations, and workplace issue resolution processes under the Occupational Health and Safety Act 2004. This approach helps managers, supervisors, and senior leaders better understand how to effectively engage with HSRs and how the HSR role can be a practical asset to improving safety systems, consultation, and workplace communication.</p>
                                        	    <p>On-site delivery also allows training to be contextualised to the organisation's workplace environment while remaining fully aligned with WorkSafe-approved course requirements.</p>

                                        	    <h3 class="mt-25 mb-10">Learning Outcomes</h3>
                                        	    <p>By the end of this course, participants will be able to:</p>
                                        	    <ul class="list theme-colored">
                                        	        <li>Understand the role, powers, and functions of an HSR</li>
                                        	        <li>Interpret and apply the Occupational Health and Safety Act 2004 in the workplace</li>
                                        	        <li>Identify hazards and participate in risk management processes</li>
                                        	        <li>Participate effectively in consultation and issue resolution procedures</li>
                                        	        <li>Represent their designated work group with confidence</li>
                                        	        <li>Contribute to improved workplace safety systems and consultation practices</li>
                                        	    </ul>

                                        	    <h3 class="mt-25 mb-10">What to Expect During the Course</h3>
                                        	    <p>This course is interactive, discussion-based, and focused on real workplace consultation rather than passive learning. Participants are encouraged to actively engage throughout the five days.</p>
                                        	    <p>To get the most value from the training, participants should:</p>
                                        	    <ul class="list theme-colored">
                                        	        <li>Bring a positive and open mindset to learning</li>
                                        	        <li>Be prepared to ask questions and participate in discussions</li>
                                        	        <li>Be willing to work collaboratively in group activities</li>
                                        	        <li>Share workplace experiences where appropriate to support practical learning</li>
                                        	    </ul>
                                        	    <p>The course involves group discussions, scenario-based activities, and consultation exercises that reflect real workplace situations and the practical role of a Health and Safety Representative.</p>

                                        	    <h3 class="mt-25 mb-10">For Employers &amp; Organisations</h3>
                                        	    <p>This WorkSafe-approved course supports employers in meeting their legal obligations to provide training to elected HSRs while strengthening workplace consultation, cooperation, and overall safety performance.</p>
                                        	    <p>Delivered by an experienced safety consultancy, the training goes beyond basic theory and focuses on practical workplace application, helping organisations build functional safety systems where HSRs, management, and workers can effectively consult and resolve safety issues in accordance with legislative requirements.</p>

                                        	    <h3 class="mt-25 mb-10">Course Delivery Information</h3>
                                        	    <table class="table table-bordered">
                                        	        <tr><th style="width:40%">Duration</th><td>5 Days (Face-to-Face)</td></tr>
                                        	        <tr><th>Course Type</th><td>WorkSafe-Approved HSR Initial OHS Training Course</td></tr>
                                        	        <tr><th>Delivery Format</th><td>Classroom-based public courses and on-site workplace group training</td></tr>
                                        	        <tr><th>Locations</th><td>South East Melbourne training venues &amp; on-site delivery across Victoria</td></tr>
                                        	        <tr><th>Materials</th><td>Printed WorkSafe materials and a copy of the Act is provided to students in accordance with WorkSafe course delivery requirements. Morning tea, lunch and light refreshments are provided.</td></tr>
                                        	    </table>

                                        	    <h3 class="mt-25 mb-10">Booking &amp; Enrolment</h3>
                                        	    <p>Upcoming public course dates are released regularly.</p>
                                        	    <p>Organisations may also enquire about private on-site group bookings across Victoria.</p>
                                        	    <p>For bookings, group training enquiries, or availability, please <a href="contact.php" class="text-theme-colored2">contact Interact Safety</a> or proceed with the enrolment process below.</p>
                                        	    <?php
                                        	} else {
                                        	    echo $courses_details['description'];
                                        	}
                                        	?>
				                        </div>
                                    </div>
                                </div>
                                <div><a class="btn btn-xl btn-theme-colored2 mt-30 pr-40 pl-40" href="courses-detail/<?php echo $courses_details['id']; ?>/<?php echo $_GET['title']; ?>#book">Scroll Up To Book</a></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                                <?php
                                $d = $courses_details;
                                $dur = !empty($d['duration']) ? $d['duration'] . ' ' . (!empty($d['duration_type']) ? $d['duration_type'] : 'Days') : '';
                                $delivery = !empty($d['delivery_types']) ? htmlspecialchars($d['delivery_types']) : 'Face-to-face and on-site options available';
                                if ($courseid == '1') {
                                    $wsafe = 'Interact Safety is approved by WorkSafe Victoria to deliver the HSR Initial OHS Training Course.';
                                    $dur = $dur ?: '5 Days';
                                    $legis = 'Under the OHS Act 2004, elected HSRs are entitled to attend an approved HSR initial training course.';
                                    $loc = 'South East Melbourne venues &amp; flexible on-site delivery across Victoria.';
                                    $included = 'Printed WorkSafe materials and a copy of the Act; morning tea, lunch and light refreshments provided.';
                                    $delivery = 'Face-to-face public courses and on-site workplace group training.';
                                } else {
                                    $wsafe = 'Interact Safety delivers WorkSafe-approved and quality OHS training across Victoria.';
                                    $legis = 'Under the OHS Act 2004, elected HSRs may be entitled to attend approved training. Contact us for eligibility.';
                                    $loc = 'South East Melbourne &amp; flexible on-site delivery across Victoria.';
                                    $included = 'Course materials and refreshments as per course. Contact us for details.';
                                    if (!$dur) $dur = 'As per course schedule';
                                }
                                ?>
                                <div class="widget mb-20">
                                    <div class="course-sidebar-info">
                                        <div style="display:inline-block; width: calc(100% - 40px);">
                                            <div style="display: flex; align-items: center;">
                                                <i class="fa fa-check-circle info-icon"></i>
                                                <p class="info-title mb-0">WorkSafe Approval</p>
                                            </div>
                                            <p class="info-desc"><?php echo $wsafe; ?></p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-clock-o info-icon"></i>
                                            <p class="info-title mb-0">Duration</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 40px);">
                                            <p class="info-desc"><?php echo $dur; ?></p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-balance-scale info-icon mb-10"></i>
                                            <p class="info-title mb-0">Legislative Entitlement</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 40px);">
                                            <p class="info-desc"><?php echo $legis; ?></p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-graduation-cap info-icon"></i>
                                            <p class="info-title mb-0">Delivery Format</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 40px);">
                                            <p class="info-desc"><?php echo $delivery; ?></p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-map-marker info-icon"></i>
                                            <p class="info-title mb-0">Training Locations</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 40px);">
                                            <p class="info-desc"><?php echo $loc; ?></p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-book info-icon"></i>
                                            <p class="info-title mb-0">What's Included</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 40px);">
                                            <p class="info-desc"><?php echo $included; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget course-sidebar-info p-15">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-dollar info-icon font-48"></i>
                                            <div class="pull-right ml-5"><span class="info-title">Course Price</span><h4 class="mt-0">$<?php echo htmlspecialchars($d['price']); ?></h4></div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="widget course-sidebar-info p-15">
                                    <h4 class="info-title widget-title line-bottom-theme-colored-2 mb-10">Quick Contact</h4>
                                    <form id="quick_contact_form_sidebar" name="footer_quick_contact_form" class="quick-contact-form" action="#" method="post">
                                        <div class="form-group">
                                            <input name="form_email" class="form-control" type="text" required placeholder="Enter Email">
                                        </div>
                                        <div class="form-group">
                                        <textarea name="form_message" class="form-control" required placeholder="Enter Message" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input name="form_botcheck" class="form-control" type="hidden" value />
                                            <button type="submit" class="btn btn-default btn-flat btn-xs btn-quick-contact text-white pt-5 pb-5 bg-theme-colored2" style="height: 32px; border-radius:8px; border: none;" data-loading-text="Please wait...">Send Message</button>
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
    <script>
        $( document ).ready(function(e) {
         $("#importform").on('submit',(function(e) {
          e.preventDefault();
          $.ajax({
               url: "checkPrivatecourse.php",
               type: "POST",
               data:  new FormData(this),
               contentType: false,
                cache: false,
               processData:false,
               beforeSend: function(){
                 $("#myloaderabc").css("display","block");
                    $("#myloaderabc").css("background","url(img/LoaderIcon.gif) center / 75px 75px no-repeat");
                    $("#submitbook").prop("disabled", true);
                },
               success: function(data) { console.log(data);
                 $("#submitbook").prop("disabled", false);
                 $("#myloaderabc").css("display","none");
                 $("#myloaderabc").css("background","#fff");
                   if(data == '1') {
                        $("#bookerr").css('display','block');
                        $("#bookerr").text('').text("The course code you entered does not exist!");
                   } else if(data == '2') {
                        $("#bookerr").css('display','block');
                        $("#bookerr").text('').text("The course code you entered is not associated with this course!");
                   } else if(data == '3') {
                        $("#bookerr").css('display','block');
                        $("#bookerr").text('').text("This course is sold out!");
                   } else if(data == '4') {
                        $("#bookerr").css('display','block');
                        $("#bookerr").text('').text("The course code you entered is expired!");
                   } else {
                        $("#bookerr").text('');
                        $("#bookerr").css('display','none');
                        window.location.href=data;
                   }
              },       
            });
         }));
         });
    </script>
</body>
</html>