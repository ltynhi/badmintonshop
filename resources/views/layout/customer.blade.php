<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Cửa hàng Cầu Lông VNB')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    
    <style>
        .user-menu {
            position: relative;
            display: inline-block;
        }
        
        .user-button {
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
            padding: 8px 15px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .user-button:hover {
            background-color: #f0f0f0;
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            min-width: 200px;
            margin-top: 8px;
            display: none;
            z-index: 1000;
        }
        
        .user-dropdown.show {
            display: block;
        }
        
        .user-dropdown a,
        .user-dropdown button {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .user-dropdown a:hover,
        .user-dropdown button:hover {
            background-color: #f8f9fa;
        }
        
        .user-dropdown button.logout {
            color: #e74c3c;
            border-top: 1px solid #eee;
            font-weight: 500;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .btn-login {
            padding: 8px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @include('partials.header')

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; text-align: center; border-bottom: 3px solid #28a745;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; text-align: center; border-bottom: 3px solid #dc3545;">
            ✗ {{ session('error') }}
        </div>
    @endif

    @yield('content')

    <footer>
        <div class="footer-top">
            <div class="footer-column">
                <h3>THÔNG TIN CHUNG</h3>
                <p><strong>VNB Sports</strong> là hệ thống cửa hàng cầu lông với hơn 50 chi nhánh trên toàn quốc</p>
                <p><strong>Sứ mệnh:</strong> "<i>VNB cam kết mang đến những sản phẩm, dịch vụ chất lượng tốt nhất</i>"</p>
            </div>

            <div class="footer-column">
                <h3>THÔNG TIN LIÊN HỆ</h3>
                <p><strong>Hotline:</strong> 0977508430 | 0338000308</p>
                <p><strong>Email:</strong> info@shopvnb.com</p>
            </div>

            <div class="footer-column">
                <h3>CHÍNH SÁCH</h3>
                <ul>
                    <li>Chính sách đổi trả, hoàn tiền</li>
                    <li>Chính sách bảo hành</li>
                    <li>Chính sách vận chuyển</li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>HƯỚNG DẪN</h3>
                <ul>
                    <li>Hướng dẫn mua hàng</li>
                    <li>Hướng dẫn thanh toán</li>
                    <li>Kiểm tra đơn hàng</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>© 2024 VNB Sports - Hệ thống cửa hàng cầu lông uy tín</p>
        </div>
    </footer>

    <!-- JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }
        
        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu')) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown) {
                    dropdown.classList.remove('show');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
