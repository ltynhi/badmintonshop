<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'customer')->get();
        $products = Product::take(5)->get();

        $comments = [
            'Sản phẩm rất tốt, chất lượng cao, đáng tiền!',
            'Giao hàng nhanh, đóng gói cẩn thận. Sản phẩm đúng như mô tả.',
            'Chất lượng ổn, giá cả hợp lý. Sẽ mua lại lần sau.',
            'Sản phẩm đẹp, chất lượng tốt. Nhân viên tư vấn nhiệt tình.',
            'Rất hài lòng với sản phẩm này. Chất lượng vượt mong đợi.',
            'Sản phẩm tốt, giao hàng đúng hẹn. Cảm ơn shop!',
            'Chất lượng sản phẩm tuyệt vời, đúng như hình ảnh quảng cáo.',
            'Giá cả phải chăng, chất lượng tốt. Sẽ giới thiệu cho bạn bè.',
        ];

        foreach ($products as $product) {
            // Tạo 2-4 reviews cho mỗi sản phẩm
            $reviewCount = rand(2, 4);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                $user = $users->random();
                
                // Kiểm tra user đã review sản phẩm này chưa
                $existingReview = Review::where('product_id', $product->id)
                    ->where('user_id', $user->id)
                    ->first();
                
                if (!$existingReview) {
                    Review::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'rating' => rand(3, 5), // Rating từ 3-5 sao
                        'comment' => $comments[array_rand($comments)],
                        'is_approved' => true, // Tự động duyệt
                    ]);
                }
            }
        }
    }
}