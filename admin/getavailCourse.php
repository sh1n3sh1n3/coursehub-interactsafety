<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Select Slot</th>
            <th>Select Date</th>
            <th>Course Dates</th>
            <th>Venue</th>
        </tr> 
    </thead>
    <tbody>
<?php include('includes/conn.php'); 
$course = $_POST['course'];$cnt=0;$dates='';
$course_slots = $conn->query("SELECT * FROM course_slots WHERE courseid='".$course."' AND makecapacity > 0");
while($fetchcouslot = $course_slots->fetch_assoc()) { $cnt++;$dates='';
$location = $conn->query("SELECT * FROM locations WHERE id=".$fetchcouslot['locid'])->fetch_assoc();
$cities = $conn->query("SELECT * FROM cities WHERE id=".$fetchcouslot['cityid'])->fetch_assoc();
$states = $conn->query("SELECT * FROM states WHERE id=".$cities['state_id'])->fetch_assoc();
$opurse_startdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
$opurse_enddates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
$cpurse_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date ASC");
$ccnntt=0; while($fetchdates = $cpurse_dates->fetch_assoc()) {$ccnntt++;
    $startdate = date('d/M/Y', strtotime($fetchdates['date']));
    $starttimeh = date('h:i A', strtotime($fetchdates['starttime']));
    $endtimeh = date('h:i A', strtotime($fetchdates['endtime']));
    $dates .= 'Day '.$ccnntt.' - '.$startdate.' ('.$starttimeh.'-'.$endtimeh.')'.'<hr>';
}
$slotid = $fetchcouslot['id'];
$course_dates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcouslot['id']."' ORDER BY date DESC LIMIT 1")->fetch_assoc();
if($course_dates['date'] >= date('Y-m-d')) {
?>
    <tr>
        <td><input type="radio" onclick="makereq(<?php echo $slotid; ?>)" class="radiobtn" id="checked_<?php echo $slotid; ?>" value="<?php echo $fetchcouslot['id']; ?>" name="slotid"/></td>
        <td><input class="joindate" type="date" id="joindate_<?php echo $slotid; ?>" onchange="checkdates(this.value, '<?php echo $slotid; ?>')" name="joindate" min="<?php if($opurse_startdates['date'] >= date('Y-m-d')) { echo $opurse_startdates['date']; } else { echo date('Y-m-d'); }?>" max="<?php echo $opurse_enddates['date']; ?>"/>
        <p class="error_<?php echo $slotid; ?>" style="color:red"></p>
        </td>
        <td><?php echo $dates; ?></td>
        <td><?php echo $location['title'].' '.$location['location'].' '.$cities['name'].' '.$states['name']; ?></td>
    </tr>
<?php }} ?>
    </tbody>
</table>