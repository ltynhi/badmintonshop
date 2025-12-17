@extends('admin.layout.app')

@section('title', 'Xuất Báo Cáo')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Xuất Báo Cáo Thống Kê</h3>
                </div>
                <div class="card-body">
                    <form id="reportForm" method="POST" action="{{ route('admin.reports.export') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- Loại báo cáo -->
                            <div class="col-md-6 mb-3">
                                <label for="report_type" class="form-label">Loại báo cáo <span class="text-danger">*</span></label>
                                <select class="form-select" id="report_type" name="report_type" required>
                                    <option value="">-- Chọn loại báo cáo --</option>
                                    <option value="overview">Báo cáo tổng quan</option>
                                    <option value="orders">Báo cáo đơn hàng</option>
                                    <option value="revenue">Báo cáo doanh thu</option>
                                    <option value="products">Báo cáo sản phẩm</option>
                                </select>
                            </div>

                            <!-- Định dạng file -->
                            <div class="col-md-6 mb-3">
                                <label for="format" class="form-label">Định dạng file <span class="text-danger">*</span></label>
                                <select class="form-select" id="format" name="format" required>
                                    <option value="">-- Chọn định dạng --</option>
                                    <option value="excel">Excel (CSV)</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Từ ngày -->
                            <div class="col-md-6 mb-3">
                                <label for="date_from" class="form-label">Từ ngày</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                <small class="text-muted">Mặc định: 30 ngày trước</small>
                            </div>

                            <!-- Đến ngày -->
                            <div class="col-md-6 mb-3">
                                <label for="date_to" class="form-label">Đến ngày</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="{{ date('Y-m-d') }}">
                                <small class="text-muted">Mặc định: Hôm nay</small>
                            </div>
                        </div>

                        <!-- Quick date filters -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Chọn nhanh:</label>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setDateRange('today')">Hôm nay</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setDateRange('week')">Tuần này</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setDateRange('month')">Tháng này</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setDateRange('year')">Năm nay</button>
                                </div>
                            </div>
                        </div>

                        <!-- Mô tả báo cáo -->
                        <div class="alert alert-info" id="reportDescription" style="display: none;">
                            <strong>Mô tả:</strong>
                            <p id="descriptionText"></p>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-download"></i> Xuất Báo Cáo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Hướng dẫn -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Hướng dẫn sử dụng</h5>
                </div>
                <div class="card-body">
                    <h6>Các loại báo cáo:</h6>
                    <ul>
                        <li><strong>Báo cáo tổng quan:</strong> Thống kê tổng hợp về đơn hàng, doanh thu, sản phẩm và khách hàng</li>
                        <li><strong>Báo cáo đơn hàng:</strong> Danh sách chi tiết tất cả đơn hàng trong khoảng thời gian</li>
                        <li><strong>Báo cáo doanh thu:</strong> Phân tích doanh thu theo ngày, xu hướng và so sánh</li>
                        <li><strong>Báo cáo sản phẩm:</strong> Thống kê sản phẩm bán chạy, tồn kho và doanh thu</li>
                    </ul>

                    <h6 class="mt-3">Định dạng file:</h6>
                    <ul>
                        <li><strong>Excel (CSV):</strong> Dữ liệu dạng bảng, có thể mở bằng Excel, Google Sheets</li>
                        <li><strong>PDF:</strong> Định dạng in ấn, bảo mật, dễ chia sẻ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Mô tả các loại báo cáo
const reportDescriptions = {
    'overview': 'Báo cáo tổng quan bao gồm: Tổng số đơn hàng, doanh thu, sản phẩm đã bán, khách hàng mới, phân bố đơn hàng theo trạng thái và top 10 sản phẩm bán chạy.',
    'orders': 'Báo cáo đơn hàng chi tiết bao gồm: Mã đơn, thông tin khách hàng, ngày đặt, tổng tiền, trạng thái đơn hàng và trạng thái thanh toán.',
    'revenue': 'Báo cáo doanh thu bao gồm: Tổng doanh thu, giá trị đơn hàng trung bình, doanh thu theo ngày và biểu đồ xu hướng.',
    'products': 'Báo cáo sản phẩm bao gồm: Danh sách sản phẩm, số lượng đã bán, doanh thu từng sản phẩm, giá và tồn kho.'
};

// Hiển thị mô tả khi chọn loại báo cáo
document.getElementById('report_type').addEventListener('change', function() {
    const description = reportDescriptions[this.value];
    const descBox = document.getElementById('reportDescription');
    const descText = document.getElementById('descriptionText');
    
    if (description) {
        descText.textContent = description;
        descBox.style.display = 'block';
    } else {
        descBox.style.display = 'none';
    }
});

// Hàm set khoảng thời gian nhanh
function setDateRange(range) {
    const today = new Date();
    const dateFrom = document.getElementById('date_from');
    const dateTo = document.getElementById('date_to');
    
    dateTo.value = today.toISOString().split('T')[0];
    
    switch(range) {
        case 'today':
            dateFrom.value = today.toISOString().split('T')[0];
            break;
        case 'week':
            const weekAgo = new Date(today);
            weekAgo.setDate(today.getDate() - 7);
            dateFrom.value = weekAgo.toISOString().split('T')[0];
            break;
        case 'month':
            const monthAgo = new Date(today);
            monthAgo.setMonth(today.getMonth() - 1);
            dateFrom.value = monthAgo.toISOString().split('T')[0];
            break;
        case 'year':
            const yearStart = new Date(today.getFullYear(), 0, 1);
            dateFrom.value = yearStart.toISOString().split('T')[0];
            break;
    }
}

// Xử lý submit form
document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const format = document.getElementById('format').value;
    const formData = new FormData(this);
    
    // Thay đổi action URL dựa trên format
    if (format === 'excel') {
        this.action = '{{ route("admin.reports.export.excel") }}';
    } else if (format === 'pdf') {
        this.action = '{{ route("admin.reports.export.pdf") }}';
    }
    
    // Submit form
    this.submit();
});
</script>

<style>
.card {
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.btn-group .btn {
    margin-right: 5px;
}

#reportDescription {
    margin-top: 20px;
}
</style>
@endsection
