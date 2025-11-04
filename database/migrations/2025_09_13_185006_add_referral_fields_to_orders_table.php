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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('referral_code_used')->nullable();
            $table->foreignId('referrer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('total_commission_amount', 10, 2)->default(0);
            $table->boolean('commissions_processed')->default(false);
            $table->timestamp('commissions_processed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'referral_code_used',
                'referrer_id',
                'total_commission_amount',
                'commissions_processed',
                'commissions_processed_at'
            ]);
        });
    }
};