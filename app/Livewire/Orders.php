<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{
    public $orders;
    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Order::with(['user', 'service'])
            ->whereHas('service', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('status', 'desc')
            ->get();
        $this->formatPrices();
    }

    private function formatPrices()
    {
        foreach ($this->orders as $order) {
            $order->service->price = "Rp " . number_format($order->service->price, 2, ',', '.');
        }
    }

    public function proceedStatus($orderId, $status)
    {
        Order::Where('id', $orderId)->update([
            'status' => $status === "Pending" ? "On Going" : ($status === "On Going" ? "Completed" : "Cancelled"),
        ]);
        $this->loadOrders();

        session()->flash('success', 'Status updated successfully.');
    }
    
    public function render()
    {
        return view('livewire.orders')->extends('layouts.app');
    }
}
