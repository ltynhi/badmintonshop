<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->route('list-product');
        }
        
        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('brand', 'like', "%{$query}%");
            })
            ->with('category')
            ->paginate(12);
        
        $categories = \App\Models\Category::where('is_active', true)->get();
        $allBrands = Product::where('is_active', true)
            ->whereNotNull('brand')
            ->distinct()
            ->pluck('brand')
            ->filter()
            ->sort()
            ->values();
        
        return view('list-product', compact('products', 'categories', 'allBrands', 'query'));
    }
    
    public function autocomplete(Request $request)
    {
        $query = $request->input('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $products = Product::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('brand', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'price', 'sale_price', 'image', 'slug')
            ->limit(5)
            ->get();
        
        return response()->json($products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => number_format($product->getCurrentPrice()),
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'url' => route('product.detail', $product)
            ];
        }));
    }
}
