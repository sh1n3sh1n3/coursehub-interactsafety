<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<?php include('includes/head.php'); ?>
</head>

<body>
    <div id="wrapper">
        <?php include('includes/sidebar.php'); ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <?php include('includes/header.php'); 
		$courseaccept =$conn->query("SELECT * FROM course_teachers WHERE teacherid='".$_SESSION['teacher']."' AND accepted='1' AND status='1' AND is_deleted='0' order by id DESC")->num_rows;
		$courseinvite =$conn->query("SELECT * FROM course_teachers WHERE teacherid='".$_SESSION['teacher']."' AND accepted='0' AND status='1' AND is_deleted='0' order by id DESC")->num_rows;
		$coursedecline =$conn->query("SELECT * FROM course_teachers WHERE teacherid='".$_SESSION['teacher']."' AND accepted='2' AND status='1' AND is_deleted='0' order by id DESC")->num_rows;
		?>
        </div>
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
                <div class="col-lg-12">
					<div class="ibox ">
						<div class="ibox-content">
							<div class="table-responsive">
								<h1>Welcome Teacher</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title">
							<span class="label label-success float-right">Total</span>
							<h5>Course Invite</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins"><?php echo $courseinvite; ?></h1>
							<small>Total Users</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title">
							<span class="label label-success float-right">Total</span>
							<h5>Course Accepted</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins"><?php echo $courseaccept; ?></h1>
							<small>Total Users</small>
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title">
							<span class="label label-success float-right">Total</span>
							<h5>Course Decline</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins"><?php echo $coursedecline; ?></h1>
							<small>Total Users</small>
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