<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Thông báo - VNB Sports</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .notifications-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e6560e;
        }
        
        .notifications-header h1 {
            font-size: 28px;
            color: #333;
            margin: 0;
        }
        
        .mark-all-btn {
            padding: 10px 20px;
            background: #e6560e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .mark-all-btn:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        
        .notification-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            gap: 15px;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .notification-card.unread {
            background: #e7f3ff;
            border-left-color: #2196F3;
        }
        
        .notification-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
        
        .notification-icon-large {
            font-size: 40px;
            flex-shrink: 0;
        }
        
        .notification-body {
            flex: 1;
        }
        
        .notification-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        
        .notification-message {
            color: #666;
            font-size: 15px;
            margin-bottom: 8px;
            line-height: 1.5;
        }
        
        .notification-meta {
            display: flex;
            gap: 15px;
            font-size: 13px;
            color: #999;
        }
        
        .notification-time {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .notification-status {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }
        
        .empty-state-icon {
            font-size: 80px;
            opacity: 0.3;
            margin-bottom: 20px;
        }
        
        .empty-state-text {
            font-size: 18px;
            color: #999;
        }
        
        .pagination {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    @include('partials.header')
    
    <div class="notifications-container">
        <div class="notifications-header">
            <h1><i class="fas fa-bell"></i> Thông báo của tôi</h1>
            @if($notifications->where('read_at', null)->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="mark-all-btn">
                    <i class="fas fa-check-double"></i> Đánh dấu tất cả đã đọc
                </button>
            </form>
            @endif
        </div>
        
        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
            <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
                <div class="notification-icon-large">{{ $notification->icon }}</div>
                <div class="notification-body">
                    <div class="notification-title">{{ $notification->title }}</div>
                    <div class="notification-message">{{ $notification->message }}</div>
                    <div class="notification-meta">
                        <div class="notification-time">
                            <i class="far fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                        @if(!$notification->read_at)
                        <div class="notification-status">
                            <i class="fas fa-circle" style="color: #2196F3; font-size: 8px;"></i>
                            Chưa đọc
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            
            <div class="pagination">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">🔔</div>
                <div class="empty-state-text">Bạn chưa có thông báo nào</div>
            </div>
        @endif
    </div>
    
    <footer style="margin-top: 80px;">
        <div class="footer-top">
            <div class="footer-column">
                <h3>THÔNG TIN CHUNG</h3>
                <p><strong>VNB Sports</strong> là hệ thống cửa hàng cầu lông với hơn 50 chi nhánh trên toàn quốc</p>
            </div>
            <div class="footer-column">
                <h3>THÔNG TIN LIÊN HỆ</h3>
                <p><strong>Hotline:</strong> 0977508430 | 0338000308</p>
                <p><strong>Email:</strong> info@shopcoza.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Công ty TNHH COZA SPORTS</p>
            <p>Email: info@shopcoza.com</p>
        </div>
    </footer>
</body>
</html>
