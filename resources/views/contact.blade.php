<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Liên hệ - Coza Shop</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-YnI7pt5yzy52JZZUKRFuEHV4i2kVOA8vw8Rmf92x8Iu5F01Q5gPq1xUHI7bkWQWcm0koFSr8Xe1kuzZ6cOnmDQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    
    <style>
        /* Force ẩn tất cả search box trừ mainSearchBox */
        .search-box:not(#mainSearchBox) {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            background: none !important;
        }
        
        /* Thu hẹp KHUNG header vừa phải - giữ nguyên kích thước chữ */
        .header-main {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 4px 0 !important;
            min-height: 40px !important;
        }
        
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 0 15px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .logo-link {
            display: flex;
            align-items: center;
        }
        
        .header-logo {
            height: 35px !important;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .header-logo:hover {
            transform: scale(1.05);
        }
        
        .main-nav {
            padding: 0 !important;
            min-height: 40px !important;
        }
        
        .hotline {
            font-size: 14px !important;
        }
        
        .header-actions {
            gap: 12px !important;
        }
        
        /* KHUNG menu vừa phải - giữ nguyên font chữ */
        .menu > li > a {
            padding: 8px 15px !important;
            font-size: 15px !important;
            font-weight: 600 !important;
        }
        
        /* KHUNG search box vừa phải - giữ nguyên font chữ */
        #mainSearchBox {
            margin: 0 10px !important;
            padding: 3px 8px !important;
        }
        
        #mainSearchBox input {
            width: 300px !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
        }
        
        /* Contact section layout */
        .contact-section {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }
        
        .contact-left {
            flex: 1;
            max-width: 600px;
        }
        
        /* Logo trang trí bên phải - to hơn và ở giữa */
        .contact-right {
            flex: 0 0 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 500px;
        }
        
        .decorative-logo-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 25px;
            padding: 40px 20px;
            width: 100%;
            text-align: center;
            background: transparent;
        }
        
        .decorative-logo-wrapper img {
            max-width: 220px;
            max-height: 150px;
            object-fit: contain;
            transition: transform 0.3s ease, opacity 0.3s ease;
            opacity: 0.9;
        }
        
        .decorative-logo-wrapper img:hover {
            transform: scale(1.05);
            opacity: 1;
        }
        
        .decorative-text {
            color: #666;
            font-size: 16px;
            font-style: italic;
            font-weight: 400;
            line-height: 1.5;
            max-width: 320px;
            opacity: 0.8;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .header-left {
                flex-direction: column;
                gap: 5px;
                align-items: flex-start;
            }
            
            .header-logo {
                height: 24px !important;
            }
            
            .menu > li > a {
                padding: 6px 8px !important;
                font-size: 12px !important;
            }
            
            #mainSearchBox input {
                width: 200px !important;
                padding: 4px 8px !important;
            }
            
            .contact-section {
                flex-direction: column;
                gap: 30px;
            }
            
            .contact-right {
                flex: none;
                min-height: auto;
            }
            
            .decorative-logo-wrapper {
                padding: 30px 15px;
            }
            
            .decorative-logo-wrapper img {
                max-width: 160px !important;
                max-height: 110px !important;
            }
            
            .decorative-text {
                font-size: 14px;
                max-width: 280px;
            }
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const searchBoxes = document.querySelectorAll('.search-box');
                searchBoxes.forEach(function(box) {
                    if (box.id !== 'mainSearchBox') {
                        const hasInput = box.querySelector('input');
                        const hasForm = box.querySelector('form');
                        if (!hasInput && !hasForm) {
                            box.remove();
                        }
                    }
                });
            }, 200);
        });
    </script>
</head>
<body>
    @include('partials.header')
    <main class="container">

        <section class="contact-section">
            <div class="contact-left">
                <h2>NƠI GIẢI ĐÁP TOÀN BỘ MỌI THẮC MẮC CỦA BẠN?</h2>

                <p><strong>Hotline:</strong> <span class="highlight-number">0977508430 | 0338000308</span></p>
                <p><strong>Email:</strong> <a href="mailto:info@shopvnb.com" class="highlight-email">info@shopvnb.com</a></p>

                <h3>LIÊN HỆ VỚI CHÚNG TÔI</h3>

                <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <input type="text" id="fullname" name="name" placeholder="Họ và tên" required />
                        <input type="email" id="email" name="email" placeholder="Email" required />
                    </div>
                    <input type="tel" id="phone" name="phone" placeholder="Điện thoại" />
                    <textarea id="message" name="message" rows="5" placeholder="Nội dung" required></textarea>
                    <button type="submit" class="btn-submit">Gửi thông tin</button>
                </form>
            </div>

            <!-- Logo trang trí bên phải -->
            <div class="contact-right">
                <div class="decorative-logo-wrapper">
                    <img src="{{ asset('img/logo.png') }}" alt="VNB Sports Logo">
                    <div class="decorative-text">
                        Hệ thống cửa hàng cầu lông uy tín hàng đầu Việt Nam
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <script>
        const form = document.getElementById('contactForm');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Disable button
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang gửi...';
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    form.reset();
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Gửi thông tin';
            });
        });
    </script>
</body>
</html>
