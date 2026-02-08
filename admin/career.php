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
                    <h2>Get a Job</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Get a Job</strong>
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
                        <h5>Get a Job</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Resume</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM career order by id desc");
					while($fetch = $contact->fetch_assoc()) {$count++;
					$id=$fetch['id']; ?>
                    <tr>
                        <td><?php echo $fetch['name']; ?></td>
                        <td><?php echo $fetch['email']; ?></td>
                        <td><?php echo $fetch['phone']; ?></td>
                        <td><a target="_blank" href="../assets/images/resume/<?php echo $fetch['resume']; ?>">View File</a></td>
                        <td><?php echo date('d-M-Y H:i A', strtotime($fetch['date'])); ?></td>
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