<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
<?php include('includes/head.php'); ?>
<style>
.text-success {
    color: #28a745 !important;
}
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
                    <h2>Courses </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
							<a href="courses.php">Courses</a>
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
                        <h5>Courses</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Time Slots</th>
                        <th>Invitees</th>
                        <th>Details</th>
                        <th>Remarks</th>
                        <th style="width:165px">Action</th>
                    </tr>
                    </thead>
                    <?php $count=0;$coursecode = '';
					$contact = $conn->query("SELECT * FROM course_teachers WHERE teacherid='".$_SESSION['teacher']."' AND accepted='0' AND status='1' AND is_deleted='0' order by id DESC");
					while($fetteach = $contact->fetch_assoc()) {$count++; $dates=$invitees='';
					    $fetdata = $conn->query("SELECT * FROM course_slots WHERE id=".$fetteach['slot_id'])->fetch_assoc();
					    $fetch = $conn->query("SELECT * FROM courses WHERE id=".$fetdata['courseid'])->fetch_assoc();
    					$cities = $conn->query("SELECT * FROM cities WHERE id=".$fetdata['cityid'])->fetch_assoc();
                        $locs = $conn->query("SELECT * FROM locations WHERE id=".$fetdata['locid'])->fetch_assoc();
    					$states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
                        $locscheck = $conn->query("SELECT * FROM location_checklist WHERE location_id=".$locs['id'])->fetch_assoc();
                        $ccnntt=0; $cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetdata['id']."' ORDER BY date ASC");
                        while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
                            $startdate = date('d/M/Y', strtotime($fetchdates['date']));
                            $starttimeh = date('h:i A', strtotime($fetchdates['starttime']));
                            $endtimeh = date('h:i A', strtotime($fetchdates['endtime']));
                            $dates .= 'Day '.$ccnntt.' - '.$startdate.' ('.$starttimeh.'-'.$endtimeh.')'.'<hr>';
                        }
                        $course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='".$fetdata['id']."' AND status='1' AND is_deleted='0' ORDER BY id ASC");
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
                        if($fetdata['type'] == 'private') {
					        $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=".$fetdata['id'])->fetch_assoc();
                            $coursecode = $fetchprivate['course_code'];
                        }
					?>
                    <tr>
                        <td><img src="../assets/images/course/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></td>
                        <td><?php echo $fetch['title']; ?></td>
                        <td><?php echo $locscheck['room_location'].', '.$locscheck['venue_details'].', '.$locs['title'].', '.$cities['name'].', '.$states['name']; ?></td>
                        <td><?php echo $dates; ?></td>
                        <td><?php echo $invitees; ?></td>
                        <td>
							<a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?php echo $fetch['id']; ?>"><i class="fa fa-eye"></i> View </a>
							<div id="myModal<?php echo $fetch['id']; ?>" class="modal fade" role="dialog">
                              <div class="modal-dialog modal-lg">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Description</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  <div class="modal-body">
                                    <p><?php echo $fetch['description'];?></p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                            
                              </div>
                            </div>
						</td>
						<td><input type="text" name="remarks[<?php echo $fetteach["id"]; ?>]" id="remarks_<?php echo $fetteach["id"]; ?>" class="form-control"/></td>
                        <td><a href="javascript:" onclick="setstatus(<?php echo $fetteach["id"]; ?>,'accept')" class="btn btn-success">Accept</a>  <a href="javascript:" onclick="setstatus(<?php echo $fetteach["id"]; ?>,'decline')" class="btn btn-danger">Decline</a></td>
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
    function setstatus(id, type) {
        var remarks = $("#remarks_"+id).val();
        $.ajax({
           url: "approveRequest.php",
           type: "POST",
           data:  {id:id, type:type, remarks:remarks},
           success: function(data) { console.log(data);
               alert("Updated successfully.");
               if(type == 'accept') {
                   window.location.href = "courses.php";
               } else {
                   window.location.href = "coursesDecline.php";
               }
           }
        });
    }
</script>
</body>
</html>