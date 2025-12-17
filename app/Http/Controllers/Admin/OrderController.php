<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }
        
        $orders = $query->latest()->paginate(15);
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
            'note' => 'nullable|string',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);
        
        // Tạo thông báo nếu trạng thái thay đổi
        if ($oldStatus !== $validated['status'] && $order->user_id) {
            $statusLabels = [
                'pending' => 'Chờ xử lý',
                'processing' => 'Đang xử lý',
                'shipping' => 'Đang giao hàng',
                'completed' => 'Hoàn thành',
                'cancelled' => 'Đã hủy',
            ];
            
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'type' => 'order_status_updated',
                'title' => 'Cập nhật đơn hàng',
                'message' => "Đơn hàng #{$order->order_number} đã chuyển sang trạng thái: {$statusLabels[$validated['status']]}",
                'data' => json_encode(['order_id' => $order->id])
            ]);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Đơn hàng đã được cập nhật!');
    }

    public function destroy(Order $order)
    {
        if ($order->status != 'cancelled') {
            return redirect()->route('admin.orders.index')
                ->with('error', 'Chỉ có thể xóa đơn hàng đã hủy!');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được xóa!');
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipping,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $order->update($validated);

        // Tạo thông báo cho khách hàng
        if ($order->user_id) {
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'type' => 'order_status_updated',
                'title' => 'Cập nhật đơn hàng #' . $order->order_number,
                'message' => 'Đơn hàng của bạn đã được cập nhật trạng thái: ' . $this->getStatusText($validated['status']),
                'data' => json_encode(['order_id' => $order->id]),
            ]);
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng');
    }

    /**
     * Hủy đơn hàng (Admin)
     */
    public function cancelOrder(Order $order)
    {
        if ($order->status == 'cancelled') {
            return back()->with('error', 'Đơn hàng đã bị hủy trước đó');
        }

        $order->update(['status' => 'cancelled']);

        // Hoàn trả tồn kho
        foreach ($order->orderItems as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // Thông báo cho khách hàng
        if ($order->user_id) {
            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'type' => 'order_status_updated',
                'title' => 'Đơn hàng #' . $order->order_number . ' đã bị hủy',
                'message' => 'Đơn hàng của bạn đã bị hủy bởi quản trị viên',
                'data' => json_encode(['order_id' => $order->id]),
            ]);
        }

        return back()->with('success', 'Đã hủy đơn hàng thành công');
    }

    /**
     * Lấy text trạng thái
     */
    private function getStatusText($status)
    {
        $statuses = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        return $statuses[$status] ?? $status;
    }
}
