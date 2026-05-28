<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    //
    public function index() {
        $allnotes = [];
        $yournotes = [];
        $followednotes = [];
        $trashednotes = [];


        $notes = Note::with('task','user')->get();
        return view('notes.index', compact('notes'));
    }
}
