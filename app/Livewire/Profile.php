<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $username;
    public $description;
    public $email;
    public $phone_number;
    public $role;
    public $image;
    public $new_image;
    public $password;
    public $passwordConfirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->description = $user->description;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->role = $user->role;
        $this->image = $user->image;
    }

    public function updateProfile()
    {
        $userId = Auth::id();

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:6', 'max:255',  'unique:users,username,' . $userId],
            'description' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',  'unique:users,email,' . $userId],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'phone_number' => ['required', 'string', 'min:6'],
            'new_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = User::findOrFail($userId);

        $user->name = $this->name;
        $user->username = $this->username;
        $user->description = $this->description;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;

        if ($this->new_image) {
            $path = $this->new_image->store('public/user');
            $user->image = $path;
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        if (!$user->save()) {
            $this->addError('email', trans('auth.failed'));
            return;
        }

        session()->flash('message', 'Profile updated successfully.');

        // return redirect()->route("profile");
    }

    public function render()
    {
        return view('livewire.profile')->extends('layouts.app');
    }
}
