<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Desserts', 'description' => 'Sweet treats and desserts'],
            ['name' => 'Main Courses', 'description' => 'Main dish recipes'],
            ['name' => 'Appetizers', 'description' => 'Starters and appetizers'],
            ['name' => 'Breakfast', 'description' => 'Breakfast and brunch recipes'],
            ['name' => 'Beverages', 'description' => 'Drinks and beverages'],
            ['name' => 'Salads', 'description' => 'Fresh salads'],
            ['name' => 'Soups', 'description' => 'Soups and stews'],
            ['name' => 'Snacks', 'description' => 'Quick snacks and finger foods'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}