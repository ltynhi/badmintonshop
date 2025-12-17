<!-- Header main - Logo và hotline bên trái -->
<div class="header-main">
    <div class="container header-flex">
        <div class="header-left">
            <a href="{{ route('home') }}" class="logo-link">
                <img src="{{ asset('img/logo.png') }}" alt="Coza Shop Logo" class="header-logo">
            </a>
            <div class="hotline">
                <i class="icon-phone"></i>
                <span>HOTLINE:</span> <strong>0977508430 | 0338000308</strong>
            </div>
        </div>
        <!-- Search box duy nhất trong header -->
        <div class="search-box" id="headerSearchBox">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" 
                       name="q" 
                       placeholder="Tìm sản phẩm..." 
                       value="{{ request('q') }}" 
                       autocomplete="off" />
            </form>
            <div id="searchResults" class="search-results"></div>
        </div>
        <div class="header-actions">
            <!-- Notifications -->
            @auth
            <div class="notification-menu">
                <button class="notification-button" onclick="toggleNotifications()">
                    <span style="font-size: 18px; color: #e6560e;">🔔</span>
                    <span class="notification-badge" id="notificationBadge" style="display: flex;">2</span>
                </button>
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <h4>Thông báo</h4>
                        <button onclick="markAllAsRead()" class="mark-all-read">Đánh dấu đã đọc</button>
                    </div>
                    <div class="notification-list" id="notificationList">
                        <div class="notification-loading">
                            <i class="fas fa-spinner fa-spin"></i> Đang tải...
                        </div>
                    </div>
                    <div class="notification-footer">
                        <a href="{{ route('notifications.index') }}">Xem tất cả thông báo</a>
                    </div>
                </div>
            </div>
            @endauth
            
            <!-- User Avatar Dropdown -->
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
                        <a href="{{ route('notifications.index') }}">
                            <i class="fas fa-bell"></i> Thông báo
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="logout">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-login">
                        <i class="fas fa-user"></i> Đăng nhập
                    </a>
                @endauth
            </div>

            <!-- Cart -->
            <div class="action-item cart-wrapper">
                <a href="{{ route('cart') }}">
                    🛒
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

<!-- Navigation menu -->
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

<style>
.header-left {
    display: flex;
    align-items: center;
    gap: 25px;
}

.logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.header-logo {
    height: 40px;
    width: auto;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.header-logo:hover {
    transform: scale(1.05);
}

.search-box form {
    display: flex;
    align-items: center;
    width: 100%;
}

.search-box input {
    flex: 1;
}

.search-box button {
    flex-shrink: 0;
}

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
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
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
    min-width: 220px;
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

.user-dropdown a i,
.user-dropdown button i {
    width: 20px;
    margin-right: 8px;
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

.btn-login {
    padding: 8px 20px;
    background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
    color: white;
    text-decoration: none;
    border-radius: 20px;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(230, 86, 14, 0.4);
}

.cart-wrapper {
    position: relative;
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

/* Notification Menu */
.notification-menu {
    position: relative;
    display: inline-block;
    margin-right: 15px;
}

.notification-button {
    background: none;
    border: none;
    color: #e6560e !important;
    cursor: pointer;
    padding: 8px 12px;
    font-size: 20px;
    position: relative;
    border-radius: 50%;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    min-height: 40px;
}

.notification-button span {
    color: #e6560e !important;
}

.notification-button i {
    color: #e6560e !important;
}

.notification-button:hover {
    background-color: rgba(230, 86, 14, 0.1);
    color: #d73027 !important;
}

.notification-button:hover i {
    color: #d73027 !important;
}

.notification-badge {
    position: absolute;
    top: -2px;
    right: -2px;
    background: #e6560e;
    color: white;
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: bold;
    padding: 0 4px;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    width: 380px;
    margin-top: 8px;
    display: none;
    z-index: 1000;
    max-height: 500px;
    overflow: hidden;
}

.notification-dropdown.show {
    display: block;
}

.notification-header {
    padding: 15px 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-header h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.mark-all-read {
    background: none;
    border: none;
    color: #e6560e;
    font-size: 12px;
    cursor: pointer;
    font-weight: 500;
}

.mark-all-read:hover {
    text-decoration: underline;
}

.notification-list {
    max-height: 350px;
    overflow-y: auto;
}

.notification-item {
    padding: 15px 20px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background 0.2s ease;
    display: flex;
    gap: 12px;
}

.notification-item:hover {
    background: #f8f9fa;
}

.notification-item.unread {
    background: #e7f3ff;
}

.notification-icon {
    font-size: 24px;
    flex-shrink: 0;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 4px;
}

.notification-message {
    font-size: 13px;
    color: #666;
    margin-bottom: 4px;
}

.notification-time {
    font-size: 11px;
    color: #999;
}

.notification-loading,
.notification-empty {
    padding: 40px 20px;
    text-align: center;
    color: #999;
}

.notification-footer {
    padding: 12px 20px;
    border-top: 1px solid #eee;
    text-align: center;
}

.notification-footer a {
    color: #e6560e;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

.notification-footer a:hover {
    text-decoration: underline;
}

.search-box {
    position: relative;
}

/* Header search box styling - Đảm bảo hiển thị rõ ràng */
#headerSearchBox {
    display: flex !important;
    align-items: center;
    background: #fafafa;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    padding: 5px 15px;
    margin: 0 15px;
    min-width: 350px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

#headerSearchBox form {
    display: flex !important;
    align-items: center;
    width: 100%;
}

#headerSearchBox input {
    width: 100%;
    padding: 8px 12px;
    border: none;
    border-radius: 25px;
    font-size: 14px;
    color: #333;
    outline: none;
    background: transparent;
    transition: all 0.3s;
}

#headerSearchBox input:focus {
    background: white;
    box-shadow: 0 0 0 2px rgba(230, 86, 14, 0.2);
}

#headerSearchBox input::placeholder {
    color: #999;
    font-weight: 400;
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    margin-top: 8px;
    max-height: 400px;
    overflow-y: auto;
    display: none;
    z-index: 1000;
}

.search-results.show {
    display: block;
}

.search-result-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    text-decoration: none;
    color: #333;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s ease;
}

