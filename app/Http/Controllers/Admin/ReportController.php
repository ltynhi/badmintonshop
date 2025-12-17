<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Hiển thị form xuất báo cáo
     */
    public function index()
    {
        return view('admin.reports.index');
    }

    /**
     * Xuất báo cáo Excel
     */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:overview,orders,revenue,products',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $reportType = $request->report_type;
        $dateFrom = $request->date_from ?? now()->subDays(30)->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $data = $this->getReportData($reportType, $dateFrom, $dateTo);
        
        return $this->generateExcel($data, $reportType, $dateFrom, $dateTo);
    }

    /**
     * Xuất báo cáo PDF
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:overview,orders,revenue,products',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $reportType = $request->report_type;
        $dateFrom = $request->date_from ?? now()->subDays(30)->format('Y-m-d');
        $dateTo = $request->date_to ?? now()->format('Y-m-d');

        $data = $this->getReportData($reportType, $dateFrom, $dateTo);
        
        return $this->generatePdf($data, $reportType, $dateFrom, $dateTo);
    }

    /**
     * Lấy dữ liệu báo cáo theo loại
     */
    private function getReportData($reportType, $dateFrom, $dateTo)
    {
        switch ($reportType) {
            case 'overview':
                return $this->getOverviewData($dateFrom, $dateTo);
            case 'orders':
                return $this->getOrdersData($dateFrom, $dateTo);
            case 'revenue':
                return $this->getRevenueData($dateFrom, $dateTo);
            case 'products':
                return $this->getProductsData($dateFrom, $dateTo);
            default:
                return [];
        }
    }

    /**
     * Dữ liệu báo cáo tổng quan
     */
    private function getOverviewData($dateFrom, $dateTo)
    {
        $orders = Order::whereBetween('created_at', [$dateFrom, $dateTo])->get();
        
        return [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->where('payment_status', 'paid')->sum('total'),
            'total_products_sold' => $orders->sum(function($order) {
                return $order->items->sum('quantity');
            }),
            'new_customers' => User::where('role', 'customer')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->count(),
            'orders_by_status' => [
                'pending' => $orders->where('status', 'pending')->count(),
                'processing' => $orders->where('status', 'processing')->count(),
                'shipping' => $orders->where('status', 'shipping')->count(),
                'completed' => $orders->where('status', 'completed')->count(),
                'cancelled' => $orders->where('status', 'cancelled')->count(),
            ],
            'top_products' => Product::withCount(['orderItems as total_sold' => function($query) use ($dateFrom, $dateTo) {
                $query->selectRaw('sum(quantity)')
                    ->whereHas('order', function($q) use ($dateFrom, $dateTo) {
                        $q->whereBetween('created_at', [$dateFrom, $dateTo]);
                    });
            }])
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get(),
        ];
    }

    /**
     * Dữ liệu báo cáo đơn hàng
     */
    private function getOrdersData($dateFrom, $dateTo)
    {
        return [
            'orders' => Order::with('user', 'items.product')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->orderBy('created_at', 'desc')
                ->get(),
        ];
    }

    /**
     * Dữ liệu báo cáo doanh thu
     */
    private function getRevenueData($dateFrom, $dateTo)
    {
        $dailyRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'daily_revenue' => $dailyRevenue,
            'total_revenue' => $dailyRevenue->sum('revenue'),
            'average_order_value' => $dailyRevenue->sum('orders_count') > 0 
                ? $dailyRevenue->sum('revenue') / $dailyRevenue->sum('orders_count') 
                : 0,
        ];
    }

    /**
     * Dữ liệu báo cáo sản phẩm
     */
    private function getProductsData($dateFrom, $dateTo)
    {
        return [
            'products' => Product::withCount(['orderItems as total_sold' => function($query) use ($dateFrom, $dateTo) {
                $query->selectRaw('sum(quantity)')
                    ->whereHas('order', function($q) use ($dateFrom, $dateTo) {
                        $q->whereBetween('created_at', [$dateFrom, $dateTo]);
                    });
            }])
            ->withSum(['orderItems as revenue' => function($query) use ($dateFrom, $dateTo) {
                $query->selectRaw('sum(quantity * price)')
                    ->whereHas('order', function($q) use ($dateFrom, $dateTo) {
                        $q->whereBetween('created_at', [$dateFrom, $dateTo]);
                    });
            }], 'quantity')
            ->orderBy('total_sold', 'desc')
            ->get(),
        ];
    }

    /**
     * Tạo file Excel (CSV format - không cần thư viện)
     */
    private function generateExcel($data, $reportType, $dateFrom, $dateTo)
    {
        $filename = "bao-cao-{$reportType}-{$dateFrom}-{$dateTo}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data, $reportType) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            switch ($reportType) {
                case 'overview':
                    $this->writeOverviewExcel($file, $data);
                    break;
                case 'orders':
                    $this->writeOrdersExcel($file, $data);
                    break;
                case 'revenue':
                    $this->writeRevenueExcel($file, $data);
                    break;
                case 'products':
                    $this->writeProductsExcel($file, $data);
                    break;
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Viết dữ liệu tổng quan vào Excel
     */
    private function writeOverviewExcel($file, $data)
    {
        fputcsv($file, ['BÁO CÁO TỔNG QUAN']);
        fputcsv($file, []);
        fputcsv($file, ['Tổng số đơn hàng', $data['total_orders']]);
        fputcsv($file, ['Tổng doanh thu', number_format($data['total_revenue']) . ' VNĐ']);
        fputcsv($file, ['Tổng sản phẩm đã bán', $data['total_products_sold']]);
        fputcsv($file, ['Khách hàng mới', $data['new_customers']]);
        fputcsv($file, []);
        
        fputcsv($file, ['PHÂN BỐ ĐƠN HÀNG THEO TRẠNG THÁI']);
        fputcsv($file, ['Trạng thái', 'Số lượng']);
        fputcsv($file, ['Chờ xử lý', $data['orders_by_status']['pending']]);
        fputcsv($file, ['Đang xử lý', $data['orders_by_status']['processing']]);
        fputcsv($file, ['Đang giao', $data['orders_by_status']['shipping']]);
        fputcsv($file, ['Hoàn thành', $data['orders_by_status']['completed']]);
        fputcsv($file, ['Đã hủy', $data['orders_by_status']['cancelled']]);
        fputcsv($file, []);
        
        fputcsv($file, ['TOP 10 SẢN PHẨM BÁN CHẠY']);
        fputcsv($file, ['Tên sản phẩm', 'Số lượng đã bán', 'Giá', 'Tồn kho']);
        foreach ($data['top_products'] as $product) {
            fputcsv($file, [
                $product->name,
                $product->total_sold ?? 0,
                number_format($product->price) . ' VNĐ',
                $product->stock,
            ]);
        }
    }

    /**
     * Viết dữ liệu đơn hàng vào Excel
     */
    private function writeOrdersExcel($file, $data)
    {
        fputcsv($file, ['BÁO CÁO ĐƠN HÀNG']);
        fputcsv($file, []);
        fputcsv($file, ['Mã đơn', 'Khách hàng', 'Ngày đặt', 'Tổng tiền', 'Trạng thái', 'Thanh toán']);
        
        foreach ($data['orders'] as $order) {
            fputcsv($file, [
                $order->id,
                $order->user->name ?? 'Khách',
                $order->created_at->format('d/m/Y H:i'),
                number_format($order->total) . ' VNĐ',
                $this->getStatusText($order->status),
                $this->getPaymentStatusText($order->payment_status),
            ]);
        }
    }

    /**
     * Viết dữ liệu doanh thu vào Excel
     */
    private function writeRevenueExcel($file, $data)
    {
        fputcsv($file, ['BÁO CÁO DOANH THU']);
        fputcsv($file, []);
        fputcsv($file, ['Tổng doanh thu', number_format($data['total_revenue']) . ' VNĐ']);
        fputcsv($file, ['Giá trị đơn hàng trung bình', number_format($data['average_order_value']) . ' VNĐ']);
        fputcsv($file, []);
        fputcsv($file, ['Ngày', 'Doanh thu', 'Số đơn hàng']);
        
        foreach ($data['daily_revenue'] as $day) {
            fputcsv($file, [
                date('d/m/Y', strtotime($day->date)),
                number_format($day->revenue) . ' VNĐ',
                $day->orders_count,
            ]);
        }
    }

    /**
     * Viết dữ liệu sản phẩm vào Excel
     */
    private function writeProductsExcel($file, $data)
    {
        fputcsv($file, ['BÁO CÁO SẢN PHẨM']);
        fputcsv($file, []);
        fputcsv($file, ['Tên sản phẩm', 'Số lượng đã bán', 'Doanh thu', 'Giá', 'Tồn kho']);
        
        foreach ($data['products'] as $product) {
            fputcsv($file, [
                $product->name,
                $product->total_sold ?? 0,
                number_format($product->revenue ?? 0) . ' VNĐ',
                number_format($product->price) . ' VNĐ',
                $product->stock,
            ]);
        }
    }

    /**
     * Tạo file PDF (HTML to PDF - không cần thư viện)
     */
    private function generatePdf($data, $reportType, $dateFrom, $dateTo)
    {
        $html = view('admin.reports.pdf', [
            'data' => $data,
            'reportType' => $reportType,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ])->render();

        $filename = "bao-cao-{$reportType}-{$dateFrom}-{$dateTo}.pdf";
        
        // Sử dụng DomPDF hoặc trả về HTML để in
        // Tạm thời trả về HTML có thể in thành PDF
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    /**
     * Helper: Lấy text trạng thái đơn hàng
     */
    private function getStatusText($status)
    {
        $statuses = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];
        return $statuses[$status] ?? $status;
    }

    /**
     * Helper: Lấy text trạng thái thanh toán
     */
    private function getPaymentStatusText($status)
    {
        $statuses = [
            'pending' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thất bại',
        ];
        return $statuses[$status] ?? $status;
    }
}
