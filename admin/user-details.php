<?php include('session.php');

function getUserStatusLabel($status)
{
    return $status == '1' ? 'Active' : 'Not Active';
}

function getUserHsrLabel($value)
{
    if ($value == '1') {
        return 'HSR';
    } elseif ($value == '2') {
        return 'Deputy HSR';
    } elseif ($value == '3') {
        return 'Supervisor';
    } elseif ($value == '5') {
        return 'Other';
    }

    return '-';
}

function displayValue($value)
{
    $value = is_string($value) ? trim($value) : $value;
    if ($value === null || $value === '') {
        return '-';
    }

    return (string)$value;
}

function hasValue($value)
{
    return trim((string)$value) !== '';
}

$user = false;
$userId = 0;
$userName = 'User Details';
$firstOrderDate = '-';
$latestCourseTitle = '-';
$totalOrders = 0;
$industryTitle = '-';

if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
    $userId = (int) $_GET['id'];
    $user = $conn->query("SELECT * FROM registration WHERE id=" . $userId)->fetch_assoc();

    if ($user) {
        $userName = trim($user['title'] . ' ' . $user['fname'] . ' ' . $user['lname']);
        $firstOrder = $conn->query("SELECT date FROM sale WHERE user='" . $userId . "' ORDER BY id ASC LIMIT 1")->fetch_assoc();
        $latestOrder = $conn->query("SELECT * FROM sale WHERE user='" . $userId . "' ORDER BY id DESC LIMIT 1")->fetch_assoc();
        $totalOrders = $conn->query("SELECT COUNT(*) AS count FROM sale WHERE user='" . $userId . "'")->fetch_assoc();

        if ($firstOrder && !empty($firstOrder['date'])) {
            $firstOrderDate = date('d-M-Y', strtotime($firstOrder['date']));
        }

        if ($latestOrder) {
            $latestCourse = $conn->query("SELECT * FROM courses WHERE id='" . $latestOrder['courseid'] . "'")->fetch_assoc();
            if ($latestCourse) {
                $latestCourseTitle = $latestCourse['title'];
            }
        }

        $industryId = !empty($user['industry_type']) ? $user['industry_type'] : ($latestOrder['industry_type'] ?? '');
        if (!empty($industryId)) {
            $industry = $conn->query("SELECT * FROM industry_type WHERE id='" . (int) $industryId . "'")->fetch_assoc();
            if ($industry) {
                $industryTitle = $industry['title'];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo htmlspecialchars($userName); ?></title>
    <?php include('includes/head.php'); ?>
    <style>
        .details-table th {
            width: 38%;
            white-space: nowrap;
            background: #f8f8f8;
        }
        .details-table th,
        .details-table td {
            vertical-align: middle !important;
            padding: 10px 12px !important;
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
                    <h2><?php echo htmlspecialchars($userName); ?></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="users.php">Registered Students</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong><?php echo htmlspecialchars($userName); ?></strong>
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
                                <h5>User Details</h5>
                            </div>
                            <div class="ibox-content">
                                <?php if (!$user) { ?>
                                    <div class="alert alert-danger">User not found.</div>
                                <?php } else { ?>
                                    <div style="margin-bottom: 15px;">
                                        <a href="users.php" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back to Registered Students</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <table class="table table-bordered details-table">
                                                <tbody>
                                                    <tr>
                                                        <th>Student ID</th>
                                                        <td><?php echo htmlspecialchars(displayValue(strtoupper((string)$user['generated_code']))); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Full Name</th>
                                                        <td><?php echo htmlspecialchars(displayValue(trim($user['title'] . ' ' . $user['fname'] . ' ' . $user['lname']))); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status</th>
                                                        <td><?php echo htmlspecialchars(getUserStatusLabel($user['status'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Email</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['email'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Role</th>
                                                        <td><?php echo htmlspecialchars(getUserHsrLabel($user['hsr_or_not'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Company</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['company'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Industry</th>
                                                        <td><?php echo htmlspecialchars(displayValue($industryTitle)); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-6">
                                            <table class="table table-bordered details-table">
                                                <tbody>
                                                    <tr>
                                                        <th>Workplace Contact</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['workplace_contact'])); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Workplace Email</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['workplace_email'])); ?></td>
                                                    </tr>
                                                    <?php if (hasValue($user['workplace_phone'])) { ?>
                                                    <tr>
                                                        <th>Workplace Phone</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['workplace_phone'])); ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if (hasValue($user['food_requirements'])) { ?>
                                                    <tr>
                                                        <th>Food Requirements</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['food_requirements'])); ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if (hasValue($user['special_requirements'])) { ?>
                                                    <tr>
                                                        <th>Special Requirements</th>
                                                        <td><?php echo htmlspecialchars(displayValue($user['special_requirements'])); ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <th>First Registered Date</th>
                                                        <td><?php echo htmlspecialchars(displayValue($firstOrderDate)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Latest Course Enrolled</th>
                                                        <td><?php echo htmlspecialchars(displayValue($latestCourseTitle)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Orders</th>
                                                        <td><?php echo (int) ($totalOrders['count'] ?? 0); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($user) { ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5><?php echo htmlspecialchars($userName); ?> Orders</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Date</th>
                                                    <th>Invoice No</th>
                                                    <th>Order No</th>
                                                    <th>Payment Id</th>
                                                    <th>Amount</th>
                                                    <th>Course Type</th>
                                                    <th>Course</th>
                                                    <th>Course Slot</th>
                                                    <th>Location</th>
                                                    <th>Teacher</th>
                                                    <th>Attandance</th>
                                                    <th>Certificate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $count = 0;
                                                $contact = $conn->query("SELECT * FROM sale WHERE user='" . $userId . "' ORDER BY id DESC");
                                                while ($fetch = $contact->fetch_assoc()) {
                                                    $dates = $invitees = '';
                                                    $count++;
                                                    $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='" . $fetch['courseid'] . "'")->fetch_assoc();
                                                    $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE courseid='" . $fetch['courseid'] . "' AND id='" . $fetch['slotid'] . "'")->fetch_assoc();
                                                    $course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='" . $sqlcourseslot['id'] . "'");
                                                    while ($fetchdates = $course_dates->fetch_assoc()) {
                                                        $dates .= date('d-M-Y', strtotime($fetchdates['date'])) . ' (' . date('h:i A', strtotime($fetchdates['starttime'])) . ' - ' . date('h:i A', strtotime($fetchdates['endtime'])) . ')';
                                                    }
                                                    $coursecode = '';
                                                    $private_course = $conn->query("SELECT * FROM private_course WHERE slot_id='" . $sqlcourseslot['id'] . "'")->fetch_assoc();
                                                    if ($sqlcourseslot['type'] == 'private') {
                                                        $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=" . $sqlcourseslot['id'])->fetch_assoc();
                                                        $coursecode = ' (' . $fetchprivate['course_code'] . ')';
                                                    }
                                                    $sqllocation = $conn->query("SELECT * FROM locations WHERE id='" . $sqlcourseslot['locid'] . "'")->fetch_assoc();
                                                    $cities = $conn->query("SELECT * FROM cities WHERE id=" . $sqlcourseslot['cityid'])->fetch_assoc();
                                                    $amt = $sqlcourseslot['type'] == 'private' ? ($private_course['course_fees'] ?? '0') : $fetch['amount'];
                                                    $course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='" . $sqlcourseslot['id'] . "' AND status='1' AND is_deleted='0' ORDER BY id ASC");
                                                    while ($fetchteacherss = $course_teachers->fetch_assoc()) {
                                                        $fetchteach = $conn->query("SELECT * FROM teachers WHERE id=" . $fetchteacherss['teacherid'])->fetch_assoc();
                                                        if ($fetchteacherss['accepted'] == '1') {
                                                            $checkst = '<i class="fa fa-check-circle text-success" title="Accepted"></i>';
                                                        } elseif ($fetchteacherss['accepted'] == '2') {
                                                            $checkst = '<i class="fa fa-times-circle text-danger" title="Decline"></i>';
                                                        } else {
                                                            $checkst = '<i class="fa fa-minus-circle text-info" title="Pending"></i>';
                                                        }
                                                        $invitees .= $checkst . ' ' . $fetchteach['title'];
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo $count; ?>.</td>
                                                        <td><?php echo date('d-M-Y', strtotime($fetch['date'])); ?></td>
                                                        <td><?php echo htmlspecialchars($fetch['invoiceno']); ?></td>
                                                        <td><?php echo htmlspecialchars($fetch['orderno']); ?></td>
                                                        <td><?php echo htmlspecialchars($fetch['paymentid']); ?></td>
                                                        <td>$<?php echo htmlspecialchars($amt); ?></td>
                                                        <td><?php echo htmlspecialchars(ucfirst($sqlcourseslot['type'])) . '<br>' . htmlspecialchars($coursecode); ?></td>
                                                        <td><a href="<?php echo (int) $fetch['courseid']; ?>/scheduled-courses-report.php"><?php echo htmlspecialchars($sqlcourses['title']); ?></a></td>
                                                        <td><a href="<?php echo (int) $fetch['courseid']; ?>/<?php echo (int) $fetch['slotid']; ?>/students-report.php"><?php echo $dates; ?></a></td>
                                                        <td><?php echo htmlspecialchars($cities['name'] . ' - ' . $sqllocation['location'] . ' (' . $sqllocation['title'] . ')'); ?></td>
                                                        <td><?php echo $invitees; ?></td>
                                                        <td><a class="btn btn-info" href="javascript:" onclick="getattandace(<?php echo $fetch['user']; ?>, <?php echo $fetch['courseid']; ?>, <?php echo $fetch['slotid']; ?>)">View</a></td>
                                                        <td>
                                                            <?php if ($fetch['generateCertificate'] == '1') { ?>
                                                                <a class="btn btn-dark" target="_blank" href="certificate.php?id=<?php echo $fetch['id']; ?>">View</a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-default disabled">Not Issued</span>
                                                            <?php } ?>
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
                <?php } ?>
            </div>
            <div id="attandanceModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" id="AttandanceBody">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php'); ?>
        </div>
    </div>
    <?php include('includes/foot.php'); ?>
    <script>
        function getattandace(user, course, slot) {
            $.ajax({
                type: "POST",
                url: 'getAttandance.php',
                data: {
                    user: user,
                    course: course,
                    slot: slot
                },
                success: function(res) {
                    $("#AttandanceBody").html('').html(res);
                    $('#attandanceModal').modal('toggle');
                }
            });
        }
    </script>
</body>

</html>