<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class ServiceDetail extends Component
{
    public $serviceId;
    public $service;
    public $formattedPrice;
    public $totalRating;

    public function mount($serviceId)
    {
        $this->serviceId = $serviceId;
        $this->service = Service::with('user', 'category', 'ratings')->findOrFail($serviceId);
        $this->totalRating = $this->calculateTotalRating();
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


