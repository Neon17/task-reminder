<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait HandlesTimeZones
{
    protected function convertToUserTimezone($value)
    {
        if (!$value) {
            return null;
        }

        $timezone = Auth::user()->timezone ?? 'UTC';

        try {
            if (is_numeric($value)) {
                return Carbon::createFromTimestamp($value)
                    ->setTimezone($timezone)
                    ->format('Y-m-d H:i:s');
            }

            if (preg_match('/^\d{1,4}$/', $value)) {
                return Carbon::createFromDate((int) $value, 1, 1)
                    ->setTimezone($timezone)
                    ->format('Y-m-d H:i:s');
            }

            return Carbon::parse($value)
                ->setTimezone($timezone)
                ->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            Log::error("Timezone conversion failed: " . $e->getMessage());
            return $value;
        }
    }

    protected function convertUserDateToUTC($date)
    {
        if (!$date) {
            return null;
        }

        $timezone = Auth::user()->timezone ?? 'UTC';

        try {
            if ($date instanceof \DateTime) {
                return Carbon::instance($date)
                    ->setTimezone($timezone)
                    ->setTimezone('UTC')
                    ->format('Y-m-d H:i:s');
            }

            return Carbon::parse($date, $timezone)
                ->setTimezone('UTC')
                ->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            Log::error("UTC conversion failed: " . $e->getMessage());
            return null;
        }
    }
}