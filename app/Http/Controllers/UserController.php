<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function index () {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function store(Request $request) {
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
            'role' => ($request->role)=='admin'?'admin':'user'
        ]);

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }
}
