<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Cập nhật các cột giá trong orders
            $table->decimal('subtotal', 15, 0)->change();
            $table->decimal('shipping_fee', 15, 0)->change();
            $table->decimal('total', 15, 0)->change();
            $table->decimal('discount_amount', 15, 0)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->change();
            $table->decimal('shipping_fee', 10, 2)->change();
            $table->decimal('total', 10, 2)->change();
            $table->decimal('discount_amount', 10, 2)->default(0)->change();
        });
    }
};