@extends('layout.customer')

@section('title', 'Thanh toán')

@push('styles')
<style>
    .checkout-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
    }
    
    .checkout-left, .checkout-right {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .title {
        color: #e6560e;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    
    .shipping-info h3, .payment-methods h3 {
        color: #333;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e6560e;
    }
    
    .shipping-info input,
    .shipping-info textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }
    
    .shipping-info textarea {
        min-height: 80px;
        resize: vertical;
    }
    
    .payment-methods {
        margin-top: 30px;
    }
    
    .payment-methods .option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        margin-bottom: 10px;
        border: 2px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-methods .option:hover {
        border-color: #e6560e;
        background: #fff5f0;
    }
    
    .payment-methods .option label {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .payment-methods input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    
    .checkout-right h3 {
        color: #333;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e6560e;
    }
    
    .order-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    
    .order-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .order-desc {
        flex: 1;
        font-size: 14px;
    }
    
    .order-desc .quantity {
        display: inline-block;
        background: #e6560e;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 12px;
        margin-right: 8px;
    }
    
    .order-price {
        font-weight: bold;
        color: #e6560e;
    }
    
    .order-summary {
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    
    .order-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn-edit-cart,
    .btn-submit-order {
        flex: 1;
        padding: 15px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-edit-cart {
        background: #6c757d;
        color: white;
    }
    
    .btn-edit-cart:hover {
        background: #5a6268;
    }
    
    .btn-submit-order {
        background: #e6560e;
        color: white;
    }
    
    .btn-submit-order:hover {
        background: #c74a0c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(230, 86, 14, 0.3);
    }
    
    .shipping-note {
        margin-top: 20px;
        padding: 15px;
        background: #fff3cd;
        border-radius: 5px;
        font-size: 13px;
        color: #856404;
    }
    
    .shipping-note p {
        margin: 5px 0;
    }
    
    .empty-cart {
        max-width: 600px;
        margin: 50px auto;
        text-align: center;
        padding: 50px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .empty-cart p {
        font-size: 1.5em;
        color: #999;
        margin-bottom: 20px;
    }
    
    .empty-cart a {
        display: inline-block;
        padding: 12px 30px;
        background: #e6560e;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
    }
    
    .empty-cart a:hover {
        background: #c74a0c;
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .checkout-container {
            grid-template-columns: 1fr;
        }
        
        .order-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
@php
    $cart = session()->get('cart', []);
    $subtotal = 0;
    foreach($cart as $details) {
        $subtotal += $details['price'] * $details['quantity'];
    }
    $shippingFee = 30000;
    $total = $subtotal + $shippingFee;
@endphp

@if(count($cart) == 0)
<div class="empty-cart">
    <p>🛒 Giỏ hàng trống</p>
    <a href="{{ route('list-product') }}">Tiếp tục mua sắm</a>
</div>
@else
<div class="checkout-container">
    <div class="checkout-left">
        <h2 class="title">VNBSports</h2>
        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="shipping-info">
                <h3>Thông tin nhận hàng</h3>
                <input type="text" name="customer_name" placeholder="Họ và tên người nhận hàng" 
                    value="{{ Auth::user()->name ?? old('customer_name') }}" required />
                <input type="tel" name="customer_phone" placeholder="Số điện thoại" 
                    value="{{ Auth::user()->phone ?? old('customer_phone') }}" required />
                <input type="text" name="customer_address" placeholder="Địa chỉ" 
                    value="{{ Auth::user()->address ?? old('customer_address') }}" required />
                <input type="email" name="customer_email" placeholder="Email" 
                    value="{{ Auth::user()->email ?? old('customer_email') }}" required />
                <textarea name="note" placeholder="Ghi chú đơn hàng (tùy chọn)">{{ old('note') }}</textarea>
                
                <!-- Mặc định thanh toán COD -->
                <input type="hidden" name="payment_method" value="cod" />
                
                @if($errors->any())
                    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-top: 15px;">
                        @foreach($errors->all() as $error)
                            <p style="margin: 5px 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>


        </form>
    </div>

    <div class="checkout-right">
        <h3>Đơn hàng ({{ count($cart) }} sản phẩm)</h3>
        
        @foreach($cart as $id => $details)
        <div class="order-item">
            @if($details['image'])
                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" />
            @else
                <img src="https://via.placeholder.com/60x60?text=No+Image" alt="{{ $details['name'] }}" />
            @endif
            <div class="order-desc">
                <span class="quantity">{{ $details['quantity'] }}</span>
                {{ $details['name'] }}
            </div>
            <div class="order-price">{{ number_format($details['price'] * $details['quantity']) }}đ</div>
        </div>
        @endforeach

        <div class="order-summary">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Tạm tính</span>
                <span>{{ number_format($subtotal) }}đ</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span>Phí vận chuyển</span>
                <span>{{ number_format($shippingFee) }}đ</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 1.2em; font-weight: bold; padding-top: 10px; border-top: 2px solid #ddd;">
                <span>Tổng cộng</span>
                <span style="color: #e6560e;">{{ number_format($total) }}đ</span>
            </div>
        </div>

        <div class="order-buttons">
            <a href="{{ route('cart') }}"><button type="button" class="btn-edit-cart">Sửa giỏ hàng</button></a>
            <button type="button" class="btn-submit-order" onclick="document.getElementById('checkoutForm').submit()">ĐẶT HÀNG</button>
        </div>

        <div class="shipping-note">
            <p>📦 Phí vận chuyển: 30,000đ (áp dụng toàn quốc)</p>
            <p>⏰ Thời gian xử lý: Từ 8h00-17h thứ 2 đến thứ 7</p>
            <p>💡 Đơn hàng sau giờ sẽ được xử lý vào ngày làm việc tiếp theo</p>
        </div>
    </div>
</div>
@endif
@endsection
