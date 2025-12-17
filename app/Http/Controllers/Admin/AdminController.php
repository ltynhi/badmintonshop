<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        
        // Đơn hàng theo trạng thái
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $shippingOrders = Order::where('status', 'shipping')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        // Thống kê sản phẩm
        $activeProducts = Product::where('is_active', true)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<=', 10)->count();
        
        // Doanh thu theo tháng (6 tháng gần nhất)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Order::where('payment_status', 'paid')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('total');
            $monthlyRevenue[] = [
                'month' => $month->format('m/Y'),
                'revenue' => $revenue
            ];
        }
        
        // Top 5 sản phẩm bán chạy
        $topProducts = Product::withCount(['orderItems as total_sold' => function($query) {
            $query->selectRaw('sum(quantity)');
        }])
        ->orderBy('total_sold', 'desc')
        ->take(5)
        ->get();
        
        // Đơn hàng gần đây
        $recentOrders = Order::with('user', 'items')
            ->latest()
            ->take(10)
            ->get();
        
        // Khách hàng mới trong tháng
        $newCustomersThisMonth = User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'totalRevenue',
            'pendingOrders',
            'processingOrders',
            'shippingOrders',
            'completedOrders',
            'cancelledOrders',
            'activeProducts',
            'outOfStockProducts',
            'lowStockProducts',
            'monthlyRevenue',
            'topProducts',
            'recentOrders',
            'newCustomersThisMonth'
        ));
    }
}
