<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<img alt="Interact Safety" class="" src="../images/logo/logo.svg" style="width:180px;max-width:100%;height:auto;"/>
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo $teacher['title']; ?></span>
                        <span class="text-muted text-xs block"><?php echo $teacher['email']; ?> <b class="caret"></b></span>
                    </a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a class="dropdown-item" href="profile.php">Profile</a></li>
						<li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
						<li><a class="dropdown-item" href="logout.php">Logout</a></li>
					</ul>
				</div>
				<div class="logo-element">
					<img alt="Interact Safety" class="" src="../images/logo/logo.svg" style="width:58px;height:auto;max-width:100%;"/>
				</div>
			</li>
			<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
			<li class="<?= (($activePage == 'dashboard')) ? 'active':''; ?>">
				<a href="dashboard.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
			</li>
			<li class="<?= (($activePage == 'courses-invite')) ? 'active':''; ?>">
				<a href="courses-invite.php"><i class="fa fa-list"></i> <span class="nav-label">Course Invite</span></a>
			</li>
			<li class="<?= (($activePage == 'courses')) ? 'active':''; ?>">
				<a href="courses.php"><i class="fa fa-check"></i> <span class="nav-label">Courses Accept</span></a>
			</li>
			<li class="<?= (($activePage == 'coursesDecline')) ? 'active':''; ?>">
				<a href="coursesDecline.php"><i class="fa fa-close"></i> <span class="nav-label">Courses Decline</span></a>
			</li>
			<!--<li class="<?= (($activePage == 'calender')) ? 'active':''; ?>">
				<a href="calender.php"><i class="fa fa-calendar"></i> <span class="nav-label">Calender</span></a>
			</li>-->
		</ul>

	</div>
</nav>