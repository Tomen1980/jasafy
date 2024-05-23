<?php

namespace App\Livewire;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Services extends Component
{public $services;
    public $title;
    public $description;
    public $location;
    public $serviceId;
    public $maps;
    public $showModal = false;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'location' => 'required|string|max:255',
        'maps' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->services = Service::all();
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->location = '';
        $this->serviceId = null;
    }

    public function addService()
    {
        $this->validate();

        Service::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'maps' => $this->maps,
        ]);

        $this->services = Service::all();
        $this->resetInputFields();
        $this->closeModal();
    }

    public function editService($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->title = $service->title;
        $this->description = $service->description;
        $this->location = $service->location;
        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function updateService()
    {
        $this->validate();

        $service = Service::findOrFail($this->serviceId);
        $service->update([
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
        ]);

        $this->services = Service::all();
        $this->resetInputFields();
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.services');
    }
}
