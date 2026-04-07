<?php

/**
 * Public course seat labels for listing pages (course detail / preview).
 * Spec: seats > 5 → "Seats Available"; 2–5 → "Only X seats left"; 1 → "Last seat remaining".
 */
function format_public_seat_availability_label($seatsRemaining)
{
    $n = (int) $seatsRemaining;
    if ($n <= 0) {
        return 'No seats available';
    }
    if ($n === 1) {
        return 'Last seat remaining';
    }
    if ($n <= 5) {
        return 'Only ' . $n . ' seats left';
    }
    return 'Seats Available';
}

/**
 * Remaining seats for a slot: maxcapacity minus enrolled count (remain_places.count).
 */
function get_public_seats_remaining($conn, $courseid, $slotid)
{
    $courseid = (int) $courseid;
    $slotid = (int) $slotid;
    if ($courseid <= 0 || $slotid <= 0) {
        return null;
    }
    $slotRes = $conn->query('SELECT maxcapacity FROM course_slots WHERE id=' . $slotid . ' AND courseid=' . $courseid);
    if (!$slotRes || $slotRes->num_rows === 0) {
        return null;
    }
    $slot = $slotRes->fetch_assoc();
    $max = (int) ($slot['maxcapacity'] ?? 0);
    $count = 0;
    $rpRes = $conn->query('SELECT count FROM remain_places WHERE courseid=' . $courseid . ' AND slotid=' . $slotid);
    if ($rpRes && $rpRes->num_rows > 0) {
        $rp = $rpRes->fetch_assoc();
        $count = (int) ($rp['count'] ?? 0);
    }
    return $max - $count;
}

/**
 * User-facing message when enrolment/payment must be blocked due to capacity.
 */
function format_course_capacity_block_message($seatsRemaining)
{
    $n = max(0, (int) $seatsRemaining);
    if ($n === 0) {
        return 'No seats remaining for this course.';
    }
    return 'Only ' . $n . ($n === 1 ? ' seat' : ' seats') . ' remaining for this course.';
}
