<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/test-review-form/{product}', function (Product $product) {
    // Đăng nhập user đầu tiên để test
    $user = User::where('role', 'customer')->first();
    if ($user) {
        Auth::login($user);
    }
    
    return view('test-review-form', compact('product'));
});

Route::post('/test-review-submit/{product}', function (\Illuminate\Http\Request $request, Product $product) {
    \Log::info('Test review submit', [
        'product_id' => $product->id,
        'request_data' => $request->all(),
        'user_id' => Auth::id(),
        'is_authenticated' => Auth::check()
    ]);
    
    return response()->json([
        'success' => true,
        'message' => 'Test form received',
        'data' => $request->all(),
        'user_id' => Auth::id(),
        'product_id' => $product->id
    ]);
});