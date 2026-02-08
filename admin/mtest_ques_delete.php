<?php 
include 'session.php'; 
if(isset($_POST['checked_id']))
{
	foreach($_POST['checked_id'] as $checked_id)
	{
		$query12 = mysqli_query($con,"delete from mques where id='".$checked_id."'");
	}
	echo 'ok';
}
else
{
	echo 'error';
}	
?>