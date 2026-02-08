<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
	<?php include('includes/head.php'); ?>
</head>

<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <?php include('includes/header.php'); 
		$students = $conn->query("SELECT * FROM registration WHERE status='1'")->num_rows;
		$courses = $conn->query("SELECT * FROM courses")->num_rows;
		$contact = $conn->query("SELECT * FROM contact")->num_rows;?>
        </div>
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
                <div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-content">
							<div class="table-responsive">
								<h1>Welcome Admin</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title">
							<span class="label label-success float-right">Total</span>
							<h5>Users</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins"><?php echo $students; ?></h1>
							<small>Total Users</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title">
							<span class="label label-success float-right">Total</span>
							<h5>Courses</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins"><?php echo $courses; ?></h1>
							<small>Total Courses</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title">
							<span class="label label-success float-right">Total</span>
							<h5>Contact Queries</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins"><?php echo $contact; ?></h1>
							<small>Total Contact Queries</small>
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