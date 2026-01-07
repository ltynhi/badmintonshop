<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng đến với Coza Shop</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.2rem;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-message {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 5px solid #e6560e;
        }
        .welcome-message h2 {
            color: #e6560e;
            margin: 0 0 15px 0;
            font-size: 1.4rem;
        }
        .benefits {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
        }
        .benefits h3 {
            color: #333;
            margin: 0 0 20px 0;
            font-size: 1.2rem;
        }
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .benefit-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 40px;
            text-align: center;
        }
        .cta-section {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            color: white;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(230, 86, 14, 0.3);
        }
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 86, 14, 0.4);
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .footer p {
            margin: 5px 0;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #e6560e;
            text-decoration: none;
            font-size: 1.2rem;
        }
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .header h1 {
                font-size: 1.8rem;
            }
            .cta-button {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🛍️ Coza Shop</h1>
            <p>Chào mừng bạn đến với gia đình chúng tôi!</p>
        </div>
        
        <div class="content">
            <div class="welcome-message">
                <h2>Xin chào {{ $user->name }}! 👋</h2>
                <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>Coza Shop</strong>. Chúng tôi rất vui mừng được chào đón bạn vào cộng đồng khách hàng thân thiết của chúng tôi!</p>
            </div>

            <div class="benefits">
                <h3>🎁 Quyền lợi của thành viên:</h3>
                
                <div class="benefit-item">
                    <div class="benefit-icon">🚚</div>
                    <div>
                        <strong>Miễn phí vận chuyển</strong><br>
                        <small>Cho đơn hàng từ 500.000đ trên toàn quốc</small>
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">🔥</div>
                    <div>
                        <strong>Ưu đãi độc quyền</strong><br>
                        <small>Nhận thông báo sale sớm và giảm giá đặc biệt</small>
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">💎</div>
                    <div>
                        <strong>Tích điểm thưởng</strong><br>
                        <small>Mỗi đơn hàng đều được tích điểm đổi quà</small>
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">🎯</div>
                    <div>
                        <strong>Hỗ trợ 24/7</strong><br>
                        <small>Đội ngũ tư vấn chuyên nghiệp luôn sẵn sàng</small>
                    </div>
                </div>
            </div>

            <div class="cta-section">
                <h3>🛒 Bắt đầu mua sắm ngay!</h3>
                <p>Khám phá hàng ngàn sản phẩm chất lượng với giá tốt nhất</p>
                
                <a href="{{ $shopUrl }}" class="cta-button">
                    Xem sản phẩm
                </a>
                
                <a href="{{ $loginUrl }}" class="cta-button" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);">
                    Đăng nhập ngay
                </a>
            </div>

            <div style="background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 25px 0; border-left: 5px solid #2196f3;">
                <h4 style="color: #1976d2; margin: 0 0 10px 0;">💡 Mẹo nhỏ:</h4>
                <p style="margin: 0; color: #555;">
                    Để không bỏ lỡ các chương trình khuyến mãi hấp dẫn, hãy theo dõi email và bật thông báo từ Coza Shop nhé!
                </p>
            </div>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="#" title="Facebook">📘 Facebook</a>
                <a href="#" title="Instagram">📷 Instagram</a>
                <a href="#" title="Zalo">💬 Zalo</a>
            </div>
            
            <p><strong>Coza Shop</strong> - Nơi mua sắm tin cậy</p>
            <p>📧 Email: {{ $supportEmail }}</p>
            <p>📞 Hotline: 1900-xxxx</p>
            <p>🏢 Địa chỉ: 123 Đường ABC, Quận XYZ, TP.HCM</p>
            
            <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
            
            <p style="font-size: 0.9rem; color: #999;">
                Bạn nhận được email này vì đã đăng ký tài khoản tại Coza Shop.<br>
                Nếu có thắc mắc, vui lòng liên hệ với chúng tôi.
            </p>
        </div>
    </div>
</body>
</html>