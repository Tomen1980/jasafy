<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Exception;

class MyOrders extends Component
{
    public $orders;
    public $rating;
    public $comment;
    public $orderId;
    public $serviceId;
    public $ratingId;

    protected $listeners = [
        'setRatingData' => 'setRatingData'
    ];

    public function mount()
    {
        $this->orders = Order::where('user_id', auth()->user()->id)
            ->with(['service', 'rating'])
            ->orderBy('status', 'desc')
            ->get();
        $this->formatPrices();
    }

    private function formatPrices()
    {
        foreach ($this->orders as $order) {
            if (is_numeric($order->service->price)) {
                $order->service->price = 'Rp ' . number_format((float)$order->service->price, 2, ',', '.');
            }
        }
    }

    public function setRatingData($orderId, $serviceId, $ratingId = null, $rating = null, $comment = null)
    {
        $this->orderId = $orderId;
        $this->serviceId = $serviceId;
        $this->ratingId = $ratingId;
        $this->rating = $rating;
        $this->comment = $comment;
    }

    public function rateService()
    {
        try {
            $this->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:255',
            ]);

            Rating::create([
                'user_id' => auth()->user()->id,
                'service_id' => $this->serviceId,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);

            session()->flash('success', 'Rating submitted successfully.');
            $this->resetInputFields();
            $this->mount();
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
            session()->flash('error', 'Validation failed. Please correct the errors and try again.');
        } catch (Exception $e) {
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function updateRating()
    {
        try {
            $this->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string|max:255',
            ]);

            $rating = Rating::findOrFail($this->ratingId);
            $rating->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);

            session()->flash('success', 'Rating updated successfully.');
            $this->resetInputFields();
            $this->mount();
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
            session()->flash('error', 'Validation failed. Please correct the errors and try again.');
        } catch (Exception $e) {
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function deleteRating($ratingId)
    {
        try {
            $rating = Rating::findOrFail($ratingId);
            $rating->delete();

            session()->flash('success', 'Rating removed successfully.');
            $this->resetInputFields();
            $this->mount();
        } catch (Exception $e) {
            session()->flash('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    private function resetInputFields()
    {
        $this->rating = null;
        $this->comment = null;
        $this->orderId = null;
        $this->serviceId = null;
        $this->ratingId = null;
    }

    public function render()
    {
        return view('livewire.my-orders')->extends('layouts.app');
    }
}
