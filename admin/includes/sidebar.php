<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<img alt="image" class="" src="../images/logo/logo.png" style="width:auto;height:48px"/>
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo $admin['name']; ?></span>
                        <span class="text-muted text-xs block"><?php echo $admin['email']; ?> <b class="caret"></b></span>
                    </a>
					<ul class="dropdown-menu animated fadeInRight m-t-xs">
						<li><a class="dropdown-item" href="emails.php">Email Settings</a></li>
						<li><a class="dropdown-item" href="profile.php">Profile</a></li>
						<li><a class="dropdown-item" href="changepassword.php">Change Password</a></li>
						<li><a class="dropdown-item" href="logout.php">Logout</a></li>
					</ul>
				</div>
				<div class="logo-element">
					<img alt="image" class="rounded-circle" src="../images/logo/logo.png" style="width:58px;height:48px"/>
				</div>
			</li>
			<?php $activePage = basename($_SERVER['PHP_SELF'], ".php"); ?>
			<li class="<?= (($activePage == 'index')) ? 'active':''; ?>">
				<a href="index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
			</li>
			<li class="<?= (($activePage == 'media') || ($activePage == 'Addmedia')) ? 'active':''; ?>">
				<a href="media.php"><i class="fa fa-image"></i> <span class="nav-label">Media</span></a>
			</li>
			<li class="<?= (($activePage == 'addIndustry') || ($activePage == 'industry')|| ($activePage == 'editIndustry') || ($activePage == 'about') || ($activePage == 'course-content') || ($activePage == 'notification') || ($activePage == 'aboutvideo') || ($activePage == 'count') || ($activePage == 'offers') || ($activePage == 'editOffer') || ($activePage == 'locations') || ($activePage == 'addLocations') || ($activePage == 'editLocations') || ($activePage == 'support') || ($activePage == 'information')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-globe"></i> <span class="nav-label">Content</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'about')) ? 'active':''; ?>"><a href="about.php">About Us</a></li>
					<li  class="<?= (($activePage == 'information')) ? 'active':''; ?>"><a href="information.php">Information</a></li>
					<li  class="<?= (($activePage == 'count')) ? 'active':''; ?>"><a href="count.php">Web counts</a></li>
					<li class="<?= (($activePage == 'addLocations') || ($activePage == 'locations')|| ($activePage == 'editLocations')) ? 'active':''; ?>">
						<a href="#"><span class="nav-label">Locations</span><span class="fa arrow"></span></a>
						<ul class="nav nav-second-level collapse">
							<li  class="<?= (($activePage == 'addLocations')) ? 'active':''; ?>"><a href="addLocations.php">Add Location</a></li>
							<li  class="<?= (($activePage == 'locations')||($activePage == 'checklist')|| ($activePage == 'editLocations')) ? 'active':''; ?>"><a href="locations.php">Location Register</a></li>
						</ul>
				    </li>
				    <li class="<?= (($activePage == 'addIndustry') || ($activePage == 'industry')|| ($activePage == 'editIndustry')) ? 'active':''; ?>">
						<a href="#"><span class="nav-label">Industry Type</span><span class="fa arrow"></span></a>
						<ul class="nav nav-second-level collapse">
							<li  class="<?= (($activePage == 'addIndustry')) ? 'active':''; ?>"><a href="addIndustry.php">Add Industry</a></li>
							<li  class="<?= (($activePage == 'industry')||($activePage == 'checklist')|| ($activePage == 'editIndustry')) ? 'active':''; ?>"><a href="industry.php">Industry Register</a></li>
						</ul>
				    </li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'users')) ? 'active':''; ?>">
				<a href="users.php"><i class="fa fa-users"></i> <span class="nav-label">Student Register</span></a>
			</li>
			<li class="<?= (($activePage == 'extensionRequest')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-folder"></i> <span class="nav-label">Extension Request</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'extensionRequest')) ? 'active':''; ?>"><a href="extensionRequest.php">All Extension Requests</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'makeupRequests') || ($activePage == 'absentStudents')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-folder"></i> <span class="nav-label">Absent Students</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'makeupRequests')) ? 'active':''; ?>"><a href="makeupRequests.php">Makeup Class Request</a></li>
					<li  class="<?= (($activePage == 'absentStudents')) ? 'active':''; ?>"><a href="absentStudents.php">Absent Students</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'addmakeupClass') || ($activePage == 'makeupClass')|| ($activePage == 'editmakeupClass')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-clock-o"></i> <span class="nav-label">Makeup Classes</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addmakeupClass')) ? 'active':''; ?>"><a href="addmakeupClass.php">Add Makeup Class</a></li>
					<li  class="<?= (($activePage == 'makeupClass')|| ($activePage == 'editmakeupClass')) ? 'active':''; ?>"><a href="makeupClass.php">Makeup Classes</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'addCategory') || ($activePage == 'category')|| ($activePage == 'editCategory')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-graduation-cap"></i> <span class="nav-label">Course Category</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addCategory')) ? 'active':''; ?>"><a href="addCategory.php">Add Category</a></li>
					<li  class="<?= (($activePage == 'category')|| ($activePage == 'editCategory')) ? 'active':''; ?>"><a href="category.php">Category Register</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'course_detail') || ($activePage == 'addCourse') || ($activePage == 'courses')|| ($activePage == 'editCourse')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-graduation-cap"></i> <span class="nav-label">Courses</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
				    
					<li  class="<?= (($activePage == 'addCourse')) ? 'active':''; ?>"><a href="addCourse.php">Add Course</a></li>
					<li  class="<?= (($activePage == 'courses')|| ($activePage == 'editCourse')) ? 'active':''; ?>"><a href="courses.php">Course Register</a></li>
					
				</ul>
			</li>
				<li class="<?= (($activePage == 'courseslots') || ($activePage == 'addCourseSlots') || ($activePage == 'courseslots')|| ($activePage == 'editCourseSlots')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-table"></i> <span class="nav-label">Schedule Course</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
				    
					<li  class="<?= (($activePage == 'addCourseSlots')) ? 'active':''; ?>"><a href="addCourseSlots.php">Schedule Course</a></li>
					<li  class="<?= (($activePage == 'courseslots')|| ($activePage == 'editCourseSlots')) ? 'active':''; ?>"><a href="courseslots.php">Scheduled Course Register</a></li>
					
				</ul>
			</li>
			<li class="<?= (($activePage == 'completeRegister') || ($activePage == 'courseHub')||($activePage == 'courseScope')||($activePage == 'attandanceRegister')|| ($activePage == 'participantIndustry')|| ($activePage == 'studentProfile')|| ($activePage == 'courseDeivery')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-newspaper-o"></i> <span class="nav-label">Reports</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<!--<li  class="<?= (($activePage == 'coursecatReport')) ? 'active':''; ?>"><a href="coursecatReport.php">Course Category Report</a></li>-->
					<li  class="<?= (($activePage == 'courseHub')) ? 'active':''; ?>"><a href="courseHub.php">Course Hub</a></li>
					<li  class="<?= (($activePage == 'courseScope')) ? 'active':''; ?>"><a href="courseScope.php">Course Scope</a></li>
					<li  class="<?= (($activePage == 'attandanceRegister')) ? 'active':''; ?>"><a href="attandanceRegister.php">Course Register</a></li>
					<li  class="<?= (($activePage == 'completeRegister')) ? 'active':''; ?>"><a href="completeRegister.php">Student Register</a></li>
					<li  class="<?= (($activePage == 'participantIndustry')) ? 'active':''; ?>"><a href="participantIndustry.php">Industry Type</a></li>
					<li  class="<?= (($activePage == 'courseDeivery')) ? 'active':''; ?>"><a href="courseDeivery.php">Course Delivery</a></li>
					<li  class="<?= (($activePage == 'studentProfile')) ? 'active':''; ?>"><a href="studentProfile.php">Student Profile</a></li>
				</ul>
		    </li>
			<li class="<?= (($activePage == 'addServicesCategory') || ($activePage == 'servicescategory')|| ($activePage == 'editServicesCategory')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-handshake-o"></i> <span class="nav-label">Consultation Services</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addServicesCategory')) ? 'active':''; ?>"><a href="addServicesCategory.php">Add Services Category</a></li>
					<li  class="<?= (($activePage == 'services')|| ($activePage == 'editServicesCategory')) ? 'active':''; ?>"><a href="servicescategory.php">All Services Category</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'addServices') || ($activePage == 'services')|| ($activePage == 'editServices')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-building-o"></i> <span class="nav-label">Services</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addServices')) ? 'active':''; ?>"><a href="addServices.php">Add Services</a></li>
					<li  class="<?= (($activePage == 'services')|| ($activePage == 'editServices')) ? 'active':''; ?>"><a href="services.php">Service Register</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'addTeachers') || ($activePage == 'teachers')|| ($activePage == 'editTeachers')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-industry"></i> <span class="nav-label">Teachers</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addTeachers')) ? 'active':''; ?>"><a href="addTeachers.php">Add Teachers</a></li>
					<li  class="<?= (($activePage == 'teachers')|| ($activePage == 'editTeachers')) ? 'active':''; ?>"><a href="teachers.php">Teacher Register</a></li>
				</ul>
			</li>
			<li class="<?= (($activePage == 'addClient') || ($activePage == 'client')|| ($activePage == 'editClient')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Clients</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addClient')) ? 'active':''; ?>"><a href="addClient.php">Add Client</a></li>
					<li  class="<?= (($activePage == 'client')|| ($activePage == 'editClient')) ? 'active':''; ?>"><a href="client.php">Client Register</a></li>
				</ul>
		    </li>	
		<!--	<li class="<?= (($activePage == 'addBlog') || ($activePage == 'blogs')|| ($activePage == 'editBlog')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Blog</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
				    
					<li  class="<?= (($activePage == 'addBlog')) ? 'active':''; ?>"><a href="addBlog.php">Add Blog</a></li>
					<li  class="<?= (($activePage == 'blogs')|| ($activePage == 'editBlog')) ? 'active':''; ?>"><a href="blogs.php">All Blog</a></li>
					
				</ul>
			</li>
			<li class="<?= (($activePage == 'addTestimonial') || ($activePage == 'testimonials')|| ($activePage == 'editTestimonial')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-quote-left"></i> <span class="nav-label">Testimonials</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'addTestimonial')) ? 'active':''; ?>"><a href="addTestimonial.php">Add Testimonials</a></li>
					<li  class="<?= (($activePage == 'testimonials')|| ($activePage == 'editTestimonial')) ? 'active':''; ?>"><a href="testimonials.php">Testimonial Register</a></li>
				</ul>
		    </li>-->
			<li class="<?= (($activePage == 'privacy') || ($activePage == 'terms')|| ($activePage == 'refund')) ? 'active':''; ?>">
				<a href="#"><i class="fa fa-lock"></i> <span class="nav-label">Policies</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li  class="<?= (($activePage == 'privacy')) ? 'active':''; ?>"><a href="privacy.php">Privacy Policy</a></li>
					<li  class="<?= (($activePage == 'terms')) ? 'active':''; ?>"><a href="terms.php">Booking Terms and Conditions</a></li>
					<li  class="<?= (($activePage == 'social-media')) ? 'active':''; ?>"><a href="social-media.php">Social Media Policy</a></li>
				</ul>
			</li>
		</ul>

	</div>
</nav>