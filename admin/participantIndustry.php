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
                    <h2>Industry Type</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Industry Type</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Industry Type</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive" id="tablebody">
							<table class="table table-striped table-bordered table-hover dataTables-example1" >
                                <thead>
                                    <?php $querycnt = $conn->query("SELECT * FROM courses WHERE isPublished = '1' AND status = '1'")->num_rows; ?>
                                <tr>
                                	<th rowspan="2" style="vertical-align:middle; text-align:center;">Industry Type</th>
                                	<th colspan="<?php echo $querycnt + 1; ?>" style="vertical-align:middle; text-align:center;">Participants by Industry</th>
                            	</tr>
                            	<tr>
                                	<?php 
                                $contact = $conn->query("SELECT * FROM courses WHERE isPublished = '1' AND status = '1' ORDER BY id ASC");
                                while($fetch = $contact->fetch_assoc()) { ?>
                                	<th style="vertical-align:middle; text-align:center;"><?php echo $fetch['title']; ?> </th>
                                <?php } ?>
                                	<th style="vertical-align:middle; text-align:center;">Total</th>
                                </tr>
                                </thead>
                                <tbody id="tablebody">
                                <?php $count=0;
                                $industype = $conn->query("SELECT * FROM industry_type WHERE status='1'");
                                while($fetchindustype = $industype->fetch_assoc()) { $count++; ?>
                                <tr>
                                	<th style="vertical-align:middle; text-align:center;"><?php echo $fetchindustype['title']; ?> </th>
                                	<?php $salcnt = 0; $contact1 = $conn->query("SELECT * FROM courses WHERE isPublished = '1' AND status = '1' ORDER BY id ASC");
                                    while($fetch1 = $contact1->fetch_assoc()) { 
                                    $saledata = $conn->query("SELECT count(*) as count FROM sale WHERE industry_type='".$fetchindustype['id']."' AND courseid='".$fetch1['id']."'")->fetch_assoc();
                                    $salcnt += $saledata['count'];?>
                                	<td style="vertical-align:middle; text-align:center;"><?php echo $saledata['count']; ?> </td>
                                <?php } ?>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $salcnt; ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                	<th style="vertical-align:middle; text-align:center;">Total </th>
                                	<?php $salcnt1 = 0; $contact2 = $conn->query("SELECT * FROM courses WHERE isPublished = '1' AND status = '1' ORDER BY id ASC");
                                    while($fetch2 = $contact2->fetch_assoc()) { 
                                    $saledata1 = $conn->query("SELECT count(*) as count FROM sale WHERE courseid='".$fetch2['id']."'")->fetch_assoc();
                                    $salcnt1 += $saledata1['count'];?>
                                	<td style="vertical-align:middle; text-align:center;"><?php echo $saledata1['count']; ?> </td>
                                <?php } ?>
                                    <td style="vertical-align:middle; text-align:center;"><?php echo $salcnt1; ?></td>
                                </tr>
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
                    filename: 'ATAR_Industry Type',
				},
			]

		});

	});
</script>
</body>
</html>