<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Wishlist::factory(10)->create();

        User::create([
            'name' => "John Dev",
            'username' => "johndev",
            'email' => "johndev@gmail.com",
            'password' => Hash::make("johndev111"),
            'phone_number' => "62898123445",
            'role' => 'customer',
            'image' => 'default.jpg'
        ]);

        User::create([
            'name' => "Ammar",
            'username' => "ammar",
            'email' => "ammar@gmail.com",
            'password' => Hash::make("ammar111"),
            'phone_number' => "62898123445",
            'role' => 'seller',
            'image' => 'default.jpg'
        ]);
    }
}
