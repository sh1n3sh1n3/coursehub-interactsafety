<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
<?php include('includes/head.php'); ?>
<style>
    table {font-size:10px;}
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
                    <h2>Course Delivery</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Course Delivery</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Course Delivery</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive" id="tablebody">
							<table class="table table-striped table-bordered table-hover dataTables-example1" >
                                <thead>
                                    <?php $querycnt = $conn->query("SELECT * FROM locations WHERE status = '1'")->num_rows; ?>
                                    <?php $querycntm = $conn->query("SELECT * FROM locations WHERE status = '1' AND type='Metro'")->num_rows; ?>
                                    <?php $querycntr = $conn->query("SELECT * FROM locations WHERE status = '1' AND type='Regional'")->num_rows; ?>
                                <tr>
                                	<th rowspan="3" style="vertical-align:middle; text-align:center;">Approved HSR Courses</th>
                                	<th colspan="<?php echo $querycnt + 2; ?>" style="vertical-align:middle; text-align:center;">Courses Delivered</th>
                                	<th colspan="3" style="vertical-align:middle; text-align:center;">Participants Attendent</th>
                                	<th colspan="6" style="vertical-align:middle; text-align:center;">Type of Participants</th>
                            	</tr>
                            	<tr>
                                	<th colspan="<?php echo $querycntm; ?>" style="vertical-align:middle; text-align:center;">Metro</th>
                                	<th colspan="<?php echo $querycntr; ?>" style="vertical-align:middle; text-align:center;">Regional</th>
                                	<th style="vertical-align:middle; text-align:center;">Total</th>
                                	<th style="vertical-align:middle; text-align:center;">Total</th>
                                	<th style="vertical-align:middle; text-align:center;">Metro</th>
                                	<th style="vertical-align:middle; text-align:center;">Regional</th>
                                	<th style="vertical-align:middle; text-align:center;">Total</th>
                                	<th colspan="5" style="vertical-align:middle; text-align:center;">Metro and Regional</th>
                                	<th style="vertical-align:middle; text-align:center;">Total</th>
                                </tr>
                                <tr>
                                	<?php 
                                $contact = $conn->query("SELECT * FROM locations WHERE status = '1' AND type='Metro' ORDER BY id ASC");
                                while($fetch = $contact->fetch_assoc()) { ?>
                                	<th><span style="vertical-align:top; text-align:center;">No. metropolitan <br>courses delivered </span><br><br><span style="vertical-align:bottom; text-align:center;"><?php echo $fetch['title']; ?></span></th>
                                <?php } ?>
                                	<?php 
                                $contact = $conn->query("SELECT * FROM locations WHERE status = '1' AND type='Regional' ORDER BY id ASC");
                                while($fetch = $contact->fetch_assoc()) { ?>
                                	<th><span style="vertical-align:top; text-align:center;">No. regional <br>courses delivered </span><br><br><span style="vertical-align:bottom; text-align:center;"><?php echo $fetch['title']; ?></span></th>
                                <?php } ?>
                                	<th style="vertical-align:top; text-align:center;">Regional courses delivered</th>
                                	<th style="vertical-align:top; text-align:center;">Metro + Regional courses delivered</th>
                                	<th style="vertical-align:top; text-align:center;">Metro patricipants attended</th>
                                	<th style="vertical-align:top; text-align:center;">Regional patricipants attended</th>
                                	<th style="vertical-align:top; text-align:center;">Metro + Regional patricipants attended</th>
                                	<th style="vertical-align:top; text-align:center;">HSRs</th>
                                	<th style="vertical-align:top; text-align:center;">Deputy HSRs</th>
                                	<th style="vertical-align:top; text-align:center;">Manager/ Supervisor</th>
                                	<th style="vertical-align:top; text-align:center;">Health & Safety committee member</th>
                                	<th style="vertical-align:top; text-align:center;">Other</th>
                                	<th style="vertical-align:top; text-align:center;">Total</th>
                                </tr>
                                </thead>
                                <tbody id="tablebody">
                                <?php $count=$ttl=0;$tttl=0;
                                $industype = $conn->query("SELECT * FROM courses WHERE isPublished='1'");
                                while($fetchindustype = $industype->fetch_assoc()) { $count++; ?>
                                <tr>
                                	<th style="vertical-align:middle; text-align:center;"><?php echo $fetchindustype['title']; ?> </th>
                                	<?php $salcnt = 0; 
                                	$contact1 = $conn->query("SELECT locid FROM course_slots WHERE isPublished = '1' AND locid IN (SELECT id FROM locations WHERE type='Metro') GROUP BY locid ORDER BY locid ASC");
                                    while($fetch1 = $contact1->fetch_assoc()) { 
                                        $query = $conn->query("SELECT count(*) as count FROM course_slots WHERE isPublished = '1' AND courseid='".$fetchindustype['id']."' AND locid = '".$fetch1['locid']."'");
                                        if($query->num_rows > 0) {
                                        $row = $query->fetch_assoc();
                                        $salcnt += $row['count'];?>
                                	<td style="vertical-align:middle; text-align:center;"><?php echo $row['count']; ?> </td>
                                <?php } else { ?>
                                    <td style="vertical-align:middle; text-align:center;">0 </td>
                                <?php }} ?>
                                <?php  $salcnt1 = 0; 
                                    $contact2 = $conn->query("SELECT locid FROM course_slots WHERE isPublished = '1' AND locid IN (SELECT id FROM locations WHERE type='Regional') GROUP BY locid ORDER BY locid ASC");
                                    while($fetch2 = $contact2->fetch_assoc()) { 
                                        $query1 = $conn->query("SELECT count(*) as count FROM course_slots WHERE isPublished = '1' AND courseid='".$fetchindustype['id']."' AND locid = '".$fetch2['locid']."'");
                                        if($query1->num_rows > 0) {
                                        $row1 = $query1->fetch_assoc();
                                        $salcnt1 += $row1['count'];?>
                                	<td style="vertical-align:middle; text-align:center;"><?php echo $row1['count']; ?> </td>
                                <?php } else { ?>
                                    <td style="vertical-align:middle; text-align:center;">0 </td>
                                <?php }}
                                $ttl = $salcnt + $salcnt1;?>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $salcnt1; ?></td>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $ttl; ?></td>
                                    <?php $salcnt2 = 0; 
                                    	$contact2 = $conn->query("SELECT count(*) as count FROM tbl_attendance WHERE isVerified = '1' AND courseid='".$fetchindustype['id']."' AND locid IN (SELECT id FROM locations WHERE type='Metro')");
                                        while($fetch2 = $contact2->fetch_assoc()) { 
                                            $salcnt2 += $fetch2['count'];?>
                                    	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch2['count']; ?> </td>
                                    <?php } ?>
                                    <?php $salcnt3 = 0;
                                    	$contact3 = $conn->query("SELECT count(*) as count FROM tbl_attendance WHERE isVerified = '1' AND courseid='".$fetchindustype['id']."' AND locid IN (SELECT id FROM locations WHERE type='Regional')");
                                        while($fetch3 = $contact3->fetch_assoc()) { 
                                            $salcnt3 += $fetch3['count'];?>
                                    	<td style="vertical-align:middle; text-align:center;"><?php echo $fetch3['count']; ?> </td>
                                    <?php }
                                    $ttl3 = $salcnt2 + $salcnt3;?>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $ttl3; ?></td>
                                    <?php $hsrs = $conn->query("SELECT count(*) as count FROM registration WHERE hsr_or_not='1' AND status='1' AND courseid='".$fetchindustype['id']."'")->fetch_assoc(); ?>
                                    <?php $dhsrs = $conn->query("SELECT count(*) as count FROM registration WHERE hsr_or_not='2' AND status='1' AND courseid='".$fetchindustype['id']."'")->fetch_assoc(); ?>
                                    <?php $mshsrs = $conn->query("SELECT count(*) as count FROM registration WHERE hsr_or_not='3' AND status='1' AND courseid='".$fetchindustype['id']."'")->fetch_assoc(); ?>
                                    <?php $hmhsrs = $conn->query("SELECT count(*) as count FROM registration WHERE hsr_or_not='4' AND status='1' AND courseid='".$fetchindustype['id']."'")->fetch_assoc(); ?>
                                    <?php $ohsrs = $conn->query("SELECT count(*) as count FROM registration WHERE hsr_or_not='5' AND status='1' AND courseid='".$fetchindustype['id']."'")->fetch_assoc(); ?>
                                    <?php $tttl = $hsrs['count'] + $dhsrs['count'] + $mshsrs['count'] + $hmhsrs['count'] + $ohsrs['count']; ?>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $hsrs['count']; ?> </td>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $dhsrs['count']; ?> </td>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $mshsrs['count']; ?> </td>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $hmhsrs['count']; ?> </td>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $ohsrs['count']; ?> </td>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $tttl; ?> </td>
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
    $(document).ready(function(){
		$('.dataTables-example1').DataTable({
			pageLength: 25,
			responsive: true,
			"ordering": false,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{
				    extend: 'csv',
				    text:   'Export',
                    filename: 'ATAR_Course Delivery',
				},
			]

		});

	});
</script>
</body>
</html>