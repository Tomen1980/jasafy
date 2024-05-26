<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    public $current_password;
    public $new_password;
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
            'username' => ['required', 'string', 'min:6', 'max:255', 'unique:users,username,' . $userId],
            'description' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'phone_number' => ['required', 'string', 'min:6'],
            'new_image' => ['nullable', 'image', 'max:2048'],
            'current_password' => ['required_with:new_password', 'min:8'],
            'new_password' => ['nullable', 'min:8', 'same:passwordConfirmation'],
        ]);

        $user = User::findOrFail($userId);

        if ($this->current_password && !Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $user->name = $this->name;
        $user->username = $this->username;
        $user->description = $this->description;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;

        if ($this->new_image) {
            if ($this->image !== 'default.jpg') {
                Storage::delete($user->image);
            }
            $path = $this->new_image->store('profiles', 'public');
            $user->image = $path;
        }

        if ($this->new_password) {
            $user->password = Hash::make($this->new_password);
        }

        if (!$user->save()) {
            $this->addError('email', trans('auth.failed'));
            return;
        }

        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile')->extends('layouts.app');
    }
}
