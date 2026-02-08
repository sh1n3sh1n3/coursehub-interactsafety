<?php include('session.php');
$sale = $conn->query("SELECT * FROM sale WHERE id=".$_GET['id'])->fetch_assoc();
$userdataname = '';
if(isset($sale['user']) && !empty($sale['user']) ** $sale['user'] != 0) {
$userdata = $conn->query("SELECT * FROM registration WHERE id=".$sale['user'])->fetch_assoc(); 
$userdataname = $userdata['title'].' '.$userdata['fname'].' '.$userdata['lname'];
} ?>
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
                    <h2> <?php echo $userdataname; ?> Courses</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong> <?php echo $userdataname; ?> Courses</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;"> <?php echo $userdataname; ?> Courses</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
							<tr>
								<th>Sr. No.</th>
								<th>Course</th>
								<th>Amount</th>
								<th>Shipping</th>
								<th>Tax</th>
								<th>Total</th>
								<th>Description</th>
								<th>Test</th>
								<th>Actions</th>
							</tr>
							</thead>
							<tbody>
							<?php $count=0;
							$contact = $conn->query("SELECT * FROM sale_part WHERE orderid='".$_GET['id']."' order by id desc");
							while($fetch = $contact->fetch_assoc()) { $count++;
									$course = $conn->query("SELECT * FROM courses WHERE id='".$fetch['course']."'")->fetch_assoc();
									if($fetch['tag'] == 'renew') {$tag = '<span style="color:red;text-transform:uppercase;font-weight:bold">('.$fetch['tag'].')</span>'; } else {$tag='';}
									$cousetitle = $course['title'].$tag;
							?>
							<tr>
								<td><?php echo $count; ?>. </td>
								<td><?php echo $cousetitle; ?></td>
								<td>$<?php echo $fetch['amount']; ?></td>
								<td>$<?php echo $fetch['shipping']; ?></td>
								<td>$<?php echo $fetch['tax']; ?></td>
								<td>$<?php echo $fetch['total']; ?></td>
								<td><?php echo $fetch['description']; ?></td>
								<td><?php if($fetch['examexpire'] == '1') { 
								$mock_history = $conn->query("SELECT * FROM mock_history WHERE id=".$fetch['tid'])->fetch_assoc();
								$marks = $mock_history['totalomarks'] * 100 / $mock_history['totalmarks'];
								if($marks >= '40') {
									echo 'Passed';
								} else {
									echo 'Failed';
								}
								} else { echo 'Not Attempted';}  ?></td>
								<td><?php if($fetch['examexpire'] == '1') { 
								$mock_history = $conn->query("SELECT * FROM mock_history WHERE id=".$fetch['tid'])->fetch_assoc();
								$marks = $mock_history['totalomarks'] * 100 / $mock_history['totalmarks'];
								if($marks >= '40') { ?>
									<a class="btn btn-warning btn-sm" target="_blank" href="mock-test/analysis.php?test_id=<?=$mock_history['id']?>"> View Transcript </a>
									<a target="_blank" href="download-certificate.php?id=<?=$mock_history['id']?>" class="btn btn-success btn-sm">Download Certificate </a>
							<?php	} else { ?>
									<a target="_blank" href="updateResult.php?id=<?=$mock_history['id']?>" class="btn btn-danger btn-sm"> Pass Result  </a>
								<?php }
								} else { echo 'Test Not Attempted';}  ?></td>
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