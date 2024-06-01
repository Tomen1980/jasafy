<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Service;

use App\Livewire\Wishlist;
use App\Livewire\CartManager;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Builder;

class Services extends Component
{
    use WithFileUploads;

    public $categoryId, $serviceId, $title, $description, $price, $location, $maps, $image;
    public $isModalOpen = false;
    public $isConfirming = false;
    public string $searchTerm = '';

    public function render()
    {
        $services = Service::with('category')->when(
            $this->searchTerm !== '',
            fn(Builder $query) => $query
                ->where('title', 'like', '%' . $this->searchTerm . '%')
                ->orWhere('location', 'like', '%' . $this->searchTerm . '%')
                ->orWhereHas('category', function (Builder $query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%');
                }),
        )->get();

        $categories = Category::all();

        return view('livewire.services', [
            'services' => $services,
            'categories' => $categories,
        ])->extends('layouts.app');
    }

    public function addToCart(CartManager $cartManager, $id)
    {
        $cartManager->addToCart($id);
    }

    public function addToWishlist(Wishlist $wishlist, $serviceId)
    {
        $wishlist->addToWishlist($serviceId);
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->price = '';
        $this->location = '';
        $this->maps = '';
        $this->categoryId = '';
        $this->image = '';
        $this->serviceId = null;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'maps' => 'required|string|max:255',
            'categoryId' => 'required|min:1',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $this->image->store('services', 'public');

        Service::create([
            'user_id' => auth()->user()->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'maps' => $this->maps,
            'category_id' => $this->categoryId,
            'image' => $imagePath,
        ]);

        session()->flash('success', 'Service created successfully.');

        $this->resetInputFields();
        $this->isModalOpen = false;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'maps' => 'required|string|max:255',
            'categoryId' => 'required|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            if ($service->image && $service->image !== 'defaultService.jpg') {
                Storage::delete('public/' . $service->image);
            }
            $data['image'] = $this->image->store('services', 'public');
        }

        $service->update($data);

        session()->flash('success', 'Service updated successfully.');
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $id;
        $this->title = $service->title;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->location = $service->location;
        $this->categoryId = $service->category_id;
        $this->maps = $service->maps;
        $this->image = null;
    }

    public function delete($id)
    {
        $image = Service::find($id)->image;
        Storage::delete('public/' . $image);
        Service::find($id)->delete();
        session()->flash('message', 'Service deleted successfully.');
        $this->isConfirming = false;
    }
}
