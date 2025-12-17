<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Cập nhật các cột giá trong order_items
            $table->decimal('price', 15, 0)->change();
            $table->decimal('total', 15, 0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
            $table->decimal('total', 10, 2)->change();
        });
    }
};