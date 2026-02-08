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
                    <h2>Course Hub</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Course Hub</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Course Hub</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" enctype="multipart/form-data" id="form">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 pl-0 col-form-label">Course</label>
                                            <div class="col-sm-10"><select class="form-control" name="course" required id="course" onchange="getteachers(this.value)">
                                                <option value="">Select</option>
                                                <?php $coiurse = $conn->query("SELECT * FROM courses order by id desc");
                        							while($fetchcour = $coiurse->fetch_assoc()) { ?>
                        							<option value="<?php echo $fetchcour['id']; ?>"><?php echo $fetchcour['title']; ?></option>
                    							<?php } ?>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-3 row">
                                            <label class="col-sm-2 pl-0 col-form-label">Trainer</label>
                                            <div class="col-sm-10"><select class="form-control" name="teacher" required id="teacher" onchange="gettiming(this.value)">
                                                <option value="">Select</option>
                                            </select></div>
                                        </div>
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-3 pl-0 pr-0 col-form-label">Course Dates</label>
                                            <div class="col-sm-9"><select class="form-control" name="dates" required id="dates">
                                                <option value="">Select</option>
                                            </select></div>
                                        </div>
                                        <div class="col-sm-1 col-sm-offset-2">
                                            <button class="btn btn-primary btn-sm" type="submit" id="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                        <div class="table-responsive" id="tablebody">
							
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
function getteachers(val) {
    $.ajax({
      type: 'POST',
      url: "getteachers.php",
      data: {val: val},
      success: function(resultData) { 
        $("#teacher").html('').html(resultData);
      }
    });
}
function gettiming(val) {
    var course = $("#course").val();
    $.ajax({
      type: 'POST',
      url: "gettiming.php",
      data: {val: val, course: course},
      success: function(resultData) { 
        $("#dates").html('').html(resultData);
      }
    });
}
    $( document ).ready(function() {
        $("#form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            $.ajax({
                type: "POST",
                url: 'getcourseHub.php',
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                 $("#tablebody").html('').html(data);
                }
            });
            
        });
    });
</script>
</body>
</html>