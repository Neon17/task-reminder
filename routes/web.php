<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskUserController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // here we define routes for verified email users;
});

// for testing fortify email verification
Route::middleware(['auth'])->group(function () {
    Route::get('/test-verification', function () {
        $user = User::find(Auth::id());

        if ($user->hasVerifiedEmail()) {
            return 'Email already verified!';
        }

        $user->sendEmailVerificationNotification();
        return 'Verification email sent! Check your email.';
    });

    Route::get('/verification-status', function () {
        $user = User::find(Auth::id());
        return [
            'email' => $user->email,
            'verified' => $user->hasVerifiedEmail(),
            'verified_at' => $user->email_verified_at,
        ];
    });
});

Route::get('/excel-test', [TaskController::class, 'testExcel']);

Route::middleware([
    'auth:sanctum',
])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/register', function () {
        return response()->json([
            'message' => 'You are not authorized to access this page.',
            'advice' => 'Please contact the admin to register a new account.'
        ]);
    });

    Route::middleware(isAdmin::class)->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('users.index')->middleware(isAdmin::class);
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware(isAdmin::class);
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(isAdmin::class);
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('tasks/trashes', [TaskController::class, 'trashedTasks'])->name('tasks.trashed');
    });

    Route::get('api/users/search/{query}', function (string $query) {
        // info('query = '.$query);
        return User::where('id', '!=', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);
    });

    Route::get('/users/export', [UserController::class, 'exportFiltered'])->name('users.exportFiltered');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/trashed/items', [UserController::class, 'trashedItems'])->name('users.trashed');
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('users/{user}/forceDelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');

    Route::get('/tasks/export/', [TaskController::class, 'exportFiltered'])->name('tasks.exportFiltered');
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}', [TaskController::class, 'delete'])->name('tasks.delete'); //here delete form is rendered and notes are required for delete so
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::post('tasks/{task}/forceDelete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');
    Route::post('tasks/{task}/complete', [TaskController::class, 'completeTask'])->name('tasks.complete');
    Route::get('tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::get('/tasks/export', [TaskController::class, 'exportFiltered'])->name('tasks.exportFiltered');
    // Route::get('tasks/export', function() {
    //     log('Export route hit'); // Check storage/logs/laravel.log
    //     return "Hello, Exporting takes time...";
    // })->name('tasks.exportFiltered');

    // Route::get('tasks/{task}/notes', [TaskController::class, 'notes'])->name('tasks.notes');
    Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('notes/export', [NoteController::class, 'exportFiltered'])->name('notes.exportFiltered');

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

Route::get('/auth/redirect', [UserController::class, 'googleRedirect'])->name('google.login');

Route::get('/auth/callback', [UserController::class, 'googleCallback']);

Route::get('/test', function () {
    return view('test');
})->name('test');
