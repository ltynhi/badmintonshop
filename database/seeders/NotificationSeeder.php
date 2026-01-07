<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy một số user để tạo notification mẫu
        $users = User::where('role', 'customer')->take(3)->get();
        
        foreach ($users as $user) {
            // Notification chào mừng
            Notification::create([
                'user_id' => $user->id,
                'type' => 'welcome',
                'title' => 'Chào mừng đến với Coza Shop!',
                'message' => 'Cảm ơn bạn đã đăng ký tài khoản. Chúc bạn có những trải nghiệm mua sắm tuyệt vời!',
                'data' => [
                    'welcome_bonus' => true,
                    'first_time_user' => true
                ],
                'created_at' => now()->subDays(rand(1, 30))
            ]);
            
            // Notification về sản phẩm mới
            Notification::create([
                'user_id' => $user->id,
                'type' => 'new_product',
                'title' => 'Sản phẩm mới đã có mặt!',
                'message' => 'Khám phá những sản phẩm mới nhất với chất lượng tuyệt vời.',
                'data' => [
                    'product_count' => rand(5, 20)
                ],
                'created_at' => now()->subDays(rand(1, 15))
            ]);
            
            // Notification về sale
            Notification::create([
                'user_id' => $user->id,
                'type' => 'product_sale',
                'title' => 'Flash Sale - Giảm đến 50%!',
                'message' => 'Đừng bỏ lỡ cơ hội mua sắm với giá ưu đãi cực hấp dẫn.',
                'data' => [
                    'discount_percent' => rand(20, 50),
                    'end_time' => now()->addDays(3)->toISOString()
                ],
                'created_at' => now()->subDays(rand(1, 7))
            ]);
        }
    }
}