<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'created_at',
        'updated_at'
    ];

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
        ];
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

        if (explode(' ', $date) && count(explode(' ', $date)) == 2) {
            return Carbon::parse($date, $timezone)->shiftTimezone($timezone)->utc()->format('Y-m-d');
        } else {
            return Carbon::parse($date . ' 00:00:00', $timezone)->shiftTimezone($timezone)->utc()->format('Y-m-d H:i:s');
        }
    }
}
