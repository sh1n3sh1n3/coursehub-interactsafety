<?php include('session.php');

$courseId = isset($_GET['courseid']) ? (int)$_GET['courseid'] : 0;
$slotId = isset($_GET['slotid']) ? (int)$_GET['slotid'] : 0;
$adminBasePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');

$err = $msg = '';

// Remove a student from a specific scheduled course (unenrol = remove sale row for this slot/course/user)
if (isset($_POST['remove_student']) && $courseId > 0 && $slotId > 0) {
    $saleId = isset($_POST['sale_id']) ? (int)$_POST['sale_id'] : 0;
    if ($saleId <= 0) {
        $err = 'Invalid request.';
    } else {
        $saleRow = $conn->query("SELECT id, user, courseid, slotid FROM sale WHERE id='" . $saleId . "' LIMIT 1")->fetch_assoc();
        if (!$saleRow || (int)$saleRow['courseid'] !== $courseId || (int)$saleRow['slotid'] !== $slotId) {
            $err = 'Student enrolment not found for this scheduled course.';
        } else {
            $studentId = (int)$saleRow['user'];

            // Clean up attendance for this scheduled course (if any)
            $conn->query("DELETE FROM tbl_attendance WHERE tbl_student_id='" . $studentId . "' AND courseid='" . $courseId . "' AND slotid='" . $slotId . "'");

            // Remove enrolment from the enrolled list
            if ($conn->query("DELETE FROM sale WHERE id='" . $saleId . "' LIMIT 1")) {
                $msg = 'Student removed from this scheduled course successfully.';
            } else {
                $err = $conn->error;
            }
        }
    }
}

$course = $conn->query("SELECT * FROM courses WHERE id='" . $courseId . "'")->fetch_assoc();
$scheduledCourse = false;
if ($courseId > 0 && $slotId > 0) {
    $scheduledCourse = $conn->query("
        SELECT
            course_slots.*,
            locations.location,
            locations.title AS location_title,
            cities.name AS city_name
        FROM course_slots
        LEFT JOIN locations ON locations.id = course_slots.locid
        LEFT JOIN cities ON cities.id = course_slots.cityid
        WHERE course_slots.id='" . $slotId . "' AND course_slots.courseid='" . $courseId . "'
    ")->fetch_assoc();
}

function getStudentReportDates($conn, $slotId)
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

function getStudentReportTeachers($conn, $slotId)
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

$students = false;
if ($course && $scheduledCourse) {
    $students = $conn->query("
        SELECT
            sale.*,
            registration.generated_code,
            registration.title AS reg_title,
            registration.fname,
            registration.lname,
            registration.email,
            registration.position,
            registration.company
        FROM sale
        LEFT JOIN registration ON registration.id = sale.user
        WHERE sale.courseid='" . $courseId . "' AND sale.slotid='" . $slotId . "'
        ORDER BY sale.id DESC
    ");
}
?>
<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo $adminBasePath; ?>/" />
    <title>Enrolled Students Report</title>
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
                    <h2>Enrolled Students Report</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo $adminBasePath; ?>/courses-report.php">Course List Report</a>
                        </li>
                        <li class="breadcrumb-item">
                            <?php if ($course) { ?>
                                <a href="<?php echo $adminBasePath; ?>/<?php echo $courseId; ?>/scheduled-courses-report.php"><?php echo htmlspecialchars($course['title']); ?></a>
                            <?php } else { ?>
                                <strong>Scheduled Courses</strong>
                            <?php } ?>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Enrolled Students</strong>
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
                                <h5>Enrolled Students</h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                if (!empty($err)) {
                                    echo "<div class='alert alert-danger alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        <strong>Error:</strong> " . $err . "
                                    </div>";
                                }
                                if (!empty($msg)) {
                                    echo "<div class='alert alert-success alert-dismissible'>
                                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                        " . $msg . "
                                    </div>";
                                }
                                ?>
                                <?php if (!$course || !$scheduledCourse) { ?>
                                    <div class="alert alert-danger">Scheduled course not found.</div>
                                <?php } else { ?>
                                    <div class="row" style="margin-bottom: 15px;">
                                        <div class="col-lg-12">
                                            <a href="<?php echo $adminBasePath; ?>/<?php echo $courseId; ?>/scheduled-courses-report.php" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Scheduled Courses</a>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 15px;">
                                        <div class="col-lg-3"><strong>Course:</strong><br><?php echo htmlspecialchars($course['title']); ?></div>
                                        <div class="col-lg-2"><strong>Course Type:</strong><br><?php echo htmlspecialchars($scheduledCourse['type']); ?></div>
                                        <div class="col-lg-3"><strong>Location:</strong><br><?php echo htmlspecialchars(format_booking_location_label($scheduledCourse['city_name'] ?? '', $scheduledCourse['location'] ?? '', $scheduledCourse['location_title'] ?? '')); ?></div>
                                        <div class="col-lg-2"><strong>Dates:</strong><br><?php echo getStudentReportDates($conn, $slotId); ?></div>
                                        <div class="col-lg-2"><strong>Teacher:</strong><br><?php echo getStudentReportTeachers($conn, $slotId); ?></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example report-table">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Order Date</th>
                                                    <th>Invoice No</th>
                                                    <th>Order No</th>
                                                    <th>Payment Id</th>
                                                    <th>Student ID</th>
                                                    <th>Name</th>
                                                    <th>E-mail</th>
                                                    <th>Position</th>
                                                    <th>Company</th>
                                                    <th>Certificate Issued</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $count = 0;
                                                while ($student = $students->fetch_assoc()) {
                                                    $count++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo !empty($student['date']) ? date('d-M-Y', strtotime($student['date'])) : '-'; ?></td>
                                                        <td><?php echo htmlspecialchars($student['invoiceno']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['orderno']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['paymentid']); ?></td>
                                                        <td><?php echo htmlspecialchars(strtoupper($student['generated_code'])); ?></td>
                                                        <td><?php echo htmlspecialchars($student['reg_title'] . ' ' . $student['fname'] . ' ' . $student['lname']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['position']); ?></td>
                                                        <td><?php echo htmlspecialchars($student['company']); ?></td>
                                                        <td><?php echo $student['generateCertificate'] == '1' ? 'Yes' : 'No'; ?></td>
                                                        <td>
                                                            <a href="user-details.php?id=<?php echo (int)$student['user']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View Details</a>
                                                            <form method="post" style="display:inline-block; margin-left: 6px;" onsubmit="return confirm('Remove this student from this scheduled course? This will remove them from the enrolled list.');">
                                                                <input type="hidden" name="sale_id" value="<?php echo (int)$student['id']; ?>">
                                                                <button type="submit" name="remove_student" value="1" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i> Remove
                                                                </button>
                                                            </form>
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