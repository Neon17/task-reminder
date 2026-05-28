<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AssignFollowers extends Component
{
    public $task;
    public $name;
    public $existingFollowers;
    public function __construct($task=null, $name="followers")
    {
        $this->task = $task;
        $this->name = $name;
        $this->existingFollowers = $task?->followers ?? collect();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.assign-followers');
    }
}
