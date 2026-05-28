<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //
    public function index()
    {
        // Divide the tasks into logged in users' tasks, tasks they are following, and tasks they are not following
        $tasks = Task::with('creator')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
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
            ]
        ]);
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_date' => $request->date_of_completion,
            'notification_start_date' => $request->notification_start_date,
            'notification_interval' => $request->notification_interval,
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    public function show() {}

    public function edit($id) {
        $task = Task::where('id', $id)->with('creator')->first();
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request) {}

    public function destroy() {}
}
