<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    /**
     * login
     *
     * @return void
     */
    public function login()
    {
        $this->validate();

        $user = Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember);

        if ($user) {
            return redirect()->intended('services');
        }

        session()->flash('error', 'Invalid credentials');
        return redirect()->route('login');
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.login');
    }
}
