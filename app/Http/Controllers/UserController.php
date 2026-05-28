<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
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
            'role' => ($request->role) == 'admin' ? 'admin' : 'user'
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
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

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
