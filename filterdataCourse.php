<?php session_start(); include('include/conn.php'); 
$catid=$_POST['catid'];
$val=$_POST['val'];
if($val == 'all') { ?>
<div class="bg-silver-deep" style="padding:15px"><b>All Records</b></div>
<?php
$courses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE status='1' and catid='".$catid."'  order by title ASC");
if($courses->num_rows > 0) {
while($fetchcourses = $courses->fetch_assoc()) {
    $id = $fetchcourses['id'];
    $price = isset($fetchcourses['price']) && $fetchcourses['price'] !== '' ? $fetchcourses['price'] : null;
    $duration = '';
    if (!empty($fetchcourses['duration'])) $duration = $fetchcourses['duration'] . ' ' . (isset($fetchcourses['duration_type']) ? $fetchcourses['duration_type'] : 'days');
?>
    <div class="col-sm-6 col-md-3">
        <div class="course-card mb-30">
            <a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                <div class="thumb">
                    <img src="assets/images/course/<?php echo htmlspecialchars($fetchcourses['image']); ?>" alt="<?php echo htmlspecialchars($fetchcourses['title']); ?>">
                </div>
                <div class="card-body">
                    <h5 class="card-title text-uppercase"><?php echo htmlspecialchars($fetchcourses['title']); ?></h5>
                    <div class="card-meta">
                        <?php if ($price !== null) { ?><span class="card-price"><?php echo htmlspecialchars($price); ?></span><?php } ?>
                        <?php if ($duration !== '') { ?><span class="card-duration"><?php echo htmlspecialchars($duration); ?></span><?php } ?>
                    </div>
                    <?php if (!empty($fetchcourses['shortdescription'])) { ?><div class="card-desc"><?php echo $fetchcourses['shortdescription']; ?></div><?php } ?>
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
    while($fetchcourses = $courses->fetch_assoc()) {
        $id = $fetchcourses['id'];
        $price = isset($fetchcourses['price']) && $fetchcourses['price'] !== '' ? $fetchcourses['price'] : null;
        $duration = '';
        if (!empty($fetchcourses['duration'])) $duration = $fetchcourses['duration'] . ' ' . (isset($fetchcourses['duration_type']) ? $fetchcourses['duration_type'] : 'days');
?>
        <div class="col-sm-6 col-md-3">
            <div class="course-card mb-30">
                <a href="courses-detail/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>">
                    <div class="thumb">
                        <img src="assets/images/course/<?php echo htmlspecialchars($fetchcourses['image']); ?>" alt="<?php echo htmlspecialchars($fetchcourses['title']); ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-uppercase"><?php echo htmlspecialchars($fetchcourses['title']); ?></h5>
                        <div class="card-meta">
                            <?php if ($price !== null) { ?><span class="card-price"><?php echo htmlspecialchars($price); ?></span><?php } ?>
                            <?php if ($duration !== '') { ?><span class="card-duration"><?php echo htmlspecialchars($duration); ?></span><?php } ?>
                        </div>
                        <?php if (!empty($fetchcourses['shortdescription'])) { ?><div class="card-desc"><?php echo $fetchcourses['shortdescription']; ?></div><?php } ?>
                    </div>
                </a>
            </div>
        </div>
<?php }}} else { ?>
<div class="col-sm-12 col-md-12"><h3><center>No record found!!</center></h3></div>
<?php }} ?>