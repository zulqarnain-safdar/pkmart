<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronic gadgets and devices',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=500',
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashionable clothing for men and women',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=500',
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Everything for your home and garden',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500',
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500',
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books for all ages and interests',
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500',
            ],
            [
                'name' => 'Beauty & Health',
                'slug' => 'beauty-health',
                'description' => 'Beauty products and health supplements',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
