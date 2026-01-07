<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

// Trang người dùng
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/list-product', [PageController::class, 'listProduct'])->name('list-product');
Route::get('/sale-off', [PageController::class, 'saleoff'])->name('sale-off');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/list-news', [PageController::class, 'listnews'])->name('list-news');
Route::get('/instruct', [PageController::class, 'instruct'])->name('instruct');

// Search
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/api/search/autocomplete', [\App\Http\Controllers\SearchController::class, 'autocomplete'])->name('search.autocomplete');

// Authentication
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
Route::get('/register', [PageController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Password Reset
Route::get('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'showForgotForm'])->name('forgot-pass');
Route::post('/forgot-password', [\App\Http\Controllers\PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('password.update');

// Product Detail
Route::get('/product/{product}', [PageController::class, 'productDetail'])->name('product.detail');

// News Detail
Route::get('/news/{news}', [PageController::class, 'newsDetail'])->name('news.detail');

// Cart
Route::get('/cart', [PageController::class, 'cart'])->name('cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout - Yêu cầu đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');
    
    // My Orders
    Route::get('/my-orders', [PageController::class, 'myOrders'])->name('my-orders');
    
    // Reviews
    Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('review.store');
    
    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/api/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    // Order Detail & Cancel
    Route::get('/order/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.detail');
    Route::put('/order/{order}/cancel', [\App\Http\Controllers\OrderController::class, 'cancel'])->name('order.cancel');
});

// Trang admin - Yêu cầu đăng nhập và là admin
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('news', NewsController::class);
    Route::resource('orders', OrderController::class);
    
    // Order Management
    Route::put('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('order.update-status');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    
    // Reviews Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Contacts Management
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
    Route::patch('/contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.update-status');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/export', [ReportController::class, 'exportExcel'])->name('reports.export');
    Route::post('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    Route::post('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
});

// Test routes (remove in production)
if (app()->environment('local')) {
    require __DIR__ . '/test.php';
}
