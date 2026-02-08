<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Blogs</title>
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
                    <h2>Blogs</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Blogs</strong>
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
                        <h5>Blogs</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Tags</th>
                        <th>Posted By</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php $count=0;
					$contact = $conn->query("SELECT * FROM blogs order by id ASC");
					while($fetch = $contact->fetch_assoc()) {$count++; ?>
                    <tr>
						<td>
							<a href="editBlog.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
							<a onclick="return confirm('Are you sure you want to delete this record? This action cannot be undone.');" href="deleteBlog.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Delete </a>
							<a href="ChangeStatus.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"> Update Status </a>
						</td>
						<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
                        <td><img src="../assets/images/blog/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></td>
                        <td><?php echo $fetch['title']; ?></td>
                        <td><?php echo $fetch['tags']; ?></td>
                        <td><?php echo $fetch['postedby']; ?></td>
                        <td><?php echo date('d-M-Y', strtotime($fetch['postdate'])); ?></td>
                        <td><?php $string = strip_tags($fetch['content']);
							if (strlen($string) > 85) {

								// truncate string
								$stringCut = substr($string, 0, 85);
								$endPoint = strrpos($stringCut, ' ');

								//if the string doesn't contain any space then it will cut without word basis.
								$string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
								$string .= '... ';
							}
							echo $string;?></td>
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