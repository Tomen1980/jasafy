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

    // protected $rules = [
    //     'name' => 'required|string|max:255',
    //     'username' => 'required|string|min:3|max:255',
    //     'email' => 'required|email|max:255',
    //     'password' => 'required|string|min:5',
    //     'password_confirmation' => 'required|string|min:5',
    //     'phone_number' => 'required|string|min:6',
    // ];


    public function register()
    {
        $validation = $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:5',
            'password_confirmation' => 'required|string|min:5',
            'phone_number' => 'required|string|min:6',
        ]);

        $checkEmail = User::where('email', $validation['email'])->first();
        $checkUser = User::where('username', $validation['username'])->first();
        if ($checkEmail) {
            return redirect('/register')->with('error', 'Email already exists!');
        }else if($checkUser){
            return redirect('/register')->with('error', 'Username already exists!');
        }else if($validation['password'] != $validation['password_confirmation']){
            return redirect('/register')->with('error', 'Password doesn\'t match!');
        }

        $user = User::create([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone_number' => $this->phone_number,
            'role' => 'customer',
        ]);

        Auth::login($user);
        // return dd($user);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.register');
    }
}
