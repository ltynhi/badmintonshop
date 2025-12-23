<!-- Optimized Header -->
<header>
    <div class="header-main">
        <div class="container">
            <div class="header-flex">
                <div class="header-left">
                    <a href="{{ route('home') }}" class="logo-link">
                        <img src="{{ asset('img/logo.png') }}" alt="VNB Sports" class="header-logo">
                    </a>
                    <div class="hotline">
                        <i class="fas fa-phone"></i>
                        <span>HOTLINE: <strong>0977508430</strong></span>
                    </div>
                </div>
                
                <!-- Search Box -->
                <div class="search-box">
                    <form action="{{ route('search') }}" method="GET">
                        <input type="text" name="q" placeholder="Tìm sản phẩm..." 
                               value="{{ request('q') }}" autocomplete="off">
                    </form>
                    <div id="searchResults" class="search-results"></div>
                </div>
                
                <div class="header-actions">
                    <!-- Notifications -->
                    @auth
                    <div class="notification-menu">
                        <button class="notification-button" onclick="toggleNotifications()">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                        </button>
                        <div class="notification-dropdown" id="notificationDropdown">
                            <div class="notification-header">
                                <h4>Thông báo</h4>
                                <button onclick="markAllAsRead()" class="mark-all-read">Đánh dấu đã đọc</button>
                            </div>
                            <div class="notification-list" id="notificationList">
                                <div class="notification-loading">Đang tải...</div>
                            </div>
                        </div>
                    </div>
                    @endauth
                    
                    <!-- User Menu -->
                    <div class="user-menu">
                        @auth
                            <button class="user-button" onclick="toggleUserMenu()">
                                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <div class="user-dropdown" id="userDropdown">
                                <a href="{{ route('profile') }}">
                                    <i class="fas fa-user"></i> Thông tin tài khoản
                                </a>
                                <a href="{{ route('my-orders') }}">
                                    <i class="fas fa-shopping-bag"></i> Đơn hàng của tôi
                                </a>
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="logout">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-user"></i> Đăng nhập
                            </a>
                        @endauth
                    </div>

                    <!-- Cart -->
                    <div class="cart-wrapper">
                        <a href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        @php
                            $cartCount = session('cart') ? count(session('cart')) : 0;
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-count">{{ $cartCount }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="main-nav">
        <div class="container">
            <ul class="menu">
                <li><a href="{{ route('home') }}">TRANG CHỦ</a></li>
                <li><a href="{{ route('list-product') }}">SẢN PHẨM</a></li>
                <li><a href="{{ route('sale-off') }}">SALE OFF</a></li>
                <li><a href="{{ route('list-news') }}">TIN TỨC</a></li>
                <li><a href="{{ route('instruct') }}">HƯỚNG DẪN</a></li>
                <li><a href="{{ route('contact') }}">LIÊN HỆ</a></li>
            </ul>
        </div>
    </nav>
</header>

<script>
// Optimized JavaScript for header functionality
(function() {
    let searchTimeout;
    
    // User menu toggle
    window.toggleUserMenu = function() {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) dropdown.classList.toggle('show');
    };
    
    // Notifications toggle
    window.toggleNotifications = function() {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown && !dropdown.classList.contains('show')) {
            loadNotifications();
        }
        if (dropdown) dropdown.classList.toggle('show');
    };
    
    // Load notifications
    function loadNotifications() {
        const notificationList = document.getElementById('notificationList');
        if (!notificationList) return;
        
        fetch('{{ route('notifications.unread') }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
                
                if (data.notifications && data.notifications.length === 0) {
                    notificationList.innerHTML = '<div class="notification-empty">Không có thông báo mới</div>';
                } else if (data.notifications) {
                    notificationList.innerHTML = data.notifications.map(notif => `
                        <div class="notification-item ${notif.read_at ? '' : 'unread'}" onclick="markAsRead(${notif.id})">
                            <div class="notification-content">
                                <div class="notification-title">${notif.title}</div>
                                <div class="notification-message">${notif.message}</div>
                            </div>
                        </div>
                    `).join('');
                }
            })
            .catch(() => {
                notificationList.innerHTML = '<div class="notification-empty">Lỗi tải thông báo</div>';
            });
    }
    
    // Mark notification as read
    window.markAsRead = function(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(() => loadNotifications());
    };
    
    // Mark all as read
    window.markAllAsRead = function() {
        fetch('{{ route('notifications.mark-all-read') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(() => loadNotifications());
    };
    
    // Search autocomplete
    const searchInput = document.querySelector('.search-box input[name="q"]');
    const searchResults = document.getElementById('searchResults');
    
    if (searchInput && searchResults) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                searchResults.classList.remove('show');
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetch(`{{ route('search.autocomplete') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResults.innerHTML = '<div class="search-no-results">Không tìm thấy sản phẩm</div>';
                        } else {
                            searchResults.innerHTML = data.map(product => `
                                <a href="${product.url}" class="search-result-item">
                                    ${product.image ? `<img src="${product.image}" alt="${product.name}" class="search-result-image">` : ''}
                                    <div class="search-result-info">
                                        <div class="search-result-name">${product.name}</div>
                                        <div class="search-result-price">${product.price}đ</div>
                                    </div>
                                </a>
                            `).join('');
                        }
                        searchResults.classList.add('show');
                    })
                    .catch(() => {
                        searchResults.innerHTML = '<div class="search-no-results">Lỗi tìm kiếm</div>';
                        searchResults.classList.add('show');
                    });
            }, 300);
        });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.user-menu')) {
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) userDropdown.classList.remove('show');
        }
        
        if (!e.target.closest('.notification-menu')) {
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) notificationDropdown.classList.remove('show');
        }
        
        if (!e.target.closest('.search-box')) {
            if (searchResults) searchResults.classList.remove('show');
        }
    });
    
    // Load notifications on page load for authenticated users
    @auth
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();
        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });
    @endauth
})();
</script>