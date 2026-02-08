<?php session_start(); include('include/conn.php'); 
$catid=$_POST['catid'];
$val=$_POST['val'];
if($val == 'all') { ?>
<div class="bg-silver-deep" style="padding:15px"><b>All Records</b></div>
<?php
$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE status='1' and catid='".$catid."'  order by title ASC");
if($courses->num_rows > 0) {
while($fetchcourses = $courses->fetch_assoc()) { $id = $fetchcourses['id'];  ?>
    <div class="col-sm-6 col-md-3">
        <div class="event-list bg-silver-light maxwidth500 mb-30">
            <a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                <div class="thumb">
                    <img style="height:180px" src="assets/images/course/<?php echo $fetchcourses['image']; ?>" alt class="img-fullwidth">
                </div>
                <div class="event-list-details border-1px bg-white clearfix p-15 pt-15 pb-30">
                    <div style="height:50px;overflow:hidden">
                        <h5 class="text-uppercase font-weight-600 font-14 mb-5"><a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>"><?php echo $fetchcourses['title']; ?></a></h5>
                    </div>
                    <div style="height:50px;overflow:hidden">
                        <?php echo $fetchcourses['shortdescription']; ?>
                     </div>
                 </div>
             </a>
        </div>
    </div>
<?php } } else { ?>
    <div class="col-sm-12 col-md-12"><h3><center>No record found!!</center></h3></div>
<?php }} else {
    $loc = $conn->query("SELECT * FROM locations WHERE id=".$val)->fetch_assoc();
    $cities = $conn->query("SELECT * FROM cities WHERE id=".$loc['city'])->fetch_assoc(); ?>
    <div class="bg-silver-deep" style="padding:15px"><b><?php echo $cities['name']; ?></b></div>
    <?php
    $course_slots = $conn->query("SELECT * FROM course_slots WHERE locid='".$val."'");
    if($course_slots->num_rows > 0) {
    while($fetchcourse_slots = $course_slots->fetch_assoc()) {
    $courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE status='1' and catid='".$catid."' AND id='".$fetchcourse_slots['courseid']."'  order by title ASC");
    while($fetchcourses = $courses->fetch_assoc()) { $id = $fetchcourses['id'];  ?>
        <div class="col-sm-6 col-md-3">
            <div class="event-list bg-silver-light maxwidth500 mb-30">
                <a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                    <div class="thumb">
                        <img style="height:180px" src="assets/images/course/<?php echo $fetchcourses['image']; ?>" alt class="img-fullwidth">
                    </div>
                    <div class="event-list-details border-1px bg-white clearfix p-15 pt-15 pb-30">
                        <div style="height:50px;overflow:hidden">
                            <h5 class="text-uppercase font-weight-600 font-14 mb-5"><a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>"><?php echo $fetchcourses['title']; ?></a></h5>
                        </div>
                        <div style="height:50px;overflow:hidden">
                            <?php echo $fetchcourses['shortdescription']; ?>
                         </div>
                     </div>
                 </a>
            </div>
        </div>
<?php }}} else { ?>
<div class="col-sm-12 col-md-12"><h3><center>No record found!!</center></h3></div>
<?php }} ?>