.search-result-item:hover {
    background: #f8f9fa;
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-image {
    width: 50px;
    height: 50px;
    object-fit: contain;
    margin-right: 12px;
    border-radius: 4px;
}

.search-result-info {
    flex: 1;
}

.search-result-name {
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 4px;
}

.search-result-price {
    color: #e74c3c;
    font-weight: bold;
    font-size: 13px;
}

.search-no-results {
    padding: 20px;
    text-align: center;
    color: #999;
}
</style>

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
    
    // Close search results when clicking outside
    if (!e.target.closest('.search-box')) {
        const searchResults = document.getElementById('searchResults');
        if (searchResults) {
            searchResults.classList.remove('show');
        }
    }
});

// Search autocomplete
let searchTimeout;
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

if (searchInput) {
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
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });
}

// Notifications
function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    const isShowing = dropdown.classList.contains('show');
    
    if (!isShowing) {
        loadNotifications();
    }
    
    dropdown.classList.toggle('show');
}

function loadNotifications() {
    const notificationList = document.getElementById('notificationList');
    
    fetch('{{ route('notifications.unread') }}')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notificationBadge');
            
            if (data.unread_count > 0) {
                badge.textContent = data.unread_count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
            
            if (data.notifications.length === 0) {
                notificationList.innerHTML = '<div class="notification-empty">Không có thông báo mới</div>';
            } else {
                notificationList.innerHTML = data.notifications.map(notif => `
                    <div class="notification-item ${notif.read_at ? '' : 'unread'}" onclick="markAsRead(${notif.id})">
                        <div class="notification-icon">${getNotificationIcon(notif.type)}</div>
                        <div class="notification-content">
                            <div class="notification-title">${notif.title}</div>
                            <div class="notification-message">${notif.message}</div>
                            <div class="notification-time">${formatTime(notif.created_at)}</div>
                        </div>
                    </div>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Notification error:', error);
            notificationList.innerHTML = '<div class="notification-empty">Lỗi tải thông báo</div>';
        });
}

function getNotificationIcon(type) {
    const icons = {
        'order_created': '🛒',
        'order_status_updated': '📦',
        'new_product': '🆕',
        'product_sale': '🔥'
    };
    return icons[type] || '🔔';
}

function formatTime(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);
    
    if (diff < 60) return 'Vừa xong';
    if (diff < 3600) return Math.floor(diff / 60) + ' phút trước';
    if (diff < 86400) return Math.floor(diff / 3600) + ' giờ trước';
    return Math.floor(diff / 86400) + ' ngày trước';
}

function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => {
        loadNotifications();
    });
}

function markAllAsRead() {
    fetch('{{ route('notifications.mark-all-read') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    }).then(() => {
        loadNotifications();
    });
}

// Load notifications on page load
@auth
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    // Refresh notifications every 30 seconds
    setInterval(loadNotifications, 30000);
});
@endauth

// Search autocomplete for header search
const headerSearchInput = document.querySelector('#headerSearchBox input[name="q"]');
if (headerSearchInput) {
    headerSearchInput.addEventListener('input', function() {
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
                .catch(error => {
                    console.error('Search error:', error);
                });
        }, 300);
    });
}
</script>

<script>
// Đảm bảo thanh tìm kiếm luôn hiển thị
document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('headerSearchBox');
    if (searchBox) {
        // Force hiển thị thanh tìm kiếm
        searchBox.style.display = 'flex';
        searchBox.style.visibility = 'visible';
        searchBox.style.opacity = '1';
        
        console.log('Search box initialized:', searchBox);
    } else {
        console.error('Search box not found!');
    }
});
</script>