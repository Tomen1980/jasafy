<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartManager extends Component
{
    public $carts;

    public function mount()
    {
        if("customer" !== Auth::user()->role){
            return redirect("/");
        }
        $this->loadCarts();
    }

    public function loadCarts()
    {
        $this->carts = Cart::where('user_id', Auth::id())->get();
    }

    public function removeFromCart($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart && $cart->user_id == Auth::id()) {
            $cart->delete();
            session()->flash('success', "Removed an item from Cart successfully!!");
            $this->loadCarts();
        } else {
            session()->flash('error', "Error removing an item from Cart!!");
        }
    }

    public function render()
    {
        return view('livewire.cart-manager')->extends('layouts.app');
    }
}
