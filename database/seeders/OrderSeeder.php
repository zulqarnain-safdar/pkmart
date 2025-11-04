<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some users and products
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No users or products found. Please run UserSeeder and ProductSeeder first.');
            return;
        }

        // Create 10 sample orders
        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0, // Will be calculated
                'tax_amount' => 0,
                'shipping_amount' => 10.00,
                'status' => $this->getRandomStatus(),
                'payment_status' => $this->getRandomPaymentStatus(),
                'shipping_address' => $this->getRandomAddress(),
                'billing_address' => $this->getRandomAddress(),
                'phone' => $this->getRandomPhone(),
                'notes' => $i % 3 === 0 ? 'Please handle with care' : null,
            ]);

            // Add 1-4 random products to each order
            $orderItemsCount = rand(1, 4);
            $selectedProducts = $products->random($orderItemsCount);
            $subtotal = 0;

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $total = $price * $quantity;
                $subtotal += $total;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $total,
                ]);
            }

            // Calculate tax (8% of subtotal)
            $taxAmount = $subtotal * 0.08;
            $totalAmount = $subtotal + $taxAmount + $order->shipping_amount;

            // Update order with calculated amounts
            $order->update([
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
            ]);
        }

        $this->command->info('Created 10 sample orders with order items.');
    }

    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomPaymentStatus(): string
    {
        $statuses = ['pending', 'paid', 'failed', 'refunded'];
        return $statuses[array_rand($statuses)];
    }

    private function getRandomAddress(): string
    {
        $addresses = [
            '123 Main St, New York, NY 10001',
            '456 Oak Ave, Los Angeles, CA 90210',
            '789 Pine Rd, Chicago, IL 60601',
            '321 Elm St, Houston, TX 77001',
            '654 Maple Dr, Phoenix, AZ 85001',
        ];
        return $addresses[array_rand($addresses)];
    }

    private function getRandomPhone(): string
    {
        return '+1-' . rand(200, 999) . '-' . rand(100, 999) . '-' . rand(1000, 9999);
    }
}
