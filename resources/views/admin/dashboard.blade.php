@extends('admin.layout.app')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold" style="color: #2c3e50;">📊 Dashboard</h2>
        <p class="text-muted">Tổng quan hệ thống quản lý cửa hàng cầu lông</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">
            <i class="fas fa-file-export"></i> Xuất Báo Cáo
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Tổng đơn hàng</p>
                        <h2 class="mb-0 fw-bold">{{ $totalOrders }}</h2>
                        <small class="opacity-75">📦 Chờ xử lý: {{ $pendingOrders }}</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">📋</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Doanh thu</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalRevenue/1000000, 1) }}M</h2>
                        <small class="opacity-75">💰 {{ number_format($totalRevenue) }}đ</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">💵</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Sản phẩm</p>
                        <h2 class="mb-0 fw-bold">{{ $totalProducts }}</h2>
                        <small class="opacity-75">🏸 Đang kinh doanh</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">📦</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-0" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 opacity-75">Khách hàng</p>
                        <h2 class="mb-0 fw-bold">{{ $totalCustomers }}</h2>
                        <small class="opacity-75">👥 Đã đăng ký</small>
                    </div>
                    <div style="font-size: 3rem; opacity: 0.3;">👤</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e50;">📊 Thống kê đơn hàng</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #fff3cd;">
                            <small class="text-muted">Chờ xử lý</small>
                            <h4 class="mb-0 fw-bold text-warning">{{ $pendingOrders }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #cfe2ff;">
                            <small class="text-muted">Đang xử lý</small>
                            <h4 class="mb-0 fw-bold text-info">{{ $processingOrders }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #e7f1ff;">
                            <small class="text-muted">Đang giao</small>
                            <h4 class="mb-0 fw-bold text-primary">{{ $shippingOrders }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #d1e7dd;">
                            <small class="text-muted">Hoàn thành</small>
                            <h4 class="mb-0 fw-bold text-success">{{ $completedOrders }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e50;">📦 Thống kê sản phẩm</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #d1e7dd;">
                            <small class="text-muted">Đang kinh doanh</small>
                            <h4 class="mb-0 fw-bold text-success">{{ $activeProducts }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #f8d7da;">
                            <small class="text-muted">Hết hàng</small>
                            <h4 class="mb-0 fw-bold text-danger">{{ $outOfStockProducts }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #fff3cd;">
                            <small class="text-muted">Sắp hết hàng</small>
                            <h4 class="mb-0 fw-bold text-warning">{{ $lowStockProducts }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded" style="background: #e7f1ff;">
                            <small class="text-muted">Khách hàng mới</small>
                            <h4 class="mb-0 fw-bold text-primary">{{ $newCustomersThisMonth }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e50;">📈 Doanh thu 6 tháng gần nhất</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e50;">🏆 Top 5 sản phẩm bán chạy</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($topProducts as $index => $product)
                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary rounded-circle me-2">{{ $index + 1 }}</span>
                            <strong>{{ Str::limit($product->name, 25) }}</strong>
                        </div>
                        <span class="badge bg-success">{{ $product->total_sold ?? 0 }} đã bán</span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        <p class="mb-0">Chưa có dữ liệu</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold" style="color: #2c3e50;">📦 Đơn hàng gần đây</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><strong>{{ $order->order_number }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td><strong class="text-success">{{ number_format($order->total) }}đ</strong></td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipping' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger'
                                        ];
                                        $color = $statusColors[$order->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }}">{{ $order->status_label }}</span>
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Xem</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <div style="font-size: 3rem; opacity: 0.3;">📭</div>
                                    <p class="mb-0">Chưa có đơn hàng nào</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: {!! json_encode(array_column($monthlyRevenue, 'revenue')) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + 'đ';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', { notation: 'compact' }).format(value) + 'đ';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
