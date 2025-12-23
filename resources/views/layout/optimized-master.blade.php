<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VNB Sports - Cửa hàng cầu lông uy tín')</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('css/app.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('img/logo.png') }}" as="image">
    
    <!-- Critical CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    
    <!-- Font Awesome - Only load icons we actually use -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ==" 
          crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Google Fonts - Optimized -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    @include('partials.alerts')
    @include('partials.header-optimized')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer-optimized')
    
    <!-- Optimized JavaScript -->
    <script>
        // Critical inline JS
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts
            const alerts = document.querySelectorAll('[id$="Alert"]');
            alerts.forEach(alert => {
                if (alert) {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                }
            });
            
            // Scroll to top button
            const scrollBtn = document.createElement('button');
            scrollBtn.id = 'scrollToTopBtn';
            scrollBtn.innerHTML = '↑';
            scrollBtn.style.cssText = 'position:fixed;bottom:30px;right:30px;width:40px;height:40px;background:#e6560e;color:#fff;border:none;border-radius:50%;font-size:20px;cursor:pointer;opacity:0;transition:opacity .3s;z-index:1000;display:flex;align-items:center;justify-content:center';
            document.body.appendChild(scrollBtn);
            
            window.addEventListener('scroll', () => {
                scrollBtn.style.opacity = window.pageYOffset > 300 ? '1' : '0';
            });
            
            scrollBtn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>