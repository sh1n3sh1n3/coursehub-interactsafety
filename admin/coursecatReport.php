<?php include('session.php'); ?>
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
                    <h2>Course Category Report</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Course Category Report</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Course Category Report</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
							<tr>
								<th>Sr. No.</th>
								<th>Action</th>
								<th>Orders</th>
								<th>Status</th>
								<th>Student Number</th>
								<th>Name</th>
								<th>Surname</th>
								<th>Phone Contact</th>
								<th>E-mail address</th>
								<th>Latest Course Enrolled</th>
								<th>Certificate Issued</th>
							</tr>
							</thead>
							<tbody id="tablebody">
							<?php $count=0;
							$contact = $conn->query("SELECT * FROM registration order by id desc");
							while($fetch = $contact->fetch_assoc()) {
								$count++;$id = $fetch['id'];
								$sale = $conn->query("SELECT * FROM sale WHERE user=".$id)->num_rows;
								$order = $conn->query("SELECT * FROM sale WHERE user='".$id."' ORDER BY id DESC")->fetch_assoc();
								$sqlcourses = $conn->query("SELECT * FROM courses WHERE id='".$order['courseid']."'")->fetch_assoc();
								if($order['generateCertificate'] == '1') {
								    $gencert = 'Yes';
								} else {
								    $gencert = 'No';
								}
								?>
							<tr>
								<td><?php echo $count; ?>. </td>
								<td><?php if($fetch['status']=='1') {echo '<a href="deleteUser.php?id='.$id.'" class="btn btn-white btn-sm"><i class="fa fa-cross"></i> Deactivate </a>';}else {echo '<a href="deleteUser.php?id='.$id.'" class="btn btn-white btn-sm"><i class="fa fa-check"></i> Activate </a>';} ?></td>
								<td><a title="Click to view orders" href="orders.php?id=<?php echo $fetch['id']; ?>" class="btn btn-info btn-sm"> View <?php echo $sale; ?> order </a></td>
								<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
								<td><?php echo strtoupper($fetch['generated_code']); ?></td>
								<td><?php echo $fetch['title'].' '.$fetch['fname']; ?></td>
								<td><?php echo $fetch['lname']; ?></td>
								<td><?php echo $fetch['phone']; ?></td>
								<td><?php echo $fetch['email']; ?></td>
								<td><?php echo $sqlcourses['title']; ?></td>
								<td><?php echo $gencert; ?></td>
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
              url: "getusers.php",
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
                url: 'filterusers.php',
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                 $("#tablebody").html('').html(data);
                }
            });
            
        });
    });
</script>
</body>
</html>