<?php session_start(); include('include/conn.php'); 
// $courseid=$_GET['id'];

// $courses_details = $conn->query("SELECT * FROM courses WHERE id='".$courseid."'")->fetch_assoc();
$categoryId=$_GET['id'];
$category = $conn->query("SELECT * FROM category WHERE id = '" . $categoryId . "' LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="<?php echo $category['title']; ?>" />
    <meta name="keywords" content="<?php echo $category['title']; ?>" />
    <meta name="author" content="<?php echo $category['title']; ?>" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title><?php echo $category['title']; ?> | Interact Safety</title>
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

<script>
    var courses = [];
</script>
<div id="wrapper" class="clearfix">
        <?php
        include("include/head.php");
        ?>
     <div id="main-content" class="main-content">

            <section class="inner-header divider layer-overlay overlay-theme-colored-7" data-bg-img="images/bg/bg1.jpg">
                <div class="container pt-20 pb-20" >

                    <div class="section-content">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-theme-colored2 font-36"><?php echo htmlspecialchars($category['title']); ?></h2>
                                <ol class="breadcrumb text-left mt-10 white">
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active"><?php echo htmlspecialchars($category['title']); ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container mt-30 mb-30 pt-30 pb-30">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="single-service">
                                <h3 class="text-uppercase mt-30 mb-10"><?php echo htmlspecialchars($category['title']); ?></h3>
                                <div class="double-line-bottom-theme-colored-2 mt-10"></div>
                                <div  class="tab-content">
                                    <div class="tab-pane fade in active" id="tab1">
                                    <div id="course-dates"></div>
                                        <h2 class="line-bottom-theme-colored-2 mb-15"><strong>Course Dates</strong></h2>
                                        <table id="courseTable" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Start Date</th>
                                                <th>Seats</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    	<?php $count=0;
                                            $courses = $conn->query("
                                                SELECT 
                                                    category.title AS category_title,
                                                    category.slug AS category_slug,
                                                    courses.id AS course_id,
                                                    courses.title AS course_title,
                                                    courses.image,
                                                    courses.delivery_types,
                                                    courses.duration,
                                                    courses.price,
                                                    course_slots.*
                                                FROM course_slots
                                                INNER JOIN courses ON courses.id = course_slots.courseid
                                                INNER JOIN category ON category.id = courses.catid
                                                WHERE course_slots.type='public'
                                                    AND course_slots.isPublished='1'
                                                    AND category.id='" . $categoryId . "' ORDER BY courses.title ASC
                                            ");
                        				    if($courses->num_rows > 0) {
                                                $course_name = '';
                                                while($fetchcourses = $courses->fetch_assoc()) {
                                                    $count++; 
                                                    $id = $fetchcourses['id'];
                                                    $cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcourses['cityid'])->fetch_assoc();
                                                    $locs = $conn->query("SELECT * FROM locations WHERE id=".$fetchcourses['locid'])->fetch_assoc();

                                                    $maxcapacity = $fetchcourses['maxcapacity'];
                                                    $remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid='".$fetchcourses['course_id']."' AND slotid='".$fetchcourses['id']."'")->fetch_assoc();
                                                    $used = $remain_places ? (int) $remain_places['count'] : 0;
                                                    $leftplace = $maxcapacity - $used;
                                                    $bookingClosedEarly = public_booking_is_closed_for_slot($conn, $id);
                                                    if ($bookingClosedEarly) {
                                                        $lefttext = 'Bookings closed';
                                                        $buttonttl = '<span class="btn btn-default btn-sm disabled" role="button" aria-disabled="true">SOLD OUT</span>';
                                                    } elseif ($leftplace <= 0) {
                                                        $lefttext = 'FULL';
                                                        $buttonttl = '<span class="btn btn-default btn-sm disabled" role="button" aria-disabled="true">SOLD OUT</span>';
                                                    } else {
                                                        $lefttext = format_public_seat_availability_label($leftplace);
                                                        $buttonttl = '<a href="registration/'.$fetchcourses["courseid"].'/'.$fetchcourses["locid"].'/'.$fetchcourses["id"].'/'.$fetchcourses["cityid"].'" target="_blank" class="btn btn-primary btn-sm" role="button">Book Now</a>';
                                                    }

                                                    $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$id."' ORDER BY date ASC, starttime ASC");
                                                    if($course_name != $fetchcourses['course_title']) {
                                                        $course_name = $fetchcourses['course_title']
                                                    ?>
                                                        <tr id="<?php echo $id;?>" class="course-header" style="cursor: pointer; background: #e2e2e2;">
                                                            <td colspan="4">
                                                                <?php echo $course_name?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                    while($dates = $fetchdates->fetch_assoc()) {
                                                        $firstStartTs = strtotime($dates['date'] . ' ' . $dates['starttime']);
                                                        $now = time();
                                                        if ($now >= $firstStartTs) {
                                                            continue;
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td style="padding-left: 50px;"><?php echo htmlspecialchars(format_booking_location_label($cities['name'] ?? '', $locs['location'] ?? '', $locs['title'] ?? '')); ?></td>
                                                            <td class="course-dates-cell"><?php echo format_course_dates_table_cell_html($dates['date'], $dates['starttime'], $dates['endtime']); ?></td>
                                                            <td><?php echo $lefttext; ?></td>
                                                            <td><?php echo $buttonttl; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                    <script>
                                                        courses.push(<?php echo json_encode($fetchcourses); ?>);
                                                    </script>
                                                    <?php
                                                    }
                                            } else {
                                                echo '<tr><td>No record found!!</td><td></td><td></td><td></td></tr>';
                                            } ?>
                                         
                                            </tbody>
                                            </table>
                                           <form id="importform" name="importform" class="rest-form mb-0 bg-silver-deep p-30" method="post" action="javascript:">
                                                <input type="hidden" name="categoryid" id="categoryid" value="<?php echo $categoryid; ?>"/>
                                                <div class="form-group  row"><label class="col-sm-3 col-form-label">Private Course Code</label>
                                                    <div class="col-sm-6"><input type="text" required minlength="8" maxlength="8" class="form-control" name="course_code" id="course_code"></div>
                                                    <div class="col-sm-3"><button type="submit" id="submitbook" class="btn btn-colored btn-block btn-theme-colored2 text-white btn-lg btn-flat" data-loading-text="Please wait...">Book Now</button></div>
                                                </div>
                                            </form>
                                            <p id="bookerr" style="display:none; color:red; font-weight:bold;"></p>
                                            <div id="myloaderabc"></div>
                                        <div id="course-details" class="fluid g-pt-30 g-pb-25">
					                        <h2 class="line-bottom-theme-colored-2 mb-15" id="course-details"><strong>Category Details</strong></h2>
                                        	<?php if ($categoryid == '1') { ?>
                                            <p class="mb-0">Interact Safety is approved by WorkSafe Victoria to deliver the HSR Initial OHS Training Course.</p>
                                            <?php } else {
                                                if (!empty($category['description'])) { echo '<div class="mb-0">'.$category['description'].'</div>'; }
                                                elseif (!empty($category['title'])) { echo '<p class="mb-0">'.htmlspecialchars($category['title']).'</p>'; }
                                            } ?>
                                            <div id="book">&nbsp;</div>
				                        </div>
                                    </div>
                                </div>
                                <div><a class="btn btn-xl btn-theme-colored2 mt-30 pr-40 pl-40" href="courses-detail/<?php echo $category['id']; ?>/<?php echo $_GET['title']; ?>#main-content">Scroll Up To Book</a></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="sidebar sidebar-left mt-sm-30 ml-30 ml-sm-0">
                                <div class="widget mb-20">
                                    <div class="course-sidebar-info">
                                        <div style="display:inline-block; width: calc(100% - 20px);">
                                            <div style="display: flex; align-items: center;">
                                                <i class="fa fa-check-circle info-icon"></i>
                                                <p class="info-title mb-0">WorkSafe Approval</p>
                                            </div>
                                            <p class="info-desc">
                                                <?php 
                                                    echo $categoryid == '1' ? 'Interact Safety is approved by WorkSafe Victoria to deliver the HSR Initial OHS Training Course.' : 'Interact Safety delivers WorkSafe-approved and quality OHS training across Victoria.'; 
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-balance-scale info-icon mb-10"></i>
                                            <p class="info-title mb-0">Legislative Entitlement</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 20px);">
                                            <p class="info-desc">
                                                <?php 
                                                    echo $categoryid == '1' ? 'Under the OHS Act 2004, elected HSRs are entitled to attend an approved HSR initial training course.' : 'Under the OHS Act 2004, elected HSRs may be entitled to attend approved training. Contact us for eligibility.'; 
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-map-marker info-icon"></i>
                                            <p class="info-title mb-0">Training Locations</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 20px);">
                                            <p class="info-desc">
                                                <?php 
                                                    echo $categoryid == '1' ? 'South East Melbourne venues &amp; flexible on-site delivery across Victoria.' : 'South East Melbourne &amp; flexible on-site delivery across Victoria.'; 
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="course-sidebar-info">
                                        <div style="display: flex; align-items: center;">
                                            <i class="fa fa-book info-icon"></i>
                                            <p class="info-title mb-0">What's Included</p>
                                        </div>
                                        <div style="display:inline-block; width: calc(100% - 20px);">
                                            <p class="info-desc">
                                                <?php 
                                                    echo $categoryid == '1' ? 'Printed WorkSafe materials and a copy of the Act; morning tea, lunch and light refreshments provided.' : 'Course materials and refreshments as per course. Contact us for details.'; 
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget course-sidebar-info p-15">
                                    <ul class="list-inline">
                                        <li><i class="fa fa-dollar info-icon font-48"></i>
                                            <div class="pull-right ml-5">
                                                <span class="info-title">Course Price</span>
                                                <h4 class="mt-0" id="h4_price"></h4>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="mt-15">
                                        <img id="img_corse_image" src="" alt="" class="img-fullwidth">
                                    </div>
                                </div>
                                <div class="course-sidebar-info">
                                    <div style="display: flex; align-items: center;">
                                        <i class="fa fa-graduation-cap info-icon"></i>
                                        <p class="info-title mb-0">Delivery Format</p>
                                    </div>
                                    <div style="display:inline-block; width: calc(100% - 20px);">
                                        <p class="info-desc" id="p_delivery">

                                        </p>
                                    </div>
                                </div>
                                <div class="course-sidebar-info">
                                    <div style="display: flex; align-items: center;">
                                        <i class="fa fa-clock-o info-icon"></i>
                                        <p class="info-title mb-0">Duration</p>
                                    </div>
                                    <div style="display:inline-block; width: calc(100% - 20px);">
                                        <p class="info-desc" id="p_duration"></p>
                                    </div>
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
            $('#courseTable .course-header').click(function () {
                filloutSidePanel(courses.find(el => el.id == this.id));
            });
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

        function filloutSidePanel(course) {
            if(!course) return;
            $('#p_delivery').text(course.delivery_types);
            $('#p_duration').text(course.duration);
            $('#h4_price').text(course.price);
            $('#img_corse_image').attr('alt', course.title);
            $('#img_corse_image').attr('src', 'assets/images/course/' + course.image);
        }
    </script>
</body>
</html>