<?php
/**
 * Public course dates table: date on first line, h:mm AM/PM – h:mm AM/PM on second.
 */
function format_course_dates_table_cell_html($dateStr, $startTime, $endTime)
{
    $dateLine = date('M d, Y', strtotime($dateStr));
    $t1 = date('g:i A', strtotime($startTime));
    $t2 = date('g:i A', strtotime($endTime));
    $dash = "\xe2\x80\x93";

    return htmlspecialchars($dateLine, ENT_QUOTES, 'UTF-8')
        . '<br>'
        . htmlspecialchars($t1 . ' ' . $dash . ' ' . $t2, ENT_QUOTES, 'UTF-8');
}
