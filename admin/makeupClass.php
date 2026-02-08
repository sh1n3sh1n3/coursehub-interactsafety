<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Makeup Classes</title>
<?php include('includes/head.php'); ?>
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
                    <h2>Makeup Classes Register</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Makeup Classes Register</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Makeup Classes</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive" id="tablebody">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <!--<th>Action</th>-->
                        <th>Status</th>
                        <th>Course</th>
                        <th>Student</th>
                        <th>Makeup Day</th>
                        <th>Location</th>
                        <th>Course Slot</th>
                        <th>Created</th>
                    </tr>
                    </thead>
					<tbody>
					<?php $count=0;$starttimeh ='';
					$queryassoc = $conn->query("SELECT * FROM makeup_classes WHERE isDeleted='0'");
					while($fetch = $queryassoc->fetch_assoc()) {$starttimeh = $endtimeh ='';
					$count++; 
                    $course = $conn->query("SELECT * FROM courses WHERE id=".$fetch['courseid'])->fetch_assoc();
                    $fetchers = $conn->query("SELECT * FROM registration WHERE id=".$fetch['studentid'])->fetch_assoc();
                    $fetchcouslot = $conn->query("SELECT * FROM course_slots WHERE id=".$fetch['slotid'])->fetch_assoc();
                    $location = $conn->query("SELECT * FROM locations WHERE id=".$fetchcouslot['locid'])->fetch_assoc();
                    $cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcouslot['cityid'])->fetch_assoc();
                    $states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
                    $cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date ASC");
                    while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
                        $startdate = date('Y-m-d', strtotime($fetchdates['date']));
                        if($fetch['date'] == $startdate) {
                            $starttimeh = date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime']));
                        }
                    }
					?>
                    <tr>
						<!--<td>-->
							<!--<a href="editmakeupClass.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a><br>-->
							<!--<a href="deletemakeupClass.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Delete </a>-->
						<!--</td>-->
						<td><?php if($fetch['status']=='1') {echo '<span class="mb-1 label label-primary">Active</span>';}else {echo '<span class="mb-1 label label-default">Not Active</span>';} ?></td>
                        <td><?php echo $course['title']; ?></td>
                        <td><?php echo $fetchers['title'].' '.$fetchers['fname'].' '.$fetchers['lname']; ?></td>
                        <td><?php echo $fetch['makeupday']; ?></td>
                        <td><?php echo $location['title'].' '.$location['location'].' '.$cities['name'].' '.$states['name']; ?></td>
                        <td><?php echo date('d-M-Y', strtotime($fetch['date'])).' '.$starttimeh; ?></td>
                        <td><?php echo date('d-M-Y', strtotime($fetch['created'])); ?></td>
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