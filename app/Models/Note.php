<?php

namespace App\Models;

use App\Traits\HandlesTimeZones;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    //
    use HasFactory, HandlesTimeZones;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'task_id',
        'labels',
        'reason',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'labels' => 'array'
    ];

    // app/Models/Note.php
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['reason'] ?? false, fn($q, $reason) =>
            $q->where('reason', $reason))
            ->when($filters['category'] ?? false, function ($q, $category) {
                if ($category == 'creator') {
                    $q->whereHas('task', function ($q) {
                        $q->where('created_by', Auth::id());
                    });
                } elseif ($category == 'follower') {
                    $q->whereHas('task', function ($q) {
                        $q->whereHas('followers', function ($q) {
                            $q->where('user_id', Auth::id());
                        });
                    });
                } elseif ($category == 'others') {
                    $q->where(function ($q) {
                        $q->whereDoesntHave('task', function ($q) {
                            $q->where('created_by', Auth::id());  // Task not created by you
                        })
                            ->whereDoesntHave('task.followers', function ($q) {
                                $q->where('user_id', Auth::id());  // Task not followed by you
                            });
                    });
                }
            })
            ->when($filters['title'] ?? false, fn($q, $title) =>
            $q->where('title', 'like', "%{$title}%"))
            ->when($filters['user_id'] ?? false, fn($q, $userId) =>
            $q->where('user_id', $userId))
            ->when($filters['task_id'] ?? false, fn($q, $taskId) =>
            $q->where('task_id', $taskId))
            ->when($filters['reason'] ?? false, fn($q, $reason) =>
            $q->where('reason', 'like', "%{$reason}%"));
    }

    public function scopeSort($query, $sort = '')
    {
        if (!$sort) return $query->latest();

        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $column = ltrim($sort, '-');

        return in_array($column, $this->fillable)
            ? $query->orderBy($column, $direction)
            : $query->latest();
    }

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
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }
}
