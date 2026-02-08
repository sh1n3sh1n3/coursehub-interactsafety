<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Extension Request</title>
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
                    <h2>Extension Request</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Extension Request</strong>
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
                    <div class="ibox-title" style="padding:0">
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Extension Request</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
							<tr>
								<th>Sr. No.</th>
								<th>Form Submitted by</th>
								<th>Submission date</th>
								<th>Participant fullname</th>
								<th>Course start date</th>
								<th>Days missed</th>
								<th>Expected date</th>
								<th>Reason</th>
							</tr>
							</thead>
							<tbody id="tablebody">
							<?php $count=0;
							$contact = $conn->query("SELECT * FROM makeup_form order by id desc");
							while($fetch = $contact->fetch_assoc()) { $count++;
								?>
							<tr>
								<td><?php echo $count; ?>. </td>
								<td><?php echo $fetch['submittedby']; ?></td>
								<td><?php echo date('d-M-Y', strtotime($fetch['ondate'])); ?></td>
								<td><?php echo $fetch['fullname']; ?></td>
								<td><?php echo date('d-M-Y', strtotime($fetch['course_date'])); ?></td>
								<td>Days <?php echo $fetch['missed_days']; ?></td>
								<td><?php echo date('d-M-Y', strtotime($fetch['expected_date'])); ?></td>
								<td><?php echo $fetch['reason']; ?></td>
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