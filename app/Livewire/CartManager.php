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

    public function addToCart($serviceId){
        // return dd($serviceId);
        $cart = Cart::where("service_id",$serviceId)->where("user_id",Auth::id())->exists();
        if($cart){
            session()->flash('error', "The same item is in the cart");
            return redirect('/cart')->with('error', "The same item is in the cart");
        }else{
            Cart::create([
                "user_id" => Auth::id(),
                "service_id" => $serviceId
            ]);
            session()->flash('success', "add an item from Cart successfully!!");
            return redirect('/cart')->with('success', "add an item from Cart successfully!!");
        }
    }

    public function render()
    {
        return view('livewire.cart-manager')->extends('layouts.app');
    }
}
