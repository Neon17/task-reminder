<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    //this controller is meant to add follower and remove follower
    public function index(Task $task){

        return view('tasks.followers.index', [
            'task' => $task,
            'followers' => $task->followers
        ]);
    }

    public function create(Task $task){
        // $unfollowedUsers = User::where('id', '!=', $task->created_by)
        //     ->whereDoesntHave('followedTasks', fn($q) => $q->where('task_id', $task->id))->get();

        $unfollowedUsers = User::where('id', '!=', $task->created_by)
            ->whereDoesntHave('followedTasks', function($query) use ($task) {
                $query->where('task_id', $task->id);
            })->get();


        return view('tasks.followers.create', [
            'task' => $task,
            'users' => $unfollowedUsers
        ]);
    }

    public function show(Task $task, User $user) {
        // return view('tasks.followers.show', [
        //     'task' => $task,
        //     'user' => $user
        // ]);
    }

    public function store(Request $request, Task $task){
        $request->validate([
            'selected_users' => 'required|array|min:1',
            'selected_users.*' => 'exists:users,id'
        ]);

        $task->followers()->attach($request->selected_users);
        return redirect()->route('task.followers.index', $task)->with('success', count($request->selected_users) . ' follower(s) added successfully');
    }

    public function destroy (Task $task, User $user) {
        $task->followers()->detach($user->id);
        return back()->with('success', 'Follower removed successfully');
    }
}
