<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Phản hồi từ VNB Sports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #e6560e;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .footer {
            background: #333;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 8px 8px;
            font-size: 14px;
        }
        .original-message {
            background: #fff;
            padding: 15px;
            border-left: 4px solid #e6560e;
            margin: 20px 0;
        }
        .reply-message {
            background: #e8f5e8;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏸 VNB Sports</h1>
        <p>Phản hồi liên hệ của bạn</p>
    </div>
    
    <div class="content">
        <p>Xin chào <strong>{{ $contact->name }}</strong>,</p>
        
        <p>Cảm ơn bạn đã liên hệ với VNB Sports. Chúng tôi đã nhận được tin nhắn của bạn và xin gửi phản hồi như sau:</p>
        
        <div class="original-message">
            <h4>Tin nhắn gốc của bạn:</h4>
            <p><strong>Ngày gửi:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Nội dung:</strong></p>
            <p>{{ $contact->message }}</p>
        </div>
        
        <div class="reply-message">
            <h4>Phản hồi từ VNB Sports:</h4>
            <p>{{ $reply }}</p>
        </div>
        
        <p>Nếu bạn có thêm câu hỏi nào khác, vui lòng liên hệ với chúng tôi qua:</p>
        <ul>
            <li>📧 Email: info@shopvnb.com</li>
            <li>📞 Hotline: 1900 6750</li>
            <li>🌐 Website: {{ url('/') }}</li>
        </ul>
        
        <p>Trân trọng,<br>
        <strong>Đội ngũ hỗ trợ khách hàng VNB Sports</strong></p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} VNB Sports. Hệ thống cửa hàng vợt cầu lông hàng đầu Việt Nam.</p>
        <p>Email này được gửi tự động, vui lòng không trả lời trực tiếp.</p>
    </div>
</body>
</html>