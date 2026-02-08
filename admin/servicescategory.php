<?php include('session.php');
$chapterid = '';
if(isset($_GET['id'])) { 
	$chapterid = (int) $_GET['id'];
}?>
<!DOCTYPE html>
<html>
<head>
    <title>Consultation Service</title>
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
                    <h2>Consultation Services </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
							<a href="servicecategory.php">Consultation Services</a>
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
                        <h5>Consultation Services</h5>
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
                        <th>Show on Home</th>
                    </tr>
                    </thead>
                    <?php $count=0;
					$contact = $conn->query("SELECT * FROM services_category order by id ASC");
					while($fetch = $contact->fetch_assoc()) {$count++; ?>
                    <tr>
						<td>
							<a href="editServicesCategory.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
							<a onclick="return confirm('Are you sure?');" href="deleteServicesCategory.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-close"></i> Change Status </a>
						</td>
						<td><?php if($fetch['status']=='1') {echo '<span class="label label-primary">Active</span>';}else {echo '<span class="label label-default">Not Active</span>';} ?></td>
                        <td><img src="../assets/images/services/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></td>
                        <td><?php echo $fetch['title']; ?></td>
                        <td><?php if($fetch['showHome'] == '1') {echo 'Yes';} else {echo 'No';} ?></td>
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
    $(function(){
      $('#dynamic_select').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });
    });
</script>
</body>
</html>