<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HandlesTimeZones;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HandlesTimeZones;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use SoftDeletes;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'timezone',
        'password',
        'email_verified_at',
        'created_at',
        'updated_at'
    ];

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Search by name or email
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Email verification status
        if (!empty($filters['email'])) {
            $query->where(
                'email_verified_at',
                $filters['email'] === 'verified' ? '!=' : '=',
                null
            );
        }

        // Role filter
        if (!empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        // Timezone filter
        if (!empty($filters['timezone'])) {
            $query->where('timezone', $filters['timezone']);
        }

        return $query;
    }

    public function scopeSort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'name' => $query->orderBy('name'),
            '-name' => $query->orderByDesc('name'),
            'created_date' => $query->orderBy('created_at'),
            '-created_date' => $query->orderByDesc('created_at'),
            default => $query,
        };
    }


    public function isAdmin()
    {
        return $this->role == 'admin';
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function followedTasks()
    {
        return $this->belongsToMany(Task::class, 'task_user_followers')->withTimestamps();
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->convertToUserTimezone($value),
            set: fn($value) => $this->convertUserDateToUTC($value)
        );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
