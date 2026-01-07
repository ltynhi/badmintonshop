<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

echo "=== SIMPLE REVIEW TEST ===\n";

// Test tìm product
$product = Product::find(99); // Váy cầu lông có review
if (!$product) {
    echo "Product 99 not found, trying product 11\n";
    $product = Product::find(11);
}

if (!$product) {
    echo "No product found!\n";
    exit;
}

echo "Product: " . $product->name . " (ID: " . $product->id . ")\n";

// Test user
$user = User::where('role', 'customer')->first();
if (!$user) {
    echo "No customer user found!\n";
    exit;
}

echo "User: " . $user->name . " (ID: " . $user->id . ")\n";

// Đăng nhập user
Auth::login($user);
echo "User authenticated: " . (Auth::check() ? 'Yes' : 'No') . "\n";

// Kiểm tra xem user đã review sản phẩm này chưa
$existingReview = Review::where('product_id', $product->id)
    ->where('user_id', $user->id)
    ->first();

if ($existingReview) {
    echo "User already reviewed this product. Deleting old review...\n";
    $existingReview->delete();
}

// Tạo review mới
try {
    $review = Review::create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'rating' => 4,
        'comment' => 'Test review comment with more than 10 characters',
        'is_approved' => false
    ]);
    
    echo "Review created successfully!\n";
    echo "- Review ID: " . $review->id . "\n";
    echo "- Product ID: " . $review->product_id . "\n";
    echo "- User ID: " . $review->user_id . "\n";
    echo "- Rating: " . $review->rating . "\n";
    echo "- Comment: " . $review->comment . "\n";
    echo "- Approved: " . ($review->is_approved ? 'Yes' : 'No') . "\n";
    
} catch (Exception $e) {
    echo "Error creating review: " . $e->getMessage() . "\n";
}

echo "\nTotal reviews in database: " . Review::count() . "\n";