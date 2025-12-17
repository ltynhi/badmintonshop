@extends('layout.admin')

@section('title', 'Chi tiết đơn hàng #' . $order->order_number)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Chi tiết đơn hàng #{{ $order->order_number }}</h2>
                <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Cột trái: Thông tin đơn hàng -->
                <div class="col-lg-8">
                    <!-- Trạng thái và hành động -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Trạng thái đơn hàng</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.order.update-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row align-items-end">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><strong>Trạng thái đơn hàng:</strong></label>
                                        <select name="status" class="form-select" required>
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label"><strong>Trạng thái thanh toán:</strong></label>
                                        <select name="payment_status" class="form-select" required>
                                            <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                                            <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-save"></i> Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    <p class="mb-0"><strong>Cập nhật:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button onclick="window.print()" class="btn btn-primary">
                                        <i class="fas fa-print"></i> In hóa đơn
                                    </button>
                                    @if($order->status != 'cancelled')
                                        <form action="{{ route('admin.order.cancel', $order) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-times"></i> Hủy đơn
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danh sách sản phẩm -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> Sản phẩm trong đơn hàng</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50%">Sản phẩm</th>
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
                                                            <small class="text-muted">SKU: {{ $item->product->id }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="text-end align-middle">{{ number_format($item->price) }}đ</td>
                                            <td class="text-end align-middle"><strong>{{ number_format($item->total) }}đ</strong></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Tạm tính:</strong></td>
                                            <td class="text-end"><strong>{{ number_format($order->subtotal) }}đ</strong></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Phí vận chuyển:</strong></td>
                                            <td class="text-end"><strong>{{ number_format($order->shipping_fee) }}đ</strong></td>
                                        </tr>
                                        @if($order->discount_amount > 0)
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Giảm giá:</strong></td>
                                            <td class="text-end text-danger"><strong>-{{ number_format($order->discount_amount) }}đ</strong></td>
                                        </tr>
                                        @endif
                                        <tr class="table-primary">
                                            <td colspan="3" class="text-end"><strong>TỔNG CỘNG:</strong></td>
                                            <td class="text-end"><strong class="text-danger fs-5">{{ number_format($order->total) }}đ</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Thông tin khách hàng -->
                <div class="col-lg-4">
                    <!-- Thông tin khách hàng -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Thông tin khách hàng</h5>
                        </div>
                        <div class="card-body">
                            @if($order->user)
                                <p class="mb-2">
                                    <strong>Tài khoản:</strong><br>
                                    <a href="{{ route('admin.users.show', $order->user) }}">
                                        {{ $order->user->name }}
                                    </a>
                                </p>
                                <p class="mb-2">
                                    <strong>Email:</strong><br>
                                    <a href="mailto:{{ $order->user->email }}">{{ $order->user->email }}</a>
                                </p>
                            @else
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-info-circle"></i> Khách vãng lai
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Thông tin giao hàng -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="mb-0"><i class="fas fa-shipping-fast"></i> Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Người nhận:</strong><br>{{ $order->customer_name }}</p>
                            <p class="mb-2">
                                <strong>Số điện thoại:</strong><br>
                                <a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a>
                            </p>
                            <p class="mb-2">
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a>
                            </p>
                            <p class="mb-0"><strong>Địa chỉ:</strong><br>{{ $order->customer_address }}</p>
                        </div>
                    </div>

                    <!-- Thông tin thanh toán -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fas fa-credit-card"></i> Thanh toán</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Phương thức:</strong><br>
                                @switch($order->payment_method)
                                    @case('cod')
                                        <span class="badge bg-warning text-dark">COD</span>
                                        @break
                                    @case('bank_transfer')
                                        <span class="badge bg-info">Chuyển khoản</span>
                                        @break
                                    @case('momo')
                                        <span class="badge bg-danger">MoMo</span>
                                        @break
                                    @case('vnpay')
                                        <span class="badge bg-primary">VNPay</span>
                                        @break
                                @endswitch
                            </p>
                            <p class="mb-0">
                                <strong>Trạng thái:</strong><br>
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">Đã thanh toán</span>
                                @else
                                    <span class="badge bg-warning text-dark">Chưa thanh toán</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    @if($order->note)
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-sticky-note"></i> Ghi chú</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $order->note }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, nav, .sidebar, .card-header {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
