@extends('layout.customer')

@section('title', 'Đơn hàng của tôi')

@push('styles')
<style>
    .orders-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .orders-title {
        text-align: center;
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 24px;
    }
    
    .orders-subtitle {
        text-align: center;
        color: #666;
        margin-bottom: 40px;
    }
    
    .orders-box {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .orders-box h5 {
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e74c3c;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .order-table thead {
        background: #e74c3c;
        color: white;
    }
    
    .order-table th,
    .order-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }
    
    .order-table tbody tr {
        transition: all 0.3s ease;
    }

    .order-table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .badge-warning {
        background: linear-gradient(135deg, #ffc107, #ffca2c);
        color: #856404;
        border: 1px solid #ffc107;
    }
    
    .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        border: 1px solid #28a745;
    }
    
    .badge-info {
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: white;
        border: 1px solid #17a2b8;
    }
    
    .badge-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: 1px solid #007bff;
    }
    
    .badge-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        border: 1px solid #dc3545;
    }
    
    .no-orders {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    
    .btn-shop {
        background: #e74c3c;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 20px;
    }
    
    .btn-shop:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        color: white;
        text-decoration: none;
    }

    .order-filters {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .order-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        border-left: 4px solid #e74c3c;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 5px;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
        align-items: center;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-width: 70px;
        justify-content: center;
    }

    .view-btn {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
    }

    .view-btn:hover {
        background: linear-gradient(135deg, #0056b3, #004085);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,123,255,0.3);
        color: white;
        text-decoration: none;
    }

    .cancel-btn {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    .cancel-btn:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(220,53,69,0.3);
    }

    .action-btn i {
        font-size: 11px;
    }

    .action-btn span {
        font-size: 11px;
        font-weight: 600;
    }

    /* Loading state for cancel button */
    .cancel-btn.loading {
        opacity: 0.7;
        cursor: not-allowed;
        pointer-events: none;
    }

    .cancel-btn.loading::after {
        content: '';
        width: 12px;
        height: 12px;
        border: 2px solid transparent;
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-left: 5px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .order-table {
            font-size: 12px;
        }
        
        .order-table th,
        .order-table td {
            padding: 8px 4px;
        }
        
        .order-filters {
            flex-direction: column;
            align-items: stretch;
        }
        
        .order-stats {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            gap: 5px;
        }

        .action-btn {
            padding: 6px 10px;
            font-size: 11px;
            min-width: 60px;
        }

        .action-btn span {
            font-size: 10px;
        }
    }
</style>
@endpush

@section('content')
<div class="orders-container">
    <h4 class="orders-title">📦 ĐỚN HÀNG CỦA TÔI</h4>
    <p class="orders-subtitle">Theo dõi và quản lý các đơn hàng của bạn</p>

    <!-- Thống kê đơn hàng -->
    <div class="order-stats">
        <div class="stat-card">
            <div class="stat-number">{{ $orders->count() }}</div>
            <div class="stat-label">Tổng đơn hàng</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $orders->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Chờ xử lý</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $orders->where('status', 'shipping')->count() }}</div>
            <div class="stat-label">Đang giao</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $orders->where('status', 'completed')->count() }}</div>
            <div class="stat-label">Hoàn thành</div>
        </div>
    </div>

    <!-- Bộ lọc đơn hàng -->
    <div class="order-filters">
        <div class="filter-item">
            <label for="statusFilter"><strong>Trạng thái:</strong></label>
            <select id="statusFilter" class="filter-select" onchange="filterOrders()">
                <option value="">Tất cả</option>
                <option value="pending">Chờ xử lý</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="processing">Đang xử lý</option>
                <option value="shipping">Đang giao</option>
                <option value="completed">Hoàn thành</option>
                <option value="cancelled">Đã hủy</option>
            </select>
        </div>
        <div class="filter-item">
            <label for="dateFilter"><strong>Thời gian:</strong></label>
            <select id="dateFilter" class="filter-select" onchange="filterOrders()">
                <option value="">Tất cả</option>
                <option value="7">7 ngày qua</option>
                <option value="30">30 ngày qua</option>
                <option value="90">3 tháng qua</option>
            </select>
        </div>
    </div>

    <div class="orders-box">
        <h5>
            <i class="fas fa-shopping-bag"></i>
            DANH SÁCH ĐƠN HÀNG
        </h5>

        @if($orders->count() > 0)
            <table class="order-table" id="ordersTable">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Ngày đặt</th>
                        <th>Sản phẩm</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Giá trị</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr data-status="{{ $order->status }}" data-date="{{ $order->created_at->format('Y-m-d') }}">
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div style="text-align: left;">
                                    @foreach($order->items->take(2) as $item)
                                        <div style="font-size: 12px; margin-bottom: 2px;">
                                            {{ $item->product->name }} (x{{ $item->quantity }})
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 2)
                                        <div style="font-size: 11px; color: #666;">
                                            +{{ $order->items->count() - 2 }} sản phẩm khác
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>{{ Str::limit($order->customer_address ?? 'N/A', 30) }}</td>
                            <td><strong style="color: #e74c3c;">{{ number_format($order->total) }}đ</strong></td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge badge-warning">⏳ Chờ xử lý</span>
                                @elseif($order->status == 'confirmed')
                                    <span class="badge badge-info">✓ Đã xác nhận</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge badge-info">📦 Đang xử lý</span>
                                @elseif($order->status == 'shipping')
                                    <span class="badge badge-primary">🚚 Đang giao</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge badge-success">✓ Hoàn thành</span>
                                @else
                                    <span class="badge badge-danger">✗ Đã hủy</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('order.detail', $order) }}" 
                                       class="action-btn view-btn" 
                                       title="Xem chi tiết đơn hàng">
                                        <i class="fas fa-eye"></i>
                                        <span>Xem</span>
                                    </a>
                                    @if($order->status == 'pending')
                                        <button onclick="cancelOrder({{ $order->id }})" 
                                                class="action-btn cancel-btn" 
                                                title="Hủy đơn hàng">
                                            <i class="fas fa-times"></i>
                                            <span>Hủy</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div style="margin-top: 20px; text-align: center;">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="no-orders">
                <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ddd; margin-bottom: 20px;"></i>
                <p style="font-size: 1.2rem; margin-bottom: 10px;">📭 Bạn chưa có đơn hàng nào.</p>
                <p style="color: #999; margin-bottom: 20px;">Hãy khám phá các sản phẩm tuyệt vời của chúng tôi!</p>
                <a href="{{ route('list-product') }}" class="btn-shop">
                    🛍️ Mua sắm ngay
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterOrders() {
        const statusFilter = document.getElementById('statusFilter').value;
        const dateFilter = document.getElementById('dateFilter').value;
        const rows = document.querySelectorAll('#ordersTable tbody tr');
        
        const now = new Date();
        const filterDate = dateFilter ? new Date(now.getTime() - (parseInt(dateFilter) * 24 * 60 * 60 * 1000)) : null;
        
        rows.forEach(row => {
            let showRow = true;
            
            // Filter by status
            if (statusFilter && row.dataset.status !== statusFilter) {
                showRow = false;
            }
            
            // Filter by date
            if (filterDate) {
                const rowDate = new Date(row.dataset.date);
                if (rowDate < filterDate) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        });
    }
    
    function cancelOrder(orderId) {
        // Custom confirm dialog
        if (showConfirmDialog('Hủy đơn hàng', 'Bạn có chắc muốn hủy đơn hàng #' + orderId + '?', 'Hủy đơn', 'Không')) {
            const cancelBtn = document.querySelector(`button[onclick="cancelOrder(${orderId})"]`);
            
            // Add loading state
            cancelBtn.classList.add('loading');
            cancelBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang hủy...</span>';
            cancelBtn.disabled = true;
            
            // Simulate API call (replace with actual endpoint)
            setTimeout(() => {
                // Implement cancel order logic here
                fetch(`/orders/${orderId}/cancel`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Success animation
                        cancelBtn.innerHTML = '<i class="fas fa-check"></i><span>Đã hủy</span>';
                        cancelBtn.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                        
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        // Reset button on error
                        cancelBtn.classList.remove('loading');
                        cancelBtn.innerHTML = '<i class="fas fa-times"></i><span>Hủy</span>';
                        cancelBtn.disabled = false;
                        showAlert('Lỗi', 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reset button on error
                    cancelBtn.classList.remove('loading');
                    cancelBtn.innerHTML = '<i class="fas fa-times"></i><span>Hủy</span>';
                    cancelBtn.disabled = false;
                    showAlert('Lỗi', 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                });
            }, 500);
        }
    }

    function showConfirmDialog(title, message, confirmText, cancelText) {
        return confirm(`${title}\n\n${message}`);
    }

    function showAlert(title, message, type) {
        alert(`${title}: ${message}`);
    }
</script>
@endpush