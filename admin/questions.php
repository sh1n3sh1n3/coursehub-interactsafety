<?php include('session.php');
$chapterid = '';
if(isset($_GET['chapid'])) { 
	$chapterid = $_GET['chapid'];
}?>
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
                    <h2>Questions</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
							<a href="#">Questions</a>
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
                        <h5>Questions</h5>
						<a style="float:right" href="addQuestions.php?id=<?php echo $_GET['id']; ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add Questions </a>
						<?php $test = $conn->query("SELECT * FROM mocktest WHERE id=".$_GET['id'])->fetch_assoc(); ?>
                    </div>
					<a style="color:#fff !important" class="btn btn-danger btn-sm" id="deleteq" ><i class="fa fa-trash-o"></i>  Delete </a>
                    <div class="ibox-content">
						<form method="post" enctype="multipart/form-data">
							<div class="form-group  row">
								<label class="col-sm-2 col-form-label">Select Chapter</label>
								<div class="col-sm-10">
									<select class="form-control" required id="dynamic_select">
										<option value="">Select</option>
										<?php $count=0;
										$contact =  $conn->query("SELECT * FROM chapters WHERE status='1' AND course='".$test['subject_id']."' order by id ASC");
										while($fetch = $contact->fetch_assoc()) {$count++; ?>
										<option value="questions.php?id=<?php echo $_GET['id']; ?>&chapid=<?php echo $fetch['id']; ?>" <?php if(isset($_GET['chapid'])) { if($fetch['id'] == $_GET['chapid']) {echo 'selected';}} ?>><?php echo $fetch['title']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</form>
						<?php if(isset($_GET['chapid'])) {  ?>
                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
						<th>
						<div class="checkbox clip-check check-danger">
								<input type="checkbox" id="checkbox0" value="" class="select_all">
								<label for="checkbox0">
								
								</label>
							</div>
						</th>
                        <th>Action</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Answer</th>
                    </tr>
                    </thead>
                    <?php $count=0;
					$contact = $conn->query("SELECT * FROM mques WHERE chapter_id='".$chapterid."' order by id ASC");
					while($fetch = $contact->fetch_assoc()) {$count++; ?>
                    <tr id="deleteid<?php echo $fetch['id']; ?>">
					<td>
					<div class="checkbox clip-check check-danger ">
						<input type="checkbox" id="checkbox<?php echo $fetch['id']; ?>" class="checkboxsingle" value="<?php echo $fetch['id']; ?>" >
						<label for="checkbox<?php echo $fetch['id']; ?>">
								
								</label>
					</div>
					
					</td>
						<td>
							<a href="editQuestions.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit </a>
							<a href="deleteQuestions.php?id=<?php echo $fetch['id']; ?>" class="btn btn-white btn-sm"><i class="fa fa-trash"></i> Delete </a>
						</td>
                        <td><?php echo $fetch['qques']; ?></td>
                        <td><?php echo str_replace('<br />', '<br /><br />',$fetch['qoption']);; ?></td>
                        <td><?php echo $fetch['atext']; ?></td>
                    </tr>
					<?php } ?>
                    </tbody>
                    </table>
                        </div>
					<?php } ?>
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
 $('.select_all').on('change',function(){
	
        if(this.checked){
            $(this).closest("table").find('.checkboxsingle').each(function(){
				
                this.checked = true;
            });
        }else{
            $(this).closest("table").find('.checkboxsingle').each(function(){
                this.checked = false;
            });
        }
    });
	$('#deleteq').click(function(){
		$('#ques-details').addClass('csspinner');
		var myCheckboxes = new Array();
		$(".checkboxsingle:checked").each(function() {
			myCheckboxes.push($(this).val());
		});
		$.ajax({
			url: "mtest_ques_delete.php",
			type: "post",
			dataType: 'html',
			data: {checked_id:myCheckboxes },
			success: function(data) {
			if(data == "ok")
			{
				var testid = '<?php echo $_GET["id"]; ?>';
				var chapid = '<?php echo $_GET["chapid"]; ?>';
				window.location = 'questions.php?id='+testid+'&chapid='+chapid;
			}
			}
		});
	});
</script>
</body>
</html>