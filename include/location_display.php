<?php
/**
 * Booking / register label from slot city (cities.name) + Location Register (locations.location, locations.title).
 * Omits the middle segment when it repeats the city (e.g. "Seaford - Seaford (...)" → "Seaford (...)").
 */
function format_booking_location_label($cityName, $locationField, $title)
{
    $city = trim((string) ($cityName ?? ''));
    $loc = trim((string) ($locationField ?? ''));
    $ttl = trim((string) ($title ?? ''));

    $titleSuffix = $ttl !== '' ? ' (' . $ttl . ')' : '';

    $locDistinct = $loc;
    if ($city !== '' && $loc !== '' && strcasecmp($loc, $city) === 0) {
        $locDistinct = '';
    }

    if ($city === '' && $locDistinct === '') {
        return $ttl;
    }
    if ($city === '') {
        return $locDistinct . $titleSuffix;
    }
    if ($locDistinct === '') {
        return $city . $titleSuffix;
    }

    return $city $titleSuffix;
}
