<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - VNB Sports')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #FF8C69;        /* Cam pastel chính */
            --primary-light: #FFB399;        /* Cam pastel nhạt */
            --primary-dark: #FF6B47;         /* Cam đậm hơn */
            --secondary-color: #FFF5F2;      /* Trắng kem */
            --accent-color: #FFD4C4;         /* Cam rất nhạt */
            --text-dark: #333333;
            --text-light: #666666;
            --border-color: #FFE5DC;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-dark);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #FFFFFF 0%, var(--secondary-color) 100%);
            border-right: 2px solid var(--border-color);
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(255, 140, 105, 0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-bottom: 2px solid var(--primary-dark);
        }

        .sidebar-header h3 {
            color: white;
            font-weight: 700;
            margin: 0;
            font-size: 22px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .sidebar-header p {
            color: rgba(255,255,255,0.9);
            font-size: 13px;
            margin: 5px 0 0 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            margin: 5px 15px;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .menu-item a i {
            width: 25px;
            margin-right: 12px;
            font-size: 18px;
            color: var(--primary-color);
        }

        .menu-item a:hover {
            background: var(--accent-color);
            color: var(--primary-dark);
            transform: translateX(5px);
        }

        .menu-item a.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            box-shadow: 0 4px 10px rgba(255, 140, 105, 0.3);
        }

        .menu-item a.active i {
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Header */
        .top-header {
            background: white;
            height: var(--header-height);
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 10px rgba(255, 140, 105, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-left h4 {
            color: var(--text-dark);
            margin: 0;
            font-weight: 600;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px;
            background: var(--secondary-color);
            border-radius: 25px;
            border: 1px solid var(--border-color);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
        }

        .user-name {
            font-weight: 500;
            color: var(--text-dark);
        }

        .btn-logout {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 140, 105, 0.2);
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 140, 105, 0.3);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Cards */
        .card {
            border: 2px solid var(--border-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(255, 140, 105, 0.1);
            background: white;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 6px 20px rgba(255, 140, 105, 0.15);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom: 2px solid var(--primary-dark);
            border-radius: 13px 13px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 140, 105, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 140, 105, 0.3);
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #4CAF50 0%, #66BB6A 100%);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, #F44336 0%, #EF5350 100%);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(135deg, #FF9800 0%, #FFB74D 100%);
            border: none;
        }

        .btn-info {
            background: linear-gradient(135deg, #2196F3 0%, #42A5F5 100%);
            border: none;
        }

        /* Tables */
        .table {
            background: white;
        }

        .table thead {
            background: var(--accent-color);
            color: var(--text-dark);
            font-weight: 600;
        }

        .table tbody tr:hover {
            background: var(--secondary-color);
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Forms */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 105, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: var(--text-dark);
        }

        /* Alerts */
        .alert-success {
            background: #E8F5E9;
            border-color: #4CAF50;
            color: #2E7D32;
        }

        .alert-danger {
            background: #FFEBEE;
            border-color: #F44336;
            color: #C62828;
        }

        .alert-warning {
            background: #FFF3E0;
            border-color: #FF9800;
            color: #E65100;
        }

        .alert-info {
            background: #E3F2FD;
            border-color: #2196F3;
            color: #1565C0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .mobile-menu-btn {
                display: block !important;
            }
        }

        .mobile-menu-btn {
            display: none;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 20px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--secondary-color);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-store"></i> VNB Sports</h3>
            <p>Quản trị hệ thống</p>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    <span>Quản lý sản phẩm</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Quản lý danh mục</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Quản lý đơn hàng</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span>Quản lý đánh giá</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Quản lý tin tức</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Báo cáo</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Xem website</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="top-header">
            <div class="header-left">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>@yield('title', 'Dashboard')</h4>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>

        <!-- Content -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Auto dismiss alerts
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
