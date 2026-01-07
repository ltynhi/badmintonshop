<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Debug log
        \Log::info('Review store method called', [
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
            'is_authenticated' => Auth::check()
        ]);

        if (!Auth::check()) {
            \Log::warning('User not authenticated for review');
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá',
            'rating.min' => 'Đánh giá tối thiểu 1 sao',
            'rating.max' => 'Đánh giá tối đa 5 sao',
            'comment.required' => 'Vui lòng nhập nội dung đánh giá',
            'comment.min' => 'Nội dung đánh giá tối thiểu 10 ký tự',
            'comment.max' => 'Nội dung đánh giá tối đa 1000 ký tự'
        ]);

        // Kiểm tra user đã đánh giá sản phẩm này chưa
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            \Log::info('User already reviewed this product', ['review_id' => $existingReview->id]);
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi');
        }

        try {
            $review = Review::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => false // Chờ admin duyệt
            ]);

            \Log::info('Review created successfully', ['review_id' => $review->id]);

            // Tạo notification cho admin về review mới (Bước 19 trong biểu đồ)
            $adminUsers = \App\Models\User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                \App\Models\Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'new_review',
                    'title' => 'Đánh giá mới cần duyệt',
                    'message' => Auth::user()->name . ' đã đánh giá sản phẩm "' . $product->name . '" với ' . $request->rating . ' sao',
                    'data' => [
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'reviewer_name' => Auth::user()->name,
                        'rating' => $request->rating,
                        'review_time' => now()->toISOString()
                    ]
                ]);
            }

            return back()->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn sẽ được hiển thị sau khi được duyệt.');
            
        } catch (\Exception $e) {
            \Log::error('Error creating review', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại.');
        }
    }
}
