<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu - VNB Sports</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #e6560e;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .email-body p {
            margin-bottom: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #e6560e 0%, #ff7a3d 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(230, 86, 14, 0.3);
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #e6560e;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #e6560e;
            font-size: 16px;
        }
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .email-footer p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .contact-info h4 {
            color: #e6560e;
            margin-bottom: 10px;
        }
        .contact-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 5px;
            }
            .email-header, .email-body, .email-footer {
                padding: 20px;
            }
            .reset-button {
                display: block;
                text-align: center;
                margin: 20px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🔐 Đặt lại mật khẩu</h1>
            <p>VNB Sports - Cửa hàng cầu lông uy tín</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Xin chào!</h2>
            
            <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại <strong>VNB Sports</strong>.</p>
            
            <p>Để đặt lại mật khẩu, vui lòng nhấp vào nút bên dưới:</p>
            
            <div style="text-align: center;">
                <a href="{{ route('password.reset', $token) }}" class="reset-button">
                    🔑 Đặt lại mật khẩu
                </a>
            </div>
            
            <div class="info-box">
                <h3>⚠️ Lưu ý quan trọng:</h3>
                <p>• Link này chỉ có hiệu lực trong <strong>60 phút</strong> kể từ khi gửi</p>
                <p>• Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này</p>
                <p>• Để bảo mật, không chia sẻ link này với bất kỳ ai</p>
            </div>
            
            <p>Nếu nút không hoạt động, bạn có thể sao chép và dán link sau vào trình duyệt:</p>
            <p style="word-break: break-all; background: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace; font-size: 14px;">
                {{ route('password.reset', $token) }}
            </p>
            
            <div class="contact-info">
                <h4>📞 Cần hỗ trợ?</h4>
                <p><strong>Hotline:</strong> 0977508430 | 0338000308</p>
                <p><strong>Email:</strong> info@shopvnb.com</p>
                <p><strong>Địa chỉ:</strong> 390/2 Hà Huy Giáp, Phường Thạnh Lộc, Quận 12, TPHCM</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>VNB Sports</strong> - Hệ thống cửa hàng cầu lông uy tín hàng đầu Việt Nam</p>
            <p style="margin-top: 10px; font-size: 12px; color: #999;">
                Email này được gửi tự động, vui lòng không trả lời email này.
            </p>
        </div>
    </div>
</body>
</html>