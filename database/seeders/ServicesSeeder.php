<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'user_id' => 2,
            'category_id' => 1,
            'title' => 'Service 1',
            'description' => 'Ini jasa tentang service 1',
            'price' => 10000,
            'location' => 'Jakarta',
            'maps' => 'https://maps.app.goo.gl/pGdiKvaN888vuJnEA',
            'image' => 'defaultService.jpg',
        ]);
        Service::create([
            'user_id' => 2,
            'category_id' => 2,
            'title' => 'Service 2',
            'description' => 'Ini jasa tentang service 1',
            'price' => 10000,
            'location' => 'Jakarta',
            'maps' => 'https://maps.app.goo.gl/pGdiKvaN888vuJnEA',
            'image' => 'defaultService.jpg',
        ]);
        Service::create([
            'user_id' => 2,
            'category_id' => 3,
            'title' => 'Service 3',
            'description' => 'Ini jasa tentang service 1',
            'price' => 10000,
            'location' => 'Jakarta',
            'maps' => 'https://maps.app.goo.gl/pGdiKvaN888vuJnEA',
            'image' => 'defaultService.jpg',
        ]);
        Service::create([
            'user_id' => 2,
            'category_id' => 4,
            'title' => 'Service 4',
            'description' => 'Ini jasa tentang service 1',
            'price' => 10000,
            'location' => 'Jakarta',
            'maps' => 'https://maps.app.goo.gl/pGdiKvaN888vuJnEA',
            'image' => 'defaultService.jpg',
        ]);
        Service::create([
            'user_id' => 2,
            'category_id' => 5,
            'title' => 'Service 5',
            'description' => 'Ini jasa tentang service 1',
            'price' => 10000,
            'location' => 'Jakarta',
            'maps' => 'https://maps.app.goo.gl/pGdiKvaN888vuJnEA',
            'image' => 'defaultService.jpg',
        ]);
        Service::create([
            'user_id' => 2,
            'category_id' => 6,
            'title' => 'Service 6',
            'description' => 'Ini jasa tentang service 1',
            'price' => 10000,
            'location' => 'Jakarta',
            'maps' => 'https://maps.app.goo.gl/pGdiKvaN888vuJnEA',
            'image' => 'defaultService.jpg',
        ]);
    }
}
