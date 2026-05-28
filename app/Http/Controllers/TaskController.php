<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function index()
    {
        // Divide the tasks into logged in users' tasks, tasks they are following, and tasks they are not following
        $alltasks = [];
        $yourtasks = [];
        $followedtasks = [];
        $trashedtasks = [];

        $user = User::find(Auth::user()->id);

        $alltasks = Task::where('created_by', '!=', Auth::user()->id)
            ->whereDoesntHave('followers', fn($q) => $q->where('user_id', Auth::user()->id))
            ->with('creator', 'followers')->get();
        $yourtasks = Task::where('created_by', Auth::user()->id)->with('creator')->get();
        $followedtasks = $user->followedTasks()->with('creator')->get();
        $trashedtasks = Task::onlyTrashed()->with('creator')->get();

        // $tasks = Task::with('creator', 'followers')->get();
        // return $tasks;

        return view('tasks.index', [
            'tasks' => $alltasks,
            'yourtasks' => $yourtasks,
            'followedtasks' => $followedtasks,
            'trashedtasks' => $trashedtasks
        ]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function restore($id){
        //trashed object doesn't bind automatically, so can't write Task $task instead of $id in parameter
        $task = Task::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('tasks.index')->with('success', 'Task restored successfully!');
    }

    public function forceDelete($id){
        $task = Task::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted permanently!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:15',
            'description' => 'required|max:255',
            'notification_start_date' => 'required|after:today',
            'date_of_completion' => 'required|date|after:today',
            'notification_interval' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $startDate = Carbon::parse($request->notification_start_date);
                    $endDate = Carbon::parse($request->date_of_completion);
                    $maxInterval = $startDate->diffInDays($endDate);

                    info("maxInterval = $maxInterval");
                    info("Value = $value");

                    if ($value > $maxInterval) {
                        $fail("The notification interval cannot exceed $maxInterval days. Your value = $value");
                    }
                }
            ],
            'notes' => 'required'
        ]);
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_date' => $request->date_of_completion,
            'notification_start_date' => $request->notification_start_date,
            'notification_interval' => $request->notification_interval,
            'created_by' => Auth::user()->id,
        ]);

        $task->notes()->create([
            'reason' => 'creation', // no need as creation is default
            'description' => $request->notes,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        //this route is for showing single Task
    }

    public function edit($id)
    {
        // Should we need to extract joined at?
        $task = Task::where('id', $id)->with('creator', 'followers')->first();
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found!');
        }
        $validated = $request->validate([
            'title' => 'required|max:15',
            'description' => 'required|max:255',
            'notification_start_date' => 'required|after:today|before:date_of_completion',
            'date_of_completion' => 'required|date|after:today',
            'notification_interval' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $startDate = Carbon::parse($request->notification_start_date);
                    $endDate = Carbon::parse($request->date_of_completion);
                    $maxInterval = $startDate->diffInDays($endDate);

                    if ($value > $maxInterval) {
                        $fail("The notification interval cannot exceed $maxInterval days. Your value = $value");
                    }
                }
            ]
        ]);
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'assigned_date' => $validated['date_of_completion'],
            'notification_start_date' => $validated['notification_start_date'],
            'notification_interval' => $validated['notification_interval'],
        ]);

        $task->notes()->create([
            'reason' => 'updation',
            'description' => $request->notes,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function delete(Task $task) {
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found!');
        }
        return view('tasks.delete', compact('task'));
    }

    public function destroy(Request $request, Task $task)
    {
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found!');
        }
        $task->notes()->create([
            'reason' => 'deletion',
            'description' => $request->notes,
            'user_id' => Auth::user()->id
        ]);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
