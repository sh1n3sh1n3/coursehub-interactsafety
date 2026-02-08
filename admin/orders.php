<?php include('session.php');
$userdataname = '';
if(isset($_GET['id']) && !empty($_GET['id']) ** $_GET['id'] != 0) {
$userdata = $conn->query("SELECT * FROM registration WHERE id=".$_GET['id'])->fetch_assoc(); 
$userdataname = $userdata['title'].' '.$userdata['fname'].' '.$userdata['lname'];
}?>
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
                    <h2><?php echo $userdataname; ?> Orders</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong><?php echo $userdataname; ?> Orders</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;"><?php echo $userdataname; ?> Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
							<tr>
								<th>Sr. No.</th>
								<!--<th>Update</th>-->
								<!--<th>Invoice</th>-->
								<th>Date</th>
								<th>Invoice No</th>
								<th>Order No</th>
								<th>Payment Id</th>
								<th>Amount</th>
								<th>Course Type</th>
								<th>Course</th>
								<th>Course Slot</th>
								<th>Location</th>
								<!--<th>Discount</th>-->
								<th>Teacher</th>
								<th>Attandance</th>
								<th>Certificate</th>
							</tr>
							</thead>
							<tbody>
							<?php $count=0;$dates='';
							if(isset($_GET['id']) && !empty($_GET['id']) ** $_GET['id'] != 0) {
							    $contact = $conn->query("SELECT * FROM sale WHERE user='".$_GET['id']."' order by id desc");
							} else {
							    $contact = $conn->query("SELECT * FROM sale order by id desc");
							}
							while($fetch = $contact->fetch_assoc()) {$dates=$invitees='';
								$count++;$id = $fetch['id'];
								$sqlregistration = $conn->query("SELECT * FROM registration WHERE id='".$fetch['user']."'")->fetch_assoc();
								$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$fetch['courseid']."'")->fetch_assoc();
								$sqlcourseslot = $conn->query("SELECT * FROM course_slots WHERE courseid='".$fetch['courseid']."' AND id='".$fetch['slotid']."'")->fetch_assoc();
								$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$sqlcourseslot['id']."'");
            					while($fetchdates = $course_dates->fetch_assoc()) {
            					    $dates .= date('d-M-Y', strtotime($fetchdates['date'])).' ('.date('h:i A', strtotime($fetchdates['starttime'])).' - '.date('h:i A', strtotime($fetchdates['endtime'])).')'.'<hr>';
            					}
								$coursecode='';
								$private_course = $conn->query("SELECT * FROM private_course WHERE slot_id='".$sqlcourseslot['id']."'")->fetch_assoc();
                                if($sqlcourseslot['type'] == 'private') {
            				        $fetchprivate = $conn->query("SELECT * FROM private_course WHERE slot_id=".$sqlcourseslot['id'])->fetch_assoc();
                                    $coursecode = ' ('.$fetchprivate['course_code'].')';
                                }
								$sqllocation = $conn->query("SELECT * FROM locations WHERE id='".$sqlcourseslot['locid']."'")->fetch_assoc();
								$cities = $conn->query("SELECT * FROM cities WHERE id=".$sqlcourseslot['cityid'])->fetch_assoc();
								$amt = '0';
								if($sqlcourseslot['type'] == 'private') {
								    $amt = $private_course['course_fees'];
								} else {
								    $amt = $fetch['amount'];
								}
                                $course_teachers = $conn->query("SELECT * FROM course_teachers WHERE slot_id='".$sqlcourseslot['id']."' AND status='1' AND is_deleted='0' ORDER BY id ASC");
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
								<td><?php echo $count; ?>. </td>
								<!--<td><a href="updateOrder.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> Update </a></td>-->
								<!--<td><a href="invoice.php?id=<?php echo $fetch['id']; ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> Admin Invoice </a><br>-->
								<!--<a href="invoice-stu.php?id=<?php echo $fetch['id']; ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> Student Invoice </a></td>-->
								<td><?php echo date('d-M-Y', strtotime($fetch['date'])); ?></td>
								<td><?php echo $fetch['invoiceno']; ?></td>
								<td><?php echo $fetch['orderno']; ?></td>
								<td><?php echo $fetch['paymentid']; ?></td>
								<td>$<?php echo $amt; ?></td>
								<td><?php echo $sqlcourseslot['type'].'<br>'.$coursecode; ?></td>
                                <td><?php echo $sqlcourses['title']; ?></td>
                                <td><?php echo $dates; ?></td>
                                <td> <?php echo $cities['name'].' - '.$sqllocation['location'].' ('.$sqllocation['title'].')'; ?></td>
								<!--<td><?php echo $fetch['discountdescription']; ?></td>-->
								<td><?php echo $invitees; ?></td>
								<td><a class="btn btn-info" href="javascript:" onclick="getattandace(<?php echo $fetch['user']; ?>, <?php echo $fetch['courseid']; ?>, <?php echo $fetch['slotid']; ?>)">View</a></td>
								<td><a class="btn btn-dark" target="_blank" href="certificate.php?id=<?php echo $fetch['id']; ?>">View</a></td>
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
    function getattandace(user, course, slot) {
            $.ajax({
        		type: "POST",
        		url: 'getAttandance.php',
        		data:{user: user, course: course, slot: slot},
        		success: function(res){
        			$("#AttandanceBody").html('').html(res);
        			$('#attandanceModal').modal('toggle');
        		}
           });   
        }
</script>
</body>
</html>