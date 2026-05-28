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
    public function index(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'created_by' => 'nullable|integer|exists:users,id',
            'status' => "nullable|in:completed,pending,''",
            'sort' => 'nullable|string', // e.g., "assigned_date,-created_at"
            'assignee' => "nullable|string|in:creator,follower,''",
            'per_page' => 'nullable|integer|min:1|max:100'
        ]);

        $tasks = Task::query()
            ->filter($validated)
            ->sort($validated["sort"] ?? null)
            ->paginate($validated["per_page"] ?? 10)->withQueryString();


        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    public function trashedTasks(Request $request)
    {
        $trashedtasks = [];

        $trashedtasks = Task::onlyTrashed()->with('creator')->get();

        return view('tasks.trashes', [
            'tasks' => $trashedtasks
        ]);
    }


    public function create()
    {
        return view('tasks.create');
    }

    public function restore($id)
    {
        //trashed object doesn't bind automatically, so can't write Task $task instead of $id in parameter
        $task = Task::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('tasks.index')->with('success', 'Task restored successfully!');
    }

    public function forceDelete($id)
    {
        $task = Task::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted permanently!');
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);
        $task = Task::create([
            'title' => $validated["title"],
            'description' => $validated["description"],
            'assigned_date' => $validated["date_of_completion"],
            'notification_start_date' => $validated["notification_start_date"],
            'notification_interval' => $validated["notification_interval"],
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
        $task = Task::where('id', $task->id)->with('creator', 'followers')->first();
        return view('tasks.show', compact('task'));
    }

    public function complete($task)
    {
        if ($task->completed_date) {
            return redirect()->route('tasks.index')->with('error', 'Task already completed!');
        }
        return view('tasks.complete', compact('task'));
    }

    public function completeTask(Request $request, Task $task)
    {
        if ($task->completed_date) {
            return redirect()->route('tasks.index')->with('error', 'Task already completed!');
        }
        $request->validate([
            'notes' => 'required'
        ]);

        $task->update([
            'completed_date' => now()
        ]);

        $task->notes()->create([
            'reason' => 'completion',
            'description' => $request->notes,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task completed successfully!');
    }

    public function edit($id)
    {
        // Should we need to extract joined at?
        $task = Task::where('id', $id)->with('creator', 'followers', 'notes')->first();

        if ($task->completed_date) {
            return redirect()->back()->with('error', 'Task already completed!');
        }

        if (($task->created_by != Auth::user()->id) && (Auth::user()->role != 'admin')) {
            return redirect()->back()->with('error', 'Only task creator and admin are authorized to edit this task!'); //back() suitable or route('tasks.index')
        }
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        if (!$task) {
            return redirect()->route('tasks.index')->with('error', 'Task not found!');
        }
        $validated = $this->validateRequest($request);
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

    public function delete(Task $task)
    {
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

    public function validateRequest($request){
        return $request->validate([
            'title' => 'required|max:30',
            'description' => 'required|max:255',
            'notification_start_date' => 'required|after:today',
            'date_of_completion' => 'required|after:today',
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
    }
}
