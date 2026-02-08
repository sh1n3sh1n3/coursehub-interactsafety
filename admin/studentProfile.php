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
                    <h2>Student Profile</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Student Profile</strong>
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
                        <h5 style="float:left;width: auto;padding: 15px 0 8px 15px;">Student Profile</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" enctype="multipart/form-data" id="form">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 row">
                                            <label class="col-sm-2 pl-0 col-form-label">Students</label>
                                            <div class="col-sm-10"><select class="form-control" name="student" id="student">
                                                <option value="">Select</option>
                                                <?php $coiurse = $conn->query("SELECT * FROM registration WHERE status='1' order by id asc");
                        							while($fetchcour = $coiurse->fetch_assoc()) { ?>
                        							<option value="<?php echo $fetchcour['id']; ?>"><?php echo $fetchcour['title']; ?> <?php echo $fetchcour['fname']; ?> <?php echo $fetchcour['lname']; ?></option>
                    							<?php } ?>
                                            </select></div>
                                        </div>
                                        <div class="col-sm-1 col-sm-offset-2">
                                            <button class="btn btn-primary btn-sm" type="submit" id="submit">Fetch</button>
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
    $( document ).ready(function() {
        $("#form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            $.ajax({
                type: "POST",
                url: 'getstudentP.php',
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