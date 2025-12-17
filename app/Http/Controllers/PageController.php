<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home() 
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_active', true)
            ->with('category')
            ->take(8)
            ->get();
        
        $newProducts = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(12)
            ->get();
        
        $saleProducts = Product::where('is_active', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '<', \DB::raw('price'))
            ->with('category')
            ->take(8)
            ->get();
        
        $categories = Category::where('is_active', true)->get();
        
        $latestNews = News::where('is_published', true)
            ->latest('published_at')
            ->take(4)
            ->get();
        
        return view('home', compact('featuredProducts', 'newProducts', 'saleProducts', 'categories', 'latestNews'));
    }

    public function listProduct(Request $request) 
    {
        $query = Product::where('is_active', true)->with('category');
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('brand')) {
            $brands = is_array($request->brand) ? $request->brand : [$request->brand];
            $query->whereIn('brand', $brands);
        }
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12)->appends($request->except('page'));
        $categories = Category::where('is_active', true)->get();
        $allBrands = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand')
            ->filter()
            ->sort()
            ->values();
        
        return view('list-product', compact('products', 'categories', 'allBrands'));
    }

    public function saleoff(Request $request) 
    {
        $query = Product::where('is_active', true)
            ->whereNotNull('sale_price')
            ->where('sale_price', '<', \DB::raw('price'))
            ->with('category');
        
        // Lọc theo danh mục
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Lọc theo mức giảm giá
        if ($request->has('discount')) {
            $discounts = is_array($request->discount) ? $request->discount : [$request->discount];
            $query->where(function($q) use ($discounts) {
                foreach ($discounts as $discount) {
                    $discountValue = (int)str_replace('%', '', $discount);
                    $q->orWhereRaw('((price - sale_price) / price * 100) >= ?', [$discountValue])
                      ->whereRaw('((price - sale_price) / price * 100) < ?', [$discountValue + 10]);
                }
            });
        }
        
        // Lọc theo khoảng giá
        if ($request->has('price_range')) {
            $ranges = is_array($request->price_range) ? $request->price_range : [$request->price_range];
            $query->where(function($q) use ($ranges) {
                foreach ($ranges as $range) {
                    switch ($range) {
                        case 'under_500k':
                            $q->orWhere('sale_price', '<', 500000);
                            break;
                        case '500k_1m':
                            $q->orWhereBetween('sale_price', [500000, 1000000]);
                            break;
                        case '1m_2m':
                            $q->orWhereBetween('sale_price', [1000000, 2000000]);
                            break;
                        case '2m_3m':
                            $q->orWhereBetween('sale_price', [2000000, 3000000]);
                            break;
                    }
                }
            });
        }
        
        $products = $query->paginate(12)->appends($request->except('page'));
        $categories = Category::where('is_active', true)->get();
        
        return view('sale-off', compact('products', 'categories'));
    }

    public function contact() 
    {
        return view('contact');
    }

    public function listnews(Request $request) 
    {
        $query = News::where('is_published', true);
        
        // Tìm kiếm
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }
        
        $news = $query->latest('published_at')->paginate(9)->appends($request->except('page'));
        
        return view('list-news', compact('news'));
    }

    public function cart() 
    {
        return view('cart');
    }

    public function checkout() 
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }
        
        return view('checkout');
    }

    public function register() 
    {
        return view('register');
    }

    public function forgotpass() 
    {
        return view('fogot-pass');
    }

    public function instruct() 
    {
        return view('instruct');
    }

    public function profile() 
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return view('profile');
    }

    public function myOrders() 
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $orders = Auth::user()->orders()->with('items.product')->latest()->paginate(10);
        return view('my-orders', compact('orders'));
    }

    public function productDetail(Product $product)
    {
        $product->load('category');
        
        // Sản phẩm liên quan cùng danh mục
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        // Load reviews: đã duyệt + review của user hiện tại (nếu có)
        $reviewsQuery = $product->reviews()->with('user')->latest();
        
        if (Auth::check()) {
            // Hiển thị reviews đã duyệt + review của chính user
            $reviews = $reviewsQuery->where(function($query) {
                $query->where('is_approved', true)
                      ->orWhere('user_id', Auth::id());
            })->get();
        } else {
            // Chỉ hiển thị reviews đã duyệt
            $reviews = $reviewsQuery->where('is_approved', true)->get();
        }
        
        $averageRating = $product->getAverageRating();
        $totalReviews = $product->getTotalReviews();
        
        return view('product-detail', compact('product', 'relatedProducts', 'reviews', 'averageRating', 'totalReviews'));
    }

    public function newsDetail(News $news)
    {
        // Tin tức liên quan
        $relatedNews = News::where('is_published', true)
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(4)
            ->get();
        
        return view('news-detail', compact('news', 'relatedNews'));
    }
}
