<?php include('session.php');

$adminBasePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '1';

$coursesQuery = "
    SELECT
        courses.id,
        courses.title,
        courses.short,
        courses.course_type,
        courses.delivery_types,
        courses.status,
        courses.isPublished,
        COALESCE(schedule_counts.total_schedules, 0) AS total_schedules,
        COALESCE(student_counts.total_students, 0) AS total_students
    FROM courses
    LEFT JOIN (
        SELECT courseid, COUNT(*) AS total_schedules
        FROM course_slots
        GROUP BY courseid
    ) AS schedule_counts ON schedule_counts.courseid = courses.id
    LEFT JOIN (
        SELECT courseid, COUNT(*) AS total_students
        FROM sale
        GROUP BY courseid
    ) AS student_counts ON student_counts.courseid = courses.id
    WHERE courses.id <> 0
";

if ($statusFilter !== 'all' && ($statusFilter === '1' || $statusFilter === '0')) {
    $coursesQuery .= " AND courses.status='" . mysqli_real_escape_string($conn, $statusFilter) . "'";
}

$coursesQuery .= " ORDER BY courses.title ASC";
$courses = $conn->query($coursesQuery);
?>
<!DOCTYPE html>
<html>

<head>
    <base href="<?php echo $adminBasePath; ?>/" />
    <title>Course Report</title>
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
                    <h2>Course Report</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Reports</strong>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Course Report</strong>
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
                                <h5>Course Report</h5>
                            </div>
                            <div class="ibox-content">
                                <form method="get" action="courses-report.php" style="margin-bottom: 20px;">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label>Status</label>
                                            <select class="form-control" name="status">
                                                <option value="1" <?php if ($statusFilter === '1') { echo 'selected'; } ?>>Active</option>
                                                <option value="0" <?php if ($statusFilter === '0') { echo 'selected'; } ?>>Inactive</option>
                                                <option value="all" <?php if ($statusFilter === 'all') { echo 'selected'; } ?>>All</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3" style="padding-top: 24px;">
                                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                                            <a href="courses-report.php" class="btn btn-info btn-sm">Clear Filter</a>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example report-table">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Status</th>
                                                <th>Course</th>
                                                <th>Course Code</th>
                                                <th>Course Type</th>
                                                <th>Delivery Method</th>
                                                <th>Scheduled Runs</th>
                                                <th>Enrolled Students</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 0;
                                            while ($course = $courses->fetch_assoc()) {
                                                $count++;
                                            ?>
                                                <tr>
                                                    <td><?php echo $count; ?>.</td>
                                                    <td>
                                                        <?php if ($course['status'] == '1') { ?>
                                                            <span class="label label-primary">Active</span><br>
                                                        <?php } else { ?>
                                                            <span class="label label-default">Not Active</span><br>
                                                        <?php } ?>

                                                        <?php if ($course['isPublished'] == '1') { ?>
                                                            <span class="label label-success">Published</span>
                                                        <?php } else { ?>
                                                            <span class="label label-info">Not Published</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                                                    <td><?php echo htmlspecialchars($course['short']); ?></td>
                                                    <td><?php echo htmlspecialchars($course['course_type']); ?></td>
                                                    <td><?php echo htmlspecialchars($course['delivery_types']); ?></td>
                                                    <td><?php echo (int)$course['total_schedules']; ?></td>
                                                    <td><?php echo (int)$course['total_students']; ?></td>
                                                    <td>
                                                        <a href="<?php echo $adminBasePath; ?>/<?php echo (int)$course['id']; ?>/scheduled-courses-report.php" class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye"></i> View Scheduled Runs
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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