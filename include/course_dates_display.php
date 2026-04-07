<?php
/**
 * Public course dates table: date on first line, HH:MM – HH:MM on second (no seconds, no brackets).
 */
function format_course_dates_table_cell_html($dateStr, $startTime, $endTime)
{
    $dateLine = date('M d, Y', strtotime($dateStr));
    $t1 = date('H:i', strtotime($startTime));
    $t2 = date('H:i', strtotime($endTime));
    $dash = "\xe2\x80\x93";

    return htmlspecialchars($dateLine, ENT_QUOTES, 'UTF-8')
        . '<br>'
        . htmlspecialchars($t1 . ' ' . $dash . ' ' . $t2, ENT_QUOTES, 'UTF-8');
}
