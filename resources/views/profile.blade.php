@extends('layout.customer')

@section('title', 'Thông tin tài khoản')

@push('styles')
<style>
    .profile-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    
    .profile-title {
        text-align: center;
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 24px;
    }
    
    .profile-subtitle {
        text-align: center;
        color: #666;
        margin-bottom: 40px;
    }
    
    .info-box {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .info-box h5 {
        color: #e74c3c;
        font-weight: bold;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e74c3c;
    }
    
    .info-box p {
        margin-bottom: 15px;
        color: #333;
    }
    
    .info-box p i {
        width: 20px;
        margin-right: 10px;
    }
    
    .btn-edit {
        background: #e74c3c;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        width: 100%;
        text-align: center;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-edit:hover {
        background: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }
    
    .order-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    
    .order-table thead {
        background: #e74c3c;
        color: white;
    }
    
    .order-table th,
    .order-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }
    
    .order-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-warning {
        background: #ffc107;
        color: #000;
    }
    
    .badge-success {
        background: #28a745;
        color: white;
    }
    
    .badge-info {
        background: #17a2b8;
        color: white;
    }
    
    .badge-danger {
        background: #dc3545;
        color: white;
    }
    
    .no-orders {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }
    
    .profile-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .profile-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <h4 class="profile-title">THÔNG TIN TÀI KHOẢN</h4>
    <p class="profile-subtitle">Xin chào, <strong>{{ Auth::user()->name }}</strong>!</p>

    <div class="profile-row">
        <!-- Thông tin khách hàng -->
        <div>
            <div class="info-box">
                <h5>👤 THÔNG TIN KHÁCH HÀNG</h5>
                <p><strong>Họ tên:</strong> {{ Auth::user()->name ?? 'Chưa cập nhật' }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email ?? 'Chưa cập nhật' }}</p>
                <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
                <p><strong>Địa chỉ:</strong> {{ Auth::user()->address ?? 'Chưa cập nhật' }}</p>

                <button onclick="showEditModal()" class="btn-edit">
                    ✏️ SỬA THÔNG TIN
                </button>
            </div>
        </div>

        <!-- Đổi mật khẩu -->
        <div>
            <div class="info-box">
                <h5>🔐 ĐỔI MẬT KHẨU</h5>
                <p style="color: #666; margin-bottom: 20px;">Để bảo mật tài khoản, hãy thường xuyên thay đổi mật khẩu</p>
                
                <button onclick="showPasswordModal()" class="btn-edit">
                    🔑 ĐỔI MẬT KHẨU
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal chỉnh sửa thông tin -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 10px; padding: 30px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <h3 style="color: #e74c3c; margin-bottom: 20px;">✏️ Chỉnh sửa thông tin</h3>
        
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Họ tên:</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Số điện thoại:</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone }}" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Địa chỉ:</label>
                <textarea name="address" rows="3" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">{{ Auth::user()->address }}</textarea>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-edit" style="flex: 1;">💾 Lưu thay đổi</button>
                <button type="button" onclick="hideEditModal()" 
                    style="flex: 1; background: #6c757d; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer;">
                    ✗ Hủy
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal đổi mật khẩu -->
<div id="passwordModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 20px; padding: 0; max-width: 450px; width: 90%; max-height: 90vh; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%); color: white; text-align: center; padding: 30px;">
            <h2 style="margin: 0; font-size: 1.8rem; font-weight: 700;">🔐 Đổi mật khẩu</h2>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Cập nhật mật khẩu mới cho tài khoản</p>
        </div>
        
        <!-- Form -->
        <div style="padding: 30px;">
            @if ($errors->any())
                <div style="background: #fee; color: #c33; border: 1px solid #fcc; padding: 15px; margin-bottom: 20px; border-radius: 10px; font-size: 0.95rem;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div style="background: #efe; color: #363; border: 1px solid #cfc; padding: 15px; margin-bottom: 20px; border-radius: 10px; font-size: 0.95rem;">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('profile.change-password') }}" method="POST" id="changePasswordForm">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Mật khẩu hiện tại:</label>
                    <input type="password" name="current_password" required 
                        style="width: 100%; padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease; box-sizing: border-box;"
                        placeholder="Nhập mật khẩu hiện tại"
                        onfocus="this.style.borderColor='#e6560e'; this.style.boxShadow='0 0 0 3px rgba(230, 86, 14, 0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Mật khẩu mới:</label>
                    <input type="password" name="password" required 
                        style="width: 100%; padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease; box-sizing: border-box;"
                        placeholder="Nhập mật khẩu mới"
                        onfocus="this.style.borderColor='#e6560e'; this.style.boxShadow='0 0 0 3px rgba(230, 86, 14, 0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 8px; color: #333; font-weight: 500;">Xác nhận mật khẩu mới:</label>
                    <input type="password" name="password_confirmation" required 
                        style="width: 100%; padding: 15px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease; box-sizing: border-box;"
                        placeholder="Nhập lại mật khẩu mới"
                        onfocus="this.style.borderColor='#e6560e'; this.style.boxShadow='0 0 0 3px rgba(230, 86, 14, 0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <button type="submit" 
                        style="flex: 1; background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%); color: white; border: none; padding: 15px; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(230, 86, 14, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        🔑 Đổi mật khẩu
                    </button>
                    <button type="button" onclick="hidePasswordModal()" 
                        style="flex: 1; background: #6c757d; color: white; padding: 15px; border: none; border-radius: 10px; font-size: 1.1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;"
                        onmouseover="this.style.background='#5a6268'"
                        onmouseout="this.style.background='#6c757d'">
                        ✗ Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showEditModal() {
        document.getElementById('editModal').style.display = 'flex';
    }
    
    function hideEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
    
    function showPasswordModal() {
        document.getElementById('passwordModal').style.display = 'flex';
    }
    
    function hidePasswordModal() {
        document.getElementById('passwordModal').style.display = 'none';
    }
    
    // Đóng modal khi click bên ngoài
    document.getElementById('editModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            hideEditModal();
        }
    });
    
    document.getElementById('passwordModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            hidePasswordModal();
        }
    });
    
    // Xử lý form đổi mật khẩu
    document.getElementById('changePasswordForm')?.addEventListener('submit', function(e) {
        const password = this.password.value;
        const confirmPassword = this.password_confirmation.value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Mật khẩu xác nhận không khớp!');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Mật khẩu phải có ít nhất 6 ký tự!');
            return false;
        }
    });
    
    // Tự động mở modal nếu có lỗi đổi mật khẩu
    @if($errors->has('current_password') || $errors->has('password'))
        showPasswordModal();
    @endif
    
    // Tự động đóng modal sau 3 giây nếu thành công
    @if(session('success') && str_contains(session('success'), 'mật khẩu'))
        showPasswordModal();
        setTimeout(function() {
            hidePasswordModal();
        }, 3000);
    @endif
</script>
@endpush

