<?php

namespace App\Models;

use App\Traits\HandlesTimeZones;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Task extends Model
{
    //
    use SoftDeletes, HandlesTimeZones;

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'assigned_date',
        'completed_date',
        'notification_start_date',
        'notification_interval',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'task_user_followers')->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }


    // Defining mutators and accessors: set is mutators, get is accessors

    protected function assignedDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }

    protected function completedDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }

    protected function notificationStartDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }
}
