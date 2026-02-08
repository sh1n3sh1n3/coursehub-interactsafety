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
                    <h2>Room Checklist </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php">Home</a>
                        </li>
                        <li class="breadcrumb-item">
							<a href="locations.php">Locations</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Room Checklist</strong>
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
                            <h5>Room Checklist</h5>
                        </div>
						<?php 
						$err = $msg = '';
						if(isset($_POST['submit'])) {
							$location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
							$venue_details = mysqli_real_escape_string($conn, $_POST['venue_details']);
							$room_location = mysqli_real_escape_string($conn, $_POST['room_location']);
							$address = mysqli_real_escape_string($conn, $_POST['address']);
							$region = mysqli_real_escape_string($conn, $_POST['region']);
							$assessment_date = mysqli_real_escape_string($conn, $_POST['assessment_date']);
							$contact_person = mysqli_real_escape_string($conn, $_POST['contact_person']);
							$contact_phone = mysqli_real_escape_string($conn, $_POST['contact_phone']);
							$contact_email = mysqli_real_escape_string($conn, $_POST['contact_email']);
							$completed_by = mysqli_real_escape_string($conn, $_POST['completed_by']);
							$suitable_for_class = mysqli_real_escape_string($conn, $_POST['suitable_for_class']);
							$appropriate_seating = mysqli_real_escape_string($conn, $_POST['appropriate_seating']);
							$adequate_seating = mysqli_real_escape_string($conn, $_POST['adequate_seating']);
							$appropriate_flooring = mysqli_real_escape_string($conn, $_POST['appropriate_flooring']);
							$house_keeping = mysqli_real_escape_string($conn, $_POST['house_keeping']);
							$electrical_testing = mysqli_real_escape_string($conn, $_POST['electrical_testing']);
							$whiteboard_visibility = mysqli_real_escape_string($conn, $_POST['whiteboard_visibility']);
							$adequate_ventilation = mysqli_real_escape_string($conn, $_POST['adequate_ventilation']);
							$sufficient_lighting = mysqli_real_escape_string($conn, $_POST['sufficient_lighting']);
							$appropriate_acoustics = mysqli_real_escape_string($conn, $_POST['appropriate_acoustics']);
							$disruptive_noise = mysqli_real_escape_string($conn, $_POST['disruptive_noise']);
							$refreshment_facility = mysqli_real_escape_string($conn, $_POST['refreshment_facility']);
							$general_signage = mysqli_real_escape_string($conn, $_POST['general_signage']);
							$appropriate_access_area = mysqli_real_escape_string($conn, $_POST['appropriate_access_area']);
							$breakout_rooms = mysqli_real_escape_string($conn, $_POST['breakout_rooms']);
							$adequate_restroom = mysqli_real_escape_string($conn, $_POST['adequate_restroom']);
							$water_access = mysqli_real_escape_string($conn, $_POST['water_access']);
							$adequate_toilets = mysqli_real_escape_string($conn, $_POST['adequate_toilets']);
							$parking_transport = mysqli_real_escape_string($conn, $_POST['parking_transport']);
							$emergency_place = mysqli_real_escape_string($conn, $_POST['emergency_place']);
							$unacceptable_behaviour = mysqli_real_escape_string($conn, $_POST['unacceptable_behaviour']);
							$others = mysqli_real_escape_string($conn, $_POST['others']);
							$comments = mysqli_real_escape_string($conn, $_POST['comments']);
							$insert = $conn->query("UPDATE location_checklist SET venue_details='".$venue_details."', room_location= '".$room_location."', address= '".$address."', region='".$region."', assessment_date= '".$assessment_date."',contact_person='".$contact_person."',contact_phone='".$contact_phone."',contact_email='".$contact_email."',completed_by='".$completed_by."' WHERE location_id=".$location_id);
							$insert1 = $conn->query("UPDATE room_checklist SET suitable_for_class='".$suitable_for_class."', appropriate_seating= '".$appropriate_seating."', adequate_seating= '".$adequate_seating."', appropriate_flooring='".$appropriate_flooring."', house_keeping= '".$house_keeping."', electrical_testing='".$electrical_testing."', whiteboard_visibility='".$whiteboard_visibility."', adequate_ventilation='".$adequate_ventilation."', sufficient_lighting='".$sufficient_lighting."', appropriate_acoustics='".$appropriate_acoustics."', disruptive_noise='".$disruptive_noise."', refreshment_facility='".$refreshment_facility."', general_signage='".$general_signage."', appropriate_access_area='".$appropriate_access_area."', breakout_rooms='".$breakout_rooms."', adequate_restroom='".$adequate_restroom."', water_access='".$water_access."', adequate_toilets='".$adequate_toilets."', parking_transport='".$parking_transport."', emergency_place='".$emergency_place."', unacceptable_behaviour='".$unacceptable_behaviour."', others='".$others."', comments='".$comments."' WHERE location_id=".$location_id);
							if($insert1){
								$msg = 'Data Updated Successfully.';
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
						$location_checklist = $conn->query("SELECT * FROM location_checklist WHERE location_id=".$_GET['id'])->fetch_assoc();
						$room_checklist = $conn->query("SELECT * FROM room_checklist WHERE location_id=".$_GET['id'])->fetch_assoc();
						?>
						
                        <div class="ibox-content">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="location_id" value="<?php echo $location_checklist['location_id']; ?>"/>
                                <div class="form-group  row"><label class="col-sm-5 col-form-label">Venue Details</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" required name="venue_details" value="<?php echo $location_checklist['venue_details']; ?>"></div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-5 col-form-label">Room Location</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" required name="room_location" value="<?php echo $location_checklist['room_location']; ?>"></div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-5 col-form-label">Address</label>
                                    <div class="col-sm-7"><textarea type="text" class="form-control" name="address"><?php echo $location_checklist['address']; ?></textarea></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Region</label>
                                    <div class="col-sm-7">
                                        	<select class="form-control select" required name="region">
    											<option value="">Select</option>
    											<option value="Metro" <?php if($location_checklist['region'] == 'Metro') { echo 'selected'; } ?>>Metro</option>
    											<option value="Barwon South West" <?php if($location_checklist['region'] == 'Barwon South West') { echo 'selected'; } ?>>Barwon South West</option>
    											<option value="Gippsland" <?php if($location_checklist['region'] == 'Gippsland') { echo 'selected'; } ?>>Gippsland</option>
    											<option value="Grampains Central West" <?php if($location_checklist['region'] == 'Grampains Central West') { echo 'selected'; } ?>>Grampains Central West</option>
    											<option value="Hume" <?php if($location_checklist['region'] == 'Hume') { echo 'selected'; } ?>>Hume</option>
    											<option value="Loddon Mallee" <?php if($location_checklist['region'] == 'Loddon Mallee') { echo 'selected'; } ?>>Loddon Mallee</option>
    										</select>
                                    </div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-5 col-form-label">Date of Assessment</label>
                                    <div class="col-sm-7"><input type="date" class="form-control" required name="assessment_date" value="<?php echo $location_checklist['assessment_date']; ?>"></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-5 col-form-label">Contact Person Name</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" required name="contact_person" value="<?php echo $location_checklist['contact_person']; ?>"></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-5 col-form-label">Contact Person Phone/Mobile</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" required name="contact_phone" value="<?php echo $location_checklist['contact_phone']; ?>"></div>
                                </div>
                                  <div class="form-group  row"><label class="col-sm-5 col-form-label">Contact Person Email</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" required name="contact_email" value="<?php echo $location_checklist['contact_email']; ?>"></div>
                                </div>
								<div class="hr-line-dashed"></div>
                                 <div class="form-group  row"><label class="col-sm-5 col-form-label">Checklist Completed By</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" required name="completed_by" value="<?php echo $location_checklist['completed_by']; ?>"></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Suitable for class size (maximun 20 participants)</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="suitable_for_class">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['suitable_for_class'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['suitable_for_class'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Seating arrangement is appropriate</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="appropriate_seating">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['appropriate_seating'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['appropriate_seating'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Adequate seating for the duartion of the course</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="adequate_seating">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['adequate_seating'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['adequate_seating'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Appropriate Flooring (for example: in good condition)</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="appropriate_flooring">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['appropriate_flooring'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['appropriate_flooring'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Housekeeping is acceptable</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="house_keeping">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['house_keeping'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['house_keeping'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Inspection and testing of electrical leads</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="electrical_testing">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['electrical_testing'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['electrical_testing'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">PowerPoint/Whiteboard visibility for all participants</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="whiteboard_visibility">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['whiteboard_visibility'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['whiteboard_visibility'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Adequate ventilation and appropriate temperature</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="adequate_ventilation">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['adequate_ventilation'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['adequate_ventilation'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Sufficient lighting</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="sufficient_lighting">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['sufficient_lighting'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['sufficient_lighting'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Appropriate room acousticks</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="appropriate_acoustics">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['appropriate_acoustics'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['appropriate_acoustics'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">No distracting or disruptive noises</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="disruptive_noise">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['disruptive_noise'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['disruptive_noise'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Refreshment facilities are suitable nearby</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="refreshment_facility">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['refreshment_facility'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['refreshment_facility'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">General signage (for example: exit signs, room numbers etc.)</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="general_signage">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['general_signage'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['general_signage'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Access area are appropriate (for example: stairs, ramps, lifts etc.)</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="appropriate_access_area">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['appropriate_access_area'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['appropriate_access_area'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Breakout rooms are appropriate for group work</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="breakout_rooms">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['breakout_rooms'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['breakout_rooms'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Adequate restrooms</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="adequate_restroom">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['adequate_restroom'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['adequate_restroom'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Access to water and refreshments</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="water_access">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['water_access'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['water_access'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Adequate disabled toilets</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="adequate_toilets">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['adequate_toilets'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['adequate_toilets'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Parking or transport is available/nearby</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="parking_transport">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['parking_transport'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['parking_transport'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Emergency precedures/plans/signs are in place</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="emergency_place">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['emergency_place'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['emergency_place'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-5 col-form-label">Support available for trainer in the event of unaccepatable participant behaviour</label>
                                    <div class="col-sm-7">
                                    	<select class="form-control select" required name="unacceptable_behaviour">
											<option value="">Select</option>
											<option value="Yes" <?php if($room_checklist['unacceptable_behaviour'] == 'Yes') { echo 'selected'; } ?>>Yes</option>
											<option value="No" <?php if($room_checklist['unacceptable_behaviour'] == 'No') { echo 'selected'; } ?>>No</option>
										</select>
                                    </div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-5 col-form-label">Other...</label>
                                    <div class="col-sm-7"><textarea class="form-control" name="others"><?php echo $room_checklist['others']; ?></textarea></div>
                                </div>
                                <div class="form-group  row"><label class="col-sm-5 col-form-label">Comments/Action Required</label>
                                    <div class="col-sm-7"><textarea class="form-control" name="description"><?php echo $room_checklist['description']; ?></textarea></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-5 col-sm-offset-2">
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
</body>
</html>