<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class MyOrders extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::where("user_id", auth()->user()->id)->with('service')->orderBy('status', 'desc')->get();
        $this->formatPrices();
    }

    private function formatPrices()
    {
        foreach ($this->orders as $order) {
            $order->service->price = "Rp " . number_format($order->service->price, 2, ',', '.');
        }
    }

    public function render()
    {
        return view('livewire.my-orders')->extends('layouts.app');
    }
}
