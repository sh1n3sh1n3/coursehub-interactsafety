<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
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
                    <h2>Jobs</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Jobs</strong>
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
                        <h5>Jobs</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Contact Info</th>
                        <th>Company</th>
                        <th>Job Location</th>
                        <th>Job type</th>
                        <th>Job Position</th>
                        <th>Website</th>
                        <th>Description</th>
                        <th>Initials</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM jobs order by id ASC");
					while($fetch = $contact->fetch_assoc()) {$count++; ?>
                    <tr>
						<td>
							<a href="editJob.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
							<a href="deleteJob.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Delete </a>
							<a href="ChangeStatus.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Update </a>
						</td>
						<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
                        <td><?php echo $fetch['name']; ?><br>
						<?php echo $fetch['email']; ?><br>
						<?php echo $fetch['phone']; ?></td>
                        <td><?php echo $fetch['company']; ?></td>
                        <td><?php echo $fetch['location']; ?></td>
                        <td><?php echo $fetch['type']; ?></td>
                        <td><?php echo $fetch['position']; ?></td>
                        <td><?php echo $fetch['website']; ?></td>
                        <td><?php $string = strip_tags($fetch['description']);
							if (strlen($string) > 85) {

								// truncate string
								$stringCut = substr($string, 0, 85);
								$endPoint = strrpos($stringCut, ' ');

								//if the string doesn't contain any space then it will cut without word basis.
								$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
								$string .= '... ';
							}
							echo $string;?></td>
                        <td><?php echo $fetch['initials']; ?></td>
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