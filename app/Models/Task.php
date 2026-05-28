<?php

namespace App\Models;

use App\Traits\HandlesTimeZones;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    //
    use HasFactory, SoftDeletes, HandlesTimeZones;

    protected $fillable = [
        'title',
        'description',
        'created_by',
        'assigned_date',
        'completed_date',
        'notification_start_date',
        'notification_interval',
        'last_notified_at',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'assigned_date' => 'datetime',
        'completed_date' => 'datetime',
        'notification_start_date' => 'datetime',
        'last_notified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['assignee'] ?? false, function ($q, $assignee) {
                if ($assignee === 'follower') {
                    $q->whereHas('followers', fn($q) => $q->where('user_id', Auth::id()));
                } elseif ($assignee === 'creator') {
                    $q->where('created_by', Auth::id());
                } elseif ($assignee === 'others'){
                    $q->where('created_by', '!=', Auth::id())
                        ->whereDoesntHave('followers', fn($q) => $q->where('user_id', Auth::id()));
                }
            })
            ->when($filters['title'] ?? false, fn($q, $title) =>
            $q->where('title', 'like', "%{$title}%"))
            ->when($filters['created_by'] ?? false, fn($q, $createdBy) =>
            $q->where('created_by', $createdBy))
            ->when($filters['status'] ?? false, function ($q, $status) {
                return match ($status) {
                    'completed' => $q->whereNotNull('completed_date'),
                    'pending' => $q->whereNull('completed_date'),
                    default => $q
                };
            });
    }

    public function scopeSort($query, $sort = "")
    {
        if (!$sort) return $query->latest();

        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        $sortableColumns = array_merge($this->fillable);

        return in_array($column, $sortableColumns)
            ? $query->orderBy($column, $direction)
            : $query->latest();
    }

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

    public function canComplete()
    {
        // it checks if the user is authorized to complete the task
        // only task creator and admin can complete the task

        return $this->created_by == Auth::user()->id || Auth::user()->role == 'admin';
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
