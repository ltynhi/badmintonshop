<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VNB Sports')</title>
    <!-- CSS chung -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Header chung -->
        <!-- Header top -->
    <div class="header-top">
        <div class="container header-flex">
            <div class="hotline">
                <i class="icon-phone"></i>
                <span>HOTLINE:</span> <strong>0977508430 | 0338000308</strong>
            </div>

            <div class="header-actions">
    <div class="action-item">
        <a href="{{ url('login') }}">
            👤
        </a>
    </div>
    <div class="action-item cart-wrapper">
        <a href="{{ url('cart') }}">
            🛒
        </a>
        <span class="cart-count">0</span>
    </div>
</div>

        </div>
    </div>

    <!-- Navigation menu -->
    <nav class="main-nav">
        <div class="container">
            <ul class="menu">
                <li><a href="{{ url('/') }}">TRANG CHỦ</a></li>
                <li class="dropdown">
                     <a href="#">SẢN PHẨM <span class="arrow">&#x25BC;</span></a>
                    <div class="dropdown-menu mega-menu">
                        <div class="menu-column">
                            <h3>VỢT CẦU LÔNG</h3>
                            <ul>
                               <li><a href="{{ url('list-product') }}">Vợt cầu lông Yonex</a></li>
                                <li><a href="#">Vợt cầu lông Victor</a></li>
                                <li><a href="#">Vợt cầu lông Lining</a></li>
                                <li><a href="#">Vợt Cầu Lông Mizuno</a></li>
                                <li><a href="#">Vợt cầu bóng Apacs</a></li>
                                <li><a href="#">Vợt Cầu Lông VNB</a></li>
                                <li><a href="#">Vợt cầu lông Proace</a></li>
                                <li><a href="#">Vợt cầu lông Forza</a></li>
                                <li><a href="#">Vợt Cầu Lông FlyPower</a></li>
                                <li><a href="#">Vợt Cầu Lông Tenway</a></li>
                            </ul>
                            <a href="#" class="view-more">Xem thêm</a>
                        </div>
                        <div class="menu-column">
                            <h3>GIÀY CẦU LÔNG</h3>
                            <ul>
                                <li><a href="#">Giày cầu lông Yonex</a></li>
                                <li><a href="#">Giày cầu lông Victor</a></li>
                                <li><a href="#">Giày cầu lông Lining</a></li>
                                <li><a href="#">Giày cầu lông Kawasaki</a></li>
                                <li><a href="#">Giày Cầu Lông Mizuno</a></li>
                                <li><a href="#">Giày Cầu Lông Kumpoo</a></li>
                                <li><a href="#">Giày Cầu Lông Promax</a></li>
                                <li><a href="#">Giày cầu lông Babolat</a></li>
                                <li><a href="#">Giày Cầu Lông Sunbatta</a></li>
                                <li><a href="#">Giày cầu lông Apacs</a></li>
                            </ul>
                            <a href="#" class="view-more">Xem thêm</a>
                        </div>
                        <div class="menu-column">
                            <h3>ÁO CẦU LÔNG</h3>
                            <ul>
                                <li><a href="#">Áo cầu lông Yonex</a></li>
                                <li><a href="#">Áo cầu lông VNB</a></li>
                                <li><a href="#">Áo cầu lông Kamito</a></li>
                                <li><a href="#">Áo cầu lông Victor</a></li>
                                <li><a href="#">Áo cầu lông Lining</a></li>
                                <li><a href="#">Áo cầu lông DonexPro</a></li>
                                <li><a href="#">Áo Cầu Lông Alien Armour</a></li>
                                <li><a href="#">Áo thể thao SFD</a></li>
                                <li><a href="#">Áo cầu lông Kawasaki</a></li>
                                <li><a href="#">Áo thể thao Pebble Beach</a></li>
                            </ul>
                            <a href="#" class="view-more">Xem thêm</a>
                        </div>
                        <div class="menu-column">
                            <h3>VÁY CẦU LÔNG</h3>
                            <ul>
                                <li><a href="#">Váy cầu lông Yonex</a></li>
                                <li><a href="#">Váy cầu lông Victec</a></li>
                                <li><a href="#">Váy cầu lông Lining</a></li>
                                <li><a href="#">Váy cầu lông Donex Pro</a></li>
                                <li><a href="#">Váy cầu lông Victor</a></li>
                                <li><a href="#">Váy cầu lông Kamito</a></li>
                                <li><a href="#">Váy cầu lông Taro</a></li>
                            </ul>
                        </div>
                        <div class="menu-column">
                            <h3>QUẦN CẦU LÔNG</h3>
                            <ul>
                                <li><a href="#">Quần cầu lông Yonex</a></li>
                                <li><a href="#">Quần cầu lông Victor</a></li>
                                <li><a href="#">Quần cầu lông Lining</a></li>
                                <li><a href="#">Quần cầu lông VNB</a></li>
                                <li><a href="#">Quần Cầu Lông SFD</a></li>
                                <li><a href="#">Quần cầu lông Donex Pro</a></li>
                                <li><a href="#">Quần Cầu Lông Apacs</a></li>
                                <li><a href="#"><strong>QUẦN CẦU LÔNG ALIEN AMOUR</strong></a></li>
                                <li><a href="#">Quần cầu lông Mizuno</a></li>
                                <li><a href="#">Quần cầu lông Kawasaki</a></li>
                            </ul>
                            <a href="#" class="view-more">Xem thêm</a>
                        </div>
                    </div>
                </li>
                <li><a href="{{ url('sale-off') }}">SALE OFF</a></li>
                <li><a href="{{ url('list-news') }}">TIN TỨC</a></li>

                <li><a href="#">HƯỚNG DẪN</a></li>
                <li><a href="#">GIỚI THIỆU</a></li>
                <li><a href="{{ url('contact') }}">LIÊN HỆ</a></li>
            </ul>
        </div>
    </nav>

    <!-- Slider -->
    <div class="main-slider-wrapper">
      <div class="swiper main-slider">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="{{ asset('img/b2.png') }}" alt="Victor Axelsen Collection" />
          </div>
          <div class="swiper-slide">
            <img src="{{ asset('img/b2.png') }}" alt="Yonex We Strive Together" />
          </div>
          <div class="swiper-slide">
            <img src="https://i.ibb.co/X7TZ8Zb/slide1.jpg" alt="Slide 3" />
          </div>
        </div>
      </div>
    </div>

    <!-- Nội dung riêng của từng trang -->
    <main>
        @yield('content')
    </main>

    <!-- Footer chung -->
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

</body>
</html>
