<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Testimonials Register</title>
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
                    <h2>Testimonials Register</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Testimonials Register</strong>
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
                        <h5>Testimonials Register</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM testimonials order by id ASC");
					while($fetch = $contact->fetch_assoc()) {$count++;
					$id=$fetch['id']; ?>
                    <tr>
						<td>
							<a href="editTestimonial.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Update </a>
							<a onclick="return confirm('Are you sure?');" href="deleteTestimonial.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> Change Status </a>
						</td>
						<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
                        <td><img src="../assets/images/testimonials/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></td>
                        <td><?php echo $fetch['name']; ?></td>
                        <td><?php echo $fetch['designation']; ?></td>
                        <td><?php echo $fetch['content']; ?></td>
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