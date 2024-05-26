<?php

namespace App\Livewire;

use App\Models\Wishlist as ModelsWishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wishlist extends Component
{
    public $wishlist;

    public function mount()
    {
        $this->loadWishlist();
    }

    public function loadWishlist()
    {
        $this->wishlist = ModelsWishlist::where('user_id', Auth::id())->get();
        $this->formatPrices();
    }

    private function formatPrices()
    {
        foreach ($this->wishlist as $wishlist) {
            $wishlist->service->price = "Rp " . number_format($wishlist->service->price, 2, ',', '.');
        }
    }

    public function removeFromWishlist($wishlistId)
    {
        $wishlist = ModelsWishlist::find($wishlistId);

        if ($wishlist && $wishlist->user_id == Auth::id()) {
            $wishlist->delete();
            session()->flash('success', 'Removed an item from Wishlist successfully!!');
            $this->loadWishlist();
        } else {
            session()->flash('error', 'Error removing an item from Wishlist!!');
        }
    }

    public function addToWishlist($serviceId)
    {
        $wishlist = ModelsWishlist::where('service_id', $serviceId)->where('user_id', Auth::id())->exists();
        if ($wishlist) {
            session()->flash('error', 'The same item is in the wishlist!!');
        } else {
            ModelsWishlist::create([
                'user_id' => Auth::id(),
                'service_id' => $serviceId,
            ]);
            session()->flash('success', 'Added an item to Wishlist successfully!!');
        }
    }

    public function placeOrder($serviceId)
    {
        return redirect()->route("order", ['q' => $serviceId]);
    }
    public function render()
    {
        return view('livewire.wishlist')->extends('layouts.app');
    }
}
