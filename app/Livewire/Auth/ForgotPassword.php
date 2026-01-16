<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email = '';
    public $isModalOpen = false;

    public function sendResetLink()
    {
        $this->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->isModalOpen = true;
        } else {
            $this->addError('email', __($status));
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->email = '';
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->extends('layouts.auth')->section('content');
    }
}
