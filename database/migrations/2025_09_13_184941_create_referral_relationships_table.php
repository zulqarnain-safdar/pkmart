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
        Schema::create('referral_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('referral_code_id')->constrained('referral_codes')->onDelete('cascade');
            $table->integer('level')->default(1); // 1 for direct referral, 2 for second level
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->useCurrent();
            
            $table->unique(['referrer_id', 'referred_id']);
            $table->index(['referrer_id', 'level']);
            $table->index(['referred_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_relationships');
    }
};