<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Register extends Component
{
    public $name;
    public $username;
    public $email;
    public $password;
    public $phone_number;
    public $password_confirmation;

    /**
     * register
     *
     * @return void
     */
    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:5',
            'password_confirmation' => 'required|string|min:5',
            'phone_number' => 'required|string|min:6',
        ]);

        $isEmailExists = User::where('email', $this->email)->first();
        $isUserExists = User::where('username', $this->username)->first();
        if ($isEmailExists) {
            return redirect('register')->with('error', 'Email already exists!');
        } elseif ($isUserExists) {
            return redirect('register')->with('error', 'Username already exists!');
        } elseif ($this->password != $this->password_confirmation) {
            return redirect('register')->with('error', 'Password doesn\'t match!');
        }

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone_number' => $this->phone_number,
        ]);

        Auth::login($user);

        return redirect()->intended('services');
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.register');
    }
}
