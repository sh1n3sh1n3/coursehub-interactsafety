<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Schedule Course Register</title>
<?php include('includes/head.php'); ?>
<style>
    
hr {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
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
                    <h2>Schedule Course Register</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Schedule Course Register</strong>
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
                        <h5>Course Slots</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" enctype="multipart/form-data" id="form">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10"><select class="form-control" name="isPublished">
                                                <option value="">Select</option>
                                                <option value="1">Published</option>
                                                <option value="2">Not Published</option>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10"><select class="form-control" name="catid">
                                                <option value="">Select</option>
                                                <?php $count=0;
											$contact = $conn->query("SELECT * FROM category WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
											<?php } ?>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 col-form-label">Delivery Method</label>
                                            <div class="col-sm-10"><select class="form-control" name="delivery_types">
                                                <option value="">Select</option>
                                                <option value="Face to Face">Face to Face</option>
                                        <option value="eLearning">eLearning</option>
                                        <option value="Connected Real Time Delivery">Connected Real Time Delivery</option>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 col-form-label">Teacher</label>
                                            <div class="col-sm-10"><select class="form-control" name="teacherid">
                                                <option value="">Select</option>
                                                <?php $count=0;
											$teachers = $conn->query("SELECT * FROM teachers WHERE status='1' order by id ASC");
											while($fetchteachers = $teachers->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetchteachers['id']; ?>"><?php echo $fetchteachers['title']; ?></option>
											<?php } ?>
                                            </select></div>
                                        </div>
                                        <!--<div class="col-lg-4 row">-->
                                        <!--    <label class="col-sm-2 col-form-label">Select Date</label>-->
                                        <!--    <div class="col-sm-10"><input type="date" class="form-control" name="startdate" value=""></div>-->
                                        <!--</div>-->
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <button class="btn btn-primary btn-sm" type="submit" id="submit">Filter</button>
                                            <button class="btn btn-info btn-sm" type="button" id="overall">Overall</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <div class="table-responsive" id="tablebody">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Course</th>
                        <th>Course Type</th>
                        <th>Location</th>
                        <th>Min Capacity</th>
                        <th>Max Capacity</th>
                        <th>Makeup Class Capacity</th>
                        <th>Date & Time</th>
                        <th>Teacher (Request Status)</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					<tbody>
					<?php $count=0; $dates='';
					$queryassoc = $conn->query("SELECT course_slots.id as id,courses.status,courseid,locid,cityid,course_slots.isPublished as published,course_slots.type as course_slots_type,course_slots.teacherid as teacherid,mincapacity,maxcapacity,makecapacity,remarks,createdate,courses.title as coursetitle,location FROM course_slots inner join courses on courseid=courses.id INNER join locations on locid=locations.id order by id DESC, courseid, locid,cityid");
					while($fetch = $queryassoc->fetch_assoc()) {$dates=$invitees='';
					$count++; 
					$fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='".$fetch['courseid']."'")->fetch_assoc();
					$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetch['id']."'");
					while($fetchdates = $course_dates->fetch_assoc()) {
					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
					}$coursecode='';
                    if($fetch['course_slots_type'] == 'private') {
				        $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=".$fetch['id'])->fetch_assoc();
                        $coursecode = ' ('.$fetchprivate['course_code'].')';
                    }
                    $course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='".$fetch['id']."' AND status='1' AND is_deleted='0' ORDER BY id ASC");
                        while($fetchteacherss = $course_teachers->fetch_assoc()) {
                            $fetchteach = $conn->query("SELECT * FROM teachers WHERE id=".$fetchteacherss['teacherid'])->fetch_assoc();
                            if($fetchteacherss['accepted'] == '1') {
                                $checkst = '<i class="fa fa-check-circle text-success" title="Accepted"></i>';
                            } else if($fetchteacherss['accepted'] == '2') {
                                $checkst = '<i class="fa fa-times-circle text-danger" title="Decline"></i>';
                            } else {
                                $checkst = '<i class="fa fa-minus-circle text-info" title="Pending"></i>';
                            }
                            $invitees .= $checkst.' '.$fetchteach['title'].'<hr>';
                        }
					?>
                    <tr>
						<td><?php if($fetch['status']=='1') {echo '<span class="mb-1 label label-primary">Active</span>';}else {echo '<span class="mb-1 label label-default">Not Active</span>';} ?><br>
						<?php if($fetch['published']=='1') {echo '<span class="mb-1 label label-success">Published</span>';}else {echo '<span class="mb-1 label label-info">Not Published</span>';} ?></td>
                        <td><?php echo $fetch['coursetitle'].$coursecode; ?></td>
                        <td><?php echo $fetch['course_slots_type']; ?></td>
                        <td><?php echo $fetch['location']; ?></td>
                        <td><?php echo $fetch['mincapacity']; ?></td>
                        <td><?php echo $fetch['maxcapacity']; ?></td>
                        <td><?php echo $fetch['makecapacity']; ?></td>
                        <td><?php echo $dates; ?></td>
                        <td><?php echo $invitees;?></td>
						<td>
							<a href="editCourseSlots.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a><br>
							<?php if($fetch['published'] == '1') { ?>
							<a href="publishSlots.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-danger btn-sm"><i class="fa fa-times-circle-o"></i> Hide </a><br>
							<?php } else { ?>
							<a href="publishSlots.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-warning btn-sm"><i class="fa fa-bullhorn"></i> Publish </a><br>
							<?php } ?>
							<a target="_blank" href="../courses-preview/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Preview </a>
							<!--<a href="deleteCourseSlots.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Delete </a>-->
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
<script>
    $( document ).ready(function() {
        $("#overall").click(function(){
            $.ajax({
              type: 'POST',
              url: "getcourseschedule.php",
              data: {},
              success: function(resultData) { 
                $("#tablebody").html('').html(resultData);
              }
            });
        });
        $("#form").submit(function(e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.
        
            var form = $(this);

            $.ajax({
                type: "POST",
                url: 'filtercourseschedule.php',
                data: form.serialize(), // serializes the form's elements.
                success: function(data) { console.log(data);
                 $("#tablebody").html('').html(data);
                }
            });
            
        });
    });
</script>
</body>
</html>