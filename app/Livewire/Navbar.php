<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.navbar');
    }
}
