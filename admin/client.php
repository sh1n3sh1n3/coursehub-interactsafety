<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Clients Register</title>
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
                    <h2>Clients Register</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Clients Register</strong>
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
                        <h5>Clients Register</h5>
                        <a href="addClient.php" style="float:right" class="btn btn-danger btn-sm"><i class="fa fa-plus"></i> Add Client </a>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Image</th>
                        <th>Title</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM clients order by id DESC");
					while($fetch = $contact->fetch_assoc()) {$count++; ?>
                    <tr>
						<td>
						    <?php if($fetch['status'] == '1') { ?>
							<a href="statusClient.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-eye-slash"></i> Hide </a>
							<?php } else { ?>
							<a href="statusClient.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-bullhorn"></i> Publish </a>
							<?php } ?>
							<a onclick="return confirm('Are you sure you want to delete this record? This action cannot be undone.');" href="deleteClient.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Delete </a>
						</td>
                        <td><a target="_blank" href="../assets/images/clients/<?php echo $fetch['image']; ?>"><img src="../assets/images/clients/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></a></td>
                        <td><?php echo $fetch['title']; ?></td>
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