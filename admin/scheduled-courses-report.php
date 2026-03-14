<?php include('session.php');

$courseId = isset($_GET['courseid']) ? (int)$_GET['courseid'] : 0;
$adminBasePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$course = $conn->query("SELECT * FROM courses WHERE id='" . $courseId . "'")->fetch_assoc();
$fromDate = isset($_GET['fromdate']) && !empty($_GET['fromdate']) ? $_GET['fromdate'] : '';
$toDate = isset($_GET['todate']) && !empty($_GET['todate']) ? $_GET['todate'] : '';
$teacherId = isset($_GET['teacherid']) ? (int)$_GET['teacherid'] : 0;

function getScheduledCourseDates($conn, $slotId)
{
    $dates = '';
    $courseDates = $conn->query("SELECT * FROM course_dates WHERE slot_id='" . (int)$slotId . "' ORDER BY date ASC, starttime ASC");
    while ($fetchDate = $courseDates->fetch_assoc()) {
        $dates .= date('d-M-Y', strtotime($fetchDate['date'])) . ' (' . date('h:i A', strtotime($fetchDate['starttime'])) . ' - ' . date('h:i A', strtotime($fetchDate['endtime'])) . ')';
    }

    if ($dates == '') {
        $dates = '-';
    }

    return $dates;
}

function getScheduledCourseTeachers($conn, $slotId)
{
    $teachersList = '';
    $courseTeachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='" . (int)$slotId . "' AND status='1' AND is_deleted='0' ORDER BY id ASC");
    while ($fetchTeacher = $courseTeachers->fetch_assoc()) {
        $teacher = $conn->query("SELECT * FROM teachers WHERE id='" . (int)$fetchTeacher['teacherid'] . "'")->fetch_assoc();
        if (!$teacher) {
            continue;
        }

        if ($fetchTeacher['accepted'] == '1') {
            $statusIcon = '<i class="fa fa-check-circle text-success" title="Accepted"></i>';
        } elseif ($fetchTeacher['accepted'] == '2') {
            $statusIcon = '<i class="fa fa-times-circle text-danger" title="Declined"></i>';
        } else {
            $statusIcon = '<i class="fa fa-minus-circle text-info" title="Pending"></i>';
        }

        $teachersList .= $statusIcon . ' ' . htmlspecialchars($teacher['title']);
    }

    if ($teachersList == '') {
        $teachersList = '-';
    }

    return $teachersList;
}

