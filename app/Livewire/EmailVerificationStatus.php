<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EmailVerificationStatus extends Component
{
    public function sendVerificationEmail()
    {
        $user = User::find(Auth::id());
        
        if ($user->hasVerifiedEmail()) {
            session()->flash('message', 'Email is already verified.');
            return;
        }

        $user->sendEmailVerificationNotification();
        session()->flash('message', 'Verification email sent!');
    }

    public function render()
    {
        return view('livewire.email-verification-status');
    }
}