<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;
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

    Route::get('/index', [UserController::class,'index'])->name('users.index')->middleware(isAdmin::class);
    Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware(isAdmin::class);
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware(isAdmin::class);
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(isAdmin::class);
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware(isAdmin::class);
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(isAdmin::class);
    
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}', [TaskController::class, 'delete'])->name('tasks.delete'); //here delete form is rendered and notes are required for delete so
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore'); // says not found
    Route::post('tasks/{task}/forceDelete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');

    // Route::get('tasks/{task}/notes', [TaskController::class, 'notes'])->name('tasks.notes');
    Route::get('notes', [NoteController::class, 'index'])->name('notes.index');

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
