<?php

namespace App\Livewire;

use App\Models\Service;

use Livewire\Component;
use Livewire\WithFileUploads;

class Services extends Component
{
    use WithFileUploads;

    public $services, $serviceId, $title, $description, $price, $location, $maps, $image;
    public $isModalOpen = false;
    public $isConfirming = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'location' => 'required|string|max:255',
        'maps' => 'required|string|max:255',
        'image' => 'required|image|max:1024',
    ];

    public function render()
    {
        $this->services = Service::all();
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

    public function confirmDeletion($id)
    {
        $this->serviceId = $id;
        $this->isConfirming = true;
    }

    public function cancelDeletion()
    {
        $this->serviceId = null;
        $this->isConfirming = false;
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->price = '';
        $this->location = '';
        $this->maps = '';
        $this->image = '';
        $this->serviceId = null;
    }

    public function store()
    {
        $this->validate();

        $imagePath = $this->image->store('services', 'public');

        Service::updateOrCreate(['id' => $this->serviceId], [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'maps' => $this->maps,
            'image' => $imagePath,
        ]);

        session()->flash('message', 
            $this->serviceId ? 'Service updated successfully.' : 'Service created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $id;
        $this->title = $service->title;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->location = $service->location;
        $this->maps = $service->maps;
        $this->image = $service->image;

        $this->openModal();
    }

    public function delete($id)
    {
        Service::find($id)->delete();
        session()->flash('message', 'Service deleted successfully.');
        $this->isConfirming = false;
    }
}
