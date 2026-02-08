<?php include('session.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Course Register</title>
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
                    <h2>Course Register </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
							<a href="courses.php">Course Register</a>
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
                        <h5>Course Register</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" enctype="multipart/form-data" id="form">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-3 row">
                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10"><select class="form-control" name="isPublished">
                                                <option value="">Select</option>
                                                <option value="1">Published</option>
                                                <option value="2">Not Published</option>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-3 row">
                                            <label class="col-sm-2 col-form-label">Category</label>
                                            <div class="col-sm-10"><select class="form-control" name="catid">
                                                <option value="">Select</option>
                                                <?php $count=0;
											$contact = $conn->query("SELECT * FROM category WHERE status='1' order by id ASC");
											while($fetch = $contact->fetch_assoc()) {$count++; ?>
											<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['title']; ?></option>
											<?php } ?>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 col-form-label">Delivery Method</label>
                                            <div class="col-sm-10"><select class="form-control" name="delivery_types">
                                                <option value="">Select</option>
                                                <option value="Face to Face">Face to Face</option>
                                        <option value="eLearning">eLearning</option>
                                        <option value="Connected Real Time Delivery">Connected Real Time Delivery</option>
                                            </select></div>
                                        </div>
                                        <div class="col-sm-2 col-sm-offset-2">
                                            <button class="btn btn-primary btn-sm" type="submit" id="submit">Filter</button>
                                            <button class="btn btn-info btn-sm" type="button" id="overall">Overall</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <div class="table-responsive" id="tablebody">
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
                        <td><?php 
                            $text  = strip_tags($fetch['shortdescription']); // DB text
                            $limit = 120;
                            
                            $short = strlen($text) > $limit ? substr($text, 0, $limit) . '...' : $text;
                            $hasMore = strlen($text) > $limit;
                            ?>
                            <p>
                                <span class="short-text"><?= $short ?></span>
                                <?php if ($hasMore): ?>
                                    <span class="full-text" style="display:none;">
                                        <?= $text ?>
                                    </span>
                                    <a href="javascript:void(0);" class="read-more">Read more</a>
                                <?php endif; ?>
                            </p>
                            </td>
      <!--                  <td>-->
						<!--	<a class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal<?php echo $fetch['id']; ?>"><i class="fa fa-eye"></i> View </a>-->
						<!--	<div id="myModal<?php echo $fetch['id']; ?>" class="modal fade" role="dialog">-->
      <!--                        <div class="modal-dialog modal-lg">-->
                            
                                <!-- Modal content-->
      <!--                          <div class="modal-content">-->
      <!--                            <div class="modal-header">-->
      <!--                              <h4 class="modal-title">Description</h4>-->
      <!--                              <button type="button" class="close" data-dismiss="modal">&times;</button>-->
      <!--                            </div>-->
      <!--                            <div class="modal-body">-->
      <!--                              <p><?php echo $fetch['description'];?></p>-->
      <!--                            </div>-->
      <!--                            <div class="modal-footer">-->
      <!--                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      <!--                            </div>-->
      <!--                          </div>-->
                            
      <!--                        </div>-->
      <!--                      </div>-->
						<!--</td>-->
						<td>
							<a href="editCourse.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
							<?php if($fetch['status'] == '1') { ?>
							<a onclick="return confirm('Are you sure?');" href="deleteCourse.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-dark btn-sm"><i class="fa fa-close"></i> Set Inactive </a><br>
							<?php } else { ?>
							<a onclick="return confirm('Are you sure?');" href="deleteCourse.php?id=<?php echo $fetch['id']; ?>" class="mb-1 btn btn-dark btn-sm"><i class="fa fa-check"></i> Set Active </a><br>
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
              url: "getcourses.php",
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
                url: 'filtercourses.php',
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                 $("#tablebody").html('').html(data);
                }
            });
            
        });
    });
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".read-more").forEach(function (btn) {
        btn.addEventListener("click", function () {

            let shortText = this.previousElementSibling.previousElementSibling;
            let fullText  = this.previousElementSibling;

            if (fullText.style.display === "none") {
                fullText.style.display = "inline";
                shortText.style.display = "none";
                this.textContent = "Read less";
            } else {
                fullText.style.display = "none";
                shortText.style.display = "inline";
                this.textContent = "Read more";
            }

        });
    });
});

</script>
</body>
</html>