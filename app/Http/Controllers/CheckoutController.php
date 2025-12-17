<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cod,bank_transfer,momo,vnpay',
            'note' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();
        
        try {
            $subtotal = 0;
            foreach ($cart as $id => $details) {
                $subtotal += $details['price'] * $details['quantity'];
            }
            
            $shippingFee = 30000; // 30k phí ship
            $total = $subtotal + $shippingFee;
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'note' => $validated['note'] ?? null,
            ]);
            
            foreach ($cart as $productId => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_name' => $details['name'],
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                    'total' => $details['price'] * $details['quantity'],
                ]);
                
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $details['quantity']);
                }
            }
            
            DB::commit();
            
            // Tạo thông báo cho khách hàng
            \App\Models\Notification::create([
                'user_id' => Auth::id(),
                'type' => 'order_created',
                'title' => 'Đặt hàng thành công',
                'message' => "Đơn hàng #{$order->order_number} đã được tạo thành công. Tổng tiền: " . number_format($total) . "đ",
                'data' => json_encode(['order_id' => $order->id])
            ]);
            
            session()->forget('cart');
            
            return redirect()->route('home')
                ->with('success', 'Đặt hàng thành công! Mã đơn hàng: #' . $order->order_number . '. Chúng tôi sẽ liên hệ với bạn sớm nhất!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra. Vui lòng thử lại!')
                ->withInput();
        }
    }
}
