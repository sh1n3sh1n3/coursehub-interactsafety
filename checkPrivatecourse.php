<?php session_start(); include('include/conn.php'); 
$courseid = $_POST['courseid'];
$course_code = $_POST['course_code'];
$private_course = $conn->query("SELECT * FROM private_course WHERE course_code='".$course_code."'");
if($private_course->num_rows > 0) {
    $fetchcourse = $private_course->fetch_assoc();
    $fetchcourses = $conn->query("SELECT * FROM course_slots WHERE id='".$fetchcourse['slot_id']."'")->fetch_assoc();
    $fetchdates = $conn->query("SELECT * FROM course_dates WHERE slot_id='".$fetchcourses['id']."' ORDER BY date ASC LIMIT 1")->fetch_assoc();
        if($fetchcourses['isPublished'] == '1') {
            if($fetchcourse['course_id'] == $courseid) {
                $maxcapacity = $fetchcourses['maxcapacity'];
                $remain_places = $conn->query("SELECT * FROM remain_places WHERE courseid='".$courseid."' AND slotid='".$fetchcourses['id']."'")->fetch_assoc();
                $leftplace = $maxcapacity - $remain_places['count'];
                if($leftplace > 0) {
                    if($fetchdates['date'] >= date('Y-m-d')) {
                        echo 'registration/'.$fetchcourses["courseid"].'/'.$fetchcourses["locid"].'/'.$fetchcourses["id"].'/'.$fetchcourses["cityid"];
                        $_SESSION['client_emaill'] = $fetchcourse["client_email"];
                        $_SESSION['client_course_code'] = $fetchcourse["course_code"];
                    } else {
                        echo '4';
                    }
                } else {
                    echo '3';
                }
            } else {
                echo '2';
            }
        } else {
            echo '1';
        }
} else {
    echo '1';
}