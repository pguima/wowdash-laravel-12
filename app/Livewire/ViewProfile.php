<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use Livewire\WithFileUploads;

class ViewProfile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $department;
    public $designation;
    public $language = 'English';
    public $description;
    public $image;

    // Password Update
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->department = $user->department;
        $this->designation = $user->designation;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'department' => 'nullable|string|max:255',
            'designation' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120', // 5MB Max
        ]);

        $user = Auth::user();
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'department' => $this->department,
            'designation' => $this->designation,
        ];

        if ($this->image) {
            $imageName = $this->image->store('profile-photos', 'public');
            $data['image'] = $imageName;
        }

        $user->update($data);

        session()->flash('message', 'Profile updated successfully.');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('password_message', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.view-profile')->extends('layouts.app')->section('content');
    }
}
