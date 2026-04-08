<?php
/**
 * Public course online booking cutoff (Melbourne time).
 *
 * Default: 6:00 PM Australia/Melbourne, N calendar days before the first session start
 * (first row in course_dates for the slot, ordered by date + start time).
 *
 * Later: replace with a per-slot column (e.g. course_slots.booking_closes_at) and read that here.
 */
if (!defined('PUBLIC_BOOKING_CUTOFF_ENABLED')) {
    define('PUBLIC_BOOKING_CUTOFF_ENABLED', true);
}
if (!defined('PUBLIC_BOOKING_CUTOFF_DAYS_BEFORE_FIRST_SESSION')) {
    define('PUBLIC_BOOKING_CUTOFF_DAYS_BEFORE_FIRST_SESSION', 2);
}
if (!defined('PUBLIC_BOOKING_CUTOFF_HOUR')) {
    define('PUBLIC_BOOKING_CUTOFF_HOUR', 18);
}
if (!defined('PUBLIC_BOOKING_CUTOFF_MINUTE')) {
    define('PUBLIC_BOOKING_CUTOFF_MINUTE', 0);
}
if (!defined('PUBLIC_BOOKING_CUTOFF_TZ')) {
    define('PUBLIC_BOOKING_CUTOFF_TZ', 'Australia/Melbourne');
}

/**
 * Unix timestamp of when online booking closes, or null if unknown.
 */
function public_booking_cutoff_timestamp_for_slot($conn, $slotId)
{
    $slotId = (int) $slotId;
    if ($slotId <= 0 || !($conn instanceof mysqli)) {
        return null;
    }
    $res = $conn->query(
        'SELECT date, starttime FROM course_dates WHERE slot_id=' . $slotId
        . ' ORDER BY date ASC, starttime ASC LIMIT 1'
    );
    if (!$res || $res->num_rows === 0) {
        return null;
    }
    $row = $res->fetch_assoc();
    $dateStr = trim((string) ($row['date'] ?? ''));
    $timeStr = trim((string) ($row['starttime'] ?? ''));
    if ($dateStr === '') {
        return null;
    }
    try {
        $tz = new DateTimeZone(PUBLIC_BOOKING_CUTOFF_TZ);
        $firstStart = new DateTime($dateStr . ' ' . ($timeStr !== '' ? $timeStr : '00:00:00'), $tz);
    } catch (Exception $e) {
        return null;
    }
    $cutoff = clone $firstStart;
    $cutoff->modify('-' . (int) PUBLIC_BOOKING_CUTOFF_DAYS_BEFORE_FIRST_SESSION . ' days');
    $cutoff->setTime((int) PUBLIC_BOOKING_CUTOFF_HOUR, (int) PUBLIC_BOOKING_CUTOFF_MINUTE, 0);
    return $cutoff->getTimestamp();
}

function public_booking_is_closed_for_slot($conn, $slotId)
{
    if (!PUBLIC_BOOKING_CUTOFF_ENABLED) {
        return false;
    }
    $ts = public_booking_cutoff_timestamp_for_slot($conn, $slotId);
    if ($ts === null) {
        return false;
    }
    $tz = new DateTimeZone(PUBLIC_BOOKING_CUTOFF_TZ);
    $now = new DateTime('now', $tz);
    return $now->getTimestamp() >= $ts;
}

function public_booking_closed_user_message()
{
    return 'Bookings for this session have closed. Please choose another date or contact us for assistance.';
}
