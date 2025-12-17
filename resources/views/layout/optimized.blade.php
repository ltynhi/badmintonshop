<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'VNB Sports - Cửa hàng Cầu Lông')</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap"></noscript>
    
    <!-- Critical CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    
    <!-- Page specific CSS -->
    @stack('styles')
    
    <!-- Font Awesome - Defer loading -->
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    
    <!-- Meta tags for SEO -->
    <meta name="description" content="@yield('description', 'VNB Sports - Hệ thống cửa hàng cầu lông uy tín với hơn 50 chi nhánh toàn quốc')">
    <meta name="keywords" content="@yield('keywords', 'cầu lông, vợt cầu lông, giày cầu lông, VNB Sports')">
    
    @stack('head')
</head>
<body>
    @include('partials.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('partials.footer')
    
    <!-- JavaScript - Load at bottom for better performance -->
    <script src="{{ asset('js/script.js') }}" defer></script>
    
    <!-- Page specific JS -->
    @stack('scripts')
    
    <!-- External JS - Load async -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js" async></script>
</body>
</html>