$scheduledCourses = false;
$teachers = false;
if ($course) {
    $teachers = $conn->query("
        SELECT DISTINCT teachers.id, teachers.title
        FROM course_teachers
        INNER JOIN teachers ON teachers.id = course_teachers.teacherid
        WHERE course_teachers.course_id='" . $courseId . "'
            AND course_teachers.status='1'
            AND course_teachers.is_deleted='0'
            AND teachers.status='1'
        ORDER BY teachers.title ASC
    ");

    $scheduledCoursesQuery = "
        SELECT
            course_slots.id,
            course_slots.type,
            course_slots.isPublished,
            course_slots.teacherid,
            course_slots.mincapacity,
            course_slots.maxcapacity,
            course_slots.makecapacity,
            locations.location,
            locations.title AS location_title,
            cities.name AS city_name,
            COALESCE(student_counts.total_students, 0) AS total_students
        FROM course_slots
        LEFT JOIN locations ON locations.id = course_slots.locid
        LEFT JOIN cities ON cities.id = course_slots.cityid
        LEFT JOIN (
            SELECT slotid, COUNT(*) AS total_students
            FROM sale
            WHERE courseid='" . $courseId . "'
            GROUP BY slotid
        ) AS student_counts ON student_counts.slotid = course_slots.id
        WHERE course_slots.courseid='" . $courseId . "'
    ";

    if (!empty($fromDate) || !empty($toDate)) {
        $scheduledCoursesQuery .= "
            AND EXISTS (
                SELECT 1
                FROM course_dates
                WHERE course_dates.slot_id = course_slots.id
            )
        ";

        if (!empty($fromDate)) {
            $scheduledCoursesQuery .= " AND EXISTS (
                SELECT 1
                FROM course_dates
                WHERE course_dates.slot_id = course_slots.id
                    AND course_dates.date >= '" . mysqli_real_escape_string($conn, $fromDate) . "'
            )";
        }

        if (!empty($toDate)) {
            $scheduledCoursesQuery .= " AND EXISTS (
                SELECT 1
                FROM course_dates
                WHERE course_dates.slot_id = course_slots.id
                    AND course_dates.date <= '" . mysqli_real_escape_string($conn, $toDate) . "'
            )";
        }
    }

    if ($teacherId > 0) {
        $scheduledCoursesQuery .= "
            AND (
                course_slots.teacherid='" . $teacherId . "'
                OR EXISTS (
                    SELECT 1
                    FROM course_teachers
                    WHERE course_teachers.slot_id = course_slots.id
                        AND course_teachers.teacherid='" . $teacherId . "'
                        AND course_teachers.status='1'
                        AND course_teachers.is_deleted='0'
                )
            )
        ";
    }

    $scheduledCoursesQuery .= " ORDER BY course_slots.id DESC";
    $scheduledCourses = $conn->query($scheduledCoursesQuery);
}
?>
<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo $adminBasePath; ?>/" />
    <title>Scheduled Courses Report</title>
    <?php include('includes/head.php'); ?>
    <style>
        .report-table th,
        .report-table td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php include('includes/header.php'); ?>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Scheduled Courses Report</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $adminBasePath; ?>/courses-report.php">Course List Report</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong><?php echo $course ? htmlspecialchars($course['title']) : 'Scheduled Courses Report'; ?></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2"></div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>
                                    <?php if ($course) {
                                        echo htmlspecialchars($course['title']) . ' Scheduled Runs';
                                    } else {
                                        echo 'Scheduled Courses Report';
                                    } ?>
                                </h5>
                            </div>
                            <div class="ibox-content">
                                <?php if (!$course) { ?>
                                    <div class="alert alert-danger">Course not found.</div>
                                <?php } else { ?>
                                    <div style="margin-bottom: 15px;">
                                        <a href="<?php echo $adminBasePath; ?>/courses-report.php" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Course List</a>
                                    </div>
                                    <form method="get" action="<?php echo $adminBasePath; ?>/<?php echo $courseId; ?>/scheduled-courses-report.php" style="margin-bottom: 20px;">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label>Teacher</label>
                                                <select class="form-control" name="teacherid" style="height: 38px;">
                                                    <option value="">All Teachers</option>
                                                    <?php if ($teachers) {
                                                        while ($teacher = $teachers->fetch_assoc()) { ?>
                                                            <option value="<?php echo (int)$teacher['id']; ?>" <?php if ($teacherId === (int)$teacher['id']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>>
                                                                <?php echo htmlspecialchars($teacher['title']); ?>
                                                            </option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>From</label>
                                                <input type="date" class="form-control" name="fromdate" value="<?php echo htmlspecialchars($fromDate); ?>">
                                            </div>
                                            <div class="col-lg-3">
                                                <label>To</label>
                                                <input type="date" class="form-control" name="todate" value="<?php echo htmlspecialchars($toDate); ?>">
                                            </div>
                                            <div class="col-lg-2" style="padding-top: 28px;">
                                                <button type="submit" class="btn btn-primary btn-sm" style="padding: 8px 16px;">Filter</button>
                                                <a href="<?php echo $adminBasePath; ?>/<?php echo $courseId; ?>/scheduled-courses-report.php" style="padding-top: 8px; padding-bottom: 8px;" class="btn btn-info btn-sm">Clear Filter</a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example report-table">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Status</th>
                                                    <th>Course Type</th>
                                                    <th>Location</th>
                                                    <th>Min Capacity</th>
                                                    <th>Max Capacity</th>
                                                    <th>Makeup Capacity</th>
                                                    <th>Date & Time</th>
                                                    <th>Teacher</th>
                                                    <th>Students</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count = 0;
                                                while ($scheduledCourse = $scheduledCourses->fetch_assoc()) {
                                                    $count++;
                                                    $courseCode = '';
                                                    if ($scheduledCourse['type'] == 'private') {
                                                        $privateCourse = $conn->query("SELECT * FROM private_course WHERE slot_id='" . (int)$scheduledCourse['id'] . "'")->fetch_assoc();
                                                        if ($privateCourse && !empty($privateCourse['course_code'])) {
                                                            $courseCode = '<br>(' . htmlspecialchars($privateCourse['course_code']) . ')';
                                                        }
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?>.</td>
                                                        <td>
                                                            <?php if ($scheduledCourse['isPublished'] == '1') { ?>
                                                                <span class="label label-success">Published</span>
                                                            <?php } else { ?>
                                                                <span class="label label-info">Not Published</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars(ucfirst($scheduledCourse['type'])) . $courseCode; ?></td>
                                                        <td><?php echo htmlspecialchars($scheduledCourse['city_name'] . ' - ' . $scheduledCourse['location'] . ' (' . $scheduledCourse['location_title'] . ')'); ?></td>
                                                        <td><?php echo (int)$scheduledCourse['mincapacity']; ?></td>
                                                        <td><?php echo (int)$scheduledCourse['maxcapacity']; ?></td>
                                                        <td><?php echo (int)$scheduledCourse['makecapacity']; ?></td>
                                                        <td><?php echo getScheduledCourseDates($conn, $scheduledCourse['id']); ?></td>
                                                        <td><?php echo getScheduledCourseTeachers($conn, $scheduledCourse['id']); ?></td>
                                                        <td><?php echo (int)$scheduledCourse['total_students']; ?></td>
                                                        <td>
                                                            <a href="<?php echo $adminBasePath; ?>/<?php echo $courseId; ?>/<?php echo (int)$scheduledCourse['id']; ?>/students-report.php" class="btn btn-info btn-sm">
                                                                <i class="fa fa-users"></i> View Students
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <?php include('includes/foot.php'); ?>
</body>

</html>