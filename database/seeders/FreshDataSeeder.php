<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FreshDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@ecom.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@ecom.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create test customer
        User::updateOrCreate(
            ['email' => 'customer@ecom.com'],
            [
                'name' => 'Test Customer',
                'email' => 'customer@ecom.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Create categories with online images
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest electronic gadgets and devices',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion & Clothing',
                'slug' => 'fashion-clothing',
                'description' => 'Trendy fashion and clothing for all ages',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Everything for your home and garden',
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Sports equipment and fitness gear',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Books & Media',
                'slug' => 'books-media',
                'description' => 'Books, movies, and digital media',
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Beauty & Health',
                'slug' => 'beauty-health',
                'description' => 'Beauty products and health supplements',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Toys & Games',
                'slug' => 'toys-games',
                'description' => 'Toys, games, and entertainment',
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Car accessories and automotive parts',
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Get category IDs for product creation
        $categoryIds = Category::pluck('id', 'slug')->toArray();

        // Create products with online images
        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'description' => 'Latest iPhone with advanced camera system and A17 Pro chip',
                'price' => 1299.99,
                'sale_price' => 1199.99,
                'sku' => 'IPH15PM-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['electronics'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'MacBook Pro 16"',
                'slug' => 'macbook-pro-16',
                'description' => 'Powerful laptop with M3 Pro chip for professionals',
                'price' => 2499.99,
                'sale_price' => null,
                'sku' => 'MBP16-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['electronics'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Sony WH-1000XM5 Headphones',
                'slug' => 'sony-wh-1000xm5',
                'description' => 'Industry-leading noise canceling wireless headphones',
                'price' => 399.99,
                'sale_price' => 349.99,
                'sku' => 'SONY-WH1000XM5',
                'stock_quantity' => 75,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['electronics'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'description' => 'Premium Android smartphone with S Pen',
                'price' => 1199.99,
                'sale_price' => null,
                'sku' => 'SGS24U-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['electronics'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Fashion & Clothing
            [
                'name' => 'Designer Leather Jacket',
                'slug' => 'designer-leather-jacket',
                'description' => 'Premium genuine leather jacket for men',
                'price' => 299.99,
                'sale_price' => 249.99,
                'sku' => 'LEATHER-JK-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['fashion-clothing'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Summer Dress Collection',
                'slug' => 'summer-dress-collection',
                'description' => 'Elegant summer dresses for women',
                'price' => 89.99,
                'sale_price' => null,
                'sku' => 'SUMMER-DR-001',
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['fashion-clothing'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Nike Air Max 270',
                'slug' => 'nike-air-max-270',
                'description' => 'Comfortable running shoes with Max Air cushioning',
                'price' => 150.00,
                'sale_price' => 120.00,
                'sku' => 'NIKE-AM270-001',
                'stock_quantity' => 100,
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['fashion-clothing'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Home & Garden
            [
                'name' => 'Smart Home Security System',
                'slug' => 'smart-home-security-system',
                'description' => 'Complete home security with cameras and sensors',
                'price' => 499.99,
                'sale_price' => null,
                'sku' => 'SMART-SEC-001',
                'stock_quantity' => 20,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['home-garden'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Garden Tool Set',
                'slug' => 'garden-tool-set',
                'description' => 'Professional garden tools for all your gardening needs',
                'price' => 79.99,
                'sale_price' => 59.99,
                'sku' => 'GARDEN-TOOLS-001',
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['home-garden'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Sports & Fitness
            [
                'name' => 'Yoga Mat Premium',
                'slug' => 'yoga-mat-premium',
                'description' => 'Non-slip yoga mat for all fitness levels',
                'price' => 49.99,
                'sale_price' => null,
                'sku' => 'YOGA-MAT-001',
                'stock_quantity' => 80,
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['sports-fitness'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Dumbbell Set 20kg',
                'slug' => 'dumbbell-set-20kg',
                'description' => 'Adjustable dumbbell set for home workouts',
                'price' => 199.99,
                'sale_price' => 179.99,
                'sku' => 'DUMBBELL-20KG',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['sports-fitness'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Books & Media
            [
                'name' => 'The Psychology of Money',
                'slug' => 'psychology-of-money',
                'description' => 'Bestselling book on personal finance and investing',
                'price' => 24.99,
                'sale_price' => null,
                'sku' => 'BOOK-PSYCH-MONEY',
                'stock_quantity' => 100,
                'image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['books-media'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Wireless Bluetooth Speaker',
                'slug' => 'wireless-bluetooth-speaker',
                'description' => 'Portable speaker with excellent sound quality',
                'price' => 89.99,
                'sale_price' => 69.99,
                'sku' => 'BT-SPEAKER-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['books-media'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Beauty & Health
            [
                'name' => 'Skincare Routine Set',
                'slug' => 'skincare-routine-set',
                'description' => 'Complete skincare routine for healthy skin',
                'price' => 129.99,
                'sale_price' => null,
                'sku' => 'SKINCARE-SET-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['beauty-health'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Vitamin C Serum',
                'slug' => 'vitamin-c-serum',
                'description' => 'Anti-aging vitamin C serum for bright skin',
                'price' => 39.99,
                'sale_price' => 29.99,
                'sku' => 'VIT-C-SERUM-001',
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['beauty-health'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Toys & Games
            [
                'name' => 'LEGO Creator Set',
                'slug' => 'lego-creator-set',
                'description' => 'Creative building blocks for all ages',
                'price' => 79.99,
                'sale_price' => null,
                'sku' => 'LEGO-CREATOR-001',
                'stock_quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['toys-games'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Board Game Collection',
                'slug' => 'board-game-collection',
                'description' => 'Family-friendly board games for all ages',
                'price' => 59.99,
                'sale_price' => 49.99,
                'sku' => 'BOARD-GAMES-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['toys-games'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Automotive
            [
                'name' => 'Car Phone Mount',
                'slug' => 'car-phone-mount',
                'description' => 'Magnetic phone mount for car dashboard',
                'price' => 29.99,
                'sale_price' => null,
                'sku' => 'CAR-MOUNT-001',
                'stock_quantity' => 70,
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['automotive'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Car Cleaning Kit',
                'slug' => 'car-cleaning-kit',
                'description' => 'Complete car cleaning and detailing kit',
                'price' => 49.99,
                'sale_price' => 39.99,
                'sku' => 'CAR-CLEAN-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['automotive'],
                'is_featured' => false,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Fresh data seeded successfully!');
        $this->command->info('Created ' . count($categories) . ' categories and ' . count($products) . ' products');
    }
}


