<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo - COZA Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .header .company-name {
            font-size: 18px;
            color: #e74c3c;
            font-weight: bold;
        }
        
        .report-info {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .report-info p {
            margin: 5px 0;
        }
        
        .report-info strong {
            display: inline-block;
            width: 150px;
        }
        
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .summary-card {
            flex: 1;
            min-width: 200px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 5px;
            text-align: center;
        }
        
        .summary-card h3 {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        
        .summary-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        table thead {
            background: #34495e;
            color: white;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        table tbody tr:hover {
            background: #e9ecef;
        }
        
        .section-title {
            font-size: 18px;
            color: #2c3e50;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #27ae60;
            color: white;
        }
        
        .badge-warning {
            background: #f39c12;
            color: white;
        }
        
        .badge-danger {
            background: #e74c3c;
            color: white;
        }
        
        .badge-info {
            background: #3498db;
            color: white;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">COZA STORE</div>
        <h1>
            @if($reportType == 'overview') BÁO CÁO TỔNG QUAN
            @elseif($reportType == 'orders') BÁO CÁO ĐƠN HÀNG
            @elseif($reportType == 'revenue') BÁO CÁO DOANH THU
            @elseif($reportType == 'products') BÁO CÁO SẢN PHẨM
            @endif
        </h1>
    </div>

    <!-- Report Info -->
    <div class="report-info">
        <p><strong>Khoảng thời gian:</strong> {{ date('d/m/Y', strtotime($dateFrom)) }} - {{ date('d/m/Y', strtotime($dateTo)) }}</p>
        <p><strong>Ngày xuất báo cáo:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Người xuất:</strong> {{ auth()->user()->name }}</p>
    </div>

    <!-- Content based on report type -->
    @if($reportType == 'overview')
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Tổng đơn hàng</h3>
                <div class="value">{{ number_format($data['total_orders']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Tổng doanh thu</h3>
                <div class="value">{{ number_format($data['total_revenue']) }} đ</div>
            </div>
            <div class="summary-card">
                <h3>Sản phẩm đã bán</h3>
                <div class="value">{{ number_format($data['total_products_sold']) }}</div>
            </div>
            <div class="summary-card">
                <h3>Khách hàng mới</h3>
                <div class="value">{{ number_format($data['new_customers']) }}</div>
            </div>
        </div>

        <!-- Orders by Status -->
        <h2 class="section-title">Phân bố đơn hàng theo trạng thái</h2>
        <table>
            <thead>
                <tr>
                    <th>Trạng thái</th>
                    <th class="text-right">Số lượng</th>
                    <th class="text-right">Tỷ lệ</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = $data['total_orders'];
                @endphp
                <tr>
                    <td>Chờ xử lý</td>
                    <td class="text-right">{{ number_format($data['orders_by_status']['pending']) }}</td>
                    <td class="text-right">{{ $total > 0 ? number_format(($data['orders_by_status']['pending'] / $total) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Đang xử lý</td>
                    <td class="text-right">{{ number_format($data['orders_by_status']['processing']) }}</td>
                    <td class="text-right">{{ $total > 0 ? number_format(($data['orders_by_status']['processing'] / $total) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Đang giao</td>
                    <td class="text-right">{{ number_format($data['orders_by_status']['shipping']) }}</td>
                    <td class="text-right">{{ $total > 0 ? number_format(($data['orders_by_status']['shipping'] / $total) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Hoàn thành</td>
                    <td class="text-right">{{ number_format($data['orders_by_status']['completed']) }}</td>
                    <td class="text-right">{{ $total > 0 ? number_format(($data['orders_by_status']['completed'] / $total) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Đã hủy</td>
                    <td class="text-right">{{ number_format($data['orders_by_status']['cancelled']) }}</td>
                    <td class="text-right">{{ $total > 0 ? number_format(($data['orders_by_status']['cancelled'] / $total) * 100, 1) : 0 }}%</td>
                </tr>
            </tbody>
        </table>

        <!-- Top Products -->
        <h2 class="section-title">Top 10 sản phẩm bán chạy</h2>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th class="text-right">Đã bán</th>
                    <th class="text-right">Giá</th>
                    <th class="text-right">Tồn kho</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['top_products'] as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-right">{{ number_format($product->total_sold ?? 0) }}</td>
                    <td class="text-right">{{ number_format($product->price) }} đ</td>
                    <td class="text-right">{{ number_format($product->stock) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($reportType == 'orders')
        <!-- Orders List -->
        <table>
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th class="text-right">Tổng tiền</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['orders'] as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Khách' }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-right">{{ number_format($order->total) }} đ</td>
                    <td class="text-center">
                        @if($order->status == 'completed')
                            <span class="badge badge-success">Hoàn thành</span>
                        @elseif($order->status == 'cancelled')
                            <span class="badge badge-danger">Đã hủy</span>
                        @elseif($order->status == 'shipping')
                            <span class="badge badge-info">Đang giao</span>
                        @else
                            <span class="badge badge-warning">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($order->payment_status == 'paid')
                            <span class="badge badge-success">Đã thanh toán</span>
                        @else
                            <span class="badge badge-warning">Chưa thanh toán</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($reportType == 'revenue')
        <!-- Revenue Summary -->
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Tổng doanh thu</h3>
                <div class="value">{{ number_format($data['total_revenue']) }} đ</div>
            </div>
            <div class="summary-card">
                <h3>Giá trị đơn TB</h3>
                <div class="value">{{ number_format($data['average_order_value']) }} đ</div>
            </div>
        </div>

        <!-- Daily Revenue -->
        <h2 class="section-title">Doanh thu theo ngày</h2>
        <table>
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th class="text-right">Doanh thu</th>
                    <th class="text-right">Số đơn hàng</th>
                    <th class="text-right">Giá trị TB/đơn</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['daily_revenue'] as $day)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($day->date)) }}</td>
                    <td class="text-right">{{ number_format($day->revenue) }} đ</td>
                    <td class="text-right">{{ number_format($day->orders_count) }}</td>
                    <td class="text-right">{{ $day->orders_count > 0 ? number_format($day->revenue / $day->orders_count) : 0 }} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($reportType == 'products')
        <!-- Products List -->
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th class="text-right">Đã bán</th>
                    <th class="text-right">Doanh thu</th>
                    <th class="text-right">Giá</th>
                    <th class="text-right">Tồn kho</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['products'] as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-right">{{ number_format($product->total_sold ?? 0) }}</td>
                    <td class="text-right">{{ number_format($product->revenue ?? 0) }} đ</td>
                    <td class="text-right">{{ number_format($product->price) }} đ</td>
                    <td class="text-right">{{ number_format($product->stock) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>© {{ date('Y') }} COZA Store. Tất cả quyền được bảo lưu.</p>
        <p>Báo cáo này được tạo tự động bởi hệ thống quản lý COZA Store</p>
    </div>

    <!-- Print button (hidden when printing) -->
    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 30px; font-size: 16px; cursor: pointer; background: #3498db; color: white; border: none; border-radius: 5px;">
            In báo cáo
        </button>
    </div>
</body>
</html>
