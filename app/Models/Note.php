<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'task_id',
        'reason'
    ];

    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
}