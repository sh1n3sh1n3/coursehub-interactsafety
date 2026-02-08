<?php include('session.php'); ?>
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
<tr>
    <th>Status</th>
    <th>Image</th>
    <th>Category</th>
    <th>Title</th>
    <th>Short</th>
    <th style="width:150px">Price</th>
    <th>Duration</th>
    <th>Short Description</th>
    <!--<th>Description</th>-->
    <th>Action</th>
</tr>
</thead>
<tbody >
<?php $count=0;
$contact = $conn->query("SELECT * FROM courses order by orderby ASC");
while($fetch = $contact->fetch_assoc()) {$count++;
$fetchcourses = $conn->query("SELECT *,replace(slug,' ','-') as slug FROM courses WHERE id='".$fetch['id']."'")->fetch_assoc();
$fetchcat = $conn->query("SELECT * FROM category WHERE id='".$fetch['catid']."'")->fetch_assoc();
?>
<tr>
	
	<td><?php if($fetch['status']=='1') {echo '<span class="mb-1 label label-primary">Active</span>';}else {echo '<span class="mb-1 label label-default">Not Active</span>';} ?><br>
	<?php if($fetch['isPublished']=='1') {echo '<span class="mb-1 label label-success">Published</span>';}else {echo '<span class="mb-1 label label-info">Not Published</span>';} ?></td>
    <td><img src="../assets/images/course/<?php echo $fetch['image']; ?>" style="width:75px;height:75px;"/></td>
    <td><?php echo $fetchcat['title']; ?></td>
    <td><?php echo $fetch['title']; ?></td>
    <td><?php echo $fetch['short']; ?></td>
    <td style="width:150px">$<?php echo $fetch['price']; ?></td>
    <td><?php echo $fetch['duration'];?> <?php echo $fetch['duration_type'];?></td>
    <td><?php echo $fetch['shortdescription']; ?></td>
 <!--   <td>-->
	<!--	<a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?php echo $fetch['id']; ?>"><i class="fa fa-eye"></i> View </a>-->
	<!--	<div id="myModal<?php echo $fetch['id']; ?>" class="modal fade" role="dialog">-->
 <!--         <div class="modal-dialog modal-lg">-->
        
            <!-- Modal content-->
 <!--           <div class="modal-content">-->
 <!--             <div class="modal-header">-->
 <!--               <h4 class="modal-title">Description</h4>-->
 <!--               <button type="button" class="close" data-dismiss="modal">&times;</button>-->
 <!--             </div>-->
 <!--             <div class="modal-body">-->
 <!--               <p><?php echo $fetch['description'];?></p>-->
 <!--             </div>-->
 <!--             <div class="modal-footer">-->
 <!--               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
 <!--             </div>-->
 <!--           </div>-->
        
 <!--         </div>-->
 <!--       </div>-->
	<!--</td>-->
	<td>
		<a href="editCourse.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
		<?php if($fetch['status'] == '1') { ?>
		<a href="deleteCourse.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-dark btn-sm"><i class="fa fa-close"></i> Set Inactive </a><br>
		<?php } else { ?>
		<a href="deleteCourse.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-dark btn-sm"><i class="fa fa-check"></i> Set Active </a><br>
		<?php } ?>
		<?php if($fetch['isPublished'] == '1') { ?>
		<a href="publishCourse.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-danger btn-sm"><i class="fa fa-times-circle-o"></i> Hide </a><br>
		<?php } else { ?>
		<a href="publishCourse.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-warning btn-sm"><i class="fa fa-bullhorn"></i> Publish </a><br>
		<?php } ?>
		<a target="_blank" href="../courses-preview/<?php echo $fetchcourses['id']; ?>/<?php echo $fetchcourses['slug']; ?>" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Preview </a>
		<?php if($fetch['comingsoon'] == '0') { ?>
		<!--<a href="comingCourse.php?id=<?php echo $fetch['id']; ?>&st=1" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Set as Coming Soon </a>-->
		<?php } else { ?>
		<!--<a href="comingCourse.php?id=<?php echo $fetch['id']; ?>&st=0" class="btn btn-success btn-sm"><i class="fa fa-close"></i> Remove From Coming Soon </a>-->
		<?php } ?>
	</td>
</tr>
<?php } ?>
</tbody>
</table>
</table>
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function(){
	    $('select.select').select2();
		$('.dataTables-example').DataTable({
			pageLength: 25,
			responsive: true,
			"ordering": false,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{extend: 'csv'},
			]

		});

	});
</script>