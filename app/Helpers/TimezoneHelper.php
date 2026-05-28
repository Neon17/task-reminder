<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTimeZone;

class TimezoneHelper
{
    /**
     * Return list of timezones with UTC offset
     */
    public static function all()
    {
        $timezones = DateTimeZone::listIdentifiers();
        $now = Carbon::now();

        $formatted = [];

        foreach ($timezones as $tz) {
            $offset = $now->setTimezone($tz)->getOffset(); // in seconds
            $formatted[] = [
                'value' => $tz,
                'label' => sprintf('UTC%+03d:%02d — %s', $offset / 3600, abs($offset) % 3600 / 60, $tz),
                'offset' => $offset,
            ];
        }

        // Sort by UTC offset
        usort($formatted, fn($a, $b) => $a['offset'] <=> $b['offset']);

        return $formatted;
    }
}
