<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        // Kiểm tra quyền xem đơn hàng
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền xem đơn hàng này');
        }

        $order->load('orderItems.product');

        return view('order-detail', compact('order'));
    }

    /**
     * Hủy đơn hàng
     */
    public function cancel(Order $order)
    {
        // Kiểm tra quyền hủy đơn hàng
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này');
        }

        // Chỉ cho phép hủy đơn hàng ở trạng thái pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Không thể hủy đơn hàng đã được xác nhận');
        }

        // Cập nhật trạng thái
        $order->update(['status' => 'cancelled']);

        // Hoàn trả tồn kho
        foreach ($order->orderItems as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        return redirect()->route('profile')->with('success', 'Đã hủy đơn hàng thành công');
    }
}
