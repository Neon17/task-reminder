<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Note extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'task_id',
        'reason',
        'created_at',
        'updated_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertToUTC($value)
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }

    // to get time from database, UTC time should be converted to user local timezone
    protected function convertToUserTimezone($date)
    {
        if (!$date) return null;

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        return Carbon::parse($date)->setTimezone($timezone);
    }

    // to store to database, inputed time in user local timezone should be converted to UTC
    protected function convertToUTC($date)
    {
        if ($date) return null;

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        return Carbon::parse($date)->shiftTimezone($timezone)->utc();
    }

    //User Date means date in user local timezone
    protected function convertUTCToUserDate($date)
    {
        if (!$date) return null;

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        return Carbon::parse($date, 'UTC')
            ->setTimezone($timezone)->format('Y-m-d');
    }

    protected function convertUserDateToUTC($date)
    {
        if (!$date) return null;

        $user = Auth::user();
        $timezone = $user->timezone ?? 'UTC';

        if (explode(' ', $date) && count(explode(' ', $date))==2) {
            return Carbon::parse($date, $timezone)->shiftTimezone($timezone)->utc()->format('Y-m-d');
        }
        else {
            return Carbon::parse($date . ' 00:00:00', $timezone)->shiftTimezone($timezone)->utc()->format('Y-m-d H:i:s');
        }
    }
}
