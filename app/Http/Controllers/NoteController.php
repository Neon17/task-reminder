<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    //
    public function index() {
        $allnotes = [];
        $yournotes = [];
        $followednotes = [];
        $trashednotes = [];

        if (Auth::user()->role=='admin') {
            $notes = Note::with('task','user')->get();
            return view('notes.index', compact('notes'));
        }

        $yournotes = Note::with('task','user')->where('user_id', Auth::user()->id)->get();
        $followednotes = Note::with('task','user')->whereHas('task', fn($q) => $q->whereHas('followers', fn($q) => $q->where('user_id', Auth::user()->id)))->get();

        return view('notes.index', [
            'notes' => $yournotes,
            'followednotes' => $followednotes
        ]);
    }
}
