<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wishlist;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'password' => Hash::make("johndev"),
            'phone_number' => "08123456789",
            'role' => 'customer',
            'image' => 'default.jpg'
        ]);

        User::create([
            'name' => "Pahuger",
            'username' => "pahuger",
            'email' => "pahuger@gmail.com",
            'password' => Hash::make("pahuger"),
            'phone_number' => "08123456789",
            'role' => 'seller',
            'image' => 'default.jpg'
        ]);
    }
}
