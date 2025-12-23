<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #E67E5F;
            --primary-light: #F4A88A;
            --primary-dark: #D96B4D;
            --secondary-color: #FFF8F5;
            --accent-color: #FFE8DC;
            --success-color: #4CAF50;
            --danger-color: #F44336;
            --warning-color: #FF9800;
            --info-color: #2196F3;
            --border-color: #FFDCC8;
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%) !important;
            box-shadow: 0 4px 15px rgba(255, 140, 105, 0.2);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 5px;
            margin: 0 0.2rem;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }
        
        .btn-logout {
            background-color: var(--danger-color);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
            transform: translateY(-3px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 140, 105, 0.2);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 140, 105, 0.3);
        }
        
        .btn-success {
            background-color: var(--success-color);
            border: none;
        }
        
        .btn-success:hover {
            background-color: #229954;
        }
        
        .btn-warning {
            background-color: var(--warning-color);
            border: none;
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border: none;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-info {
            background-color: var(--info-color);
            border: none;
        }
        
        .btn-info:hover {
            background-color: #138d75;
        }
        
        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .badge {
            padding: 0.5rem 1rem;
            font-weight: 500;
            border-radius: 20px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 1rem;
            background-color: rgba(255,255,255,0.1);
            border-radius: 25px;
            margin-right: 1rem;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-color);
            border: 2px solid white;
        }
        
        .card {
            border: 2px solid var(--border-color);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            border-bottom: 2px solid var(--primary-dark);
        }
        
        .nav-link.active {
            background-color: rgba(255,255,255,0.2) !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #66BB6A 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #FFB74D 100%);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #EF5350 100%);
        }
        
        .btn-info {
            background: linear-gradient(135deg, var(--info-color) 0%, #42A5F5 100%);
        }
        
        /* Fix pagination - Hide Previous/Next arrows, keep only numbers */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .pagination .page-link {
            font-size: 14px !important;
            padding: 8px 12px !important;
            border-radius: 5px;
            margin: 0 2px;
        }
        
        /* Hide Previous and Next buttons completely - More specific selectors */
        nav .pagination .page-item:first-child,
        nav .pagination .page-item:last-child,
        .pagination .page-item:first-child,
        .pagination .page-item:last-child {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            overflow: hidden !important;
        }
        
        /* Also hide any pagination links with rel="prev" or rel="next" */
        .pagination a[rel="prev"],
        .pagination a[rel="next"],
        .pagination span[aria-label*="Previous"],
        .pagination span[aria-label*="Next"] {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">🏸 COZA Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">Đánh giá</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div class="user-info">
                        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                        <span class="text-white">{{ Auth::user()->name }}</span>
                    </div>
                    <a class="nav-link text-white me-3" href="{{ route('home') }}" target="_blank">Xem trang web</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">Đăng xuất</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4 px-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                ✓ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                ✗ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
