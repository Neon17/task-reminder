<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    //
    use SoftDeletes;

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
}
