<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Video Editing',
        ]);
        Category::create([
            'name' => 'Ilustration',
        ]);
        Category::create([
            'name' => 'Graphic Design',
        ]);
        Category::create([
            'name' => 'Animation',
        ]);
        Category::create([
            'name' => 'Writing',
        ]);
        Category::create([
            'name' => 'Photography',
        ]);
    }
}
