<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>VN B Admin Page</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
</head>
<body>
    @include('partials.header')
   
  <div class="cart-container">
    <div class="cart-header">
      <b>GIỎ HÀNG CỦA BẠN</b>
    </div>
    
    @php
        $cart = session()->get('cart', []);
        $total = 0;
    @endphp
    
    @if(count($cart) > 0)
    <div class="cart-box">
      <div class="cart-box-header">GIỎ HÀNG ({{ count($cart) }} sản phẩm)</div>

      @foreach($cart as $id => $details)
        @php
            $itemTotal = $details['price'] * $details['quantity'];
            $total += $itemTotal;
        @endphp
        <div class="cart-item">
          <div class="item-img">
            @if($details['image'])
              <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" />
            @else
              <img src="https://via.placeholder.com/100x100?text=No+Image" alt="{{ $details['name'] }}" />
            @endif
          </div>
          <div class="item-name">
            {{ $details['name'] }}
          </div>
          <div class="qty-group">
            <button type="button" class="btn-qty minus" onclick="updateQuantity({{ $id }}, -1)">-</button>
            <input type="text" id="qty-{{ $id }}" value="{{ $details['quantity'] }}" readonly />
            <button type="button" class="btn-qty plus" onclick="updateQuantity({{ $id }}, 1)">+</button>
          </div>
          <div class="item-price">{{ number_format($itemTotal) }} đ</div>
          <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-remove" title="Xóa sản phẩm" onclick="return confirm('Xóa sản phẩm này?')">×</button>
          </form>
        </div>
      @endforeach
    </div>

    <div class="cart-total">
      <span class="label">TỔNG TIỀN:</span>
      <span class="total-amount">{{ number_format($total) }} đ</span>
    </div>
    @auth
        <a href="{{ route('checkout') }}" class="btn-order">ĐẶT HÀNG</a>
    @else
        <a href="{{ route('login') }}" class="btn-order" onclick="alert('Vui lòng đăng nhập để đặt hàng!'); return true;">ĐẶT HÀNG</a>
    @endauth
    @else
    <div class="cart-box">
      <div style="text-align: center; padding: 50px;">
        <p style="font-size: 1.2em; color: #999;">🛒 Giỏ hàng trống</p>
        <a href="{{ route('list-product') }}" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #e6560e; color: white; text-decoration: none; border-radius: 5px;">Tiếp tục mua sắm</a>
      </div>
    </div>
    @endif
  </div>
  
  <script>
    function updateQuantity(id, change) {
      const input = document.getElementById('qty-' + id);
      let currentQty = parseInt(input.value);
      let newQty = currentQty + change;
      
      if (newQty < 1) newQty = 1;
      
      input.value = newQty;
      
      // Send AJAX request to update
      fetch('{{ route("cart.update") }}', {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          id: id,
          quantity: newQty
        })
      }).then(() => {
        location.reload();
      });
    }
  </script>
<footer>
  <div class="footer-top">
    <div class="footer-column">
      <h3>THÔNG TIN CHUNG</h3>
      <p><strong>VNB Sports</strong> là hệ thống cửa hàng cầu lông với hơn 50 chi nhánh trên toàn quốc, cung cấp sỉ và lẻ các mặt hàng dụng cụ cầu lông từ phong trào tới chuyên nghiệp</p>
      <p><strong>Với sứ mệnh:</strong> "<i>VNB cam kết mang đến những sản phẩm, dịch vụ chất lượng tốt nhất phục vụ cho người chơi thể thao để nâng cao sức khỏe của chính mình.</i>"</p>
      <p><strong>Tầm nhìn:</strong> "<i>Trở thành nhà phân phối và sản xuất thể thao lớn nhất Việt Nam</i>"</p>
    </div>

    <div class="footer-column">
      <h3>THÔNG TIN LIÊN HỆ</h3>
      <p><strong>Hệ thống cửa hàng:</strong> <span class="highlight">1 Super Center, 5 shop Premium và 78 cửa hàng</span> trên toàn quốc</p>
      <p><span class="highlight">Xem tất cả các cửa hàng VNB</span></p>

      <p><strong>Hotline:</strong> <span class="highlight">0977508430 | 0338000308</span></p>
      <p><strong>Email:</strong> <span class="highlight">info@shopvnb.com</span></p>
      <p><strong>Hợp tác kinh doanh:</strong> <span class="highlight">0947342259 (Ms. Thảo)</span></p>
      <p><strong>Hotline bán sỉ:</strong> <span class="highlight">0911195711 0911105211</span></p>
      <p><strong>Nhượng quyền thương hiệu:</strong> <span class="highlight">0334.741.141 (Mr. Hậu)</span></p>
      <p><strong>Than phiền dịch vụ:</strong> <span class="highlight">0334.741.141 (Mr. Hậu)</span></p>

      <div class="social-icons">
        <a href="#" aria-label="Facebook" class="icon-facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" aria-label="YouTube" class="icon-youtube"><i class="fab fa-youtube"></i></a>
      </div>
    </div>

    <div class="footer-column">
      <h3>CHÍNH SÁCH</h3>
      <ul>
        <li>Thông tin về vận chuyển và giao nhận</li>
        <li>Chính sách đổi trả,hoàn tiền</li>
        <li>Chính sách bảo hành</li>
        <li>Chính sách xử lý khiếu nại</li>
        <li>Chính sách vận chuyển</li>
        <li>Điều khoản sử dụng</li>
        <li>Chính Sách Bảo Mật Thông Tin</li>
        <li>Chính sách nhượng quyền</li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>HƯỚNG DẪN</h3>
      <ul>
        <li>Danh sách số tài khoản chính thức của các shop trong hệ thống VNB Sports</li>
        <li>Hướng dẫn cách chọn vợt cầu lông cho người mới chơi</li>
        <li>Hướng dẫn thanh toán</li>
        <li>Kiểm tra bảo hành</li>
        <li>Kiểm tra đơn hàng</li>
        <li>HƯỚNG DẪN MUA HÀNG</li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <p>Công ty TNHH VNB SPORTS</p>
    <p>Địa chỉ: 390/2 Hà Huy Giáp, Phường Thạnh Lộc, Quận 12, TPHCM</p>
    <p>Email: info@shopvnb.com</p>
    <p>GPKD số 0314496879 do Sở KH và ĐT TP Hồ Chí Minh cấp ngày 05/07/2017</p>
    <p>GD/Sở hữu website: Nguyễn Phùng Hà Lan</p>
  </div>
</footer>
    <!-- JS -->
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</body>
</html>
