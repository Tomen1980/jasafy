<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Service;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Services extends Component
{
    use WithFileUploads;

    public $services, $categories, $categoryId, $serviceId, $title, $description, $price, $location, $maps, $image;
    public $isModalOpen = false;
    public $isConfirming = false;

    public function render()
    {
        $this->services = Service::all();
        $this->categories = Category::all();

        return view('livewire.services')->extends('layouts.app');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = false;
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

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'maps' => 'required|string|max:255',
            'image' => 'image|max:1024',
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

        session()->flash('message', 'Service created successfully.');

        // $this->closeModal();
        $this->resetInputFields();
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string|max:255',
            'maps' => 'required|string|max:255',
            // 'image' => 'nullable|image|max:1024',
        ]);

        $dataOld = Service::where('id', $this->serviceId)->first();

        if (!$this->categoryId) {
            $categoryIdData = $dataOld->category_id;
        } else {
            $categoryIdData = $this->categoryId;
        }

        if ($this->image !== $dataOld->image) {
            Storage::delete('public/' . $dataOld->image);
            $imagePath = $this->image->store('services', 'public');
        } else {
            $imagePath = $dataOld->image;
        }

        Service::Where('id', $this->serviceId)->update([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'maps' => $this->maps,
            'category_id' => $categoryIdData,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Service updated successfully.');

        $this->closeModal();
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
        $this->image = $service->image;

        $this->openModal();
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
