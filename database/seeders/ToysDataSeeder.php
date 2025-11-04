<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ToysDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@toyshop.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@toyshop.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create test customer
        User::updateOrCreate(
            ['email' => 'customer@toyshop.com'],
            [
                'name' => 'Test Customer',
                'email' => 'customer@toyshop.com',
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Create toy categories with online images
        $categories = [
            [
                'name' => 'Action Figures',
                'slug' => 'action-figures',
                'description' => 'Superheroes, movie characters, and action-packed figures',
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Building Blocks',
                'slug' => 'building-blocks',
                'description' => 'LEGO, construction sets, and creative building toys',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Dolls & Accessories',
                'slug' => 'dolls-accessories',
                'description' => 'Fashion dolls, baby dolls, and doll accessories',
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Educational Toys',
                'slug' => 'educational-toys',
                'description' => 'Learning toys, puzzles, and STEM educational games',
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Remote Control',
                'slug' => 'remote-control',
                'description' => 'RC cars, drones, helicopters, and remote control toys',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Board Games',
                'slug' => 'board-games',
                'description' => 'Family board games, strategy games, and card games',
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Outdoor Toys',
                'slug' => 'outdoor-toys',
                'description' => 'Playground equipment, sports toys, and outdoor games',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
            [
                'name' => 'Art & Crafts',
                'slug' => 'art-crafts',
                'description' => 'Drawing supplies, craft kits, and creative art toys',
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=500&h=300&fit=crop',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Get category IDs for product creation
        $categoryIds = Category::pluck('id', 'slug')->toArray();

        // Create toy products with online images
        $products = [
            // Action Figures
            [
                'name' => 'Spider-Man Action Figure',
                'slug' => 'spider-man-action-figure',
                'description' => '12-inch articulated Spider-Man figure with web accessories',
                'price' => 29.99,
                'sale_price' => 24.99,
                'sku' => 'SPIDER-MAN-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['action-figures'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Batman Deluxe Figure',
                'slug' => 'batman-deluxe-figure',
                'description' => 'Premium Batman figure with cape and batarang accessories',
                'price' => 39.99,
                'sale_price' => null,
                'sku' => 'BATMAN-DELUXE-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['action-figures'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Marvel Avengers Set',
                'slug' => 'marvel-avengers-set',
                'description' => 'Complete Avengers team action figure collection',
                'price' => 149.99,
                'sale_price' => 129.99,
                'sku' => 'AVENGERS-SET-001',
                'stock_quantity' => 20,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['action-figures'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Building Blocks
            [
                'name' => 'LEGO Creator Castle',
                'slug' => 'lego-creator-castle',
                'description' => 'Build your own medieval castle with 2000+ pieces',
                'price' => 199.99,
                'sale_price' => null,
                'sku' => 'LEGO-CASTLE-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['building-blocks'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'LEGO City Space Station',
                'slug' => 'lego-city-space-station',
                'description' => 'Space exploration set with astronauts and rocket',
                'price' => 89.99,
                'sale_price' => 79.99,
                'sku' => 'LEGO-SPACE-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['building-blocks'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Magnetic Building Tiles',
                'slug' => 'magnetic-building-tiles',
                'description' => 'Colorful magnetic tiles for creative construction',
                'price' => 49.99,
                'sale_price' => null,
                'sku' => 'MAG-TILES-001',
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['building-blocks'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Dolls & Accessories
            [
                'name' => 'Fashion Doll with Outfits',
                'slug' => 'fashion-doll-outfits',
                'description' => 'Beautiful fashion doll with 5 different outfits',
                'price' => 34.99,
                'sale_price' => 29.99,
                'sku' => 'FASHION-DOLL-001',
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['dolls-accessories'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Baby Doll with Stroller',
                'slug' => 'baby-doll-stroller',
                'description' => 'Realistic baby doll with stroller and accessories',
                'price' => 59.99,
                'sale_price' => null,
                'sku' => 'BABY-DOLL-001',
                'stock_quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['dolls-accessories'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Educational Toys
            [
                'name' => 'STEM Robot Building Kit',
                'slug' => 'stem-robot-building-kit',
                'description' => 'Build and program your own robot with coding',
                'price' => 79.99,
                'sale_price' => 69.99,
                'sku' => 'STEM-ROBOT-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['educational-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Wooden Alphabet Puzzle',
                'slug' => 'wooden-alphabet-puzzle',
                'description' => 'Educational wooden puzzle for learning letters',
                'price' => 24.99,
                'sale_price' => null,
                'sku' => 'WOOD-ALPHABET-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['educational-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Science Experiment Kit',
                'slug' => 'science-experiment-kit',
                'description' => '50+ science experiments for curious minds',
                'price' => 49.99,
                'sale_price' => 39.99,
                'sku' => 'SCIENCE-KIT-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['educational-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Remote Control
            [
                'name' => 'RC Racing Car',
                'slug' => 'rc-racing-car',
                'description' => 'High-speed remote control racing car with LED lights',
                'price' => 89.99,
                'sale_price' => null,
                'sku' => 'RC-CAR-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['remote-control'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Drone with Camera',
                'slug' => 'drone-with-camera',
                'description' => 'HD camera drone with GPS and auto-return',
                'price' => 199.99,
                'sale_price' => 179.99,
                'sku' => 'DRONE-CAM-001',
                'stock_quantity' => 15,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['remote-control'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'RC Helicopter',
                'slug' => 'rc-helicopter',
                'description' => 'Indoor remote control helicopter with gyroscope',
                'price' => 59.99,
                'sale_price' => null,
                'sku' => 'RC-HELI-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['remote-control'],
                'is_featured' => false,
                'is_active' => true,
            ],

            // Board Games
            [
                'name' => 'Monopoly Classic',
                'slug' => 'monopoly-classic',
                'description' => 'Classic Monopoly board game for family fun',
                'price' => 34.99,
                'sale_price' => null,
                'sku' => 'MONOPOLY-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['board-games'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Chess Set Premium',
                'slug' => 'chess-set-premium',
                'description' => 'Handcrafted wooden chess set with storage box',
                'price' => 79.99,
                'sale_price' => 69.99,
                'sku' => 'CHESS-PREM-001',
                'stock_quantity' => 20,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['board-games'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Scrabble Deluxe',
                'slug' => 'scrabble-deluxe',
                'description' => 'Deluxe Scrabble with rotating board and tile racks',
                'price' => 49.99,
                'sale_price' => null,
                'sku' => 'SCRABBLE-DEL-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['board-games'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Outdoor Toys
            [
                'name' => 'Trampoline 8ft',
                'slug' => 'trampoline-8ft',
                'description' => '8-foot trampoline with safety net and padding',
                'price' => 299.99,
                'sale_price' => 249.99,
                'sku' => 'TRAMP-8FT-001',
                'stock_quantity' => 10,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['outdoor-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Soccer Goal Set',
                'slug' => 'soccer-goal-set',
                'description' => 'Portable soccer goal with ball and cones',
                'price' => 59.99,
                'sale_price' => null,
                'sku' => 'SOCCER-GOAL-001',
                'stock_quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['outdoor-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Water Slide Pool',
                'slug' => 'water-slide-pool',
                'description' => 'Inflatable water slide with pool for summer fun',
                'price' => 149.99,
                'sale_price' => 129.99,
                'sku' => 'WATER-SLIDE-001',
                'stock_quantity' => 15,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['outdoor-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Art & Crafts
            [
                'name' => 'Art Supplies Set',
                'slug' => 'art-supplies-set',
                'description' => 'Complete art set with paints, brushes, and canvas',
                'price' => 39.99,
                'sale_price' => null,
                'sku' => 'ART-SET-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['art-crafts'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Pottery Wheel Kit',
                'slug' => 'pottery-wheel-kit',
                'description' => 'Electric pottery wheel with clay and tools',
                'price' => 199.99,
                'sale_price' => 179.99,
                'sku' => 'POTTERY-WHEEL-001',
                'stock_quantity' => 12,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['art-crafts'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Bead Jewelry Kit',
                'slug' => 'bead-jewelry-kit',
                'description' => 'Create beautiful jewelry with colorful beads',
                'price' => 24.99,
                'sale_price' => null,
                'sku' => 'BEAD-KIT-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=500&h=500&fit=crop',
                'category_id' => $categoryIds['art-crafts'],
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Toys data seeded successfully!');
        $this->command->info('Created ' . count($categories) . ' toy categories and ' . count($products) . ' toy products');
    }
}
