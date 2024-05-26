<?php

namespace App\Livewire;

use App\Models\Order as ModelsOrder;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;

class Order extends Component
{
    use WithFileUploads;

    public $service_id, $order_id, $service, $user_id, $image;
    public $isOpen = false;

    public function mount()
    {
        $this->service_id = request()->query('q');
        $this->service = Service::findOrFail($this->service_id);
    }

    public function render()
    {
        return view('livewire.order')->extends('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->user_id = '';
        $this->image = '';
    }

    public function store()
    {
        $this->validate([
            'image' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $this->image->store('payments', 'public');

        ModelsOrder::updateOrCreate(
            ['id' => $this->order_id],
            [
                'user_id' => auth()->user()->id,
                'total_price' => $this->service->price,
                'file_url' => $imagePath,
                'service_id' => $this->service_id,
            ],
        );

        session()->flash('message', $this->order_id ? 'Order Updated Successfully.' : 'Order Created Successfully.');

        if (!$this->order_id) {
            $this->resetInputFields();
        }
    }

    public function delete($id)
    {
        Order::find($id)->delete();
        session()->flash('message', 'Order Deleted Successfully.');
    }
}
