<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'phone' => '0123456789',
        ]);

        // Tạo Customer mẫu
        User::create([
            'name' => 'Khách hàng',
            'email' => 'customer@test.com',
            'password' => Hash::make('123456'),
            'role' => 'customer',
            'phone' => '0987654321',
            'address' => 'Hà Nội',
        ]);

        // Tạo Categories
        $categories = [
            ['name' => 'Vợt cầu lông', 'description' => 'Các loại vợt cầu lông chất lượng cao'],
            ['name' => 'Giày cầu lông', 'description' => 'Giày chuyên dụng cho cầu lông'],
            ['name' => 'Quần áo', 'description' => 'Quần áo thể thao cầu lông'],
            ['name' => 'Phụ kiện', 'description' => 'Các phụ kiện cầu lông'],
            ['name' => 'Túi vợt', 'description' => 'Túi đựng vợt và đồ cầu lông'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Tạo Products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Vợt Yonex Astrox 99',
                'description' => 'Vợt cầu lông cao cấp Yonex Astrox 99',
                'price' => 4500000,
                'sale_price' => 3990000,
                'stock' => 20,
                'brand' => 'Yonex',
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Vợt Victor Thruster K 9900',
                'description' => 'Vợt cầu lông Victor Thruster K 9900',
                'price' => 3800000,
                'stock' => 15,
                'brand' => 'Victor',
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Giày Yonex SHB 65Z3',
                'description' => 'Giày cầu lông chuyên nghiệp',
                'price' => 2200000,
                'sale_price' => 1990000,
                'stock' => 30,
                'brand' => 'Yonex',
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Giày Lining AYTQ011',
                'description' => 'Giày cầu lông Lining cao cấp',
                'price' => 1800000,
                'stock' => 25,
                'brand' => 'Lining',
            ],
            [
                'category_id' => 3,
                'name' => 'Áo Yonex 10428EX',
                'description' => 'Áo thi đấu Yonex chính hãng',
                'price' => 450000,
                'stock' => 50,
                'brand' => 'Yonex',
            ],
            [
                'category_id' => 3,
                'name' => 'Quần Victor R-3096',
                'description' => 'Quần cầu lông Victor',
                'price' => 380000,
                'stock' => 40,
                'brand' => 'Victor',
            ],
            [
                'category_id' => 4,
                'name' => 'Cước Yonex BG80',
                'description' => 'Cước căng vợt Yonex BG80',
                'price' => 180000,
                'stock' => 100,
                'brand' => 'Yonex',
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Quấn cán Yonex AC102EX',
                'description' => 'Quấn cán vợt cao cấp',
                'price' => 85000,
                'stock' => 200,
                'brand' => 'Yonex',
            ],
            [
                'category_id' => 5,
                'name' => 'Túi Yonex BAG9831W',
                'description' => 'Túi đựng vợt 3 ngăn',
                'price' => 1200000,
                'stock' => 15,
                'brand' => 'Yonex',
            ],
            [
                'category_id' => 5,
                'name' => 'Balo Victor BR6011',
                'description' => 'Balo đựng vợt và đồ cầu lông',
                'price' => 950000,
                'sale_price' => 850000,
                'stock' => 20,
                'brand' => 'Victor',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Tạo News
        $newsItems = [
            [
                'title' => 'Hướng dẫn chọn vợt cầu lông phù hợp',
                'excerpt' => 'Cách chọn vợt cầu lông phù hợp với trình độ và phong cách chơi',
                'content' => 'Nội dung chi tiết về cách chọn vợt cầu lông...',
                'user_id' => 1,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Top 5 giày cầu lông tốt nhất 2024',
                'excerpt' => 'Đánh giá những đôi giày cầu lông được ưa chuộng nhất',
                'content' => 'Nội dung chi tiết về top giày cầu lông...',
                'user_id' => 1,
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Kỹ thuật cơ bản trong cầu lông',
                'excerpt' => 'Những kỹ thuật cơ bản mà người mới chơi cần biết',
                'content' => 'Nội dung chi tiết về kỹ thuật cầu lông...',
                'user_id' => 1,
                'is_published' => true,
                'published_at' => now(),
            ],
        ];

        foreach ($newsItems as $news) {
            News::create($news);
        }
    }
}
