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
                    <h2>Locations </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="locations.php">Locations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Locations</strong>
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
                            <h5>Add Locations</h5>
                        </div>
						<?php function checkimg($pic){
								if (file_exists("../assets/images/partner/" . $pic)) {
									return false;
								} else {
									return true;
								}
							}
							$err = $msg = '';
							if(isset($_POST['submit'])) {
								$title = mysqli_real_escape_string($conn, $_POST['title']);
								$country = $_POST['country'];
								$slug = mysqli_real_escape_string($conn, $_POST['title']);
								$description = mysqli_real_escape_string($conn, $_POST['description']);
								$state = mysqli_real_escape_string($conn, $_POST['state']);
								$city = mysqli_real_escape_string($conn, $_POST['city']);
								$postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
								$location = mysqli_real_escape_string($conn, $_POST['location']);
								$phone = mysqli_real_escape_string($conn, $_POST['phone']);
								$email = mysqli_real_escape_string($conn, $_POST['email']);
								$type = mysqli_real_escape_string($conn, $_POST['type']);
								$address = mysqli_real_escape_string($conn, $_POST['address']);
								$map = '';//mysqli_real_escape_string($conn, $_POST['map']);
								$maplink = '';//mysqli_real_escape_string($conn, $_POST['maplink']);
								$image='';
                    			if(isset($_FILES["image"]['name']) && !empty($_FILES["image"]['name'])){ 
                    				if ($_FILES["image"]['name']!=''){
                    					$validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
                    					$temporary = explode(".", $_FILES["image"]["name"]);
                    					$file_extension = end($temporary);
                    					 if (in_array($file_extension, $validextensions)) {
                    						 if ($_FILES["image"]["error"] > 0){
                    							echo $_FILES["image"]["error"];
                    							$up=0;
                    						 }else{     
                    							  $picname='IMG_'.date('dmY',time())."_".date('His',time());
                    							  $image= $picname.".". $file_extension;
                    							  $i=0;
                    							  while(checkimg($image)!=true){
                    								  $i++;
                    								  $image=$picname."_(".$i.").".$file_extension;
                    							  } 
                    							  $sourcePath = $_FILES['image']['tmp_name']; // Storing source path of the file in a variable
                    							  $targetPath = "../assets/images/locations/".$image; // Target path where file is to be stored
                    							  if(move_uploaded_file($sourcePath,$targetPath)){}else{
                    								 echo  'Error while uploading your image try again later!';
                    								 $up=0;
                    							  }
                    						 }  
                    					}else{
                    						 echo 'Only jpg, jpeg and png file allowed!';
                    					}
                    				}
                    			}
							$insert = $conn->query("INSERT INTO locations (title,slug,image,description,state,city,location,phone,email,map,address, country, postcode, type, maplink) VALUES ('".$title."','".$slug."','".$image."', '".$description."','".$state."','".$city."','".$location."','".$phone."','".$email."','".$map."','".$address."', '".$country."', '".$postcode."', '".$type."', '".$maplink."')");
							if($insert){
							    $last_id = $conn->insert_id;
							    $conn->query("INSERT INTO location_checklist (location_id) VALUES ('".$last_id."')");
							    $lastId = $conn->insert_id;
							    $conn->query("INSERT INTO room_checklist (location_id, checklist_id) VALUES ('".$last_id."', '".$lastId."')");
								$msg = 'Data Added Successfully.';
							} else {
								$err = $conn->error;
							}
						}
						if(!empty($err)){
						  echo "
							<div class='alert alert-danger alert-dismissible'>
							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							  <h4><i class='fa fa-warning'></i> Error!</h4>
							  ".$err."
							</div>
						  ";
						}
						if(!empty($msg)){
						  echo "
							<div class='alert alert-success alert-dismissible'>
							  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							  <h4><i class='fa fa-check'></i> Success!</h4>
							  ".$msg."
							</div>
						  ";
						}
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Name of Venue</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="title"></div>
                                </div>
                                  <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Country</label>
                                    <div class="col-sm-10">
                                        	<select class="form-control select" name="country" onchange="getstates(this.value, 'state')">
    											<!--<option value="">Select</option>-->
    											<?php $countriesfetch = $conn->query("SELECT * FROM countries WHERE status='1' order by name ASC");
    											while($fetchcountries = $countriesfetch->fetch_assoc()) { ?>
    											<option value="<?php echo $fetchcountries['id']; ?>"><?php echo $fetchcountries['name']; ?></option>
    											<?php } ?>
											</select>
                                    </div>
                                </div>
                                 <div class="form-group  row"><label class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10"><textarea type="text" class="form-control" name="address"></textarea></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">State</label>
                                    <div class="col-sm-10">
                                        	<select class="form-control select" required name="state" id="state" onchange="getstates(this.value, 'city')">
    											<option value="">Select</option>
    											<?php $statesfetch = $conn->query("SELECT * FROM states WHERE status='1' AND country_id='14' order by name ASC");
    											while($fetchstates = $statesfetch->fetch_assoc()) { ?>
    											<option value="<?php echo $fetchstates['id']; ?>"><?php echo $fetchstates['name']; ?></option>
    											<?php } ?>
											</select>
                                    </div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">City</label>
                                    <div class="col-sm-10"><select class="form-control select" required name="city" id="city"><option value="">Select</option></select></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">Postcode</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="postcode"></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">Location</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" required name="location"></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">Location Type</label>
                                    <div class="col-sm-10">
                                        	<select class="form-control select" required name="type" id="type">
    											<option value="">Select</option>
    											<option value="Metro">Metro</option>
    											<option value="Regional">Regional</option>
											</select>
                                    </div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">Phone</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="phone"></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="email"></div>
                                </div>
                                 <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Map Embed Code</label>
                                    <div class="col-sm-10"><textarea type="text" class="form-control" name="map"></textarea></div>
                                </div>
                                  <div class="form-group d-none row"><label class="col-sm-2 col-form-label">Map URL </label>
                                    <div class="col-sm-10"><textarea type="text" class="form-control" name="maplink"></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>                       
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Photos of venue</label>
									<div class="col-sm-10">
										<div class="custom-file">
											<input id="logo" type="file" name="image"  class="custom-file-input">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
                                </div>
								<div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Venue Notes </label>
                                    <div class="col-sm-10"><textarea class="form-control" name="description"></textarea></div>
                                </div>
                              
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-white btn-sm" type="reset">Cancel</button>
                                        <button class="btn btn-primary btn-sm" type="submit" name="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
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
        function getstates(country, type) {
        	$.ajax({
        		type: "POST",
        		url: 'getstates.php',
        		data:{country:country, type: type},
        		success: function(response){ 
        		    $("#"+type).html('').html(response);
        		}
           });
        }
    </script>
</body>
</html>