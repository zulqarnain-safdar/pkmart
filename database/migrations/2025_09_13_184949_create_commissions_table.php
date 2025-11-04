<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('first_level_percentage', 5, 2)->default(0); // Percentage for direct referrer
            $table->decimal('second_level_percentage', 5, 2)->default(0); // Percentage for second level referrer
            $table->decimal('buyer_percentage', 5, 2)->default(0); // Percentage for buyer
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique('product_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};