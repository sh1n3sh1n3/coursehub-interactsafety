<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Location Register</title>
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
                    <h2>Location Register</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Location Register</strong>
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
                        <h5>Location Register</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Checklist</th>
                        <th>Title</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Location</th>
                        <th>Type</th>
                        <!--<th>Email</th>-->
                        <!--<th>Phone</th>-->
                        <th>Address</th>
                        <th>Image</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM locations order by id ASC");
					while($fetch = $contact->fetch_assoc()) {$count++;
					$id=$fetch['id'];
					$statesfetch = $conn->query("SELECT * FROM states WHERE id='".$fetch['state']."'")->fetch_assoc();
					$cityfetch = $conn->query("SELECT * FROM cities WHERE id='".$fetch['city']."'")->fetch_assoc();?>
                    <tr>
						<td>
							<a href="editLocations.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
							<a onclick="return confirm('Are you sure you want to delete this record? This action cannot be undone.');" href="deleteLocations.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> Delete </a>
						</td>
						<td>
							<a href="checklist.php?id=<?php echo $fetch['id']; ?>" class="btn btn-success btn-sm">Room Checklist </a>
						</td>
                        <td><?php echo $fetch['title']; ?></td>
                        <td><?php echo $statesfetch['name']; ?></td>
                        <td><?php echo $cityfetch['name']; ?></td>
                        <td><?php echo $fetch['location']; ?></td>
                        <td><?php echo $fetch['type']; ?></td>
                        <!--<td><?php echo $fetch['email']; ?></td>-->
                        <!--<td><?php echo $fetch['phone']; ?></td>-->
                        <td><?php echo $fetch['address']; ?></td>
                        <td><img src="../assets/images/locations/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></td>
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