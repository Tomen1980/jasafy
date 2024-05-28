<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ServiceDetail extends Component
{
    use WithFileUploads;

    public $serviceId;
    public $service;
    public $formattedPrice;
    public $totalRating;
    public $categories;
    public $isModalOpen = false;
    public $title, $description, $price, $categoryId, $location, $maps, $image;

    public function mount($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->fetchService($serviceId);
        $this->loadServiceData();
        $this->totalRating = $this->calculateTotalRating();
        $this->categories = Category::all();
    }

    public function fetchService($serviceId)
    {
        $this->service = Service::with('user', 'category', 'ratings')->findOrFail($serviceId);
    }

    public function loadServiceData()
    {
        $this->title = $this->service->title;
        $this->description = $this->service->description;
        $this->price = $this->service->price;
        $this->categoryId = $this->service->category_id;
        $this->location = $this->service->location;
        $this->maps = $this->service->maps;
        $this->image = null;
    }
    
    public function placeOrder(CartManager $cartManager, $serviceId)
    {
        $cartManager->placeOrder($serviceId);
    }
    
    public function update()
    {
        $this->validate([
            'title' => 'nullable|string|min:3|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'maps' => 'nullable|string|max:255',
        ]);

        $service = Service::find($this->serviceId);

        if (!$service) {
            session()->flash('error', 'Service not found.');
            return;
        }

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'maps' => $this->maps,
            'category_id' => $this->categoryId ?? $service->category_id,
        ];

        if ($this->image) {
            $this->validate([
                'image' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            if ($service->image && $service->image !== 'defaultService.jpg') {
                Storage::delete('public/' . $service->image);
            }
            $data['image'] = $this->image->store('services', 'public');
        }

        $service->update($data);

        session()->flash('success', 'Service updated successfully.');
        $this->fetchService($this->serviceId);
        $this->isModalOpen = false;
    }
    
    public function edit($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->loadServiceData();
    }


    public function calculateTotalRating()
    {
        $totalSum = $this->service->ratings()->sum('rating');
        $totalCount = $this->service->ratings()->count();

        if ($totalCount > 0) {
            return round(($totalSum / $totalCount), 1);
        }

        return 0;
    }

    public function render()
    {
        return view('livewire.service-detail')->extends('layouts.app');
    }
}


