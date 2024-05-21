<?php
namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
        ];
    }
}
