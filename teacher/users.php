<?php include('session.php');
$slot_id = $_GET['id'];
$fetchslot = $conn->query("SELECT * FROM course_slots WHERE id=".$slot_id)->fetch_assoc();
$fetchcourse = $conn->query("SELECT * FROM courses WHERE id=".$fetchslot['courseid'])->fetch_assoc();
$fetchdetail = $conn->query("SELECT * FROM course_teachers WHERE teacherid='".$_SESSION['teacher']."' AND accepted='1' AND slot_id='".$fetchslot['id']."' And status='1' AND is_deleted='0'");
if($fetchdetail->num_rows > 0) {} else {
    echo '<script>window.location.href="courses.php";</script>';
}
$cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchslot['id']."' ORDER BY date ASC");
while($fetchdates = $cpurse_dates->fetch_assoc()) {
    $startdate = date('d/M/Y', strtotime($fetchdates['date']));
    $starttimeh = date('h:i A', strtotime($fetchdates['starttime']));
    $endtimeh = date('h:i A', strtotime($fetchdates['endtime']));
}
?>
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
                    <h2><?php echo $fetchcourse['title']; ?> Students</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong><?php echo $fetchcourse['title']; ?> Students</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;"><?php echo $fetchcourse['title']; ?> Students</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
							<tr>
								<th>Sr. No.</th>
								<th>User Status</th>
								<th>Name</th>
								<!--<th>Phone</th>-->
								<th>Email</th>
								<th>Course</th>
								<th>Slot</th>
								<th>Location</th>
								<th>Attandance</th>
								<th>Certificate</th>
							</tr>
							</thead>
							<tbody>
							<?php $count=0;$dates='';
							$contact = $conn->query("SELECT * FROM sale WHERE slotid = '".$fetchslot['id']."' order by id desc");
							while($data = $contact->fetch_assoc()) {
								$count++;$id = $data['id'];
								$fetch = $conn->query("SELECT * FROM registration WHERE id=".$data['user'])->fetch_assoc();
                                $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$data['courseid']."'")->fetch_assoc();
                                $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE id='".$data['slotid']."'")->fetch_assoc();
								$sqllocation = $conn->query("SELECT * FROM locations WHERE id='".$sqlcourseslot['locid']."'")->fetch_assoc();
								$cities = $conn->query("SELECT * FROM cities WHERE id=".$sqlcourseslot['cityid'])->fetch_assoc();
								$dates='';
								$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchslot['id']."'");
            					while($fetchdates = $course_dates->fetch_assoc()) {
            					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
            					}
								?>
							<tr>
								<td><?php echo $count; ?>. </td>
								<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
								<td><?php echo $fetch['title'].' '.$fetch['fname'].' '.$fetch['lname']; ?></td>
								<!--<td><?php echo $fetch['phone']; ?></td>-->
								<td><?php echo $fetch['email']; ?></td>
                                <td><?php echo $sqlcourses['title']; ?></td>
                                <td><?php echo $dates; ?></td>
                                <td> <?php echo $cities['name'].' - '.$sqllocation['location'].' ('.$sqllocation['title'].')'; ?></td>
								<td><a class="btn btn-info btn-xs" href="javascript:" onclick="getattandace(<?php echo $fetch['id']; ?>, <?php echo $data['courseid']; ?>, <?php echo $data['slotid']; ?>, <?php echo $_SESSION['teacher']; ?>)">View</a></td>
								<td><a class="btn btn-dark btn-xs" target="_blank" href="certificate.php?id=<?php echo $data['id']; ?>">View</a><br>
								<?php if($data['generateCertificate'] == '1') { ?>
								<a class="btn btn-warning btn-xs" href="genCertificate.php?id=<?php echo $data['id']; ?>&pid=<?php echo $_GET['id']; ?>">Hide to Student</a></td>
								<?php } else { ?>
								<a class="btn btn-warning btn-xs" href="genCertificate.php?id=<?php echo $data['id']; ?>&pid=<?php echo $_GET['id']; ?>">Show to Student</a></td>
								<?php } ?>
							</tr>
							<?php } ?>
							<?php $count=0;$dates='';
							$contact1 = $conn->query("SELECT * FROM makeup_classes WHERE slotid = '".$fetchslot['id']."' order by id desc");
							while($data = $contact1->fetch_assoc()) {
								$count++;$id = $data['id'];
								$fetch = $conn->query("SELECT * FROM registration WHERE id=".$data['studentid'])->fetch_assoc();
                                $sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$data['courseid']."'")->fetch_assoc();
                                $sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE id='".$data['slotid']."'")->fetch_assoc();
								$sqllocation = $conn->query("SELECT * FROM locations WHERE id='".$sqlcourseslot['locid']."'")->fetch_assoc();
								$cities = $conn->query("SELECT * FROM cities WHERE id=".$sqlcourseslot['cityid'])->fetch_assoc();
								$dates='';
								$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchslot['id']."'");
            					while($fetchdates = $course_dates->fetch_assoc()) {
            					    if($data['date'] == $fetchdates['date']) {
            					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
            					    }
            					}
								?>
							<tr>
								<td><?php echo $count; ?>. </td>
								<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
								<td><?php echo $fetch['title'].' '.$fetch['fname'].' '.$fetch['lname']; ?></td>
								<!--<td><?php echo $fetch['phone']; ?></td>-->
								<td><?php echo $fetch['email']; ?></td> 
                                <td><?php echo $sqlcourses['title']; ?></td>
                                <td><?php echo $dates; ?></td>
                                <td> <?php echo $cities['name'].' - '.$sqllocation['location'].' ('.$sqllocation['title'].')'; ?></td>
								<td><a class="btn btn-info btn-xs" href="javascript:" onclick="getattandace(<?php echo $fetch['id']; ?>, <?php echo $data['courseid']; ?>, <?php echo $data['slotid']; ?>, <?php echo $_SESSION['teacher']; ?>)">View</a></td>
								<td><a class="btn btn-dark btn-xs" target="_blank" href="certificate.php?id=<?php echo $data['id']; ?>">View</a><br>
								<?php if($data['generateCertificate'] == '1') { ?>
								<a class="btn btn-warning btn-xs" href="genCertificate.php?id=<?php echo $data['id']; ?>&pid=<?php echo $_GET['id']; ?>">Hide to Student</a></td>
								<?php } else { ?>
								<a class="btn btn-warning btn-xs" href="genCertificate.php?id=<?php echo $data['id']; ?>&pid=<?php echo $_GET['id']; ?>">Show to Student</a></td>
								<?php } ?>
							</tr>
							<?php } ?>
							</tbody>
							</table>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div id="attandanceModal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">
            
                <!-- Modal content-->
                <div class="modal-content" id="AttandanceBody">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    function getattandace(user, course, slot, teacher) {
        $.ajax({
    		type: "POST",
    		url: 'getAttandance.php',
    		data:{user: user, course: course, slot: slot, teacher: teacher},
    		success: function(res){
    			$("#AttandanceBody").html('').html(res);
    			$('#attandanceModal').modal('toggle');
    		}
       });   
    }
    function verify(id) {
        $.ajax({
    		type: "POST",
    		url: 'verifyAttandance.php',
    		data:{id:id},
    		success: function(resp){ console.log(resp);
    		    if(resp == '1') {
    		        $(".sucmsg").css('display', 'block');
    			    $("#sucmsg").text('').text('Attandance verified.');
    		    } else {
    		        $(".errmsg").css('display', 'block');
    			    $("#errmsg").text('').text('Something wrong!');
    		    }
    		}
       });  
    }
    function remove(id) {
        var comments = $("#comments"+id).val();
        if(comments != null && comments != '') {
        $.ajax({
    		type: "POST",
    		url: 'removeAttandance.php',
    		data:{id:id, comments:comments},
    		success: function(resp){ console.log(resp);
    		    if(resp == '1') {
                    $("#verr"+id).prop("checked", false);
    		        $(".sucmsg").css('display', 'block');
    			    $("#sucmsg").text('').text('Attandance verified.');
    		    } else {
    		        $(".errmsg").css('display', 'block');
    			    $("#errmsg").text('').text('Something wrong!');
    		    }
    		}
       });  
        } else {
            $("#comments"+id).focus();
            $("#rem"+id).prop("checked", false);
            $("#commentserr"+id).text().text('please insert comment before check');
        }
    }
</script>
</body>
</html>