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
                    <h2>Enquiry</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Enquiry</strong>
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
                        <h5>Enquiry</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Message</th>
                        <th>On Date</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM enquiry_form order by id desc");
					while($fetch = $contact->fetch_assoc()) {$count++;
					$id=$fetch['id']; ?>
                    <tr>
                        <td><a href="deleteequery.php?id=<?php echo $fetch['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a></td>
                        <td><?php echo $fetch['name']; ?></td>
                        <td><?php echo $fetch['email']; ?></td>
                        <td><?php echo $fetch['phone']; ?></td>
                        <td><?php echo $fetch['country']; ?></td>
                        <td><?php echo $fetch['message']; ?></td>
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