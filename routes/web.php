<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/index', [UserController::class,'index'])->name('users.index');
    
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}', [TaskController::class, 'delete'])->name('tasks.delete'); //here delete form is rendered and notes are required for delete so
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');

    Route::prefix('tasks/{task}')->group(function () {
        Route::resource('followers', TaskUserController::class)->names([
            'index' => 'task.followers.index',
            'create' => 'task.followers.create',
            'store' => 'task.followers.store',
            'show' => 'task.followers.show',
            'edit' => 'task.followers.edit',
            'update' => 'task.followers.update',
            'destroy' => 'task.followers.destroy'
        ])
        ->parameters(['followers' => 'user']); // For destroy route to detach the follower
    });
});
