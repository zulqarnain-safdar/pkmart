<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'slug' => 'iphone-15-pro',
                'description' => 'The latest iPhone with advanced camera system and A17 Pro chip',
                'price' => 999.00,
                'sale_price' => 899.00,
                'sku' => 'IPH15P-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500',
                'category_id' => 1,
                'is_featured' => true,
            ],
            [
                'name' => 'MacBook Air M2',
                'slug' => 'macbook-air-m2',
                'description' => 'Ultra-thin laptop with M2 chip and all-day battery life',
                'price' => 1199.00,
                'sku' => 'MBA-M2-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=500',
                'category_id' => 1,
                'is_featured' => true,
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'slug' => 'sony-wh-1000xm5',
                'description' => 'Industry-leading noise canceling wireless headphones',
                'price' => 399.99,
                'sale_price' => 349.99,
                'sku' => 'SONY-WH-001',
                'stock_quantity' => 75,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500',
                'category_id' => 1,
                'is_featured' => false,
            ],
            
            // Clothing
            [
                'name' => 'Classic White T-Shirt',
                'slug' => 'classic-white-tshirt',
                'description' => 'Premium cotton t-shirt with comfortable fit',
                'price' => 29.99,
                'sku' => 'TSH-WHT-001',
                'stock_quantity' => 100,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500',
                'category_id' => 2,
                'is_featured' => false,
            ],
            [
                'name' => 'Denim Jacket',
                'slug' => 'denim-jacket',
                'description' => 'Classic blue denim jacket for all seasons',
                'price' => 79.99,
                'sale_price' => 59.99,
                'sku' => 'JKT-DNM-001',
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=500',
                'category_id' => 2,
                'is_featured' => true,
            ],
            
            // Home & Garden
            [
                'name' => 'Smart Home Speaker',
                'slug' => 'smart-home-speaker',
                'description' => 'Voice-controlled smart speaker with excellent sound quality',
                'price' => 99.99,
                'sku' => 'SHS-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500',
                'category_id' => 3,
                'is_featured' => false,
            ],
            [
                'name' => 'Indoor Plant Set',
                'slug' => 'indoor-plant-set',
                'description' => 'Beautiful collection of low-maintenance indoor plants',
                'price' => 49.99,
                'sku' => 'PLT-SET-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500',
                'category_id' => 3,
                'is_featured' => true,
            ],
            
            // Sports & Outdoors
            [
                'name' => 'Yoga Mat Premium',
                'slug' => 'yoga-mat-premium',
                'description' => 'Non-slip yoga mat with carrying strap',
                'price' => 39.99,
                'sku' => 'YGM-001',
                'stock_quantity' => 80,
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500',
                'category_id' => 4,
                'is_featured' => false,
            ],
            [
                'name' => 'Running Shoes',
                'slug' => 'running-shoes',
                'description' => 'Lightweight running shoes with excellent cushioning',
                'price' => 129.99,
                'sale_price' => 99.99,
                'sku' => 'RNS-001',
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500',
                'category_id' => 4,
                'is_featured' => true,
            ],
            
            // Books
            [
                'name' => 'The Great Gatsby',
                'slug' => 'the-great-gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald',
                'price' => 12.99,
                'sku' => 'BOK-GG-001',
                'stock_quantity' => 200,
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500',
                'category_id' => 5,
                'is_featured' => false,
            ],
            
            // Beauty & Health
            [
                'name' => 'Vitamin C Serum',
                'slug' => 'vitamin-c-serum',
                'description' => 'Anti-aging vitamin C serum for glowing skin',
                'price' => 24.99,
                'sku' => 'VCS-001',
                'stock_quantity' => 90,
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500',
                'category_id' => 6,
                'is_featured' => true,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
