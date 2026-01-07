<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $requestedQuantity = $request->quantity ?? 1;
        
        // Stock validation (Bước 5-6 trong biểu đồ)
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng!');
        }
        
        $cart = session()->get('cart', []);
        $currentQuantityInCart = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $totalQuantity = $currentQuantityInCart + $requestedQuantity;
        
        if ($totalQuantity > $product->stock) {
            return redirect()->back()->with('error', "Chỉ còn {$product->stock} sản phẩm trong kho!");
        }
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $requestedQuantity;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->getCurrentPrice(),
                'quantity' => $requestedQuantity,
                'image' => $product->image,
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $product = Product::find($request->id);
            
            // Stock validation (Bước 21-23 trong biểu đồ)
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
            }
            
            if ($request->quantity > $product->stock) {
                return response()->json([
                    'success' => false, 
                    'message' => "Chỉ còn {$product->stock} sản phẩm trong kho!",
                    'max_quantity' => $product->stock
                ]);
            }
            
            $cart = session()->get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}
