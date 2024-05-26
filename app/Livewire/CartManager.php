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
        $this->formatPrices();
    }

    private function formatPrices()
    {
        foreach ($this->carts as $cart) {
            $cart->service->price = "Rp " . number_format($cart->service->price, 2, ',', '.');
        }
    }

    public function removeFromCart($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart && $cart->user_id == Auth::id()) {
            $cart->delete();
            session()->flash('success', 'Removed an item from Cart successfully!!');
            $this->loadCarts();
        } else {
            session()->flash('error', 'Error removing an item from Cart!!');
        }
    }

    public function addToCart($serviceId)
    {
        $cart = Cart::where('service_id', $serviceId)->where('user_id', Auth::id())->exists();
        if ($cart) {
            session()->flash('error', 'The same item is in the cart!!');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'service_id' => $serviceId,
            ]);
            session()->flash('success', 'Added an item to Cart successfully!!');
        }
    }

    public function placeOrder($serviceId)
    {
        return redirect()->route("orders", ['q' => $serviceId]);
    }

    public function render()
    {
        return view('livewire.cart-manager')->extends('layouts.app');
    }
}
