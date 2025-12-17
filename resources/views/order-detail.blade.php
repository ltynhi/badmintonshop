@extends('layout.customer')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Chi tiết đơn hàng #{{ $order->order_number }}</h2>
                <a href="{{ route('profile') }}#orders" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <!-- Trạng thái đơn hàng -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Trạng thái đơn hàng</h5>
                            <div class="mb-2">
                                <strong>Trạng thái:</strong>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-info">Đã xác nhận</span>
                                        @break
                                    @case('processing')
                                        <span class="badge bg-primary">Đang xử lý</span>
                                        @break
                                    @case('shipping')
                                        <span class="badge bg-info">Đang giao hàng</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Đã hủy</span>
                                        @break
                                @endswitch
                            </div>
                            <div class="mb-2">
                                <strong>Thanh toán:</strong>
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                @endif
                            </div>
                            <div>
                                <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Timeline</h5>
                            <div class="timeline">
                                <div class="timeline-item {{ $order->status == 'pending' ? 'active' : 'completed' }}">
                                    <i class="fas fa-check-circle"></i> Đơn hàng đã đặt
                                </div>
                                <div class="timeline-item {{ in_array($order->status, ['confirmed', 'processing', 'shipping', 'completed']) ? 'completed' : ($order->status == 'pending' ? 'active' : '') }}">
                                    <i class="fas fa-check-circle"></i> Đã xác nhận
                                </div>
                                <div class="timeline-item {{ in_array($order->status, ['processing', 'shipping', 'completed']) ? 'completed' : '' }}">
                                    <i class="fas fa-box"></i> Đang chuẩn bị hàng
                                </div>
                                <div class="timeline-item {{ in_array($order->status, ['shipping', 'completed']) ? 'completed' : '' }}">
                                    <i class="fas fa-shipping-fast"></i> Đang giao hàng
                                </div>
                                <div class="timeline-item {{ $order->status == 'completed' ? 'completed' : '' }}">
                                    <i class="fas fa-check-circle"></i> Hoàn thành
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Thông tin giao hàng -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shipping-fast"></i> Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
                            <p class="mb-2"><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                            <p class="mb-2"><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p class="mb-0"><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
                            @if($order->note)
                                <hr>
                                <p class="mb-0"><strong>Ghi chú:</strong> {{ $order->note }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Thông tin thanh toán -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-credit-card"></i> Thông tin thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Phương thức:</strong>
                                @switch($order->payment_method)
                                    @case('cod')
                                        Thanh toán khi nhận hàng (COD)
                                        @break
                                    @case('bank_transfer')
                                        Chuyển khoản ngân hàng
                                        @break
                                    @case('momo')
                                        Ví MoMo
                                        @break
                                    @case('vnpay')
                                        VNPay
                                        @break
                                @endswitch
                            </p>
                            <p class="mb-2">
                                <strong>Trạng thái:</strong>
                                @if($order->payment_status == 'paid')
                                    <span class="text-success">Đã thanh toán</span>
                                @else
                                    <span class="text-warning">Chưa thanh toán</span>
                                @endif
                            </p>
                            
                            @if($order->payment_method == 'bank_transfer' && $order->payment_status == 'unpaid')
                                <hr>
                                <div class="alert alert-info mb-0">
                                    <strong>Thông tin chuyển khoản:</strong><br>
                                    Ngân hàng: Vietcombank<br>
                                    STK: 1234567890<br>
                                    Chủ TK: COZA STORE<br>
                                    Nội dung: {{ $order->order_number }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Sản phẩm đã đặt</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-end">Đơn giá</th>
                                    <th class="text-end">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product_name }}" 
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;"
                                                     class="me-3">
                                            @endif
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product)
                                                    <br>
                                                    <a href="{{ route('product.detail', $item->product) }}" 
                                                       class="text-primary small">
                                                        Xem sản phẩm
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                                    <td class="text-end align-middle">{{ number_format($item->price) }}đ</td>
                                    <td class="text-end align-middle"><strong>{{ number_format($item->total) }}đ</strong></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tổng tiền -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <td>Tạm tính:</td>
                                    <td class="text-end">{{ number_format($order->subtotal) }}đ</td>
                                </tr>
                                <tr>
                                    <td>Phí vận chuyển:</td>
                                    <td class="text-end">{{ number_format($order->shipping_fee) }}đ</td>
                                </tr>
                                @if($order->discount_amount > 0)
                                <tr>
                                    <td>Giảm giá:</td>
                                    <td class="text-end text-danger">-{{ number_format($order->discount_amount) }}đ</td>
                                </tr>
                                @endif
                                <tr class="border-top">
                                    <td><strong>Tổng cộng:</strong></td>
                                    <td class="text-end"><strong class="text-danger fs-5">{{ number_format($order->total) }}đ</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="mt-4 text-end">
                @if($order->status == 'pending')
                    <form action="{{ route('order.cancel', $order) }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Hủy đơn hàng
                        </button>
                    </form>
                @endif
                
                @if($order->status == 'completed' && !$order->orderItems->first()->review)
                    <a href="{{ route('product.detail', $order->orderItems->first()->product->slug) }}#reviews" 
                       class="btn btn-warning">
                        <i class="fas fa-star"></i> Đánh giá sản phẩm
                    </a>
                @endif
                
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fas fa-print"></i> In hóa đơn
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding: 10px 0;
    color: #999;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #ddd;
}

.timeline-item i {
    position: absolute;
    left: -37px;
    top: 10px;
    width: 16px;
    height: 16px;
    background: white;
    border: 2px solid #ddd;
    border-radius: 50%;
    font-size: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-item.completed {
    color: #28a745;
}

.timeline-item.completed::before {
    background: #28a745;
}

.timeline-item.completed i {
    border-color: #28a745;
    color: #28a745;
}

.timeline-item.active {
    color: #007bff;
    font-weight: bold;
}

.timeline-item.active i {
    border-color: #007bff;
    color: #007bff;
}

@media print {
    .btn, .timeline, nav, footer {
        display: none !important;
    }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection
