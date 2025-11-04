<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReferralCode;
use App\Models\ReferralRelationship;
use App\Models\Commission;
use App\Models\ReferralEarning;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ChildToysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean all data from all tables
        $this->command->info('Cleaning all data from database...');
        
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clean all tables
        ReferralEarning::truncate();
        Commission::truncate();
        ReferralRelationship::truncate();
        ReferralCode::truncate();
        OrderItem::truncate();
        Order::truncate();
        Product::truncate();
        Category::truncate();
        User::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $this->command->info('Database cleaned successfully!');

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@toyshop.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create test customer
        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@toyshop.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create toy categories with online images
        $categories = [
            [
                'name' => 'Soft & Plush Toys',
                'slug' => 'soft-plush-toys',
                'description' => 'Cuddly teddy bears, stuffed animals, and plush dolls for comfort and play',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Vehicles & Action Toys',
                'slug' => 'vehicles-action-toys',
                'description' => 'Toy cars, trains, remote control vehicles, and action figures',
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Educational & Learning Toys',
                'slug' => 'educational-learning-toys',
                'description' => 'Building blocks, puzzles, STEM toys, and learning games',
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Creative & Art Toys',
                'slug' => 'creative-art-toys',
                'description' => 'Coloring supplies, craft kits, musical instruments, and art materials',
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Outdoor & Sports Toys',
                'slug' => 'outdoor-sports-toys',
                'description' => 'Balls, skipping ropes, cycles, and outdoor play equipment',
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Baby Toys',
                'slug' => 'baby-toys',
                'description' => 'Rattles, teething rings, sensory toys, and musical mobiles',
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
            [
                'name' => 'Electronic & Interactive Toys',
                'slug' => 'electronic-interactive-toys',
                'description' => 'Talking dolls, learning tablets, interactive robots, and light & sound toys',
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }

        // Get category IDs for product creation
        $categoryIds = Category::pluck('id', 'slug')->toArray();

        // Create 30 toy products with online images
        $products = [
            // Soft & Plush Toys (5 products)
            [
                'name' => 'Classic Teddy Bear - Brown',
                'slug' => 'classic-teddy-bear-brown',
                'description' => 'Soft and cuddly 12-inch brown teddy bear made with premium plush material. Perfect for bedtime cuddles and imaginative play.',
                'price' => 24.99,
                'sale_price' => 19.99,
                'sku' => 'TEDDY-BROWN-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['soft-plush-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Stuffed Dog - Golden Retriever',
                'slug' => 'stuffed-dog-golden-retriever',
                'description' => 'Adorable golden retriever stuffed animal with realistic features and soft fur. Great companion for children.',
                'price' => 29.99,
                'sale_price' => null,
                'sku' => 'DOG-GOLDEN-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['soft-plush-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Plush Elephant - Gray',
                'slug' => 'plush-elephant-gray',
                'description' => 'Large 16-inch gray elephant plush toy with floppy ears and trunk. Super soft and huggable.',
                'price' => 34.99,
                'sale_price' => 29.99,
                'sku' => 'ELEPHANT-GRAY-001',
                'stock_quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['soft-plush-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Princess Doll - Pink Dress',
                'slug' => 'princess-doll-pink-dress',
                'description' => 'Beautiful princess plush doll with sparkly pink dress and crown. Perfect for imaginative play and dress-up.',
                'price' => 39.99,
                'sale_price' => null,
                'sku' => 'PRINCESS-PINK-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['soft-plush-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Unicorn Plush - Rainbow',
                'slug' => 'unicorn-plush-rainbow',
                'description' => 'Magical rainbow unicorn plush toy with colorful mane and tail. Soft and sparkly for magical adventures.',
                'price' => 32.99,
                'sale_price' => 27.99,
                'sku' => 'UNICORN-RAINBOW-001',
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['soft-plush-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Vehicles & Action Toys (5 products)
            [
                'name' => 'Remote Control Racing Car - Red',
                'slug' => 'remote-control-racing-car-red',
                'description' => 'High-speed remote control racing car with LED lights and realistic engine sounds. 2.4GHz frequency for interference-free play.',
                'price' => 89.99,
                'sale_price' => 74.99,
                'sku' => 'RC-CAR-RED-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['vehicles-action-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'LEGO City Police Station',
                'slug' => 'lego-city-police-station',
                'description' => 'Build your own police station with 2,000+ pieces including police cars, helicopter, and minifigures. Ages 6+.',
                'price' => 199.99,
                'sale_price' => null,
                'sku' => 'LEGO-POLICE-001',
                'stock_quantity' => 20,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['vehicles-action-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Spider-Man Action Figure - 12 inch',
                'slug' => 'spider-man-action-figure-12-inch',
                'description' => 'Articulated Spider-Man action figure with web accessories and multiple poses. Perfect for superhero adventures.',
                'price' => 34.99,
                'sale_price' => 29.99,
                'sku' => 'SPIDER-MAN-12-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['vehicles-action-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Toy Train Set - Electric',
                'slug' => 'toy-train-set-electric',
                'description' => 'Complete electric train set with locomotive, cars, tracks, and station. Includes sound effects and lights.',
                'price' => 149.99,
                'sale_price' => 129.99,
                'sku' => 'TRAIN-ELECTRIC-001',
                'stock_quantity' => 15,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['vehicles-action-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Batman Action Figure - Deluxe',
                'slug' => 'batman-action-figure-deluxe',
                'description' => 'Premium Batman action figure with cape, batarang, and utility belt. Multiple articulation points for dynamic poses.',
                'price' => 44.99,
                'sale_price' => null,
                'sku' => 'BATMAN-DELUXE-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1558060370-9b7c3d8f6c8a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['vehicles-action-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Educational & Learning Toys (5 products)
            [
                'name' => 'Wooden Building Blocks Set - 100 pieces',
                'slug' => 'wooden-building-blocks-set-100-pieces',
                'description' => 'Natural wooden building blocks in various shapes and colors. Encourages creativity and fine motor skills development.',
                'price' => 49.99,
                'sale_price' => 39.99,
                'sku' => 'BLOCKS-WOODEN-100-001',
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['educational-learning-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Alphabet Learning Puzzle - Wooden',
                'slug' => 'alphabet-learning-puzzle-wooden',
                'description' => 'Educational wooden puzzle with 26 alphabet pieces. Each letter fits into its corresponding slot with picture.',
                'price' => 24.99,
                'sale_price' => null,
                'sku' => 'PUZZLE-ALPHABET-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['educational-learning-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'STEM Robot Building Kit',
                'slug' => 'stem-robot-building-kit',
                'description' => 'Build and program your own robot with this STEM kit. Includes motors, sensors, and coding instructions. Ages 8+.',
                'price' => 79.99,
                'sale_price' => 69.99,
                'sku' => 'STEM-ROBOT-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['educational-learning-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Shape Sorter Cube - Colorful',
                'slug' => 'shape-sorter-cube-colorful',
                'description' => 'Classic shape sorter with 12 different shapes and bright colors. Helps develop problem-solving and hand-eye coordination.',
                'price' => 19.99,
                'sale_price' => null,
                'sku' => 'SHAPE-SORTER-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['educational-learning-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Number Learning Board - Interactive',
                'slug' => 'number-learning-board-interactive',
                'description' => 'Interactive number learning board with sound effects and lights. Teaches counting, addition, and subtraction.',
                'price' => 34.99,
                'sale_price' => 29.99,
                'sku' => 'NUMBER-BOARD-001',
                'stock_quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['educational-learning-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Creative & Art Toys (5 products)
            [
                'name' => 'Art Supplies Set - 50 pieces',
                'slug' => 'art-supplies-set-50-pieces',
                'description' => 'Complete art set with crayons, markers, colored pencils, paint, brushes, and drawing pad. Perfect for creative expression.',
                'price' => 39.99,
                'sale_price' => 34.99,
                'sku' => 'ART-SET-50-001',
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['creative-art-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Play-Doh Fun Factory Set',
                'slug' => 'play-doh-fun-factory-set',
                'description' => 'Play-Doh set with 10 colors, tools, and molds. Create endless shapes and characters with this classic toy.',
                'price' => 24.99,
                'sale_price' => null,
                'sku' => 'PLAYDOH-FACTORY-001',
                'stock_quantity' => 55,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['creative-art-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Toy Piano - 32 Keys',
                'slug' => 'toy-piano-32-keys',
                'description' => 'Colorful 32-key toy piano with built-in songs and recording feature. Perfect for introducing music to children.',
                'price' => 59.99,
                'sale_price' => 49.99,
                'sku' => 'PIANO-TOY-32-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['creative-art-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Craft Kit - Jewelry Making',
                'slug' => 'craft-kit-jewelry-making',
                'description' => 'Create beautiful jewelry with colorful beads, strings, and charms. Includes instructions for 20+ designs.',
                'price' => 29.99,
                'sale_price' => null,
                'sku' => 'CRAFT-JEWELRY-001',
                'stock_quantity' => 40,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['creative-art-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Coloring Book Set - Animals',
                'slug' => 'coloring-book-set-animals',
                'description' => 'Set of 5 animal-themed coloring books with 200+ pages and 24 colored pencils. Hours of creative fun.',
                'price' => 19.99,
                'sale_price' => 16.99,
                'sku' => 'COLORING-ANIMALS-001',
                'stock_quantity' => 50,
                'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['creative-art-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Outdoor & Sports Toys (5 products)
            [
                'name' => 'Soccer Ball - Size 4',
                'slug' => 'soccer-ball-size-4',
                'description' => 'Official size 4 soccer ball with durable construction. Perfect for kids aged 8-12. Includes pump and carrying bag.',
                'price' => 24.99,
                'sale_price' => null,
                'sku' => 'SOCCER-BALL-4-001',
                'stock_quantity' => 60,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['outdoor-sports-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Basketball - Junior Size',
                'slug' => 'basketball-junior-size',
                'description' => 'Junior-sized basketball with excellent grip and bounce. Perfect for young players learning the game.',
                'price' => 19.99,
                'sale_price' => 16.99,
                'sku' => 'BASKETBALL-JR-001',
                'stock_quantity' => 45,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['outdoor-sports-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Skipping Rope - LED',
                'slug' => 'skipping-rope-led',
                'description' => 'LED skipping rope with colorful lights and adjustable length. Great for exercise and outdoor play.',
                'price' => 14.99,
                'sale_price' => null,
                'sku' => 'SKIP-ROPE-LED-001',
                'stock_quantity' => 70,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['outdoor-sports-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Toy Scooter - 3 Wheels',
                'slug' => 'toy-scooter-3-wheels',
                'description' => 'Stable 3-wheel scooter with adjustable handlebar height. Perfect for kids learning to balance and ride.',
                'price' => 79.99,
                'sale_price' => 69.99,
                'sku' => 'SCOOTER-3W-001',
                'stock_quantity' => 25,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['outdoor-sports-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Frisbee Set - 2 Pack',
                'slug' => 'frisbee-set-2-pack',
                'description' => 'Set of 2 colorful frisbees perfect for beach, park, or backyard play. Lightweight and durable design.',
                'price' => 12.99,
                'sale_price' => null,
                'sku' => 'FRISBEE-2PK-001',
                'stock_quantity' => 80,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['outdoor-sports-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Baby Toys (3 products)
            [
                'name' => 'Baby Rattle Set - 3 Pack',
                'slug' => 'baby-rattle-set-3-pack',
                'description' => 'Set of 3 colorful baby rattles with different textures and sounds. Perfect for sensory development and teething relief.',
                'price' => 16.99,
                'sale_price' => null,
                'sku' => 'RATTLE-3PK-001',
                'stock_quantity' => 65,
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['baby-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Teething Ring - Silicone',
                'slug' => 'teething-ring-silicone',
                'description' => 'Soft silicone teething ring with textured surface for gum relief. BPA-free and dishwasher safe.',
                'price' => 8.99,
                'sale_price' => null,
                'sku' => 'TEETH-RING-001',
                'stock_quantity' => 90,
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['baby-toys'],
                'is_featured' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Musical Mobile - Crib',
                'slug' => 'musical-mobile-crib',
                'description' => 'Beautiful musical mobile with soft animals and gentle lullabies. Helps soothe baby to sleep.',
                'price' => 39.99,
                'sale_price' => 34.99,
                'sku' => 'MOBILE-MUSIC-001',
                'stock_quantity' => 35,
                'image' => 'https://images.unsplash.com/photo-1515488044371-f7367423d58c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['baby-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],

            // Electronic & Interactive Toys (2 products)
            [
                'name' => 'Talking Doll - Interactive',
                'slug' => 'talking-doll-interactive',
                'description' => 'Interactive talking doll that responds to touch and voice. Says 50+ phrases and sings lullabies.',
                'price' => 49.99,
                'sale_price' => 44.99,
                'sku' => 'DOLL-TALKING-001',
                'stock_quantity' => 30,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['electronic-interactive-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Learning Tablet - Kids',
                'slug' => 'learning-tablet-kids',
                'description' => 'Educational tablet with 50+ learning games, stories, and activities. Parental controls and durable design.',
                'price' => 89.99,
                'sale_price' => 79.99,
                'sku' => 'TABLET-KIDS-001',
                'stock_quantity' => 20,
                'image' => 'https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=500&q=80',
                'category_id' => $categoryIds['electronic-interactive-toys'],
                'is_featured' => true,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('Child toys data seeded successfully!');
        $this->command->info('Created ' . count($categories) . ' toy categories and ' . count($products) . ' toy products');
    }
}
