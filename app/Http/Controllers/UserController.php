<?php

namespace App\Http\Controllers;

use App\Helpers\TimezoneHelper;
use App\Exports\UsersExport;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Facades\Socialite;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    //
    public function dashboard()
    {
        //$recentTasks, $pendingTasksCount, $completedTodayCount, $teamMembersCount
        //recent tasks can be 3

        $recentTasks = Task::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->limit(3)->get();
        $pendingTasksCount = Task::where('created_by', Auth::user()->id)->where('completed_date', null)->count();
        $completedTodayCount = Task::where('created_by', Auth::user()->id)->whereDate('completed_date', Carbon::today())->count();
        $teamMembersCount = Task::with('followers')->count() + 1;

        return view('dashboard', compact('recentTasks', 'pendingTasksCount', 'completedTodayCount', 'teamMembersCount'));
    }

    public function trashedItems(Request $request)
    {
        $trashedusers = [];

        $trashedusers = User::onlyTrashed()->paginate(15)->withQueryString();
        // return $trashedusers;

        return view('users.trashes', [
            'users' => $trashedusers
        ]);
    }

    public function restore($id)
    {
        //trashed object doesn't bind automatically, so can't write Task $task instead of $id in parameter
        $task = User::onlyTrashed()->where('id', $id)->restore();
        return redirect()->route('users.index')->with('success', 'User restored successfully!');
    }

    public function index(Request $request)
    {
        $timezones = TimezoneHelper::all();
        $labels = [];
        foreach ($timezones as $timezone) {
            $labels[] = $timezone['value'];
        }
        $strTimezones = implode(',', $labels);

        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'status' => "nullable|in:trashed, ''",
            // 'email' => 'nullable|in:unverified,verified',
            'role' => 'nullable|in:admin,user',
            // 'timezone' => 'nullable|in:'.$strTimezones,
            'sort' => 'nullable|string',
        ]);

        $users = User::where('id', '!=', Auth::user()->id);
        $users = $users->filter($validated)
            ->sort($validated['sort'] ?? null);

        if ($request->export_excel == 'true') {
            return Excel::download(new UsersExport($users->get()), 'users.xlsx');
        }

        $users = $users->paginate(15)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function exportFiltered(Request $request)
    {
        $timezones = TimezoneHelper::all();
        $labels = [];
        foreach ($timezones as $timezone) {
            $labels[] = $timezone['value'];
        }
        $strTimezones = implode(',', $labels);

        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'email' => 'nullable|in:unverified,verified',
            'role' => 'nullable|in:admin,user',
            'timezone' => 'nullable|in:' . $strTimezones,
            'sort' => 'nullable|string',
        ]);

        $users = User::where('id', '!=', Auth::user()->id);
        $users = $users->filter($validated)
            ->sort($validated['sort'] ?? null);

        return Excel::download(new UsersExport($users->get()), 'users.xlsx');
    }

    public function create()
    {
        $timezones = TimezoneHelper::all();
        return view('users.create', compact('timezones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'timezone' => $request->timezone ? $request->timezone : null,
            'role' => ($request->role) == 'admin' ? 'admin' : 'user'
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $timezones = TimezoneHelper::all();
        return view('users.edit', compact('user', 'timezones'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
                function ($attribute, $value, $fail) use ($user) {
                    if ($value === $user->email) {
                        return; // Allow the same email
                    }
                    // Additional check if we want to prevent specific emails
                    if (in_array($value, ['forbidden1@example.com', 'forbidden2@example.com'])) {
                        $fail("The {$attribute} is not allowed.");
                    }
                },
            ],
        ]);

        $user = User::find($user->id);
        $user = $user->update([
            'name' => $request->username,
            'email' => $request->email,
            'role' => ($request->role) == 'admin' ? 'admin' : 'user'
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        $timezones = TimezoneHelper::all();
        return view('users.show', compact('user', 'timezones'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            $finduser = User::where('email', $user->email)->first();

            if ($finduser) {
                Auth::login($finduser);

                $user = User::where('id', $finduser->id)->first();
                $user->email_verified_at = now();
                $user->save();

                return redirect()->intended('dashboard');
            }

            return redirect('/login')->withErrors([
                'message' => 'Your email is not registered. Please contact admin!'
            ]);
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'message' => 'Google login failed. Please try again.'
            ]);
        }
    }
}
