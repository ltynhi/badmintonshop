<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Thay đổi từ decimal(10,2) thành decimal(15,0) để hỗ trợ giá VND không có phần thập phân
            $table->decimal('price', 15, 0)->change();
            $table->decimal('sale_price', 15, 0)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
            $table->decimal('sale_price', 10, 2)->nullable()->change();
        });
    }
};