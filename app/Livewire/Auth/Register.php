<?php

namespace App\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $username = '';
    
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $phone_number = '';

    /** @var boolean */
    public $is_seller = false;

    public function register()
    {
        $this->validate([
            'name' => ['required'],
            'username' => ['required', 'string', 'min:6', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'phone_number' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone_number' => $this->phone_number,
            'role' => $this->is_seller ? 'seller' : 'customer',
        ]);

        event(new Registered($user));

        Auth::login($user, true);

        return redirect()->intended(route('home'));
    }

    public function toggle()
    {
        $this->is_seller = !$this->is_seller;
    }

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.app');
    }
}
