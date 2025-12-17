@extends('admin.layout.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="mb-0 fw-bold" style="color: #2c3e50;">📦 Chi tiết đơn hàng: {{ $order->order_number }}</h5>
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Cập nhật</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->price) }}đ</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total) }}đ</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                                <td><strong>{{ number_format($order->subtotal) }}đ</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                <td><strong>{{ number_format($order->shipping_fee) }}đ</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td><strong class="text-danger">{{ number_format($order->total) }}đ</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Thông tin khách hàng</h5>
            </div>
            <div class="card-body">
                <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông tin đơn hàng</h5>
            </div>
            <div class="card-body">
                <p><strong>Trạng thái:</strong> 
                    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                        {{ $order->status_label }}
                    </span>
                </p>
                <p><strong>Thanh toán:</strong> 
                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                        {{ $order->payment_status == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                    </span>
                </p>
                <p><strong>Phương thức:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                @if($order->note)
                    <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
