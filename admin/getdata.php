<?php include('session.php'); 
$locations = $conn->query("SELECT * FROM locations WHERE id=".$_POST['val'])->fetch_assoc();
$cities = $conn->query("SELECT * FROM cities WHERE id=".$locations['city'])->fetch_assoc();
$states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
echo $cities['id'].'_'.$cities['name'].'_'.$states['name'].'_'.$locations['maplink'].'_'.$locations['map'].'_'.$locations['description'];
?>