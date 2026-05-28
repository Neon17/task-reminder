<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\NotesExport;
use Maatwebsite\Excel\Facades\Excel;

class NoteController extends Controller
{
    //
    public function index(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer|exists:users,id',
            'sort' => 'nullable|string',
            'category' => 'nullable|string|in:creator,follower,others',
            'reason' => 'nullable|string|in:creation,completion,updation,deletion',
            'per_page' => 'nullable|integer|min:1|max:100'
        ]);

        if (Auth::user()->role=='admin') {
            $notes = Note::query();
        } else {
            $notes = Note::where(function($query){
                $query->where('user_id', Auth::user()->id)
                    ->orWhereHas('task', function($q){
                        $q->whereHas('followers', function($q){
                            $q->where('id', Auth::user()->id);
                        });
                    });
            });
        }

        $notes = $notes->filter($validated)
            ->sort($validated['sort'] ?? null)
            ->with(['task', 'user']); // maybe to fix N+1 problem

        if ($request->export_excel == 'true') {
            return Excel::download(new NotesExport($notes->get()), 'notes.xlsx');
        }

        $notes = $notes->paginate($validated['per_page'] ?? 15)->withQueryString();

        $users = [];
        if (Auth::user()->role=='admin') {
            $users = User::all(); // For user dropdown
        }


        return view('notes.index', compact('notes', 'users'));
    }
}
