<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


trait HandlesTimeZones
{
    protected function convertToUserTimezone($value)
    {
        if (!$value) return null;

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        try {
            // If value is numeric, assume it's a Unix timestamp
            if (is_numeric($value)) {
                return Carbon::createFromTimestamp($value)->setTimezone($timezone)->format('Y-m-d H:i:s');
            }

            // Handle partial year formats like '2025', '25', etc.
            if (preg_match('/^\d{1,4}$/', $value)) {
                return Carbon::createFromDate((int) $value, 1, 1, $timezone)->format('Y-m-d H:i:s');
            }

            // Otherwise, parse as a general date string
            return Carbon::parse($value)->setTimezone($timezone)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::error("Timezone conversion failed: " . $e->getMessage());
            return $value;
        }
    }


    protected function convertUserDateToUTC($date)
    {
        if (!$date) return null;

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        try {
            // If numeric, assume it's a Unix timestamp
            if (is_numeric($date)) {
                return Carbon::createFromTimestamp($date, $timezone)->setTimezone('UTC')->format('Y-m-d H:i:s');
            }

            // If contains a 'T' (e.g., ISO format)
            if (str_contains($date, 'T')) {
                return Carbon::parse($date, $timezone)->setTimezone('UTC')->format('Y-m-d H:i:s');
            }

            // If date only (e.g., YYYY, YYYY-MM, YYYY-MM-DD)
            if (preg_match('/^\d{1,4}(-\d{1,2}){0,2}$/', $date)) {
                return Carbon::parse($date . ' 00:00:00', $timezone)->setTimezone('UTC')->format('Y-m-d H:i:s');
            }

            // If full datetime string (e.g., YYYY-MM-DD HH:MM or HH:MM:SS)
            return Carbon::parse($date, $timezone)->setTimezone('UTC')->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::error("UTC conversion failed: " . $e->getMessage());
            return null;
        }
    }
}
